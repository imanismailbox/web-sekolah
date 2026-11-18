<x-public-layout title="PKKM" :description="$description">
    <x-page-header title="Penilaian Kinerja Kepala Madrasah" :breadcrumbs="['PKKM' => null]" lead="Dokumen PKKM per tahun: komponen, indikator kinerja, dan bukti pendukung yang dapat ditelusuri publik." />

    <div class="container-site py-12 lg:py-16">
        @if ($years->isEmpty())
            <x-empty-state icon="clipboard-check" title="Dokumen PKKM belum terbit" message="Struktur penilaian dan bukti kinerja akan dipublikasikan di sini." />
        @else
            <h2 class="sr-only">Daftar tahun</h2>
            <ul class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($years as $pkkmYear)
                    @php $summary = $pkkmYear->summary(); @endphp
                    <li>
                        <a href="{{ route('pkkm.show', $pkkmYear->slug) }}" class="card group flex h-full flex-col p-6 sm:p-7">
                            <div class="flex items-start justify-between gap-4">
                                <p class="font-display text-5xl font-bold tracking-tight text-brand-700">{{ $pkkmYear->year }}</p>
                                @if ($loop->first)
                                    <span class="rounded-full bg-gold-400 px-2.5 py-0.5 font-display text-xs font-semibold text-brand-950">Terbaru</span>
                                @endif
                            </div>
                            <h3 class="mt-3 font-display font-semibold leading-snug text-ink group-hover:text-brand-700">{{ $pkkmYear->title }}</h3>
                            @if ($pkkmYear->description)
                                <p class="mt-2 line-clamp-3 text-sm text-muted">{{ $pkkmYear->description }}</p>
                            @endif
                            <dl class="mt-6 grid grid-cols-3 divide-x divide-line rounded-xl bg-paper py-3 text-center">
                                <div><dt class="text-xs text-muted">Komponen</dt><dd class="font-display text-xl font-semibold tabular-nums">{{ $summary['components'] }}</dd></div>
                                <div><dt class="text-xs text-muted">Indikator</dt><dd class="font-display text-xl font-semibold tabular-nums">{{ $summary['indicators'] }}</dd></div>
                                <div><dt class="text-xs text-muted">Bukti</dt><dd class="font-display text-xl font-semibold tabular-nums">{{ $summary['evidence'] }}</dd></div>
                            </dl>
                            <span class="link-arrow mt-auto pt-6">Telusuri dokumen <x-site-icon name="arrow-right" class="size-4 transition-transform group-hover:translate-x-0.5" /></span>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-public-layout>
