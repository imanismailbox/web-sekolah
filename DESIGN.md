---
name: Website Resmi Madrasah Aliyah
description: Situs madrasah standar kategori (header hijau, banner, tautan cepat, berita di depan) dalam hijau Kemenag, dikerjakan serapi patokan mayoga.sch.id.
colors:
  brand-50: "#eef7f1"
  brand-100: "#d7eedf"
  brand-200: "#a9d9b9"
  brand-300: "#6fbf8c"
  brand-400: "#33a463"
  brand-500: "#0b9149"
  brand-600: "#00843d"
  brand-700: "#006b32"
  brand-800: "#055629"
  brand-900: "#063f20"
  brand-950: "#032a15"
  gold-300: "#f6d76b"
  gold-400: "#efc33a"
  gold-500: "#d9a514"
  ink: "#15231b"
  muted: "#55635b"
  line: "#dfe7e2"
  paper: "#f6f8f6"
  white: "#ffffff"
typography:
  display:
    fontFamily: "Poppins, Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "3.75rem"
    fontWeight: 700
    lineHeight: 1.1
    letterSpacing: "-0.025em"
  headline:
    fontFamily: "Poppins, Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "2.25rem"
    fontWeight: 600
    lineHeight: 1.25
    letterSpacing: "-0.025em"
  page-title:
    fontFamily: "Poppins, Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "2.5rem"
    fontWeight: 600
    lineHeight: 1.25
    letterSpacing: "-0.025em"
  title:
    fontFamily: "Poppins, Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.0625rem"
    fontWeight: 600
    lineHeight: 1.375
  body:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1rem"
    fontWeight: 400
    lineHeight: 1.5
  prose:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "1.0625rem"
    fontWeight: 400
    lineHeight: 1.625
  label:
    fontFamily: "Poppins, Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 600
    lineHeight: 1.25
  meta:
    fontFamily: "Inter, ui-sans-serif, system-ui, sans-serif"
    fontSize: "0.75rem"
    fontWeight: 400
    lineHeight: 1.333
rounded:
  md: "8px"
  lg: "12px"
  xl: "16px"
  full: "9999px"
spacing:
  gutter-sm: "16px"
  gutter-md: "24px"
  gutter-lg: "32px"
  card-pad: "20px"
  grid-gap: "16px"
  grid-gap-lg: "24px"
  section-y: "64px"
  section-y-lg: "96px"
  container-max: "80rem"
components:
  button-primary:
    backgroundColor: "{colors.brand-600}"
    textColor: "{colors.white}"
    typography: "{typography.label}"
    rounded: "{rounded.full}"
    padding: "10px 20px"
  button-primary-hover:
    backgroundColor: "{colors.brand-700}"
  button-gold:
    backgroundColor: "{colors.gold-400}"
    textColor: "{colors.brand-950}"
    typography: "{typography.label}"
    rounded: "{rounded.full}"
    padding: "10px 20px"
  button-gold-hover:
    backgroundColor: "{colors.gold-300}"
  button-outline:
    textColor: "{colors.brand-700}"
    typography: "{typography.label}"
    rounded: "{rounded.full}"
    padding: "10px 20px"
  button-outline-hover:
    backgroundColor: "{colors.brand-50}"
  button-outline-light:
    textColor: "{colors.white}"
    typography: "{typography.label}"
    rounded: "{rounded.full}"
    padding: "10px 20px"
  card:
    backgroundColor: "{colors.white}"
    rounded: "{rounded.lg}"
    padding: "{spacing.card-pad}"
  chip:
    backgroundColor: "{colors.brand-50}"
    textColor: "{colors.brand-800}"
    typography: "{typography.meta}"
    rounded: "{rounded.full}"
    padding: "4px 12px"
  category-badge:
    backgroundColor: "{colors.gold-400}"
    textColor: "{colors.brand-950}"
    rounded: "{rounded.full}"
    padding: "2px 10px"
  topbar:
    backgroundColor: "{colors.brand-950}"
    textColor: "{colors.brand-100}"
    height: "40px"
  header:
    backgroundColor: "{colors.brand-800}"
    textColor: "{colors.white}"
    height: "72px"
  nav-item-active:
    textColor: "{colors.white}"
    rounded: "{rounded.full}"
    padding: "8px 14px"
  page-header:
    backgroundColor: "{colors.brand-700}"
    textColor: "{colors.white}"
    typography: "{typography.page-title}"
  footer:
    backgroundColor: "{colors.brand-900}"
    textColor: "{colors.brand-100}"
  icon-tile:
    backgroundColor: "{colors.brand-50}"
    textColor: "{colors.brand-700}"
    rounded: "{rounded.full}"
    size: "48px"
  empty-state:
    backgroundColor: "{colors.white}"
    textColor: "{colors.ink}"
    rounded: "{rounded.lg}"
    padding: "56px 24px"
