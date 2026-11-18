@php
    $quickLinks = [
        ['route' => route('posts.index'), 'icon' => 'newspaper', 'label' => 'Berita', 'text' => 'Kabar dan kegiatan terbaru'],
        ['route' => route('albums.index'), 'icon' => 'images', 'label' => 'Galeri', 'text' => 'Dokumentasi foto kegiatan'],
        ['route' => route('staff.index'), 'icon' => 'users', 'label' => 'Guru & Pegawai', 'text' => 'Pendidik dan tenaga kependidikan'],
        ['route' => route('pkkm.index'), 'icon' => 'clipboard-check', 'label' => 'PKKM', 'text' => 'Penilaian Kinerja Kepala Madrasah'],
    ];
    $leadPost = $latestPosts->first();
    $otherPosts = $latestPosts->slice(1);
    $whatsappNumber = $settings->whatsappNumber();
@endphp
<x-public-layout :description="$settings->tagline" :image="$slides->first() ? Storage::disk('public')->url($slides->first()->image) : null">
    {{-- Banner --}}
    @if ($slides->isNotEmpty())
        <section class="relative bg-brand-950" aria-roledescription="carousel" aria-label="Sorotan" data-slider>
            <h1 class="sr-only">{{ $settings->site_name }}</h1>
            <div class="flex snap-x snap-mandatory overflow-x-auto scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden" data-slider-track>
                @foreach ($slides as $slide)
                    <article class="relative w-full shrink-0 snap-start" aria-roledescription="slide" aria-label="{{ $loop->iteration }} dari {{ $loop->count }}">
                        <img src="{{ Storage::disk('public')->url($slide->image) }}" alt="{{ $slide->title ?? '' }}" class="h-[22rem] w-full object-cover sm:h-[28rem] lg:h-[36rem]" @if (! $loop->first) loading="lazy" @endif>
                        @if ($slide->title || $slide->caption || ($slide->url && $slide->button_label))
                            <div class="absolute inset-0 bg-[linear-gradient(to_top,rgb(3_42_21/0.88),rgb(3_42_21/0.35)_45%,transparent_75%)]"></div>
                            <div class="container-site absolute inset-x-0 bottom-0 pb-28 sm:pb-32 lg:pb-36">
                                <div class="max-w-2xl text-white">
                                    @if ($slide->title)
                                        <h2 class="text-2xl font-semibold leading-tight tracking-tight sm:text-4xl lg:text-5xl">{{ $slide->title }}</h2>
                                    @endif
                                    @if ($slide->caption)
                                        <p class="mt-3 text-base text-white/85 sm:text-lg">{{ $slide->caption }}</p>
                                    @endif
                                    @if ($slide->url && $slide->button_label)
                                        <a href="{{ $slide->url }}" class="btn-gold mt-6">{{ $slide->button_label }} <x-site-icon name="arrow-right" class="size-4" /></a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </article>
                @endforeach
            </div>

            @if ($slides->count() > 1)
                <div class="container-site pointer-events-none absolute inset-x-0 bottom-16 flex items-center justify-between sm:bottom-20 lg:bottom-24">
                    <div class="pointer-events-auto flex gap-2">
                        @foreach ($slides as $slide)
                            <button type="button" class="h-1.5 w-6 rounded-full bg-white/40 transition-all aria-[current=true]:w-10 aria-[current=true]:bg-gold-400" data-slider-dot>
                                <span class="sr-only">Tampilkan slide {{ $loop->iteration }}</span>
                            </button>
                        @endforeach
                    </div>
                    <div class="pointer-events-auto hidden gap-2 sm:flex">
                        <button type="button" class="grid size-11 place-items-center rounded-full bg-brand-950/60 text-white hover:bg-brand-950/80" data-slider-prev><x-site-icon name="chevron-left" /><span class="sr-only">Slide sebelumnya</span></button>
                        <button type="button" class="grid size-11 place-items-center rounded-full bg-brand-950/60 text-white hover:bg-brand-950/80" data-slider-next><x-site-icon name="chevron-right" /><span class="sr-only">Slide berikutnya</span></button>
                    </div>
                </div>
            @endif
        </section>
    @else
        <section class="relative overflow-hidden bg-brand-700 text-white">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(ellipse_at_85%_20%,rgb(255_255_255/0.14),transparent_55%),radial-gradient(ellipse_at_10%_110%,rgb(3_42_21/0.55),transparent_60%)]" aria-hidden="true"></div>
            <div class="container-site relative grid items-center gap-10 pb-28 pt-16 sm:pt-20 lg:grid-cols-[minmax(0,1fr)_24rem] lg:pb-36 lg:pt-24">
                <div class="max-w-3xl">
                    <h1 class="text-4xl font-bold leading-[1.1] tracking-tight sm:text-5xl lg:text-6xl">{{ $settings->site_name }}</h1>
                    @if ($settings->tagline)
                        <p class="mt-5 max-w-2xl text-lg text-brand-50 sm:text-xl">{{ $settings->tagline }}</p>
                    @endif
                    @if ($settings->address)
                        <p class="mt-4 flex items-start gap-2 text-sm text-brand-100"><x-site-icon name="map-pin" class="mt-0.5 size-4 text-gold-400" />{{ \Illuminate\Support\Str::limit(str_replace("\n", ', ', $settings->address), 120) }}</p>
                    @endif
                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('posts.index') }}" class="btn-gold">Berita terbaru <x-site-icon name="arrow-right" class="size-4" /></a>
                        <a href="{{ route('contact') }}" class="btn-outline-light">Hubungi kami</a>
                    </div>
                </div>
                @if ($leadPost)
                    <a href="{{ route('posts.show', $leadPost->slug) }}" class="group hidden rounded-2xl bg-brand-900/60 p-6 ring-1 ring-white/10 transition-colors hover:bg-brand-900/80 lg:block">
                        <span class="block font-display text-lg font-semibold leading-snug group-hover:underline">{{ $leadPost->title }}</span>
                        <span class="mt-3 flex items-center justify-between gap-3 text-sm text-brand-100">
                            <time datetime="{{ $leadPost->published_at?->toDateString() }}">{{ $leadPost->published_at?->translatedFormat('d F Y') }}</time>
                            <x-site-icon name="arrow-right" class="size-4 text-gold-400 transition-transform group-hover:translate-x-0.5" />
                        </span>
                    </a>
                @endif
            </div>
        </section>
    @endif

    {{-- Tautan cepat --}}
    <section aria-label="Tautan cepat" class="relative z-10">
        <div class="container-site">
            <ul class="-mt-12 grid grid-cols-2 gap-3 sm:gap-4 lg:-mt-16 lg:grid-cols-4">
                @foreach ($quickLinks as $quickLink)
                    <li>
                        <a href="{{ $quickLink['route'] }}" class="card group flex h-full flex-col gap-3 p-4 transition-transform duration-200 hover:-translate-y-0.5 sm:flex-row sm:items-center sm:p-5">
                            <span class="grid size-12 shrink-0 place-items-center rounded-full bg-brand-50 text-brand-700 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                <x-site-icon :name="$quickLink['icon']" class="size-6" />
                            </span>
                            <span class="min-w-0">
                                <span class="block font-display font-semibold text-ink">{{ $quickLink['label'] }}</span>
                                <span class="mt-0.5 block text-xs leading-snug text-muted sm:text-sm">{{ $quickLink['text'] }}</span>
                            </span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </section>

    {{-- Sambutan kepala madrasah --}}
    @if ($settings->headmaster_greeting)
        <section class="container-site pb-8 pt-16 lg:pb-12 lg:pt-24" aria-labelledby="sambutan">
            @if ($settings->headmaster_photo)
                <div class="grid items-center gap-12 lg:grid-cols-[22rem_minmax(0,1fr)] lg:gap-16">
                    <figure class="relative mx-auto w-full max-w-[17rem] sm:max-w-[20rem] lg:max-w-none">
                        <div class="absolute -inset-3 rounded-2xl bg-brand-100 sm:-inset-4" aria-hidden="true"></div>
                        <img src="{{ Storage::disk('public')->url($settings->headmaster_photo) }}" alt="{{ $settings->headmaster_name ?? 'Kepala Madrasah' }}" class="relative aspect-[4/5] w-full rounded-xl object-cover">
                        @if ($settings->headmaster_name)
                            <figcaption class="absolute -bottom-6 left-5 right-5 rounded-xl bg-brand-800 px-5 py-4 text-white shadow-lg">
                                <span class="block font-display font-semibold">{{ $settings->headmaster_name }}</span>
                                <span class="block text-sm text-brand-100">Kepala Madrasah</span>
                            </figcaption>
                        @endif
                    </figure>
                    <div class="pt-6 lg:pt-0">
                        <h2 id="sambutan" class="text-3xl font-semibold tracking-tight text-brand-900 sm:text-4xl">Sambutan Kepala Madrasah</h2>
                        <div class="prose-site mt-6 text-muted">{!! nl2br(e($settings->headmaster_greeting)) !!}</div>
                    </div>
                </div>
            @else
                <div class="mx-auto max-w-3xl">
                    <h2 id="sambutan" class="text-3xl font-semibold tracking-tight text-brand-900 sm:text-4xl">Sambutan Kepala Madrasah</h2>
                    <div class="prose-site mt-6 text-muted">{!! nl2br(e($settings->headmaster_greeting)) !!}</div>
                    @if ($settings->headmaster_name)
                        <p class="mt-8 flex items-center gap-4">
                            <span class="grid size-12 shrink-0 place-items-center rounded-full bg-brand-600 font-display font-semibold text-white" aria-hidden="true">{{ collect(preg_split('/\s+/', trim(preg_replace('/[^\pL\s]/u', ' ', $settings->headmaster_name))))->filter(fn ($word) => mb_strlen($word) > 1)->reject(fn ($word) => in_array(mb_strtolower($word), ['dr', 'drs', 'hj', 'ir', 'prof']))->take(2)->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('') }}</span>
                            <span>
                                <span class="block font-display font-semibold text-ink">{{ $settings->headmaster_name }}</span>
                                <span class="block text-sm text-muted">Kepala Madrasah</span>
                            </span>
                        </p>
                    @endif
                </div>
            @endif
        </section>
    @endif

    {{-- Berita terbaru --}}
    <section class="py-16 lg:py-24" aria-labelledby="berita-terbaru">
        <div class="container-site">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 id="berita-terbaru" class="text-3xl font-semibold tracking-tight text-brand-900 sm:text-4xl">Berita Terbaru</h2>
                    <p class="mt-2 text-muted">Kabar kegiatan dan pengumuman dari madrasah.</p>
                </div>
                @if ($leadPost)
                    <a href="{{ route('posts.index') }}" class="btn-outline">Semua berita <x-site-icon name="arrow-right" class="size-4" /></a>
                @endif
            </div>

            @if ($leadPost)
                <div class="mt-10 grid gap-6 lg:grid-cols-[minmax(0,7fr)_minmax(0,5fr)]">
                    <article class="group relative isolate flex min-h-[22rem] flex-col justify-end overflow-hidden rounded-xl bg-brand-800 lg:min-h-[30rem]">
                        @if ($leadPost->thumbnail)
                            <img src="{{ Storage::disk('public')->url($leadPost->thumbnail) }}" alt="" class="absolute inset-0 -z-10 size-full object-cover transition-transform duration-700 group-hover:scale-[1.03]">
                        @endif
                        <div class="absolute inset-0 -z-10 bg-[linear-gradient(to_top,rgb(3_42_21/0.92),rgb(3_42_21/0.4)_55%,rgb(3_42_21/0.05))]"></div>
                        <div class="p-6 text-white sm:p-8">
                            <p class="flex flex-wrap items-center gap-3 text-sm text-brand-100">
                                @if ($leadPost->category)
                                    <span class="rounded-full bg-gold-400 px-2.5 py-0.5 font-display text-xs font-semibold text-brand-950">{{ $leadPost->category->name }}</span>
                                @endif
                                <time datetime="{{ $leadPost->published_at?->toDateString() }}">{{ $leadPost->published_at?->translatedFormat('d F Y') }}</time>
                            </p>
                            <h3 class="mt-3 max-w-2xl text-2xl font-semibold leading-snug sm:text-3xl">
                                <a href="{{ route('posts.show', $leadPost->slug) }}" class="after:absolute after:inset-0 hover:underline">{{ $leadPost->title }}</a>
                            </h3>
                            @if ($leadPost->excerpt)
                                <p class="mt-3 line-clamp-2 max-w-2xl text-white/80">{{ $leadPost->excerpt }}</p>
                            @endif
                        </div>
                    </article>

                    @if ($otherPosts->isNotEmpty())
                        <ul class="flex flex-col divide-y divide-line rounded-xl bg-white shadow-[0_1px_2px_rgb(6_63_32/0.06),0_8px_24px_-12px_rgb(6_63_32/0.18)]">
                            @foreach ($otherPosts as $post)
                                <li class="group relative flex gap-4 p-4 sm:p-5">
                                    <div class="aspect-square w-24 shrink-0 overflow-hidden rounded-lg bg-brand-100 sm:w-28">
                                        @if ($post->thumbnail)
                                            <img src="{{ Storage::disk('public')->url($post->thumbnail) }}" alt="" loading="lazy" class="size-full object-cover">
                                        @else
                                            <span class="grid size-full place-items-center text-brand-500"><x-site-icon name="newspaper" class="size-7" /></span>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-xs text-muted">
                                            @if ($post->category)<span class="font-semibold text-brand-700">{{ $post->category->name }}</span> · @endif
                                            <time datetime="{{ $post->published_at?->toDateString() }}">{{ $post->published_at?->translatedFormat('d M Y') }}</time>
                                        </p>
                                        <h3 class="mt-1.5 font-display font-semibold leading-snug text-ink">
                                            <a href="{{ route('posts.show', $post->slug) }}" class="line-clamp-3 after:absolute after:inset-0 group-hover:text-brand-700">{{ $post->title }}</a>
                                        </h3>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @else
                <x-empty-state class="mt-10" icon="newspaper" title="Belum ada berita" message="Berita dan pengumuman madrasah akan tampil di sini setelah diterbitkan." />
            @endif
        </div>
    </section>

    {{-- PKKM --}}
    <section class="relative overflow-hidden bg-brand-900 py-16 text-white lg:py-24" aria-labelledby="pkkm-beranda">
        <div class="container-site relative grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
            <div>
                <h2 id="pkkm-beranda" class="text-3xl font-semibold tracking-tight sm:text-4xl">Penilaian Kinerja Kepala Madrasah</h2>
                <p class="mt-4 max-w-xl text-lg leading-relaxed text-brand-100">
                    Dokumen PKKM kami terbuka untuk umum: setiap komponen, indikator kinerja, dan bukti pendukungnya dapat ditelusuri per tahun.
                </p>
                <div class="mt-8 flex flex-wrap gap-3">
                    @if ($latestPkkmYear)
                        <a href="{{ route('pkkm.show', $latestPkkmYear->slug) }}" class="btn-gold">Lihat PKKM {{ $latestPkkmYear->year }} <x-site-icon name="arrow-right" class="size-4" /></a>
                    @endif
                    <a href="{{ route('pkkm.index') }}" class="btn-outline-light">Semua tahun</a>
                </div>
            </div>

            @if ($latestPkkmYear)
                @php $summary = $latestPkkmYear->summary(); @endphp
                <div class="rounded-2xl bg-white p-6 text-ink shadow-[0_24px_60px_-24px_rgb(0_0_0/0.5)] sm:p-8">
                    <div class="flex items-baseline justify-between gap-4 border-b border-line pb-4">
                        <h3 class="font-display text-lg font-semibold text-brand-900">PKKM {{ $latestPkkmYear->year }}</h3>
                        <p class="text-sm tabular-nums text-muted">{{ $summary['indicators'] }} indikator · {{ $summary['evidence'] }} bukti</p>
                    </div>
                    @if ($latestPkkmYear->components->isNotEmpty())
                        <ol class="mt-2 divide-y divide-line">
                            @foreach ($latestPkkmYear->components as $component)
                                <li>
                                    <a href="{{ route('pkkm.show', $latestPkkmYear->slug) }}#komponen-{{ $component->id }}" class="group flex items-center gap-4 py-3">
                                        <span class="grid size-9 shrink-0 place-items-center rounded-lg bg-brand-600 font-display font-semibold text-white">{{ $component->code }}</span>
                                        <span class="flex-1 font-medium leading-snug group-hover:text-brand-700">{{ $component->name }}</span>
                                        <x-site-icon name="chevron-right" class="size-4 text-muted transition-transform group-hover:translate-x-0.5" />
                                    </a>
                                </li>
                            @endforeach
                        </ol>
                    @else
                        <p class="mt-4 text-sm text-muted">Struktur komponen belum diisi.</p>
                    @endif
                    @if ($otherPkkmYears->isNotEmpty())
                        <p class="mt-5 flex flex-wrap items-center gap-2 border-t border-line pt-4 text-sm text-muted">
                            Tahun lainnya:
                            @foreach ($otherPkkmYears as $pkkmYear)
                                <a href="{{ route('pkkm.show', $pkkmYear->slug) }}" class="chip hover:bg-brand-100">{{ $pkkmYear->year }}</a>
                            @endforeach
                        </p>
                    @endif
                </div>
            @else
                <div class="rounded-2xl border border-white/15 p-8 text-brand-100">
                    <x-site-icon name="clipboard-check" class="size-8 text-gold-400" />
                    <p class="mt-4 font-display text-lg font-semibold text-white">Dokumen PKKM segera terbit</p>
                    <p class="mt-1 text-sm">Struktur penilaian dan bukti kinerja akan dipublikasikan di sini.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Galeri --}}
    <section class="py-16 lg:py-24" aria-labelledby="galeri-beranda">
        <div class="container-site">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 id="galeri-beranda" class="text-3xl font-semibold tracking-tight text-brand-900 sm:text-4xl">Galeri Kegiatan</h2>
                    <p class="mt-2 text-muted">Potret kegiatan siswa dan guru.</p>
                </div>
                @if ($latestAlbums->isNotEmpty())
                    <a href="{{ route('albums.index') }}" class="btn-outline">Semua album <x-site-icon name="arrow-right" class="size-4" /></a>
                @endif
            </div>

            @if ($latestAlbums->isNotEmpty())
                <ul class="mt-10 grid grid-cols-2 gap-3 sm:gap-4 lg:grid-cols-4">
                    @foreach ($latestAlbums as $album)
                        <li>
                            <a href="{{ route('albums.show', $album->slug) }}" class="group relative block aspect-[4/5] overflow-hidden rounded-xl bg-brand-700">
                                @if ($album->cover)
                                    <img src="{{ Storage::disk('public')->url($album->cover) }}" alt="" loading="lazy" class="size-full object-cover transition-transform duration-500 group-hover:scale-[1.05]">
                                @else
                                    <span class="grid size-full place-items-center text-white/50"><x-site-icon name="images" class="size-10" /></span>
                                @endif
                                <span class="absolute inset-0 bg-[linear-gradient(to_top,rgb(3_42_21/0.9),transparent_60%)]"></span>
                                <span class="absolute inset-x-0 bottom-0 p-4 text-white">
                                    <span class="line-clamp-2 font-display text-sm font-semibold leading-snug sm:text-base">{{ $album->title }}</span>
                                    <span class="mt-1 block text-xs text-brand-100">{{ $album->photos_count }} foto @if ($album->event_date) · {{ $album->event_date->translatedFormat('d M Y') }} @endif</span>
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <x-empty-state class="mt-10" icon="images" title="Belum ada album" message="Foto kegiatan madrasah akan tampil di sini." />
            @endif
        </div>
    </section>

    {{-- Kontak --}}
    @if ($settings->address || $settings->phone || $settings->email || $whatsappNumber)
        <section class="pb-16 lg:pb-24" aria-labelledby="kontak-beranda">
            <div class="container-site">
                <div @class(["grid overflow-hidden rounded-2xl bg-white shadow-[0_1px_2px_rgb(6_63_32/0.06),0_16px_40px_-20px_rgb(6_63_32/0.3)]", "lg:grid-cols-2" => $settings->maps_embed])>
                    <div class="p-8 sm:p-10">
                        <h2 id="kontak-beranda" class="text-2xl font-semibold tracking-tight text-brand-900 sm:text-3xl">Kunjungi atau hubungi kami</h2>
                        <ul class="mt-6 space-y-4 text-ink">
                            @if ($settings->address)
                                <li class="flex gap-3"><x-site-icon name="map-pin" class="mt-0.5 text-brand-600" /><span class="whitespace-pre-line">{{ $settings->address }}</span></li>
                            @endif
                            @if ($settings->phone)
                                <li><a href="tel:{{ $settings->phone }}" class="flex gap-3 hover:text-brand-700"><x-site-icon name="phone" class="mt-0.5 text-brand-600" />{{ $settings->phone }}</a></li>
                            @endif
                            @if ($settings->email)
                                <li><a href="mailto:{{ $settings->email }}" class="flex gap-3 hover:text-brand-700"><x-site-icon name="mail" class="mt-0.5 text-brand-600" />{{ $settings->email }}</a></li>
                            @endif
                        </ul>
                        <div class="mt-8 flex flex-wrap gap-3">
                            @if ($whatsappNumber)
                                <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="btn-primary"><x-site-icon name="message-circle" class="size-4" />Chat WhatsApp</a>
                            @endif
                            <a href="{{ route('contact') }}" class="btn-outline">Halaman kontak</a>
                        </div>
                    </div>
                    @if ($settings->maps_embed)
                        <div class="min-h-72 bg-brand-50 [&_iframe]:size-full [&_iframe]:min-h-72">{!! $settings->maps_embed !!}</div>
                    @endif
                </div>
            </div>
        </section>
    @endif
</x-public-layout>
