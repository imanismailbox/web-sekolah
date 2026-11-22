<x-public-layout title="Galeri" :description="$description">
    <x-page-header title="Galeri Kegiatan" :breadcrumbs="['Galeri' => null]" lead="Dokumentasi foto dan video kegiatan siswa, guru, dan madrasah." />

    <div class="container-site py-12 lg:py-16">
        @if ($albums->isEmpty())
            <x-empty-state icon="images" title="Belum ada album" message="Dokumentasi kegiatan madrasah akan tampil di sini setelah diterbitkan." />
        @else
            <h2 class="sr-only">Daftar album</h2>
            <ul class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($albums as $album)
                    <li>
                        <a href="{{ route('albums.show', $album->slug) }}" class="card group block">
                            <div class="relative aspect-[4/3] overflow-hidden bg-brand-700">
                                @if ($album->cover)
                                    <img src="{{ Storage::disk('public')->url($album->cover) }}" alt="" loading="lazy" class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.04]">
                                @else
                                    <span class="grid size-full place-items-center text-white/50"><x-site-icon name="images" class="size-12" /></span>
                                @endif
                                <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-brand-950/80 px-2.5 py-1 text-xs font-medium text-white">
                                    <x-site-icon name="images" class="size-3.5" />{{ $album->photos_count }} media
                                </span>
                            </div>
                            <div class="p-5">
                                <h3 class="font-display text-lg font-semibold leading-snug text-ink group-hover:text-brand-700">{{ $album->title }}</h3>
                                @if ($album->event_date)
                                    <p class="mt-1.5 flex items-center gap-1.5 text-sm text-muted"><x-site-icon name="calendar" class="size-4" />{{ $album->event_date->translatedFormat('d F Y') }}</p>
                                @endif
                                @if ($album->description)
                                    <p class="mt-2 line-clamp-2 text-sm text-muted">{{ $album->description }}</p>
                                @endif
                            </div>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="mt-12">{{ $albums->links('public.partials.pagination') }}</div>
        @endif
    </div>
</x-public-layout>
