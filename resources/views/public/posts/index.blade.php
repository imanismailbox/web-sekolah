@php
    $heading = $category ? $category->name : ($tag ? 'Tag: '.$tag : 'Berita');
    $breadcrumbs = $category || $tag ? ['Berita' => route('posts.index'), $heading => null] : ['Berita' => null];
@endphp
<x-public-layout :title="$heading" :description="$description">
    <x-page-header :title="$heading" :breadcrumbs="$breadcrumbs" :lead="$category?->description ?? 'Kabar kegiatan, prestasi, dan pengumuman madrasah.'" />

    <div class="container-site py-12 lg:py-16">
        @if ($categories->isNotEmpty())
            <nav aria-label="Kategori berita" class="-mx-4 overflow-x-auto px-4 sm:mx-0 sm:px-0">
                <ul class="flex gap-2 whitespace-nowrap">
                    <li><a href="{{ route('posts.index') }}" @class(['rounded-full px-4 py-2 font-display text-sm font-medium transition-colors', 'bg-brand-600 text-white' => ! $category && ! $tag, 'bg-white text-ink shadow-sm hover:bg-brand-50' => $category || $tag]) @if (! $category && ! $tag) aria-current="page" @endif>Semua</a></li>
                    @foreach ($categories as $categoryItem)
                        <li><a href="{{ route('posts.category', $categoryItem->slug) }}" @class(['rounded-full px-4 py-2 font-display text-sm font-medium transition-colors', 'bg-brand-600 text-white' => $category?->is($categoryItem), 'bg-white text-ink shadow-sm hover:bg-brand-50' => ! $category?->is($categoryItem)]) @if ($category?->is($categoryItem)) aria-current="page" @endif>{{ $categoryItem->name }}</a></li>
                    @endforeach
                </ul>
            </nav>
        @endif

        @if ($tag)
            <p class="mt-6 flex items-center gap-2 text-sm text-muted">
                <x-site-icon name="tag" class="size-4 text-brand-600" />
                Menampilkan berita dengan tag <span class="font-semibold text-ink">#{{ $tag }}</span>
                <a href="{{ route('posts.index') }}" class="ml-1 font-medium text-brand-700 hover:underline">Hapus filter</a>
            </p>
        @endif

        @if ($posts->isEmpty())
            <x-empty-state class="mt-8" icon="newspaper" title="Belum ada berita" :message="$category || $tag ? 'Tidak ada berita untuk filter ini.' : 'Berita akan tampil di sini setelah diterbitkan.'">
                @if ($category || $tag)
                    <a href="{{ route('posts.index') }}" class="btn-outline mt-6">Lihat semua berita</a>
                @endif
            </x-empty-state>
        @else
            <h2 class="sr-only">Daftar berita</h2>
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>
            <div class="mt-12">{{ $posts->links('public.partials.pagination') }}</div>
        @endif
    </div>
</x-public-layout>
