# Plan: Website Sekolah (Madrasah) — Panel Admin Filament

## Context
Proyek masih skeleton Laravel 13 (PHP 8.4, `.lerd.yaml` → MySQL, Tailwind 4 + Vite). Belum ada Filament, belum ada git repo.
Fase ini: **panel admin saja** (Filament) untuk mengelola seluruh konten. Frontend publik dikerjakan di fase berikutnya, tapi model/tabel sudah disiapkan agar frontend tinggal membaca (slug, status publish, URL menu).

Keputusan user:
- Admin saja dulu; MySQL; Bahasa Indonesia (`APP_LOCALE=id`, `Asia/Jakarta`)
- Media: Filament `FileUpload` biasa → disk `public`
- PKKM: bukti bisa **link (GDrive) atau upload file**; ada fitur **duplikat struktur dari tahun sebelumnya**
- Guru & Pegawai: field standar
- Menu: semua tipe, nested 2 level, drag sort
- Roles: `super_admin`, `admin`, `editor`, `editor_pkkm`

## Stack (kompatibel Laravel 13)
| Paket | Fungsi |
|---|---|
| `laravel/boost` (dev) | wajib per AGENTS.md, dipasang pertama |
| `filament/filament:^5` | panel `/admin` |
| `spatie/laravel-permission` + `bezhansalleh/filament-shield:^4.2` | role & permission + UI (Shield ≥4.2 support L13) |
| `spatie/laravel-activitylog` | log aktivitas |
| `spatie/laravel-settings` + `filament/spatie-laravel-settings-plugin:^5` | halaman Pengaturan |
| `spatie/laravel-tags` + `filament/spatie-laravel-tags-plugin:^5` | tags berita |

## Data model
| Modul | Tabel & kolom utama |
|---|---|
| Halaman | `pages`: title, slug (unique), content (rich), featured_image?, is_published, timestamps |
| Slideshow | `slides`: image, title?, caption?, button_label?, url?, sort, is_active |
| Kategori berita | `categories`: name, slug, description? |
| Berita | `posts`: category_id, user_id (penulis), title, slug, excerpt?, content (rich), thumbnail?, status (draft/published), published_at, is_featured, views; tags via `HasTags` (type `null`) |
| Galeri | `albums`: title, slug, description?, cover?, event_date?, is_published · `album_photos`: album_id, image, caption?, sort |
| Guru & Pegawai | `staff`: name, nip?, nuptk?, type (enum guru/pegawai), position (jabatan), subject? (mapel), photo?, education?, email?, phone?, sort, is_active |
| PKKM | `pkkm_years`: year (unique), title, slug, description?, is_published · `pkkm_components`: pkkm_year_id, code (A/B/C), name, sort · `pkkm_items` (unsur/tugas utama): pkkm_component_id, code (1.1), name, sort · `pkkm_indicators`: pkkm_item_id, number, description (indikator kinerja), expected_evidence (data/bukti yg diharapkan), sort · `pkkm_evidences`: pkkm_indicator_id, label, type (link/file), url?, file_path?, sort |
| Menu | `menu_items`: parent_id?, label, type (enum), target_id?, url?, route_name?, open_in_new_tab, sort, is_active |
| Pengaturan | `GeneralSettings` (spatie settings): site_name, tagline, logo, favicon, address, phone, email, whatsapp, maps_embed, social (facebook/instagram/youtube/tiktok), headmaster_name, headmaster_photo, headmaster_greeting, footer_text |

Enums (`app/Enums`): `PostStatus`, `StaffType`, `MenuItemType` (Url, Page, Category, Album, PkkmYear, Route), `EvidenceType` (Link, File) — implement Filament `HasLabel`.

`MenuItem::url()` accessor me-resolve URL per type (slug model target / `route()` jika route ada, fallback `#`) — siap dipakai frontend.

Semua model konten pakai trait `LogsActivity` (`logFillable()->logOnlyDirty()`); `User` juga (tanpa password).

## Filament (panel `admin`)
Navigasi grup:
- **Konten**: Berita (`PostResource`), Kategori (`CategoryResource`, simple/modal), Halaman, Slideshow (reorderable table), Galeri (`AlbumResource` + RelationManager foto / Repeater reorderable + multiple upload)
- **Profil**: Guru & Pegawai (`StaffResource`, filter type, reorderable)
- **PKKM**: `PkkmYearResource`
  - Edit tahun: RelationManager Komponen → nested Repeater (Unsur → Indikator → Bukti) **atau** nested resources Filament 5 (`ParentResource`) — pilih nested Repeater bila performa form OK; fallback ke nested resources jika form terlalu besar (±40 indikator × bukti).
  - Bukti: `ToggleButtons` type → `TextInput url` / `FileUpload` (pdf/jpg/png, disk public, dir `pkkm/{year}`) kondisional
  - Action tabel **"Duplikat dari tahun…"**: pilih tahun sumber + tahun baru → copy komponen/unsur/indikator dalam transaksi, **tanpa bukti** (service `App\Actions\DuplicatePkkmYear`)
