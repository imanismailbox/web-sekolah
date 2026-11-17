<?php

namespace Database\Seeders;

use App\Models\PkkmYear;
use Illuminate\Database\Seeder;

/**
 * Seeds the PKKM instrument skeleton (Komponen + Unsur/Tugas Utama) for the current year.
 * Indicators and evidence are filled in through the admin panel.
 */
class PkkmTemplateSeeder extends Seeder
{
    /**
     * @var array<string, array{name: string, items: array<string, string>}>
     */
    private const TEMPLATE = [
        'A' => [
            'name' => 'Usaha Pengembangan Madrasah',
            'items' => [
                '1.1' => 'Mengembangkan madrasah sesuai dengan kebutuhan',
                '1.2' => 'Mengelola perubahan dan pengembangan madrasah menuju organisasi pembelajar yang efektif',
                '1.3' => 'Mengelola hubungan antara madrasah dan masyarakat dalam rangka pencarian dukungan ide, sumber belajar, dan pembiayaan',
                '1.4' => 'Mengelola proses pencapaian 8 SNP sesuai dengan arah dan tujuan pendidikan nasional',
                '1.5' => 'Mengelola unit layanan khusus madrasah dalam mendukung kegiatan pembelajaran dan kegiatan peserta didik di madrasah',
                '1.6' => 'Mengelola sistem informasi madrasah dalam mendukung penyusunan program dan pengambilan keputusan',
                '1.7' => 'Memanfaatkan kemajuan teknologi informasi bagi peningkatan pembelajaran dan manajemen madrasah',
            ],
        ],
        'B' => [
            'name' => 'Pelaksanaan Tugas Manajerial',
            'items' => [
                '2.1' => 'Menyusun perencanaan madrasah untuk berbagai tingkatan perencanaan',
                '2.2' => 'Memimpin madrasah dalam rangka pendayagunaan sumber daya madrasah secara optimal',
                '2.3' => 'Menciptakan budaya dan iklim madrasah yang kondusif dan inovatif bagi pembelajaran peserta didik',
                '2.4' => 'Mengelola guru dan staf dalam rangka pendayagunaan sumber daya manusia secara optimal',
                '2.5' => 'Mengelola sarana dan prasarana madrasah dalam rangka pendayagunaan secara optimal',
                '2.6' => 'Mengelola peserta didik dalam rangka penerimaan peserta didik baru, penempatan, dan pengembangan kapasitas peserta didik',
                '2.7' => 'Mengelola pengembangan kurikulum dan kegiatan pembelajaran sesuai dengan arah dan tujuan pendidikan nasional',
                '2.8' => 'Mengelola keuangan madrasah sesuai dengan prinsip pengelolaan yang akuntabel, transparan, dan efisien',
                '2.9' => 'Mengelola ketatausahaan madrasah dalam mendukung pencapaian tujuan madrasah',
                '2.10' => 'Melakukan monitoring, evaluasi, dan pelaporan pelaksanaan program kegiatan madrasah dengan prosedur yang tepat, serta merencanakan tindak lanjutnya',
            ],
        ],
        'C' => [
            'name' => 'Pengembangan Kewirausahaan',
            'items' => [
                '3.1' => 'Menciptakan inovasi yang bermanfaat dan tepat bagi pengembangan madrasah',
                '3.2' => 'Bekerja keras untuk mencapai keberhasilan madrasah sebagai organisasi pembelajaran yang efektif',
                '3.3' => 'Memiliki motivasi yang kuat untuk sukses dalam melaksanakan tugas pokok dan fungsinya sebagai pemimpin madrasah',
                '3.4' => 'Pantang menyerah dan selalu mencari solusi terbaik dalam menghadapi kendala yang dihadapi madrasah',
                '3.5' => 'Memiliki naluri kewirausahaan dalam mengelola kegiatan produksi/jasa madrasah sebagai sumber pembelajaran peserta didik',
            ],
        ],
        'D' => [
            'name' => 'Supervisi kepada Guru dan Tenaga Kependidikan',
            'items' => [
                '4.1' => 'Menyusun program supervisi akademik dalam rangka peningkatan profesionalisme guru',
                '4.2' => 'Melaksanakan supervisi akademik terhadap guru dengan menggunakan pendekatan dan teknik supervisi yang tepat',
                '4.3' => 'Menilai dan menindaklanjuti kegiatan supervisi akademik dalam rangka peningkatan profesionalisme guru',
            ],
        ],
        'E' => [
            'name' => 'Hasil Kinerja Kepala Madrasah',
            'items' => [
                '5.1' => 'Prestasi peserta didik',
                '5.2' => 'Prestasi pendidik dan tenaga kependidikan',
                '5.3' => 'Prestasi madrasah',
                '5.4' => 'Prestasi kepala madrasah',
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = now()->year;

        if (PkkmYear::query()->where('year', $currentYear)->exists()) {
            return;
        }

        $year = PkkmYear::query()->create([
            'year' => $currentYear,
            'title' => "Penilaian Kinerja Kepala Madrasah (PKKM) Tahun {$currentYear}",
            'slug' => "pkkm-tahun-{$currentYear}",
            'is_published' => false,
        ]);

        $componentSort = 0;

        foreach (self::TEMPLATE as $code => $component) {
            $newComponent = $year->components()->create([
                'code' => $code,
                'name' => $component['name'],
                'sort' => ++$componentSort,
            ]);

            $itemSort = 0;

            foreach ($component['items'] as $itemCode => $itemName) {
                $newComponent->items()->create([
                    'code' => (string) $itemCode,
                    'name' => $itemName,
                    'sort' => ++$itemSort,
                ]);
            }
        }
    }
}
