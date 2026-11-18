<x-public-layout title="Halaman tidak ditemukan">
    <section class="container-site grid place-items-center py-24 text-center lg:py-32">
        <div class="max-w-xl">
            <p class="font-display text-7xl font-bold tracking-tight text-brand-200">404</p>
            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-brand-900">Halaman tidak ditemukan</h1>
            <p class="mt-3 text-muted">Halaman yang Anda cari tidak ada, sudah dipindahkan, atau belum diterbitkan.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('home') }}" class="btn-primary"><x-site-icon name="home" class="size-4" />Kembali ke beranda</a>
                <a href="{{ route('posts.index') }}" class="btn-outline">Lihat berita</a>
            </div>
        </div>
    </section>
</x-public-layout>
