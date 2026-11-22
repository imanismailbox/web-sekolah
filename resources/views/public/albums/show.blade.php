@php
    $videoCount = $album->photos->filter->isVideo()->count();
    $photoCount = $album->photos->count() - $videoCount;
    $mediaCounts = array_filter([
        $photoCount > 0 ? $photoCount.' foto' : null,
        $videoCount > 0 ? $videoCount.' video' : null,
    ]);
    $mediaSummary = $mediaCounts !== [] ? implode(' · ', $mediaCounts) : '0 media';
@endphp

<x-public-layout :title="$album->title" :description="$album->description" :image="$album->cover ? Storage::disk('public')->url($album->cover) : null">
    <x-page-header :title="$album->title" :breadcrumbs="['Galeri' => route('albums.index'), $album->title => null]" :lead="$album->description">
        <ul class="mt-5 flex flex-wrap gap-x-5 gap-y-2 text-sm text-brand-100">
            @if ($album->event_date)
                <li class="flex items-center gap-1.5"><x-site-icon name="calendar" class="size-4 text-gold-400" />{{ $album->event_date->translatedFormat('l, d F Y') }}</li>
            @endif
            <li class="flex items-center gap-1.5"><x-site-icon name="images" class="size-4 text-gold-400" />{{ $mediaSummary }}</li>
        </ul>
    </x-page-header>

    <div class="container-site py-12 lg:py-16">
        @if ($album->photos->isEmpty())
            <x-empty-state icon="images" title="Belum ada media" message="Foto atau video untuk album ini belum diunggah." />
        @else
            <h2 class="sr-only">Foto dan video</h2>
            <ul class="grid grid-cols-2 gap-3 sm:gap-4 md:grid-cols-3 lg:grid-cols-4">
                @foreach ($album->photos as $photo)
                    @php
                        $mediaUrl = Storage::disk('public')->url($photo->image);
                        $isVideo = $photo->isVideo();
                    @endphp
                    <li>
                        <figure class="relative">
                            @if ($isVideo)
                                <a href="{{ $mediaUrl }}" class="group relative block overflow-hidden rounded-xl bg-brand-950" data-lightbox-item data-media-type="video" data-caption="{{ $photo->caption }}" aria-label="{{ $photo->caption ?? 'Video '.$loop->iteration.' '.$album->title }}">
                                    <video src="{{ $mediaUrl }}#t=0.1" muted playsinline preload="metadata" class="aspect-square w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:opacity-90"></video>
                                    <span class="pointer-events-none absolute inset-0 grid place-items-center bg-brand-950/20">
                                        <span class="grid size-12 place-items-center rounded-full bg-brand-950/80 text-white shadow-lg ring-1 ring-white/25 transition duration-300 group-hover:scale-110 group-hover:bg-brand-900">
                                            <x-site-icon name="play" class="size-5 translate-x-0.5 fill-current" />
                                        </span>
                                    </span>
                                    <span class="pointer-events-none absolute right-2.5 top-2.5 rounded-full bg-brand-950/80 px-2 py-0.5 text-[11px] font-medium text-white">Video</span>
                                </a>
                            @else
                                <a href="{{ $mediaUrl }}" class="group block overflow-hidden rounded-xl bg-brand-100" data-lightbox-item data-media-type="image" data-caption="{{ $photo->caption }}">
                                    <img src="{{ $mediaUrl }}" alt="{{ $photo->caption ?? 'Foto '.$loop->iteration.' '.$album->title }}" loading="lazy" class="aspect-square w-full object-cover transition duration-300 group-hover:scale-[1.03] group-hover:opacity-90">
                                </a>
                            @endif
                            @if ($photo->caption)
                                <figcaption class="pointer-events-none absolute inset-x-0 bottom-0 rounded-b-xl bg-[linear-gradient(to_top,rgb(3_42_21/0.85),transparent)] px-3 pb-2.5 pt-8 text-xs text-white sm:text-sm">{{ $photo->caption }}</figcaption>
                            @endif
                        </figure>
                    </li>
                @endforeach
            </ul>

            <dialog class="m-auto size-full max-h-none max-w-none bg-transparent p-0 backdrop:bg-brand-950/95" data-lightbox aria-label="Penampil galeri">
                <div class="flex size-full flex-col text-white">
                    <div class="flex items-center justify-between p-4">
                        <p class="text-sm tabular-nums text-brand-100" data-lightbox-counter></p>
                        <button type="button" class="grid size-11 place-items-center rounded-full bg-white/10 hover:bg-white/20" data-lightbox-close><x-site-icon name="x" /><span class="sr-only">Tutup</span></button>
                    </div>
                    <div class="relative flex min-h-0 flex-1 items-center justify-center px-4">
                        <img alt="" class="max-h-full max-w-full rounded-lg object-contain" data-lightbox-image>
                        <video controls playsinline class="hidden max-h-full max-w-full rounded-lg bg-black" data-lightbox-video></video>
                        <button type="button" class="absolute left-3 top-1/2 grid size-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 hover:bg-white/20 sm:left-6" data-lightbox-prev><x-site-icon name="chevron-left" /><span class="sr-only">Media sebelumnya</span></button>
                        <button type="button" class="absolute right-3 top-1/2 grid size-11 -translate-y-1/2 place-items-center rounded-full bg-white/10 hover:bg-white/20 sm:right-6" data-lightbox-next><x-site-icon name="chevron-right" /><span class="sr-only">Media berikutnya</span></button>
                    </div>
                    <p class="min-h-14 p-4 text-center text-sm text-brand-100" data-lightbox-caption></p>
                </div>
            </dialog>
        @endif

        <a href="{{ route('albums.index') }}" class="link-arrow mt-10"><x-site-icon name="arrow-left" class="size-4" />Kembali ke galeri</a>
    </div>
</x-public-layout>