- **Tampilan**: Menu Navigasi (`MenuItemResource`, reorderable, parent select max 2 level, field target dinamis per type), Pengaturan (`ManageGeneralSettings` SettingsPage)
- **Sistem**: Pengguna (`UserResource`, assign role), Role (Shield), Log Aktivitas (`ActivityResource` read-only: list + view, filter causer/subject/event)

Rich editor: Filament `RichEditor` dengan file attachment ke disk public.
Slug: auto dari title (`afterStateUpdated` + `Str::slug`), unique.

## Roles & Permission (Shield)
Generate policy & permission via `shield:generate --all`, seeder `RolePermissionSeeder`:
| Role | Akses |
|---|---|
| super_admin | semua (Shield super admin, gate bypass) |
| admin | semua kecuali Role, Log Aktivitas, Pengguna |
| editor | Berita, Kategori, Galeri, Slideshow (CRUD) |
| editor_pkkm | PKKM saja |

`User implements FilamentUser` → `canAccessPanel()` = punya salah satu role.
Seeder super admin dari env (`ADMIN_EMAIL`/`ADMIN_PASSWORD`) atau `shield:super-admin`.

## Files to create/modify (utama)
- `composer.json`, `config/app.php` (locale/timezone via `.env.example`), `.env.example` (mysql, id)
- `app/Providers/Filament/AdminPanelProvider.php` (plugins: Shield, brand dari settings)
- `app/Models/{User,Page,Slide,Category,Post,Album,AlbumPhoto,Staff,PkkmYear,PkkmComponent,PkkmItem,PkkmIndicator,PkkmEvidence,MenuItem}.php`
- `app/Enums/*.php`, `app/Settings/GeneralSettings.php`, `database/settings/*_create_general_settings.php`
- `app/Actions/DuplicatePkkmYear.php`
- `app/Filament/Resources/**`, `app/Filament/Pages/ManageGeneralSettings.php`
- `app/Policies/*` (Shield-generated)
- `database/migrations/*`, `database/factories/*`, `database/seeders/{DatabaseSeeder,RolePermissionSeeder,PkkmTemplateSeeder?}.php`
- `tests/Feature/**`

## Reuse
Skeleton kosong — tidak ada kode untuk di-reuse selain `App\Models\User` dan Tailwind/Vite config. Andalkan generator: `make:filament-resource --generate`, `make:filament-settings-page`, `shield:*`, `vendor:publish` migrations spatie.

## Steps
- [x] 1. `git init` + commit awal skeleton; install Laravel Boost (`composer require laravel/boost --dev && php artisan boost:install`), baca ulang AGENTS.md
- [x] 2. Konfig: `.env` MySQL (lerd), `APP_LOCALE=id`, `APP_TIMEZONE=Asia/Jakarta`, `php artisan storage:link`
- [x] 3. Install Filament 5 + panel `admin`; install semua paket spatie + publish migrations/config; Shield setup
- [x] 4. Enums + migrations + models (+ factories) untuk semua modul, `LogsActivity`, `HasTags` di Post
- [x] 5. `GeneralSettings` + settings migration + `ManageGeneralSettings` page
- [x] 6. Resources Konten: Category, Post (tags plugin `SpatieTagsInput`/`SpatieTagsColumn`), Page, Slide, Album(+foto)
- [x] 7. StaffResource
- [x] 8. PKKM: models, `PkkmYearResource` dengan struktur bertingkat + bukti link/file, action Duplikat + `DuplicatePkkmYear`; seeder template instrumen PKKM (komponen A–C dari contoh) opsional
- [x] 9. MenuItemResource + `MenuItem::url()` resolver
- [ ] 10. UserResource + ActivityResource (read-only)
- [ ] 11. Shield generate permissions/policies + `RolePermissionSeeder` (4 role) + super admin seeder
- [ ] 12. Tests feature (PHPUnit + Livewire): render list/create tiap resource, akses per role, duplikat PKKM, resolver URL menu, activity log tercatat
- [ ] 13. `vendor/bin/pint`, `php artisan test`

## Verification
- `php artisan migrate:fresh --seed` sukses di MySQL
- `php artisan test` hijau, mencakup:
  - super_admin bisa buka semua resource; editor tak bisa buka PKKM/Role/Log; editor_pkkm hanya PKKM
  - `DuplicatePkkmYear` menyalin komponen/unsur/indikator, bukti tidak ikut
  - `MenuItem::url()` per type
  - membuat Post menulis entri `activity_log`
- Manual: login `/admin`, coba CRUD berita dengan tags, upload galeri, isi PKKM (link + file), duplikat tahun, simpan pengaturan, susun menu drag-drop

## Di luar scope (fase berikut)
Frontend publik (beranda + slideshow, berita, galeri, guru, halaman, `/pkkm/{tahun}`, menu render), SEO/sitemap.