---

# Design System: Website Resmi Madrasah Aliyah

## Overview

**Creative North Star: "Papan Pengumuman Madrasah yang Rapi"**

Situs ini sengaja memakai bentuk standar kategori situs madrasah Indonesia: topbar hijau tua dengan running text, header hijau resmi dengan logo dan nama madrasah, banner selebar layar, empat tautan cepat yang menumpang di tepi bawah banner, berita di depan, lalu band PKKM, galeri, kontak, dan footer hijau. Kebaruannya bukan pada bentuk, melainkan pada kerapian: hierarki tegas, jarak yang konsisten, ikon garis satu ketebalan, dan setiap bagian tetap utuh ketika kontennya kosong. Patokan kerapiannya adalah mayoga.sch.id (MAN 3 Sleman).

Identitas dibawa oleh hijau Kemenag bertingkat: hijau paling tua untuk topbar, hijau tua untuk header dan footer, hijau utama (#00843d) untuk aksi dan aksen, dan hijau sangat muda untuk latar ikon serta chip. Emas Kemenag hadir hanya sebagai titik kecil dan tombol pil utama. Halaman berlatar kertas putih kehijauan, bukan putih murni, sehingga kartu putih terangkat dengan bayangan hijau yang lembut. Kepadatan sedang: ramah ponsel, satu kolom di layar kecil, dua sampai empat kolom di desktop.

Sistem ini menolak tampilan template polos tanpa identitas dan juga dunia visual eksperimental. Tidak ada efek blur atau kaca dekoratif, tidak ada label kecil (eyebrow/kicker) di atas judul.

**Key Characteristics:**
- Bentuk standar situs madrasah, dikerjakan rapi; bukan eksperimen visual.
- Hijau Kemenag bertingkat sebagai identitas; emas hanya aksen kecil dan tombol pil utama.
- Poppins untuk judul dan label tombol, Inter untuk teks.
- Kartu putih bersudut 12px di atas kertas kehijauan, bayangan berwarna hijau tua.
- Tombol selalu berbentuk pil.
- Ikon garis Lucide, satu ketebalan (1.75).
- Setiap bagian tetap rapi tanpa gambar dan tanpa konten.

## Colors

Satu keluarga hijau Kemenag bertingkat dengan netral bernuansa hijau, ditambah emas sebagai bumbu.

### Primary
- **Hijau Kemenag** (brand-600): warna aksi utama. Tombol utama, ubin kode komponen PKKM, ikon kontak, kotak inisial kepala madrasah, latar ikon tautan cepat saat hover.
- **Hijau Daun Tua** (brand-700): hover tombol utama, teks tombol garis, teks tautan, latar page header dan panel beranda tanpa slide.
- **Hijau Header** (brand-800): latar header sticky, latar artikel berita utama tanpa gambar, kartu nama kepala madrasah.
- **Hijau Hutan** (brand-900): footer, band PKKM di beranda, panel menu mobile, warna judul bagian (h2) di atas kertas.
- **Hijau Malam** (brand-950): topbar, teks di atas emas, dasar overlay gradien foto (`rgb(3 42 21 / …)`), latar lightbox.
- **Hijau Embun** (brand-50 / brand-100 / brand-200): latar ubin ikon, chip, hover menu dropdown, placeholder gambar, teks sekunder di atas hijau tua, seleksi teks (brand-200), garis putus empty state (brand-200).
- **Hijau Sedang** (brand-300 / brand-400 / brand-500): dipakai hemat: dekorasi garis bawah tautan prose, pemisah breadcrumb, garis blockquote, ikon placeholder.

### Secondary
- **Emas Kemenag** (gold-400): tombol pil utama di atas hijau (CTA banner, "Lihat PKKM", "Chat WhatsApp" di footer), lencana kategori berita, badge "Info" di topbar, titik pemisah running text, titik slider aktif, garis bawah 4px page header, cincin logo inisial, ikon kontak di footer, outline fokus.
- **Emas Muda** (gold-300): hover tombol emas, baris "Kementerian Agama Republik Indonesia" di header, item aktif menu mobile.
- **Emas Tua** (gold-500): cadangan dalam skala; belum dipakai di halaman publik.

### Neutral
- **Tinta** (ink): teks utama dan judul kartu.
- **Abu Lumut** (muted): teks pendukung, tanggal, metadata, lead bagian.
- **Garis** (line): pembagi daftar, border tabel prose, garis putus bukti PKKM yang kosong.
- **Kertas** (paper): latar halaman. Kartu dan panel putih (#ffffff) duduk di atasnya.

### Named Rules
**The Gold Seasoning Rule.** Emas hanya untuk aksen kecil (lencana, titik, garis bawah 4px, cincin, ikon kecil, outline fokus) dan tombol pil utama. Emas tidak pernah menjadi latar bidang besar, latar bagian, atau warna teks paragraf.

**The Green Ladder Rule.** Semakin tinggi posisi pita di halaman, semakin tua hijaunya: topbar brand-950, header brand-800, page header brand-700. Footer kembali ke brand-900. Jangan menukar urutan ini.

**The Paper, Not White Rule.** Latar halaman selalu paper; putih murni hanya untuk kartu, panel, dan dropdown agar terangkat.

## Typography

**Display Font:** Poppins 500/600/700 (dengan Inter, ui-sans-serif, system-ui)
**Body Font:** Inter variabel 100–900 (dengan ui-sans-serif, system-ui)

Keduanya di-host sendiri dari `public/fonts/site` (woff2, `font-display: swap`); Inter dan Poppins 600 di-preload.

**Character:** Poppins memberi kesan geometris, ramah, dan resmi khas situs sekolah Indonesia; Inter menjaga paragraf berbahasa Indonesia tetap tenang dan mudah dibaca di ponsel. Semua h1–h4 otomatis Poppins dengan `text-balance`.

### Hierarchy
- **Display** (700, 2.25rem → 3rem → 3.75rem, line-height 1.1, tracking -0.025em): nama madrasah di panel beranda tanpa slide. Judul slide memakai 600 pada 1.5rem → 2.25rem → 3rem.
- **Headline** (600, 1.875rem → 2.25rem, tracking -0.025em, brand-900): judul bagian beranda (Sambutan, Berita Terbaru, Galeri Kegiatan, PKKM). Judul grup di halaman isi turun ke 1.5rem → 1.875rem.
- **Page Title** (600, 1.875rem → 2.5rem, leading-tight): h1 di page header semua halaman isi, putih di atas brand-700.
- **Title** (600, 1rem–1.125rem, line-height 1.375): judul kartu berita (1.0625rem), nama guru, judul tautan cepat, judul empty state (1.125rem).
- **Body** (400, 1rem, 1.5): teks umum; lead bagian memakai muted.
- **Prose** (400, 1.0625rem, line-height 1.625, maks 70ch): isi berita dan halaman dari editor admin. h2 prose 1.5rem, h3 prose 1.25rem, keduanya 600 brand-900.
- **Label** (Poppins 600, 0.875rem): teks tombol, `link-arrow`, judul kolom footer.
- **Meta** (Inter 400, 0.75rem): tanggal, jumlah foto, keterangan kecil; chip memakai 0.75rem 600.

### Named Rules
**The No Kicker Rule.** Tidak ada label kecil huruf kapital di atas judul bagian. Judul berdiri sendiri, diikuti satu baris lead berwarna muted bila perlu. Satu-satunya baris kecil berhuruf kapital adalah afiliasi "Kementerian Agama Republik Indonesia" di lockup logo header (bentuk pendek "Kementerian Agama RI" di bawah breakpoint sm); itu identitas institusi, bukan kicker.

**The Poppins Speaks, Inter Explains Rule.** Poppins untuk judul, nama, label tombol, dan angka penting; Inter untuk semua kalimat. Angka hitungan memakai `tabular-nums`.

## Layout

Wadah tunggal `container-site`: lebar maksimum 80rem, padding samping 16px → 24px (sm) → 32px (lg). Bagian beranda berirama vertikal 64px di ponsel dan 96px di desktop; halaman isi memakai 48px → 64px di bawah page header. Kepala bagian adalah baris fleksibel: judul plus lead di kiri, tombol garis "Semua …" di kanan, turun ke bawah saat sempit.

Grid: tautan cepat dan galeri 2 kolom → 4 kolom (lg), jarak 12px → 16px. Guru dan pegawai 2 → 3 (md) → 4 (lg), jarak 16px → 24px. Berita utama beranda 7:5 (artikel besar + daftar ringkas). Footer 1 → 2 (md) → 1.4fr 1fr 1fr 1fr (lg). PKKM detail: sidebar sticky 16rem + konten. Breakpoint mengikuti default Tailwind (sm 640, md 768, lg 1024); menu desktop muncul mulai lg.

Tautan cepat menumpang di tepi bawah banner dengan margin negatif (-48px → -64px), sehingga banner dan isi terasa satu kesatuan.

### Named Rules
**The Empty Still Stands Rule.** Setiap bagian harus tetap rapi tanpa konten dan tanpa gambar: foto kosong diganti inisial di atas gradien hijau muda, thumbnail kosong diganti ubin ikon, daftar kosong diganti komponen empty state, banner tanpa slide diganti panel hijau dengan nama madrasah dan dua tombol. Tidak ada bagian yang meninggalkan lubang.

## Elevation & Depth

Sistem berlapis lembut: bidang hijau datar untuk pita struktural (topbar, header, page header, band PKKM, footer), dan kartu putih yang terangkat di atas kertas dengan bayangan berwarna hijau tua (bukan abu atau hitam). Bayangan bersifat ambien, dua lapis: garis kontak tipis ditambah bayangan lebar yang menyebar ke bawah. Kedalaman di atas foto dibangun dengan gradien hijau malam dari bawah ke atas agar teks putih terbaca.

### Shadow Vocabulary
- **Kartu diam** (`box-shadow: 0 1px 2px rgb(6 63 32 / 0.06), 0 8px 24px -12px rgb(6 63 32 / 0.18)`): kartu, daftar berita ringkas, tautan cepat.
- **Kartu hover** (`box-shadow: 0 1px 2px rgb(6 63 32 / 0.06), 0 18px 36px -16px rgb(6 63 32 / 0.32)`): kartu berita saat hover.
- **Panel besar** (`box-shadow: 0 1px 2px rgb(6 63 32 / 0.06), 0 16px 40px -20px rgb(6 63 32 / 0.3)`): panel kontak beranda.
- **Header sticky** (`box-shadow: 0 6px 20px -10px rgb(3 42 21 / 0.6)`): bayangan di bawah header.
- **Dropdown** (`box-shadow: 0 18px 40px -16px rgb(3 42 21 / 0.45)`): submenu navigasi.
- **Kartu di atas hijau** (`box-shadow: 0 24px 60px -24px rgb(0 0 0 / 0.5)`): kartu PKKM putih di band hijau.

### Named Rules
**The Green Shadow Rule.** Bayangan di atas kertas selalu berbasis hijau tua (rgb 6 63 32 atau 3 42 21), tidak pernah abu netral.

**The No Glass Rule.** Tidak ada backdrop-blur, glassmorphism, atau blur dekoratif. Kedalaman datang dari bayangan hijau, tonalitas hijau, dan gradien overlay foto.

## Shapes

Bahasa bentuk lembut dan resmi. Tombol, chip, lencana, item navigasi, ubin ikon bulat, dan tombol slider selalu pil atau lingkaran penuh. Kartu, empty state, thumbnail berita utama, kartu galeri, accordion PKKM, dan gambar prose bersudut 12px. Panel besar (kartu PKKM beranda, panel kontak, kartu berita utama di panel tanpa slide) bersudut 16px. Thumbnail kecil, item dropdown, tautan bukti PKKM, dan ubin kode kecil bersudut 8px. Satu-satunya tepi keras adalah garis bawah emas 4px pada page header.

## Components

### Buttons
Tegas, ramah, selalu pil.
- **Shape:** pil penuh, tinggi sekitar 40px, padding 10px 20px, Poppins 600 0.875rem, jarak ikon 8px, transisi warna 200ms.
- **Primary (btn-primary):** brand-600, teks putih; hover brand-700. Untuk aksi utama di atas kertas atau putih (Chat WhatsApp di panel kontak, kembali ke beranda di 404).
- **Gold (btn-gold):** gold-400, teks brand-950; hover gold-300. Hanya untuk CTA utama di atas bidang hijau atau foto (banner, band PKKM, footer).
- **Outline (btn-outline):** border 1px brand-600, teks brand-700; hover latar brand-50. Untuk "Semua berita/album" dan aksi sekunder di atas kertas.
- **Outline Light (btn-outline-light):** border putih 40%, teks putih; hover latar putih 10%. Pasangan sekunder tombol emas di atas hijau.
- **Focus:** outline 2px gold-400 dengan offset 2px, berlaku global.
- **Link Arrow:** tautan teks Poppins 600 brand-700 dengan panah kanan yang bergeser 2px saat hover; hover brand-900.

### Chips
- **Chip (chip):** latar brand-50, teks brand-800, 0.75rem 600, pil; hover brand-100. Untuk tahun PKKM lain dan tag.
- **Lencana kategori:** gold-400, teks brand-950, Poppins 600 0.6875rem–0.75rem, pil; menempel di pojok kiri atas thumbnail atau di atas judul berita utama.

### Cards / Containers
- **Corner Style:** 12px; panel besar 16px.
- **Background:** putih di atas paper.
- **Shadow Strategy:** kartu diam, naik ke kartu hover (lihat Elevation & Depth). Tautan cepat naik 2px saat hover.
- **Border:** tidak ada; pembagi internal memakai garis line.
- **Internal Padding:** 16px → 20px; panel besar 24px → 40px.
- **Kartu berita:** gambar 16:10 dengan zoom 1.04 saat hover (500ms), tanggal dengan ikon kalender, judul 3 baris maks, ringkasan 2 baris, link arrow di dasar. Tanpa gambar: gradien brand-600 → brand-800 dengan ikon koran.
- **Kartu guru:** foto 4:5 diposisikan ke atas; tanpa foto: inisial Poppins 2.25rem brand-700 di gradien brand-100 → brand-200.

### Navigation
- **Topbar:** tinggi 40px, brand-950, badge "Info" emas, running text berita terbaru (marquee 40 detik, berhenti saat hover/fokus, diganti satu judul statis saat reduced motion), telepon dan email di kanan mulai lg.
- **Header:** sticky, brand-800, tinggi 72px. Kiri: logo 48px atau lingkaran inisial putih bercincin emas, lalu baris afiliasi Kemenag (0.6875rem uppercase gold-300), nama madrasah Poppins 600, dan tagline. Kanan: item pil Poppins 500 putih 85%; aktif dan hover berlatar putih 10%. Submenu: dropdown putih 12px dengan item 8px, hover brand-50.
- **Mobile:** tombol bulat 44px (putih 10%) membuka panel brand-900 di bawah header; item dipisah garis putih 10%, aktif berwarna gold-300; Escape menutup.
- **Page header:** brand-700 dengan garis bawah emas 4px, breadcrumb ikon rumah dan chevron, h1, lead brand-100; dapat memuat ringkasan berbentuk pil putih 10% (statistik PKKM).
- **Footer:** brand-900, empat kolom (identitas + kontak berikon emas, Jelajahi, Transparansi, Ikuti Kami dengan tombol sosial bulat yang menjadi emas saat hover), baris hak cipta di bawah garis putih 10%.

### Empty State
Kotak putih 12px dengan border putus brand-200, ubin ikon bulat 56px brand-50/brand-600, judul Poppins 1.125rem, pesan muted maks 28rem. Dipakai di semua daftar yang bisa kosong.

### Icon Tile
Lingkaran 48px brand-50 dengan ikon Lucide 24px brand-700; saat kartu induk di-hover menjadi brand-600 dengan ikon putih. Ikon selalu garis Lucide, stroke 1.75, ujung bulat, ukuran default 20px.

### Banner Slider
Slider scroll-snap native selebar layar (tinggi 22rem → 28rem → 36rem), overlay gradien hijau malam dari bawah, judul dan CTA emas di kiri bawah, titik pil (aktif melebar 40px dan emas), tombol prev/next bulat brand-950 60%. Putar otomatis 6 detik, berhenti saat hover/fokus, mati saat reduced motion.

### Lightbox Galeri
Dialog native layar penuh dengan backdrop brand-950 95%, navigasi prev/next, keterangan, dan penghitung.

## Do's and Don'ts

### Do:
- **Do** pakai hijau Kemenag bertingkat sesuai The Green Ladder Rule: topbar brand-950, header brand-800, page header brand-700, footer brand-900.
- **Do** batasi emas pada aksen kecil dan tombol pil utama di atas hijau atau foto.
- **Do** pakai tombol pil untuk semua aksi, Poppins 600 0.875rem.
- **Do** taruh kartu putih bersudut 12px dengan bayangan hijau di atas latar paper.
- **Do** sediakan pengganti untuk setiap konten yang bisa kosong: inisial, ubin ikon, empty state, panel hijau tanpa slide.
- **Do** pakai ikon garis Lucide stroke 1.75 lewat komponen site-icon.
- **Do** tampilkan "Kementerian Agama Republik Indonesia" di lockup header, dan "Kementerian Agama RI" di bawah breakpoint sm.
- **Do** hormati prefers-reduced-motion: marquee, slider otomatis, dan smooth scroll dimatikan.

### Don't:
- **Don't** pasang label kecil (eyebrow/kicker) di atas judul bagian.
- **Don't** pakai blur, backdrop-blur, atau efek kaca dekoratif.
- **Don't** pakai emas sebagai latar bidang besar, latar bagian, atau warna paragraf.
- **Don't** pakai bayangan abu atau hitam di atas kertas; bayangan selalu berbasis hijau tua.
- **Don't** biarkan bagian kosong meninggalkan lubang atau gambar rusak.
- **Don't** bergeser ke dunia visual eksperimental atau tampilan template polos tanpa identitas.
- **Don't** pakai ikon isi, emoji, atau ikon dengan ketebalan garis berbeda.
