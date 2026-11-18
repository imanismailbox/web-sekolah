<x-public-layout title="Guru & Pegawai" :description="$description">
    <x-page-header title="Guru & Pegawai" :breadcrumbs="['Guru & Pegawai' => null]" lead="Pendidik dan tenaga kependidikan madrasah." />

    <div class="container-site space-y-16 py-12 lg:py-16">
        @if ($teachers->isEmpty() && $employees->isEmpty())
            <x-empty-state icon="users" title="Data belum tersedia" message="Daftar guru dan pegawai akan tampil di sini." />
        @endif

        @foreach (['guru' => ['Guru', $teachers], 'pegawai' => ['Tenaga Kependidikan', $employees]] as $anchor => [$groupLabel, $people])
            @if ($people->isNotEmpty())
                <section id="{{ $anchor }}" aria-labelledby="judul-{{ $anchor }}" class="scroll-mt-28">
                    <div class="flex items-baseline gap-3">
                        <h2 id="judul-{{ $anchor }}" class="text-2xl font-semibold tracking-tight text-brand-900 sm:text-3xl">{{ $groupLabel }}</h2>
                        <span class="text-sm tabular-nums text-muted">{{ $people->count() }} orang</span>
                    </div>
                    <ul class="mt-8 grid grid-cols-2 gap-4 sm:gap-6 md:grid-cols-3 lg:grid-cols-4">
                        @foreach ($people as $person)
                            @php
                                $personInitials = collect(preg_split('/\s+/', trim(preg_replace('/[^\pL\s]/u', ' ', $person->name))))->filter(fn ($word) => mb_strlen($word) > 1)->take(2)->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))->implode('');
                            @endphp
                            <li class="card flex flex-col">
                                <div class="aspect-[4/5] overflow-hidden bg-brand-50">
                                    @if ($person->photo)
                                        <img src="{{ Storage::disk('public')->url($person->photo) }}" alt="{{ $person->name }}" loading="lazy" class="size-full object-cover object-top">
                                    @else
                                        <span class="grid size-full place-items-center bg-[linear-gradient(160deg,var(--color-brand-100),var(--color-brand-200))] font-display text-4xl font-semibold text-brand-700" aria-hidden="true">{{ $personInitials ?: '?' }}</span>
                                    @endif
                                </div>
                                <div class="flex flex-1 flex-col p-4 sm:p-5">
                                    <h3 class="font-display font-semibold leading-snug text-ink">{{ $person->name }}</h3>
                                    @if ($person->position)
                                        <p class="mt-1 text-sm text-brand-700">{{ $person->position }}</p>
                                    @endif
                                    @if ($person->subject || $person->education)
                                        <dl class="mt-3 space-y-1 border-t border-line pt-3 text-xs text-muted">
                                            @if ($person->subject)
                                                <div class="flex gap-1.5"><dt>Mapel:</dt><dd class="font-medium text-ink">{{ $person->subject }}</dd></div>
                                            @endif
                                            @if ($person->education)
                                                <div class="flex gap-1.5"><dt>Pendidikan:</dt><dd class="font-medium text-ink">{{ $person->education }}</dd></div>
                                            @endif
                                        </dl>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        @endforeach
    </div>
</x-public-layout>
