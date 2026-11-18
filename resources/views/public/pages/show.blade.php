<x-public-layout :title="$page->title" :description="\Illuminate\Support\Str::limit(strip_tags($page->content), 160)" :image="$page->featured_image ? Storage::disk('public')->url($page->featured_image) : null">
    <x-page-header :title="$page->title" :breadcrumbs="[$page->title => null]" />

    <div class="container-site py-12 lg:py-16">
        <article class="mx-auto max-w-3xl">
            @if ($page->featured_image)
                <img src="{{ Storage::disk('public')->url($page->featured_image) }}" alt="{{ $page->title }}" class="mb-10 aspect-[16/9] w-full rounded-xl object-cover">
            @endif
            {{-- Konten dari editor admin (tepercaya) --}}
            <div class="prose-site">{!! $page->content !!}</div>
        </article>
    </div>
</x-public-layout>
