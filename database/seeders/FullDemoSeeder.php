<?php

namespace Database\Seeders;

use App\Enums\MenuItemType;
use App\Enums\PostStatus;
use App\Enums\StaffType;
use App\Models\Album;
use App\Models\AlbumPhoto;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PkkmEvidence;
use App\Models\PkkmIndicator;
use App\Models\PkkmItem;
use App\Models\PkkmYear;
use App\Models\Post;
use App\Models\Slide;
use App\Models\Staff;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Mengisi seluruh modul aplikasi dengan data demo (pengguna, pengaturan umum,
 * kategori & berita, halaman, slide, galeri, staf, PKKM, dan menu navigasi).
 * Setiap bagian dilewati bila datanya sudah ada, sehingga aman dijalankan ulang.
 */
class FullDemoSeeder extends Seeder
{
    /**
     * Seed the application's demo data.
     */
    public function run(): void
    {
        $this->call(PkkmTemplateSeeder::class);

        $this->seedEditorUsers();
        $this->seedGeneralSettings();

        $categories = $this->seedCategories();
        $this->seedPosts($categories);

        $pages = $this->seedPages();
        $this->seedSlides();
        $albums = $this->seedAlbums();
        $this->seedStaff();
        $pkkmYear = $this->seedPkkmIndicators();
        $this->seedMenu($pages, $pkkmYear);
    }

    private function seedEditorUsers(): void
    {
        $accounts = [
            ['email' => 'editor@madrasah.test', 'name' => 'Editor Berita', 'role' => 'editor'],
            ['email' => 'pkkm@madrasah.test', 'name' => 'Editor PKKM', 'role' => 'editor_pkkm'],
        ];

        foreach ($accounts as $account) {
            $user = User::query()->firstOrCreate(
                ['email' => $account['email']],
                ['name' => $account['name'], 'password' => 'password', 'email_verified_at' => now()],
            );

            $user->assignRole($account['role']);
        }
    }

    private function seedGeneralSettings(): void
    {
        $settings = app(GeneralSettings::class);

        $settings->site_name = 'Madrasah Aliyah Contoh';
        $settings->tagline = 'Unggul, Berakhlak, dan Berprestasi';
        $settings->address = 'Jl. Pendidikan No. 1, Kota Contoh';
        $settings->phone = '0221234567';
        $settings->email = 'info@madrasah.test';
        $settings->whatsapp = '081234567890';
        $settings->facebook = 'https://facebook.com/madrasah';
        $settings->instagram = 'https://instagram.com/madrasah';
        $settings->youtube = 'https://youtube.com/@madrasah';
        $settings->tiktok = 'https://tiktok.com/@madrasah';
        $settings->headmaster_name = 'Drs. H. Ahmad Fauzi, M.Pd.';
        $settings->headmaster_greeting = 'Selamat datang di website resmi madrasah kami. Semoga informasi ini bermanfaat bagi seluruh warga madrasah dan masyarakat.';
        $settings->footer_text = 'Hak cipta © '.now()->year.' Madrasah Aliyah Contoh. Seluruh hak dilindungi.';

        $settings->save();
    }

