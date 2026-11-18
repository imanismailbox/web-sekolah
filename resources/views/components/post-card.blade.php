@props(['post', 'headingLevel' => 'h3'])
<article class="card group flex flex-col transition-shadow duration-200 hover:shadow-[0_1px_2px_rgb(6_63_32/0.06),0_18px_36px_-16px_rgb(6_63_32/0.32)]">
    <a href="{{ route('posts.show', $post->slug) }}" class="relative block aspect-[16/10] overflow-hidden bg-brand-100" tabindex="-1" aria-hidden="true">
        @if ($post->thumbnail)
            <img src="{{ Storage::disk('public')->url($post->thumbnail) }}" alt="" loading="lazy" class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">
        @else
            <span class="grid size-full place-items-center bg-[linear-gradient(135deg,var(--color-brand-600),var(--color-brand-800))] text-white/80">
                <x-site-icon name="newspaper" class="size-10" />
            </span>
        @endif
        @if ($post->category)
            <span class="absolute left-3 top-3 rounded-full bg-gold-400 px-2.5 py-0.5 font-display text-[0.6875rem] font-semibold text-brand-950">{{ $post->category->name }}</span>
        @endif
    </a>
    <div class="flex flex-1 flex-col p-5">
        <p class="flex items-center gap-1.5 text-xs text-muted">
            <x-site-icon name="calendar" class="size-3.5" />
            <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d F Y') }}</time>
        </p>
        <{{ $headingLevel }} class="mt-2 font-display text-[1.0625rem] font-semibold leading-snug text-ink">
            <a href="{{ route('posts.show', $post->slug) }}" class="line-clamp-3 hover:text-brand-700">{{ $post->title }}</a>
        </{{ $headingLevel }}>
        @if ($post->excerpt)
            <p class="mt-2 line-clamp-2 text-sm leading-relaxed text-muted">{{ $post->excerpt }}</p>
        @endif
        <a href="{{ route('posts.show', $post->slug) }}" class="link-arrow mt-auto pt-4" aria-label="Baca berita: {{ $post->title }}">
            Baca selengkapnya <x-site-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-0.5" />
        </a>
    </div>
</article>
