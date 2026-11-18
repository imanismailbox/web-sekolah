<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Category;
use App\Models\Page;
use App\Models\PkkmYear;
use App\Models\Post;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $urls = [
            ['loc' => route('home'), 'lastmod' => null],
            ['loc' => route('posts.index'), 'lastmod' => null],
            ['loc' => route('albums.index'), 'lastmod' => null],
            ['loc' => route('staff.index'), 'lastmod' => null],
            ['loc' => route('pkkm.index'), 'lastmod' => null],
            ['loc' => route('contact'), 'lastmod' => null],
        ];

        foreach (Category::query()->get() as $category) {
            $urls[] = ['loc' => route('posts.category', $category->slug), 'lastmod' => null];
        }

        foreach (Post::query()->published()->get(['slug', 'updated_at']) as $post) {
            $urls[] = ['loc' => route('posts.show', $post->slug), 'lastmod' => $post->updated_at];
        }

        foreach (Album::query()->published()->get(['slug', 'updated_at']) as $album) {
            $urls[] = ['loc' => route('albums.show', $album->slug), 'lastmod' => $album->updated_at];
        }

        foreach (PkkmYear::query()->published()->get(['slug', 'updated_at']) as $pkkmYear) {
            $urls[] = ['loc' => route('pkkm.show', $pkkmYear->slug), 'lastmod' => $pkkmYear->updated_at];
        }

        foreach (Page::query()->published()->get(['slug', 'updated_at']) as $page) {
            $urls[] = ['loc' => route('pages.show', $page->slug), 'lastmod' => $page->updated_at];
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
            .view('public.sitemap', ['urls' => $urls])->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