    /**
     * @return Collection<int, Category>
     */
    private function seedCategories(): Collection
    {
        $categories = [
            'Berita' => 'Berita terkini seputar kegiatan madrasah.',
            'Pengumuman' => 'Pengumuman resmi untuk siswa, guru, dan orang tua.',
            'Kegiatan' => 'Dokumentasi kegiatan akademik dan non-akademik.',
            'Prestasi' => 'Prestasi siswa, guru, dan madrasah.',
        ];

        foreach ($categories as $name => $description) {
            Category::query()->firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => $description],
            );
        }

        return Category::query()->get();
    }

    /**
     * @param  Collection<int, Category>  $categories
     */
    private function seedPosts(Collection $categories): void
    {
        if (Post::query()->exists()) {
            return;
        }

        $authors = User::query()->get();

        $posts = [
            ['Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027 Dibuka', 'Pengumuman', true, ['PPDB', 'Pendaftaran']],
            ['Jadwal Ujian Akhir Semester Ganjil Telah Diumumkan', 'Pengumuman', true, ['Ujian', 'Akademik']],
            ['Siswa Madrasah Raih Juara Lomba Tilawah Tingkat Provinsi', 'Prestasi', true, ['Lomba', 'Prestasi']],
            ['Pesantren Kilat Ramadhan Diikuti Seluruh Siswa', 'Kegiatan', true, ['Ramadhan', 'Keagamaan']],
            ['Guru Madrasah Ikuti Pelatihan Kurikulum Merdeka', 'Berita', true, ['Pelatihan', 'Guru']],
            ['Bakti Sosial Peringati Hari Anak Nasional', 'Kegiatan', true, ['Sosial']],
            ['Kunjungan Edukatif Siswa ke Museum Daerah', 'Kegiatan', true, ['Study Tour']],
            ['Pemeliharaan Sarana Laboratorium Komputer', 'Berita', true, ['Fasilitas']],
            ['Rapat Komite Madrasah Bahas Program Tahun Depan', 'Berita', false, ['Rapat']],
            ['Lomba Kebersihan Kelas Antar Rombongan Belajar', 'Kegiatan', false, ['Lomba']],
            ['Libur Hari Raya Idul Adha 1447 H', 'Pengumuman', false, ['Libur']],
            ['Tim Olimpiade Sains Lolos Babak Final', 'Prestasi', true, ['Olimpiade', 'Sains']],
        ];

        foreach ($posts as $index => [$title, $categoryName, $isPublished, $tags]) {
            $post = Post::factory()->create([
                'category_id' => $categories->firstWhere('name', $categoryName)->id,
                'user_id' => $authors->random()->id,
                'title' => $title,
                'slug' => Str::slug($title),
                'status' => $isPublished ? PostStatus::Published : PostStatus::Draft,
                'published_at' => $isPublished ? now()->subDays(count($posts) - $index) : null,
                'is_featured' => $index < 3,
                'views' => $isPublished ? fake()->numberBetween(10, 900) : 0,
            ]);

            $post->attachTags($tags);
        }
    }

    /**
     * @return Collection<int, Page>
     */
    private function seedPages(): Collection
    {
        $pages = [
            'Profil Madrasah' => 'Madrasah Aliyah Contoh berdiri sejak tahun 1995 dan berkomitmen mencetak generasi yang beriman, berilmu, dan berakhlak mulia.',
            'Visi dan Misi' => '<p><strong>Visi:</strong> Terwujudnya madrasah unggul yang menghasilkan lulusan beriman, berilmu, dan berakhlak mulia.</p><p><strong>Misi:</strong></p><ol><li>Menyelenggarakan pembelajaran yang aktif, kreatif, dan menyenangkan.</li><li>Menanamkan nilai-nilai keislaman dalam kehidupan sehari-hari.</li><li>Mengembangkan potensi siswa di bidang akademik dan non-akademik.</li></ol>',
            'Sejarah' => 'Sejarah singkat perjalanan madrasah dari sebuah sekolah kecil hingga menjadi madrasah unggulan di daerah.',
            'Struktur Organisasi' => 'Struktur organisasi madrasah yang terdiri dari kepala madrasah, wakil kepala, koordinator bidang, serta wali kelas.',
            'Fasilitas' => 'Madrasah dilengkapi laboratorium komputer, laboratorium IPA, perpustakaan, masjid, dan lapangan olahraga.',
        ];

        foreach ($pages as $title => $content) {
            if (! str_starts_with($content, '<')) {
                $content = "<p>{$content}</p>";
            }

            Page::query()->firstOrCreate(
                ['slug' => Str::slug($title)],
                ['title' => $title, 'content' => $content, 'is_published' => true],
            );
        }

        return Page::query()->get();
    }

    private function seedSlides(): void
    {
        if (Slide::query()->exists()) {
            return;
        }

        $slides = [
            ['Selamat Datang di Madrasah Aliyah Contoh', 'Membentuk generasi berilmu dan berakhlak mulia.', 'Profil Madrasah', '/profil-madrasah'],
            ['Penerimaan Peserta Didik Baru 2026/2027', 'Daftarkan putra-putri Anda sekarang juga.', 'Hubungi Kami', '/kontak'],
            ['Prestasi Gemilang Siswa Kami', 'Juara lomba tingkat provinsi dan olimpiade sains.', 'Lihat Berita', '/berita'],
        ];

        foreach ($slides as $index => [$title, $caption, $buttonLabel, $url]) {
            Slide::factory()->create([
                'title' => $title,
                'caption' => $caption,
                'button_label' => $buttonLabel,
                'url' => $url,
                'sort' => $index + 1,
                'is_active' => true,
            ]);
        }
    }

    /**
     * @return Collection<int, Album>
     */
    private function seedAlbums(): Collection
    {
        if (Album::query()->exists()) {
            return Album::query()->get();
        }

        $albums = [
            'Pesantren Kilat Ramadhan',
            'Wisuda Tahun Pelajaran 2025/2026',
            'Peringatan Hari Kemerdekaan',
        ];

        foreach ($albums as $title) {
            Album::factory()
                ->has(
                    AlbumPhoto::factory()
                        ->count(4)
                        ->sequence(fn ($sequence): array => ['sort' => $sequence->index + 1]),
                    'photos',
                )
                ->create([
                    'title' => $title,
                    'slug' => Str::slug($title),
                    'is_published' => true,
                ]);
        }

        return Album::query()->get();
    }

    private function seedStaff(): void
    {
        if (Staff::query()->exists()) {
            return;
        }

        Staff::factory()->create([
            'name' => 'Drs. H. Ahmad Fauzi, M.Pd.',
            'position' => 'Kepala Madrasah',
            'type' => StaffType::Employee,
            'education' => 'S2',
            'sort' => 1,
        ]);

        Staff::factory()
            ->count(9)
            ->sequence(fn ($sequence): array => ['sort' => $sequence->index + 2])
            ->create();
    }

    /**
     * Mengisi indikator dan tautan bukti untuk setiap Unsur PKKM pada tahun berjalan.
     */
    private function seedPkkmIndicators(): ?PkkmYear
    {
        $pkkmYear = PkkmYear::query()->where('year', now()->year)->first();

        if ($pkkmYear === null) {
            return null;
        }

        $pkkmYear->update([
            'is_published' => true,
            'description' => 'Ringkasan penilaian kinerja kepala madrasah tahun '.$pkkmYear->year.' beserta komponen, unsur, indikator, dan bukti pendukung.',
            'content' => $this->pkkmContent($pkkmYear->year),
        ]);

        if (PkkmIndicator::query()->exists()) {
            return $pkkmYear;
        }

        $items = PkkmItem::query()
            ->whereIn('pkkm_component_id', $pkkmYear->components()->pluck('id'))
            ->get();

        foreach ($items as $item) {
            foreach (range(1, 2) as $number) {
                $indicator = PkkmIndicator::factory()->create([
                    'pkkm_item_id' => $item->id,
                    'number' => (string) $number,
                    'sort' => $number,
                ]);

                PkkmEvidence::factory()->create([
                    'pkkm_indicator_id' => $indicator->id,
                    'label' => 'Lihat Bukti',
                    'sort' => 1,
                ]);
            }
        }

        return $pkkmYear;
    }

    private function pkkmContent(int $year): string
    {
        return <<<HTML
        <h2>Latar Belakang</h2>
        <p>Penilaian Kinerja Kepala Madrasah (PKKM) tahun {$year} dilaksanakan sebagai bagian dari upaya peningkatan mutu kepemimpinan dan pengelolaan madrasah secara berkelanjutan.</p>
        <h2>Tujuan</h2>
        <ul>
            <li>Mengukur capaian kinerja kepala madrasah pada lima komponen penilaian.</li>
            <li>Menjadi dasar perencanaan pengembangan kompetensi kepala madrasah.</li>
            <li>Mendorong transparansi dan akuntabilitas pengelolaan madrasah.</li>
        </ul>
        <h2>Tata Cara Penilaian</h2>
        <ol>
            <li>Kepala madrasah menyiapkan bukti pendukung untuk setiap indikator.</li>
            <li>Bukti diunggah berupa tautan atau berkas pada masing-masing indikator.</li>
            <li>Tim penilai memverifikasi bukti dan memberikan penilaian akhir.</li>
        </ol>
        <blockquote>Seluruh bukti yang diunggah wajib sesuai dengan kondisi nyata madrasah dan dapat dipertanggungjawabkan.</blockquote>
        HTML;
    }

    /**
     * @param  Collection<int, Page>  $pages
     */
    private function seedMenu(Collection $pages, ?PkkmYear $pkkmYear): void
    {
        if (MenuItem::query()->exists()) {
            return;
        }

        MenuItem::query()->create([
            'label' => 'Beranda',
            'type' => MenuItemType::Route,
            'route_name' => 'home',
            'sort' => 1,
        ]);

        $profile = MenuItem::query()->create([
            'label' => 'Profil',
            'type' => MenuItemType::None,
            'sort' => 2,
        ]);

        foreach (['Profil Madrasah', 'Visi dan Misi', 'Sejarah', 'Struktur Organisasi', 'Fasilitas'] as $index => $pageTitle) {
            MenuItem::query()->create([
                'parent_id' => $profile->id,
                'label' => $pageTitle,
                'type' => MenuItemType::Page,
                'target_id' => $pages->firstWhere('slug', Str::slug($pageTitle))->id,
                'sort' => $index + 1,
            ]);
        }

        MenuItem::query()->create([
            'label' => 'Berita',
            'type' => MenuItemType::Route,
            'route_name' => 'posts.index',
            'sort' => 3,
        ]);

        MenuItem::query()->create([
            'label' => 'Galeri',
            'type' => MenuItemType::Route,
            'route_name' => 'albums.index',
            'sort' => 4,
        ]);

        MenuItem::query()->create([
            'label' => 'Guru & Staf',
            'type' => MenuItemType::Route,
            'route_name' => 'staff.index',
            'sort' => 5,
        ]);

        if ($pkkmYear !== null) {
            MenuItem::query()->create([
                'label' => 'PKKM',
                'type' => MenuItemType::PkkmYear,
                'target_id' => $pkkmYear->id,
                'sort' => 6,
            ]);
        }

        MenuItem::query()->create([
            'label' => 'Kontak',
            'type' => MenuItemType::Route,
            'route_name' => 'contact',
            'sort' => 7,
        ]);
    }
}
