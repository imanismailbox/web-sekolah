@props(['title', 'breadcrumbs' => [], 'lead' => null, 'image' => null])
{{-- $breadcrumbs: array label => url (url null untuk halaman aktif) --}}
{{-- $image: path di disk public; kosong = gambar header dari Pengaturan Situs --}}
@php
    $headerImage = $image ?: app(\App\Settings\GeneralSettings::class)->page_header_image;
@endphp
<section class="relative overflow-hidden border-b-4 border-gold-400 bg-brand-700 text-white">
    @if ($headerImage)
        <img src="{{ Storage::disk('public')->url($headerImage) }}" alt="" aria-hidden="true" class="absolute inset-0 size-full object-cover" data-page-header-image>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-900/90 via-brand-800/80 to-brand-700/60" aria-hidden="true"></div>
    @endif
    <div class="container-site relative py-10 md:py-14">
        <nav aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-1.5 text-sm text-brand-100">
                <li><a href="{{ route('home') }}" class="inline-flex items-center gap-1 hover:text-white"><x-site-icon name="home" class="size-4" /><span class="sr-only">Beranda</span></a></li>
                @foreach ($breadcrumbs as $label => $url)
                    <li @class(['items-center gap-1.5', 'flex' => $url, 'hidden sm:flex' => ! $url])>
                        <x-site-icon name="chevron-right" class="size-3.5 text-brand-300" />
                        @if ($url)
                            <a href="{{ $url }}" class="hover:text-white">{{ $label }}</a>
                        @else
                            <span aria-current="page" class="text-white">{{ \Illuminate\Support\Str::limit($label, 60) }}</span>
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
        <h1 class="mt-4 max-w-4xl text-3xl font-semibold leading-tight tracking-tight md:text-[2.5rem]">{{ $title }}</h1>
        @if ($lead)
            <p class="mt-3 max-w-2xl text-brand-100">{{ $lead }}</p>
        @endif
        {{ $slot }}
    </div>
</section>
