<x-public-layout :title="$post->title" :description="$post->excerpt" :image="$post->thumbnail ? Storage::disk('public')->url($post->thumbnail) : null">
    <x-page-header :title="$post->title" :breadcrumbs="array_filter(['Berita' => route('posts.index'), $post->category?->name => $post->category ? route('posts.category', $post->category->slug) : false, $post->title => null], fn ($url) => $url !== false)">
        <ul class="mt-5 flex flex-wrap items-center gap-x-5 gap-y-2 text-sm text-brand-100">
            <li class="flex items-center gap-1.5"><x-site-icon name="calendar" class="size-4 text-gold-400" /><time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('l, d F Y') }}</time></li>
            @if ($post->author)
                <li class="flex items-center gap-1.5"><x-site-icon name="user" class="size-4 text-gold-400" />{{ $post->author->name }}</li>
            @endif
            <li class="flex items-center gap-1.5"><x-site-icon name="eye" class="size-4 text-gold-400" /><span class="tabular-nums">{{ number_format($post->views, 0, ',', '.') }}</span>&nbsp;kali dibaca</li>
        </ul>
    </x-page-header>

    <div class="container-site grid gap-12 py-12 lg:grid-cols-[minmax(0,1fr)_20rem] lg:py-16">
        <article>
            @if ($post->thumbnail)
                <img src="{{ Storage::disk('public')->url($post->thumbnail) }}" alt="{{ $post->title }}" class="mb-10 aspect-[16/9] w-full rounded-xl object-cover">
            @endif
            {{-- Konten dari editor admin (tepercaya) --}}
            <div class="prose-site">{!! $post->content !!}</div>

            @if ($post->tags->isNotEmpty())
                <div class="mt-12 flex flex-wrap items-center gap-2 border-t border-line pt-6">
                    <x-site-icon name="tag" class="size-4 text-brand-600" />
                    @foreach ($post->tags as $tagItem)
                        <a href="{{ route('posts.index', ['tag' => $tagItem->name]) }}" class="chip hover:bg-brand-100">#{{ $tagItem->name }}</a>
                    @endforeach
                </div>
            @endif

            <a href="{{ route('posts.index') }}" class="link-arrow mt-10"><x-site-icon name="arrow-left" class="size-4" />Kembali ke berita</a>
        </article>

        <aside class="space-y-8" aria-label="Berita lainnya">
            @if ($relatedPosts->isNotEmpty())
                <section>
                    <h2 class="font-display text-lg font-semibold text-brand-900">Berita lainnya</h2>
                    <ul class="mt-4 divide-y divide-line rounded-xl bg-white shadow-sm">
                        @foreach ($relatedPosts as $relatedPost)
                            <li class="group relative flex gap-3 p-4">
                                <div class="size-16 shrink-0 overflow-hidden rounded-lg bg-brand-100">
                                    @if ($relatedPost->thumbnail)
                                        <img src="{{ Storage::disk('public')->url($relatedPost->thumbnail) }}" alt="" loading="lazy" class="size-full object-cover">
                                    @else
                                        <span class="grid size-full place-items-center text-brand-500"><x-site-icon name="newspaper" class="size-5" /></span>
                                    @endif
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('posts.show', $relatedPost->slug) }}" class="line-clamp-2 font-display text-sm font-semibold leading-snug text-ink after:absolute after:inset-0 group-hover:text-brand-700">{{ $relatedPost->title }}</a>
                                    <p class="mt-1 text-xs text-muted">{{ $relatedPost->published_at?->translatedFormat('d M Y') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif

            @if ($categories->isNotEmpty())
                <section>
                    <h2 class="font-display text-lg font-semibold text-brand-900">Kategori</h2>
                    <ul class="mt-4 flex flex-wrap gap-2">
                        @foreach ($categories as $categoryItem)
                            <li><a href="{{ route('posts.category', $categoryItem->slug) }}" class="chip hover:bg-brand-100">{{ $categoryItem->name }}</a></li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</x-public-layout>
