<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $tag = $request->string('tag')->trim()->toString();

        $posts = Post::query()
            ->published()
            ->with(['category', 'tags'])
            ->when($tag !== '', fn ($query) => $query->withAnyTags([$tag]))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('public.posts.index', [
            'posts' => $posts,
            'categories' => $this->categories(),
            'category' => null,
            'tag' => $tag !== '' ? $tag : null,
            'description' => 'Berita dan kegiatan terbaru.',
        ]);
    }

    public function category(Request $request, string $slug): View
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $posts = Post::query()
            ->published()
            ->with(['category', 'tags'])
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        return view('public.posts.index', [
            'posts' => $posts,
            'categories' => $this->categories(),
            'category' => $category,
            'tag' => null,
            'description' => 'Berita kategori '.$category->name.'.',
        ]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()
            ->published()
            ->with(['category', 'author', 'tags'])
            ->where('slug', $slug)
            ->firstOrFail();

        $post->increment('views');

        return view('public.posts.show', [
            'post' => $post,
            'categories' => $this->categories(),
            'relatedPosts' => Post::query()
                ->published()
                ->whereKeyNot($post->getKey())
                ->when($post->category_id, fn ($query) => $query->orderByRaw('category_id = ? desc', [$post->category_id]))
                ->latest('published_at')
                ->take(4)
                ->get(['id', 'title', 'slug', 'thumbnail', 'published_at']),
            'description' => $post->excerpt,
        ]);
    }

    /**
     * Kategori yang punya berita terbit, untuk filter.
     *
     * @return Collection<int, Category>
     */
    private function categories(): Collection
    {
        return Category::query()
            ->whereHas('posts', fn ($query) => $query->published())
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);
    }
}
