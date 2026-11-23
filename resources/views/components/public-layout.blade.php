@props(['title' => null, 'description' => null, 'image' => null])
@php
    $currentUrl = url()->current();
    $pageTitle = $title ? $title.' | '.$settings->site_name : $settings->site_name.($settings->tagline ? ' | '.$settings->tagline : '');
    $pageDescription = \Illuminate\Support\Str::limit(strip_tags($description ?: ($settings->tagline ?? $settings->site_name)), 160);
    $isActive = fn (string $url): bool => $url === $currentUrl || ($url !== url('/') && $url !== '#' && str_starts_with($currentUrl, rtrim($url, '/').'/'));
    $initials = collect(preg_split('/\s+/', trim($settings->site_name)))->filter()->take(2)->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
    $whatsappNumber = $settings->whatsappNumber();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    <link rel="canonical" href="{{ $currentUrl }}">
    <meta name="theme-color" content="#055629">
    <meta property="og:site_name" content="{{ $settings->site_name }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:type" content="website">
    <meta property="og:locale" content="id_ID">
    @if ($image)
        <meta property="og:image" content="{{ $image }}">
        <meta name="twitter:card" content="summary_large_image">
    @endif
    @if ($settings->favicon)
        <link rel="icon" href="{{ Storage::disk('public')->url($settings->favicon) }}">
    @endif
    <link rel="preload" href="/fonts/site/inter-latin-wght-normal.woff2" as="font" type="font/woff2" crossorigin>
    <link rel="preload" href="/fonts/site/poppins-latin-600-normal.woff2" as="font" type="font/woff2" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen flex-col">
    <a href="#konten" class="sr-only z-50 rounded-md bg-gold-400 px-4 py-2 font-semibold text-brand-950 focus:not-sr-only focus:fixed focus:left-4 focus:top-4">Lewati ke konten</a>

    {{-- Topbar: running text berita terbaru + kontak --}}
    <div class="bg-brand-950 text-sm text-brand-100">
        <div class="container-site flex h-10 items-center gap-4">
            <span class="inline-flex shrink-0 items-center gap-1.5 rounded-full bg-gold-400 px-2.5 py-0.5 font-display text-xs font-semibold text-brand-950">
                <x-site-icon name="megaphone" class="size-3.5" />
                Info
            </span>
            <div class="marquee relative min-w-0 flex-1 overflow-hidden [mask-image:linear-gradient(90deg,transparent,#000_2rem,#000_calc(100%-2rem),transparent)] motion-reduce:[mask-image:none]">
                @if ($tickerPosts->isNotEmpty())
                    <div class="marquee-track flex w-max gap-10 whitespace-nowrap motion-reduce:hidden">
                        @foreach ([0, 1] as $copy)
                            <ul class="flex gap-10" @if ($copy === 1) aria-hidden="true" @endif>
                                @foreach ($tickerPosts as $tickerPost)
                                    <li class="flex items-center gap-10">
                                        <a href="{{ route('posts.show', $tickerPost->slug) }}" class="hover:text-white hover:underline" @if ($copy === 1) tabindex="-1" @endif>{{ $tickerPost->title }}</a>
                                        <span class="size-1 rounded-full bg-gold-400" aria-hidden="true"></span>
                                    </li>
                                @endforeach
                            </ul>
                        @endforeach
                    </div>
                    <a href="{{ route('posts.show', $tickerPosts->first()->slug) }}" class="hidden truncate hover:text-white hover:underline motion-reduce:block">{{ $tickerPosts->first()->title }}</a>
                @else
                    <p class="truncate">Selamat datang di website resmi {{ $settings->site_name }}.</p>
                @endif
            </div>
            <div class="hidden shrink-0 items-center gap-5 lg:flex">
                @if ($settings->phone)
                    <a href="tel:{{ $settings->phone }}" class="inline-flex items-center gap-1.5 hover:text-white"><x-site-icon name="phone" class="size-4" />{{ $settings->phone }}</a>
                @endif
                @if ($settings->email)
                    <a href="mailto:{{ $settings->email }}" class="inline-flex items-center gap-1.5 hover:text-white"><x-site-icon name="mail" class="size-4" />{{ $settings->email }}</a>
                @endif
            </div>
        </div>
    </div>

    {{-- Header --}}
    <header class="sticky top-0 z-40 bg-brand-800 text-white shadow-[0_6px_20px_-10px_rgb(3_42_21/0.6)]" data-site-header>
        <div class="container-site flex h-[4.5rem] items-center justify-between gap-6">
            <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
                @if ($logoUrl)
                    <img src="{{ $logoUrl }}" alt="Logo {{ $settings->site_name }}" class="size-12 shrink-0 object-contain">
                @else
                    <span class="grid size-12 shrink-0 place-items-center rounded-full bg-white font-display text-base font-bold text-brand-800 ring-2 ring-gold-400 ring-offset-2 ring-offset-brand-800" aria-hidden="true">{{ $initials }}</span>
                @endif
                <span class="min-w-0">
                    <span class="block text-[0.6875rem] font-medium uppercase tracking-wide text-gold-300"><span class="sm:hidden">Kementerian Agama RI</span><span class="hidden sm:inline">Kementerian Agama Republik Indonesia</span></span>
                    <span class="block truncate font-display text-base font-semibold leading-tight sm:text-lg">{{ $settings->site_name }}</span>
                    @if ($settings->tagline)
                        <span class="hidden truncate text-xs text-brand-100/90 sm:block">{{ $settings->tagline }}</span>
                    @endif
                </span>
            </a>

            <nav aria-label="Navigasi utama" class="hidden lg:block">
                <ul class="flex items-center gap-1">
                    @foreach ($navigation as $item)
                        @php
                            $active = $isActive($item['url']) || collect($item['children'])->contains(fn ($child) => $isActive($child['url']));
                        @endphp
                        <li class="group relative">
                            <a href="{{ $item['url'] }}"
                                @if ($item['newTab']) target="_blank" rel="noopener noreferrer" @endif
                                @if ($isActive($item['url'])) aria-current="page" @endif
                                class="relative flex items-center gap-1 rounded-full px-3.5 py-2 font-display text-sm font-medium transition-colors hover:bg-white/10 {{ $active ? 'bg-white/10 text-white' : 'text-white/85' }}">
                                {{ $item['label'] }}
                                @if ($item['children'])
                                    <x-site-icon name="chevron-down" class="size-4 transition-transform group-hover:rotate-180 group-focus-within:rotate-180" />
                                @endif
                            </a>

                            @if ($item['children'])
                                <div class="invisible absolute left-0 top-full z-30 pt-2 opacity-0 transition duration-150 group-hover:visible group-hover:opacity-100 group-focus-within:visible group-focus-within:opacity-100">
                                    <ul class="min-w-60 rounded-xl bg-white p-2 text-ink shadow-[0_18px_40px_-16px_rgb(3_42_21/0.45)]">
                                        @foreach ($item['children'] as $child)
                                            <li>
                                                <a href="{{ $child['url'] }}"
                                                    @if ($child['newTab']) target="_blank" rel="noopener noreferrer" @endif
                                                    @if ($isActive($child['url'])) aria-current="page" @endif
                                                    class="block rounded-lg px-3 py-2 text-sm hover:bg-brand-50 hover:text-brand-800 {{ $isActive($child['url']) ? 'bg-brand-50 font-semibold text-brand-800' : '' }}">
                                                    {{ $child['label'] }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </nav>

            <button type="button" class="grid size-11 shrink-0 place-items-center rounded-full bg-white/10 hover:bg-white/15 lg:hidden" aria-controls="menu-mobile" aria-expanded="false" data-menu-toggle>
                <span class="sr-only">Buka menu</span>
                <x-site-icon name="menu" class="size-6" data-menu-icon-open />
                <x-site-icon name="x" class="hidden size-6" data-menu-icon-close />
            </button>
        </div>

        {{-- Menu mobile --}}
        <nav id="menu-mobile" aria-label="Navigasi mobile" class="hidden max-h-[calc(100dvh-4.5rem)] overflow-y-auto border-t border-white/10 bg-brand-900 lg:hidden" data-menu-panel>
            <ul class="container-site py-3">
                @foreach ($navigation as $item)
                    <li class="border-b border-white/10 last:border-0">
                        <a href="{{ $item['url'] }}"
                            @if ($item['newTab']) target="_blank" rel="noopener noreferrer" @endif
                            @if ($isActive($item['url'])) aria-current="page" @endif
                            class="flex items-center justify-between py-3 font-display font-medium {{ $isActive($item['url']) ? 'text-gold-300' : 'text-white' }}">
                            {{ $item['label'] }}
                        </a>
                        @if ($item['children'])
                            <ul class="-mt-1 mb-3 space-y-1 border-l border-white/15 pl-4">
                                @foreach ($item['children'] as $child)
                                    <li>
                                        <a href="{{ $child['url'] }}"
                                            @if ($child['newTab']) target="_blank" rel="noopener noreferrer" @endif
                                            class="block py-1.5 text-sm {{ $isActive($child['url']) ? 'text-gold-300' : 'text-brand-100' }}">
                                            {{ $child['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </header>

    <main id="konten" class="flex-1">
        {{ $slot }}
    </main>

    {{-- Footer --}}
    <footer class="mt-auto bg-brand-900 text-brand-100">
        <div class="container-site grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">
            <div>
                <div class="flex items-center gap-3">
                    @if ($logoUrl)
                        <img src="{{ $logoUrl }}" alt="" class="size-12 object-contain">
                    @else
                        <span class="grid size-12 place-items-center rounded-full bg-white font-display text-base font-bold text-brand-800" aria-hidden="true">{{ $initials }}</span>
                    @endif
                    <p class="font-display text-lg font-semibold leading-tight text-white">{{ $settings->site_name }}</p>
                </div>
                @if ($settings->tagline)
                    <p class="mt-4 max-w-sm text-sm leading-relaxed">{{ $settings->tagline }}</p>
                @endif
                <ul class="mt-5 space-y-3 text-sm">
                    @if ($settings->address)
                        <li class="flex gap-3"><x-site-icon name="map-pin" class="mt-0.5 size-4 text-gold-400" /><span class="whitespace-pre-line">{{ $settings->address }}</span></li>
                    @endif
                    @if ($settings->phone)
                        <li><a href="tel:{{ $settings->phone }}" class="flex gap-3 hover:text-white"><x-site-icon name="phone" class="mt-0.5 size-4 text-gold-400" />{{ $settings->phone }}</a></li>
                    @endif
                    @if ($settings->email)
                        <li><a href="mailto:{{ $settings->email }}" class="flex gap-3 hover:text-white"><x-site-icon name="mail" class="mt-0.5 size-4 text-gold-400" />{{ $settings->email }}</a></li>
                    @endif
                </ul>
            </div>

            <div>
                <h2 class="font-display text-sm font-semibold text-white">Jelajahi</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('posts.index') }}" class="hover:text-white">Berita</a></li>
                    <li><a href="{{ route('albums.index') }}" class="hover:text-white">Galeri</a></li>
                    <li><a href="{{ route('staff.index') }}" class="hover:text-white">Guru &amp; Pegawai</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Kontak</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-display text-sm font-semibold text-white">Transparansi</h2>
                <ul class="mt-4 space-y-2.5 text-sm">
                    <li><a href="{{ route('pkkm.index') }}" class="hover:text-white">Penilaian Kinerja Kepala Madrasah</a></li>
                    <li><a href="{{ route('complaints.create') }}" class="hover:text-white">Aduan &amp; Saran</a></li>
                    <li><a href="{{ route('sitemap') }}" class="hover:text-white">Peta situs</a></li>
                </ul>
            </div>

            <div>
                <h2 class="font-display text-sm font-semibold text-white">Ikuti Kami</h2>
                @if ($socialLinks)
                    <ul class="mt-4 flex flex-wrap gap-2.5">
                        @foreach ($socialLinks as $network => $socialUrl)
                            <li>
                                <a href="{{ $socialUrl }}" target="_blank" rel="noopener noreferrer" class="grid size-10 place-items-center rounded-full bg-white/10 text-white transition-colors hover:bg-gold-400 hover:text-brand-950">
                                    <x-site-icon :name="$network" class="size-[1.125rem]" />
                                    <span class="sr-only">{{ ucfirst($network) }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
                @if ($whatsappNumber)
                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="btn-gold mt-5">
                        <x-site-icon name="message-circle" class="size-4" />
                        Chat WhatsApp
                    </a>
                @elseif (! $socialLinks)
                    <p class="mt-4 text-sm">Hubungi kami lewat halaman <a href="{{ route('contact') }}" class="text-white underline">Kontak</a>.</p>
                @endif

                <section aria-label="Statistik pengunjung" class="mt-6 border-t border-white/10 pt-5">
                    <h3 class="flex items-center gap-2 font-display text-sm font-semibold text-white">
                        <x-site-icon name="bar-chart" class="size-4 text-gold-400" />
                        <span>Statistik Pengunjung</span>
                    </h3>
                    <dl class="mt-3 grid grid-cols-4 gap-1.5 text-center">
                        <div class="rounded-lg bg-white/5 px-1.5 py-2 ring-1 ring-white/10">
                            <dt class="flex items-center justify-center gap-1 whitespace-nowrap text-[10px] text-brand-200">
                                <span class="size-1.5 shrink-0 rounded-full bg-brand-400 motion-safe:animate-pulse" aria-hidden="true"></span>
                                Online
                            </dt>
                            <dd class="mt-1 font-display text-sm font-semibold tabular-nums text-white" data-visitor-stat="online">
                                {{ number_format($visitorStats['online'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="rounded-lg bg-white/5 px-1.5 py-2 ring-1 ring-white/10">
                            <dt class="whitespace-nowrap text-[10px] text-brand-200">Hari Ini</dt>
                            <dd class="mt-1 font-display text-sm font-semibold tabular-nums text-white" data-visitor-stat="today">
                                {{ number_format($visitorStats['today'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="rounded-lg bg-white/5 px-1.5 py-2 ring-1 ring-white/10">
                            <dt class="whitespace-nowrap text-[10px] text-brand-200">Bulan Ini</dt>
                            <dd class="mt-1 font-display text-sm font-semibold tabular-nums text-white" data-visitor-stat="month">
                                {{ number_format($visitorStats['month'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div class="rounded-lg bg-white/5 px-1.5 py-2 ring-1 ring-white/10">
                            <dt class="whitespace-nowrap text-[10px] text-brand-200">Total</dt>
                            <dd class="mt-1 font-display text-sm font-semibold tabular-nums text-white" data-visitor-stat="total">
                                {{ number_format($visitorStats['total'], 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </section>
            </div>
        </div>

        <div class="border-t border-white/10">
            <div class="container-site flex flex-col gap-2 py-5 text-xs text-brand-200 sm:flex-row sm:items-center sm:justify-between">
                <p>&copy; {{ now()->year }} {{ $settings->site_name }}. Hak cipta dilindungi.</p>
                @if ($settings->footer_text)
                    <p>{{ $settings->footer_text }}</p>
                @endif
            </div>
        </div>
    </footer>

    @if ($settings->background_music_enabled && $settings->background_music)
        {{-- Musik latar: diputar otomatis; jika diblokir browser, mulai pada interaksi pertama. Posisi putar diingat antar halaman. --}}
        <audio id="background-music" src="{{ Storage::disk('public')->url($settings->background_music) }}" loop preload="auto"></audio>
        <button type="button" class="fixed bottom-4 left-4 z-40 grid size-12 place-items-center rounded-full bg-brand-800 text-white shadow-[0_10px_30px_-10px_rgb(3_42_21/0.7)] ring-2 ring-gold-400 hover:bg-brand-700 focus-visible:outline-none focus-visible:ring-4 focus-visible:ring-gold-300" data-music-toggle aria-pressed="false" aria-label="Putar musik latar">
            <x-site-icon name="play" class="size-5" data-music-icon-play />
            <x-site-icon name="pause" class="hidden size-5" data-music-icon-pause />
        </button>
        <script>
            (function () {
                const audio = document.getElementById('background-music');
                const button = document.querySelector('[data-music-toggle]');
                const playIcon = button.querySelector('[data-music-icon-play]');
                const pauseIcon = button.querySelector('[data-music-icon-pause]');
                const preferenceKey = 'backgroundMusic:preference';
                const positionKey = 'backgroundMusic:position';
                let wantsPlaying = localStorage.getItem(preferenceKey) !== 'paused';

                const render = () => {
                    const playing = !audio.paused;
                    button.setAttribute('aria-pressed', String(playing));
                    button.setAttribute('aria-label', playing ? 'Jeda musik latar' : 'Putar musik latar');
                    playIcon.classList.toggle('hidden', playing);
                    pauseIcon.classList.toggle('hidden', !playing);
                };

                const tryPlay = () => audio.play().catch(() => {});

                audio.addEventListener('loadedmetadata', () => {
                    const savedPosition = parseFloat(sessionStorage.getItem(positionKey));
                    if (Number.isFinite(savedPosition) && savedPosition < audio.duration) {
                        audio.currentTime = savedPosition;
                    }
                });
                audio.addEventListener('timeupdate', () => {
                    sessionStorage.setItem(positionKey, String(audio.currentTime));
                });
                audio.addEventListener('play', render);
                audio.addEventListener('pause', render);

                button.addEventListener('click', () => {
                    if (audio.paused) {
                        wantsPlaying = true;
                        localStorage.setItem(preferenceKey, 'playing');
                        tryPlay();
                    } else {
                        wantsPlaying = false;
                        localStorage.setItem(preferenceKey, 'paused');
                        audio.pause();
                    }
                });

                if (wantsPlaying) {
                    tryPlay();
                    ['pointerdown', 'keydown', 'touchend'].forEach((eventName) => {
                        window.addEventListener(eventName, () => {
                            if (wantsPlaying && audio.paused) {
                                tryPlay();
                            }
                        }, { once: true, passive: true });
                    });
                }

                render();
            })();
        </script>
    @endif
</body>
</html>
