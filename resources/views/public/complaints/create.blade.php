@php
    $settings = app(\App\Settings\GeneralSettings::class);
@endphp
<x-public-layout title="Aduan & Saran" description="Sampaikan kritik, saran, atau aduan Anda untuk peningkatan layanan {{ $settings->site_name }}.">
    <x-page-header
        title="Aduan &amp; Saran"
        :breadcrumbs="['Aduan & Saran' => null]"
        lead="Sampaikan kritik, saran, atau aduan Anda untuk membantu kami meningkatkan kualitas layanan madrasah."
    />

    <div class="container-site py-12 lg:py-16">
        <div class="grid items-start gap-8 lg:grid-cols-[minmax(0,7fr)_minmax(0,5fr)]">
            <div class="card p-6 sm:p-8">
                <h2 class="font-display text-xl font-semibold text-brand-900">Formulir Aduan / Kritik &amp; Saran</h2>
                <p class="mt-1.5 text-sm text-muted">Kolom bertanda <span class="font-semibold text-red-600">*</span> wajib diisi.</p>

                @if (session('status'))
                    <div role="status" class="mt-6 flex items-start gap-3 rounded-xl border border-brand-200 bg-brand-50 p-4 text-sm text-brand-900">
                        <x-site-icon name="check-circle" class="mt-0.5 size-5 shrink-0 text-brand-600" />
                        <p class="font-medium">{{ session('status') }}</p>
                    </div>
                @endif

                <form method="POST" action="{{ route('complaints.store') }}" class="mt-6 flex flex-col gap-5">
                    @csrf

                    <div class="flex flex-col gap-1.5">
                        <label for="name" class="font-display text-sm font-semibold text-ink">
                            Nama <span class="text-red-600" aria-hidden="true">*</span>
                        </label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            maxlength="150"
                            autocomplete="name"
                            placeholder="Masukkan nama lengkap Anda"
                            @class([
                                'block w-full rounded-xl border bg-white px-4 py-3 text-sm text-ink placeholder:text-muted/70 transition-colors focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-600/20',
                                'border-red-500' => $errors->has('name'),
                                'border-line hover:border-brand-300' => ! $errors->has('name'),
                            ])
                        >
                        @error('name')
                            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="contact" class="font-display text-sm font-semibold text-ink">
                            Email / No. HP <span class="font-sans text-xs font-normal text-muted">(Opsional)</span>
                        </label>
                        <input
                            id="contact"
                            name="contact"
                            type="text"
                            value="{{ old('contact') }}"
                            maxlength="150"
                            placeholder="Contoh: nama@email.com atau 081234567890"
                            @class([
                                'block w-full rounded-xl border bg-white px-4 py-3 text-sm text-ink placeholder:text-muted/70 transition-colors focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-600/20',
                                'border-red-500' => $errors->has('contact'),
                                'border-line hover:border-brand-300' => ! $errors->has('contact'),
                            ])
                        >
                        <p class="text-xs text-muted">Isi jika Anda ingin kami menghubungi kembali terkait tindak lanjut.</p>
                        @error('contact')
                            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="message" class="font-display text-sm font-semibold text-ink">
                            Isi Aduan / Kritik &amp; Saran <span class="text-red-600" aria-hidden="true">*</span>
                        </label>
                        <textarea
                            id="message"
                            name="message"
                            rows="6"
                            required
                            maxlength="5000"
                            placeholder="Tuliskan aduan, kritik, atau saran Anda secara jelas..."
                            @class([
                                'block w-full rounded-xl border bg-white px-4 py-3 text-sm leading-relaxed text-ink placeholder:text-muted/70 transition-colors focus:border-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-600/20',
                                'border-red-500' => $errors->has('message'),
                                'border-line hover:border-brand-300' => ! $errors->has('message'),
                            ])
                        >{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-1">
                        <button type="submit" class="btn-primary w-full cursor-pointer py-3 text-base sm:w-auto sm:px-7">
                            <x-site-icon name="send" class="size-4" />
                            Kirim Aduan
                        </button>
                    </div>
                </form>
            </div>

            <aside class="flex flex-col gap-4">
                <div class="card p-6">
                    <h2 class="font-display text-base font-semibold text-brand-900">Informasi Layanan Aduan</h2>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Setiap masukan yang dikirimkan melalui formulir ini akan diterima langsung oleh pengelola {{ $settings->site_name }} untuk ditinjau dan ditindaklanjuti.
                    </p>
                    <ul class="mt-4 flex flex-col gap-2.5 text-sm text-muted">
                        <li class="flex items-start gap-2.5">
                            <x-site-icon name="check-circle" class="mt-0.5 size-4 shrink-0 text-brand-600" />
                            <span>Sampaikan kritik, saran, atau laporan dengan bahasa yang jelas dan sopan.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <x-site-icon name="check-circle" class="mt-0.5 size-4 shrink-0 text-brand-600" />
                            <span>Cantumkan email atau nomor HP apabila memerlukan tanggapan balik.</span>
                        </li>
                    </ul>
                </div>

                <div class="card p-6">
                    <h2 class="font-display text-base font-semibold text-brand-900">Butuh respon cepat?</h2>
                    <p class="mt-2 text-sm leading-relaxed text-muted">
                        Anda juga dapat menghubungi madrasah secara langsung melalui saluran kontak resmi kami.
                    </p>
                    <a href="{{ route('contact') }}" class="link-arrow mt-4">
                        Lihat halaman Kontak
                        <x-site-icon name="arrow-right" class="size-4" />
                    </a>
                </div>
            </aside>
        </div>
    </div>
</x-public-layout>
