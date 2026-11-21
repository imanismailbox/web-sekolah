@php $summary = $pkkmYear->summary(); @endphp
<x-public-layout :title="$pkkmYear->title" :description="$pkkmYear->description ?? $pkkmYear->title">
    <x-page-header :title="$pkkmYear->title" :breadcrumbs="['PKKM' => route('pkkm.index'), (string) $pkkmYear->year => null]" :lead="$pkkmYear->description">
        <dl class="mt-6 flex flex-wrap gap-3">
            @foreach (['Komponen' => $summary['components'], 'Indikator' => $summary['indicators'], 'Bukti' => $summary['evidence'] > 0 ? "{$summary['filled_evidence']}/{$summary['evidence']}" : 0] as $summaryLabel => $summaryValue)
                <div class="flex items-baseline gap-2 rounded-full bg-white/10 px-4 py-1.5 text-sm">
                    <dd class="order-first font-display text-lg font-semibold tabular-nums text-white">{{ $summaryValue }}</dd>
                    <dt class="text-brand-100">{{ $summaryLabel }}</dt>
                </div>
            @endforeach
        </dl>
    </x-page-header>

    <div class="container-site py-12 lg:py-16">
        @if (filled($pkkmYear->content))
            <div class="prose-site mb-14 max-w-3xl">{!! $pkkmYear->content !!}</div>
        @endif

        @if ($pkkmYear->components->isEmpty())
            <x-empty-state icon="clipboard-check" title="Struktur belum diisi" message="Komponen dan indikator PKKM tahun ini belum dipublikasikan." />
        @else
            <div class="grid gap-10 lg:grid-cols-[16rem_minmax(0,1fr)]">
                <nav aria-label="Daftar komponen" class="lg:sticky lg:top-28 lg:self-start">
                    <h2 class="font-display text-sm font-semibold text-muted">Komponen</h2>
                    <ol class="mt-3 space-y-1">
                        @foreach ($pkkmYear->components as $component)
                            <li>
                                <a href="#komponen-{{ $component->id }}" class="flex gap-3 rounded-lg px-3 py-2 text-sm hover:bg-white hover:text-brand-800">
                                    <span class="grid size-6 shrink-0 place-items-center rounded-full bg-brand-600 font-display text-xs font-semibold text-white">{{ $component->code }}</span>
                                    <span class="leading-snug">{{ $component->name }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ol>
                </nav>

                <div class="min-w-0 space-y-14">
                    @foreach ($pkkmYear->components as $component)
                        <section id="komponen-{{ $component->id }}" class="scroll-mt-28" aria-labelledby="judul-komponen-{{ $component->id }}">
                            <h2 id="judul-komponen-{{ $component->id }}" class="flex items-start gap-3 text-2xl font-semibold tracking-tight text-brand-900">
                                <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-brand-600 text-lg text-white">{{ $component->code }}</span>
                                <span class="pt-1">{{ $component->name }}</span>
                            </h2>

                            @if ($component->items->isEmpty())
                                <p class="mt-4 text-sm text-muted">Belum ada unsur untuk komponen ini.</p>
                            @endif

                            <div class="mt-6 space-y-4">
                                @foreach ($component->items as $item)
                                    <details class="group rounded-xl bg-white shadow-sm open:shadow-[0_1px_2px_rgb(6_63_32/0.06),0_12px_32px_-16px_rgb(6_63_32/0.28)]" open>
                                        <summary class="flex cursor-pointer list-none items-start gap-4 p-5 [&::-webkit-details-marker]:hidden">
                                            <span class="font-display text-sm font-semibold tabular-nums text-brand-700">{{ $item->code }}</span>
                                            <span class="flex-1 font-display font-semibold leading-snug text-ink">{{ $item->name }}</span>
                                            <span class="hidden shrink-0 text-xs text-muted sm:block">{{ $item->indicators->count() }} indikator</span>
                                            <x-site-icon name="chevron-down" class="size-5 text-muted transition-transform group-open:rotate-180" />
                                        </summary>

                                        @if ($item->indicators->isNotEmpty())
                                            <ol class="divide-y divide-line border-t border-line">
                                                @foreach ($item->indicators as $indicator)
                                                    <li class="grid grid-cols-[2rem_minmax(0,1fr)] gap-x-3 gap-y-4 p-5 md:grid-cols-[2.5rem_minmax(0,1fr)_minmax(0,18rem)] md:gap-x-4">
                                                        <span class="grid size-8 place-items-center font-display text-sm font-semibold tabular-nums text-brand-800">{{ $item->code }}.{{ $indicator->number }}</span>
                                                        <div>
                                                            <p class="leading-relaxed text-ink">{{ $indicator->description }}</p>
                                                            {{-- @if ($indicator->expected_evidence)
                                                                <p class="mt-2 text-sm text-muted"><span class="font-medium text-ink">Bukti yang diharapkan:</span> {{ $indicator->expected_evidence }}</p>
                                                            @endif --}}
                                                        </div>
                                                        <div class="col-start-2 md:col-start-auto">
                                                            @if ($indicator->evidence->isNotEmpty())
                                                                <ul class="space-y-2">
                                                                    @foreach ($indicator->evidence as $evidence)
                                                                        @php
                                                                            $isFile = $evidence->type === \App\Enums\EvidenceType::File;
                                                                            $evidenceUrl = $evidence->href();
                                                                        @endphp
                                                                        <li>
                                                                            @if ($evidenceUrl)
                                                                                <a href="{{ $evidenceUrl }}" target="_blank" rel="noopener noreferrer" class="flex items-start gap-2.5 rounded-lg border border-line px-3 py-2 text-sm transition-colors hover:border-brand-300 hover:bg-brand-50">
                                                                                    <x-site-icon :name="$isFile ? 'file-text' : 'link'" class="mt-0.5 size-4 text-brand-600" />
                                                                                    <span class="min-w-0 flex-1">
                                                                                        <span class="block font-medium text-ink">{{ $evidence->label }}</span>
                                                                                        <span class="block text-xs text-muted">{{ $isFile ? 'Berkas' : 'Tautan' }}</span>
                                                                                    </span>
                                                                                    <x-site-icon :name="$isFile ? 'download' : 'external-link'" class="mt-0.5 size-4 text-muted" />
                                                                                </a>
                                                                            @else
                                                                                <span class="flex items-start gap-2.5 rounded-lg border border-dashed border-line px-3 py-2 text-sm text-muted">
                                                                                    <span class="min-w-0 flex-1">
                                                                                        <span class="block text-ink/70">{{ $evidence->label }}</span>
                                                                                        <span class="block text-xs text-muted">Belum diunggah</span>
                                                                                    </span>
                                                                                </span>
                                                                            @endif
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            @else
                                                                <p class="rounded-lg border border-dashed border-line px-3 py-2 text-sm text-muted">Bukti belum diunggah</p>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <p class="border-t border-line p-5 text-sm text-muted">Belum ada indikator.</p>
                                        @endif
                                    </details>
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-public-layout>
