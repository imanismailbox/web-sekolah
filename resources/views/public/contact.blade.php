@php
    $settings = app(\App\Settings\GeneralSettings::class);
    $whatsappNumber = $settings->whatsappNumber();
    $socials = array_filter([
        'facebook' => $settings->facebook,
        'instagram' => $settings->instagram,
        'youtube' => $settings->youtube,
        'tiktok' => $settings->tiktok,
    ]);
    $channels = array_filter([
        ['icon' => 'map-pin', 'label' => 'Alamat', 'value' => $settings->address, 'href' => null],
        ['icon' => 'phone', 'label' => 'Telepon', 'value' => $settings->phone, 'href' => $settings->phone ? 'tel:'.$settings->phone : null],
        ['icon' => 'message-circle', 'label' => 'WhatsApp', 'value' => $settings->whatsapp, 'href' => $whatsappNumber ? 'https://wa.me/'.$whatsappNumber : null],
        ['icon' => 'mail', 'label' => 'Email', 'value' => $settings->email, 'href' => $settings->email ? 'mailto:'.$settings->email : null],
    ], fn (array $channel): bool => filled($channel['value']));
@endphp
<x-public-layout title="Kontak" description="Alamat, telepon, WhatsApp, dan email {{ $settings->site_name }}.">
    <x-page-header title="Hubungi Kami" :breadcrumbs="['Kontak' => null]" lead="Kami siap membantu informasi pendaftaran, kegiatan, dan layanan madrasah." />

    <div class="container-site py-12 lg:py-16">
        @if (empty($channels) && empty($socials) && ! $settings->maps_embed)
            <x-empty-state icon="phone" title="Informasi kontak belum diisi" message="Alamat dan nomor kontak madrasah akan tampil di sini." />
        @else
            <div @class(["grid gap-8", "lg:grid-cols-[minmax(0,5fr)_minmax(0,7fr)]" => $settings->maps_embed])>
                <div @class(["space-y-4", "grid items-start gap-4 space-y-0 md:grid-cols-2" => ! $settings->maps_embed])>
                    @foreach ($channels as $channel)
                        <div class="card flex gap-4 p-5">
                            <span class="grid size-11 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-700"><x-site-icon :name="$channel['icon']" /></span>
                            <div class="min-w-0">
                                <h2 class="font-display text-sm font-semibold text-muted">{{ $channel['label'] }}</h2>
                                @if ($channel['href'])
                                    <a href="{{ $channel['href'] }}" @if (str_starts_with($channel['href'], 'https://')) target="_blank" rel="noopener noreferrer" @endif class="mt-0.5 block break-words font-medium text-ink hover:text-brand-700">{{ $channel['value'] }}</a>
                                @else
                                    <p class="mt-0.5 whitespace-pre-line font-medium text-ink">{{ $channel['value'] }}</p>
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode(str_replace("\n", ' ', $channel['value'])) }}" target="_blank" rel="noopener noreferrer" class="link-arrow mt-2">Buka di Google Maps <x-site-icon name="external-link" class="size-3.5" /></a>
                                @endif
                            </div>
                        </div>
                    @endforeach

                    @if ($socials)
                        <div class="card p-5">
                            <h2 class="font-display text-sm font-semibold text-muted">Media sosial</h2>
                            <ul class="mt-3 flex flex-wrap gap-2">
                                @foreach ($socials as $network => $socialUrl)
                                    <li>
                                        <a href="{{ $socialUrl }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-full bg-brand-50 px-4 py-2 text-sm font-medium text-brand-800 hover:bg-brand-100">
                                            <x-site-icon :name="$network" class="size-4" />{{ ucfirst($network) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($whatsappNumber)
                        <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="btn-primary w-full self-start py-3.5 text-base"><x-site-icon name="message-circle" />Chat lewat WhatsApp</a>
                    @endif

                    <div class="card p-5">
                        <h2 class="font-display text-sm font-semibold text-brand-900">Aduan, Kritik &amp; Saran</h2>
                        <p class="mt-1.5 text-sm text-muted">Sampaikan masukan atau laporan Anda secara langsung melalui formulir resmi madrasah.</p>
                        <a href="{{ route('complaints.create') }}" class="link-arrow mt-3">Isi Formulir Aduan <x-site-icon name="arrow-right" class="size-4" /></a>
                    </div>
                </div>

                @if ($settings->maps_embed)
                    {{-- Kode embed dari admin (tepercaya) --}}
                    <div class="card min-h-96 [&_iframe]:size-full [&_iframe]:min-h-96">{!! $settings->maps_embed !!}</div>
                @endif
            </div>
        @endif
    </div>
</x-public-layout>
