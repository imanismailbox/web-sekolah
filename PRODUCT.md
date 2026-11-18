# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users
- Masyarakat umum: calon siswa Madrasah Aliyah (MA) dan orang tuanya, siswa aktif, alumni, dan warga sekitar. Mereka datang untuk mencari tahu madrasah ini: kegiatan, berita, guru, dan kontak.
- Asesor dan pengawas yang meninjau Penilaian Kinerja Kepala Madrasah (PKKM). Mereka menelusuri komponen, indikator, dan bukti per tahun.

## Product Purpose
Website resmi sebuah Madrasah Aliyah. Ada dua fungsi yang sama penting:
1. Profil publik yang membangun kepercayaan: berita, galeri, guru & pegawai, halaman profil, dan kontak.
2. Dokumentasi PKKM yang transparan: struktur komponen, unsur, indikator, dan bukti (tautan atau berkas) per tahun.

Website berhasil kalau pengunjung umum cepat mendapat kesan madrasah yang aktif dan terpercaya, lalu bisa menghubunginya, dan asesor bisa menemukan bukti setiap indikator tanpa bantuan.

## Positioning
Profil madrasah yang sekaligus membuka dokumen kinerja kepala madrasahnya ke publik, per tahun, sampai ke level bukti.

## Operating Context
- Semua konten dikelola staf lewat panel admin Filament (`/admin`): berita, kategori, tag, halaman, slideshow, galeri, guru & pegawai, PKKM, menu navigasi (2 level), dan pengaturan umum.
- Bahasa Indonesia, zona waktu Asia/Jakarta.
- Banyak pengunjung membuka lewat ponsel.

## Capabilities and Constraints
- Laravel 13, Blade, Tailwind CSS 4, Vite. Tanpa framework JS.
- Semua konten bisa kosong. Setiap halaman harus tetap rapi tanpa gambar, berita, atau foto.
- Konten rich text dari editor admin dirender apa adanya.
- Hanya konten yang sudah terbit (published/aktif) yang tampil ke publik.

## Brand Commitments
- Jenjang Madrasah Aliyah, di bawah Kementerian Agama.
- Warna hijau khas Kemenag wajib dipakai sebagai warna identitas.
- Logo madrasah resmi diunggah lewat Pengaturan admin. Desain tidak boleh bergantung pada logo itu ada.
- Preferensi tetap: tampilan standar situs madrasah (header hijau, banner/slider, tautan cepat, kartu berita, footer hijau), dikerjakan serapi patokan https://mayoga.sch.id (MAN 3 Sleman). Bukan dunia visual eksperimental.

## Evidence on Hand
- Belum ada logo, foto, maupun teks profil di repo. Foto kegiatan asli dan logo akan diisi lewat admin.
- Jangan mengarang prestasi, jumlah siswa, akreditasi, testimoni, atau angka lain.

## Product Principles
- Kepercayaan lewat bukti nyata (berita, foto, bukti PKKM), bukan klaim.
- PKKM setara dengan profil: mudah ditemukan dari navigasi dan beranda.
- Tetap bagus saat kosong; konten yang belum ada tidak meninggalkan lubang.
- Cepat dan terbaca di ponsel.
