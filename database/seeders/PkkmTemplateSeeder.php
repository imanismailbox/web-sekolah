<?php

namespace Database\Seeders;

use App\Enums\EvidenceType;
use App\Models\PkkmYear;
use Illuminate\Database\Seeder;

/**
 * Seeds the complete PKKM instrument (Komponen, Unsur/Tugas Utama, Indikator Kinerja,
 * and Rincian Bukti Dukung checklist) based on SK Dirjen Pendis Nomor 1111 Tahun 2019
 * and the 2026 annual PKKM digital evidence form.
 * Evidence links/files are filled in progressively through the admin panel.
 */
class PkkmTemplateSeeder extends Seeder
{
    /**
     * @var array<string, array{
     *     name: string,
     *     items: array<string, array{
     *         name: string,
     *         indicators: list<array{description: string, expected_evidence: string, evidence?: list<string>}>
     *     }>
     * }>
     */
    private const TEMPLATE = [
        'A' => [
            'name' => 'Usaha Pengembangan Madrasah',
            'items' => [
                '1.1' => [
                    'name' => 'Mengembangkan madrasah sesuai dengan kebutuhan',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan struktur organisasi yang sesuai dengan kebutuhan program.',
                            'expected_evidence' => 'Dokumen struktur madrasah. Bukti fisik: Melalui observasi dan studi dokumen: bagan/struktur organisasi; notulen rapat yang berisi keputusan tentang penyusunan struktur organisasi; dokumen sosialisasi.',
                            'evidence' => [
                                'FILE Bagan/Struktur Organisasi Madrasah',
                                'File Notulen Rapat Penyusunan Struktur Organisasi Madrasah',
                                'File Dokumen Sosialisasi Struktur Organisasi',
                                'File Daftar Hadir Rapat Penyusunan Struktur',
                            ],
                        ],
                        [
                            'description' => 'Mampu menempatkan personalia yang sesuai dengan kebutuhan.',
                            'expected_evidence' => 'Dokumen uraian tugas personalia di madrasah. Bukti fisik: Melalui studi dokumen: dokumen penetapan/pengesahan susunan organisasi madrasah; rincian tugas setiap personil pada struktur organisasi madrasah; SOP personalia; sertifikat.',
                            'evidence' => [
                                'File Penetapan/Pengesahan Susunan Pengurus Komite',
                                'File Rincian Tugas Pengurus Komite',
                                'File Semua SOP Personalia',
                                'File Sertifikat kompetensi pendukung personalia',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan pedoman dan prosedur kerja organisasi madrasah.',
                            'expected_evidence' => 'Pedoman dan prosedur kerja organisasi madrasah. Bukti fisik: Melalui observasi dokumen SOP madrasah atau Pedoman Sistem Informasi Madrasah.',
                            'evidence' => [
                                'SOP Madrasah',
                                'Buku Pedoman Tata Kerja Madrasah',
                            ],
                        ],
                    ],
                ],
                '1.2' => [
                    'name' => 'Mengelola perubahan dan pengembangan madrasah menuju organisasi pembelajar yang efektif',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan program baru untuk meningkatkan pencapaian target yang lebih tinggi.',
                            'expected_evidence' => 'Program pengembangan madrasah mengandung target pencapaian pada indikator keunggulan khas satuan pendidikan, kerja sama tim, dan data realisasi target yang meningkat daripada pencapaian sebelumnya. Bukti fisik: Melalui studi dokumen: visi dan misi madrasah; data prestasi madrasah; data hasil UN 3 tahun terakhir; data alumni; RKJM.',
                            'evidence' => [
                                'File Visi dan Misi Madrasah',
                                'File Data Prestasi Madrasah Akademik dan Non Akademik',
                                'File Data Hasil ANBK/asesmen 3 tahun terakhir',
                                'File Data /Buku Penelusuran Alumni',
                            ],
                        ],
                        [
                            'description' => 'Mampu dan terampil dalam membangun tim kerja yang efektif untuk mendapatkan produk kinerja yang lebih unggul.',
                            'expected_evidence' => 'Terdapat struktur organisasi yang dilengkapi dengan distribusi dan deskripsi pembagian tugas. Bukti fisik: Melalui observasi dan studi dokumen: bagan/struktur organisasi; SK; tugas dan fungsi; pedoman monitoring dan evaluasi kerja; pedoman reward dan punishment.',
                            'evidence' => [
                                'File Bagan/Struktur Organisasi, surat tugas dan fungsing',
                                'File SK Pengurus Rumpun/KKG/MGMP/FGD Rumpun',
                                'File Tugas dan Fungsi Rumpun/kKG/MGMP/FGD Rumpun',
                                'File Program Kerja Rumpun/KKG/MGMP/FGD Rumpun',
                                'File Laporan Kegiatan Rumpun/KKG/MGMP/FGD Rumpun',
                            ],
                        ],
                        [
                            'description' => 'Mampu menerapkan berbagai teknik pembaharuan dalam pengelolaan pembelajaran.',
                            'expected_evidence' => 'Terdapat penerapan strategi pembaharuan dengan strategi yang terprogram. Bukti fisik: Melalui studi dokumen: kurikulum; kalender pendidikan; perangkat pembelajaran; penilaian; peraturan akademik; notulen diskusi evaluasi rutin pembelajaran.',
                            'evidence' => [
                                'File Dokumen KOM/KM',
                                'File Kalender Madrasah',
                                'File Perangkat Pembelajaran Inovatif Guru',
                                'File Instrumen/Pedoman Penilaian ( Kisi/kisi, Soal,Nilai )',
                                'File Peraturan Akademik',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan potensi dan meningkatkan prestasi madrasah.',
                            'expected_evidence' => 'Dokumen bukti perkembangan potensi dan prestasi peserta didik yang meningkat dari waktu ke waktu. Bukti fisik: Melalui studi dokumen: data prestasi madrasah 1 tahun terakhir; data hasil UN 1 tahun terakhir; dokumen akreditasi; program ekstrakurikuler; program unggulan madrasah.',
                            'evidence' => [
                                'File Data Prestasi Madrasah Akademik dan Non Akademik 1 tahun',
                                'File Hasil ANBK/UM/Asesmen',
                                'File Dokumen Akreditasi',
                                'File Program Semua Ekstrakurikuler dan Jadwal Ekstrakurikuler',
                            ],
                        ],
                    ],
                ],
                '1.3' => [
                    'name' => 'Mengelola hubungan antara madrasah dan masyarakat dalam rangka pencarian dukungan ide, sumber belajar, dan pembiayaan',
                    'indicators' => [
                        [
                            'description' => 'Merencanakan kerjasama dengan lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Data kerjasama dengan lembaga pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: SK komite madrasah; AD/ART komite madrasah; program kerja komite madrasah; laporan kegiatan komite madrasah; dokumen tertulis kerja sama (MoU); foto-foto; sertifikat/plakat kerja sama; laporan kegiatan.',
                            'evidence' => [
                                'File SK Komite Madrasah',
                                'File AD/ART Komite',
                                'File Program Kerja Komite',
                                'File Laporan Kegiatan Komite',
                                'File Dokumen MOU',
                            ],
                        ],
                        [
                            'description' => 'Melakukan pendekatan-pendekatan dalam rangka mendapatkan dukungan dari lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Dokumen program kerjasama dengan pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: program kegiatan kerja sama; foto kegiatan; jadwal kegiatan; laporan kegiatan.',
                            'evidence' => [
                                'File Proposal/Program Kegiatan Kerja Sama',
                                'kegiatan bersama mitra',
                                'File Jadwal Pelaksanaan Kegiatan Kerja sama',
                                'File SK Penaggungjawab Program Dukungan dari Lembaga Lain',
                            ],
                        ],
                        [
                            'description' => 'Memanfaatkan dan memelihara hubungan kerjasama dengan lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Data hasil kerjasama dengan lembaga pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: laporan kegiatan kerja sama; laporan monitoring/evaluasi kegiatan; dokumentasi foto/video pelaksanaan kerjasama.',
                            'evidence' => [
                                'Laporan Kegiatan Kerja Sama',
                                'Bukti manfaat/out put hasil program kemitraan',
                            ],
                        ],
                    ],
                ],
                '1.4' => [
                    'name' => 'Mengelola proses pencapaian SNP sesuai dengan arah dan tujuan pendidikan nasional',
                    'indicators' => [
                        [
                            'description' => 'Mengaplikasikan pengembangan kurikulum yang mengacu kepada standar isi.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar isi. Bukti fisik: Melalui studi dokumen: kurikulum; kalender pendidikan; perangkat pembelajaran; pedoman penilaian; peraturan akademik; buku kerja guru; dokumen rapat penyusunan kurikulum (daftar hadir, daftar peserta, foto).',
                            'evidence' => [
                                'File KOM',
                                'File Kalender Madrasah',
                                'File Perangkat Pembelajaran Semua Guru',
                                'File Penilaian (Kisi-Kisi, Soal, Nilai )',
                                'File Peraturan Akademik',
                                'File Buku Kerja Guru',
                            ],
                        ],
                        [
                            'description' => 'Mengaplikasikan pengembangan proses pembelajaran yang mengacu kepada standar proses.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar proses. Bukti fisik: Melalui studi dokumen: dokumen pengembangan silabus; RPP; struktur kurikulum; pembagian jam mengajar; jadwal mengajar; RPE; buku teks; jurnal mengajar guru; data siswa per kelas; dokumen supervisi (laporan pemantauan pembelajaran, laporan supervisi, laporan evaluasi pembelajaran dan rencana tindak lanjut).',
                            'evidence' => [
                                'File Dokumen Silabus/ CP/ATP',
                                'File RPP/Modul Ajar dan RPE ( Rencana Pekan Efektif )',
                                'File Buku Teks Pelajaran',
                                'File Jurnal Mengajar',
                                'File Data Presensi Siswa',
                            ],
                        ],
                        [
                            'description' => 'Mengaplikasikan sistem penilaian pembelajaran yang mengacu kepada standar penilaian.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar penilaian. Bukti fisik: Melalui studi dokumen: instrumen penilaian; kisi-kisi soal; kumpulan naskah soal; analisis butir soal; dokumen analisis hasil belajar siswa; laporan hasil belajar siswa; tindak lanjut hasil penilaian; dokumen pelaksanaan PAS; dokumen pelaksanaan PAT.',
                            'evidence' => [
                                'File Instrumen Penilaian',
                                'File Kisi -Kisi Soal',
                                'File Kumpulan Naskah Soal',
                                'File Analisis Butir Soal& Analisis Hasil Belajar',
                                'Program Remedial & Pengayaan',
                                'File Laporan Hasil Belajar RDM',
                                'File Tindak Lanjut Hasil Penilaian',
                                'File Dokumen Pelaksanaan PAS',
                                'File Dokumen Pelaksanaan PAT',
                            ],
                        ],
                        [
                            'description' => 'Melaksanakan penjaminan mutu pencapaian standar kompetensi lulusan.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar kompetensi lulusan. Bukti fisik: Melalui studi dokumen: dokumen program kegiatan kesiswaan; laporan kegiatan kesiswaan; dokumentasi kegiatan kesiswaan; laporan kegiatan pembiasaan siswa; dokumen kegiatan literasi; data rata-rata hasil ujian 2 tahun terakhir; data prestasi akademik 2 tahun terakhir; data prestasi non akademik 2 tahun terakhir.',
                            'evidence' => [
                                'File Program Kegiatan Kesiswaan (pembiasaan religius)',
                                'File Laporan Kegiatan Kesiswaan',
                                'File Dokumen Kegiatan Kesiswaan',
                                'File Laporan Kegiatan Pembiasaan Siswa',
                                'File Dokumen Kegiatan Literasi',
                                'File Data Rata RataHasil Ujian 2 Tahun',
                                'File Data Prestasi Akademik 2 Tahun',
                                'File Data Prestasi Non Akademik 2 Tahun',
                            ],
                        ],
                    ],
                ],
                '1.5' => [
                    'name' => 'Mengelola unit layanan khusus madrasah dalam mendukung kegiatan pembelajaran dan kegiatan peserta didik di madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola laboratorium madrasah agar dapat dimanfaatkan secara optimal untuk kepentingan pembelajaran peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan laboratorium dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: luas sesuai standar; sarana pendukung laboratorium; jurnal dan laporan pengelolaan laboratorium; program kerja lab.',
                            'evidence' => [
                                'File Luas Laboran & Data sarana ruang laboratorium dan peralatannya',
                                'Jadwal Penggunaan laboratorium',
                                'File Jurnal Laboratorium',
                                'File Program Pemeliharaan dan Pengembangan Sarpras',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola perpustakaan madrasah dalam menyiapkan sumber belajar yang diperlukan oleh peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan perpustakaan dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: luas sesuai standar; sarana pendukung; daftar buku induk perpustakaan; laporan pengelolaan perpustakaan; program kerja perpustakaan.',
                            'evidence' => [
                                'Buku Induk Inventaris Perpustakaan',
                                'File Sarana Pendukung Perpus',
                                'Jadwal dan dokumentasi pemanfaatan perpustakaan',
                                'Statistik kunjungan dan sirkulasi peminjaman buku',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola usaha madrasah untuk pembelajaran peserta didik dan pemasukan tambahan dana bagi madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan usaha madrasah dalam pembelajaran. Bukti fisik: Melalui studi dokumen: data/laporan kegiatan usaha madrasah; dokumentasi kegiatan (foto/video).',
                            'evidence' => [
                                'SK Pengelola Unit Usaha Madrasah',
                                'Dokumentasi keterlibatan siswa dalam pembelajaran usaha',
                                'Laporan pembukuan keuangan dan operasional unit usaha',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola koperasi madrasah baik sebagai media praktik maupun sebagai sumber belajar bagi peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan koperasi dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: instrumen hasil praktek pembelajaran; foto kegiatan praktik; AD/ART koperasi; laporan RAT.',
                            'evidence' => [
                                'Buku Administrasi & Laporan Keuangan Koperasi Madrasah/Usaha Madrasah',
                                'Dokumen Foto Kegiatan Praktek Siswa di Koperasi',
                                'Jadwal Piket Praktik Kerja Koperasi',
                                'Instrumen Hasil Praktek Pembelajaran',
                            ],
                        ],
                    ],
                ],
                '1.6' => [
                    'name' => 'Mengelola sistem informasi madrasah dalam mendukung penyusunan program dan pengambilan keputusan',
                    'indicators' => [
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam manajemen madrasah.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam manajemen madrasah. Bukti fisik: Observasi, studi dokumen dan wawancara: fasilitas teknologi dan informasi; sumber daya informasi; website madrasah; pedoman Sistem Informasi Madrasah.',
                            'evidence' => [
                                'Daftar Sarana TIK Pendukung Manajemen Madrasah',
                                'Dokumen Pemanfaatan aplikasi SIM Madrasah (Emis, Simpatika, Siaga)',
                            ],
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam pembelajaran, baik sebagai sumber belajar maupun sebagai alat/media pembelajaran.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi sebagai sumber belajar dan media pembelajaran. Bukti fisik: Observasi lingkungan madrasah dan wawancara: ketersediaan komputer; jaringan internet; website madrasah; alamat email madrasah; pemanfaatan TIK untuk pembelajaran.',
                            'evidence' => [
                                'File Data Ketersediaan Komputer dan akses internet',
                                'Website dan email resmi madrasah yang aktif',
                                'Pemanfaatan Rapor Digital Madrasah (RDM) / LMS pembelajaran',
                            ],
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam menjalin kerjasama dengan pihak lain.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam menjalin kerjasama dengan pihak lain. Bukti fisik: Observasi lingkungan madrasah, wawancara dan studi dokumen: pengelolaan SIM; fasilitas SIM; surat tugas pengelola SIM; pelaporan data dan informasi.',
                            'evidence' => [
                                'SK Penugasan Operator SIM / EMIS Madrasah',
                                'Dokumentasi koordinasi daring dengan Kemenag',
                                'Berita Acara Pendataan (BAP) EMIS dan SIMPATIKA',
                            ],
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam promosi program madrasah dan prestasi yang telah dicapai.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam promosi program madrasah dan prestasi yang telah dicapai. Bukti fisik: Observasi lingkungan madrasah, wawancara dan studi dokumen: pengelolaan SIM; fasilitas SIM; surat tugas pengelola SIM; pelaporan data dan informasi.',
                            'evidence' => [
                                'Website dan akun media sosial resmi madrasah',
                                'Brosur PPDB daring / banner publikasi prestasi',
                                'Konten publikasi prestasi siswa dan guru di media digital',
                            ],
                        ],
                    ],
                ],
                '1.7' => [
                    'name' => 'Memanfaatkan kemajuan teknologi informasi bagi peningkatan pembelajaran dan manajemen madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan sistem administrasi pengelolaan secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Terdapat penerapan TIK (berbasis komputer, CD, jejaring intranet, internet) dalam pengelolaan administrasi persuratan, sarana prasarana, kepegawaian, kepesertadidikan, dan keuangan. Bukti fisik: Observasi lingkungan madrasah dan wawancara: jumlah komputer dan LCD yang cukup; memiliki jaringan internet; memiliki web sekolah; memiliki e-mail madrasah; laporan absensi elektronik; dokumen lain pemanfaatan TIK untuk administrasi madrasah.',
                            'evidence' => [
                                'Sistem buku agenda persuratan digital / email dinas',
                                'Bukti jaringan intranet/LAN madrasah yang berfungsi',
                                'Aplikasi data kepegawaian dan sarana berbasis komputer',
                            ],
                        ],
                        [
                            'description' => 'Mengelola administrasi pembelajaran secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Model penerapan TIK dalam pengelolaan administrasi kurikulum dan pembelajaran, misalnya pengelolaan kurikulum berbasis komputer, intranet, dan internet. Bukti fisik: Observasi lingkungan madrasah dan wawancara: jumlah komputer dan LCD yang cukup; memiliki jaringan internet; pemanfaatan TIK untuk pembelajaran (Edmodo, Google Classroom, dll); pengelolaan penilaian berbasis TIK.',
                            'evidence' => [
                                'Pemanfaatan aplikasi RDM / e-learning pembelajaran',
                                'Dokumentasi asesmen berbasis komputer (CBT / ANBK)',
                                'Arsip digital perangkat ajar modul kurikulum guru',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan sistem pengelolaan perpustakaan secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Model pemanfaatan TIK dalam sistem pengelolaan perpustakaan berbasis komputer, intranet, atau internet. Bukti fisik: Observasi lingkungan madrasah dan studi dokumen: katalog digital; BSE; akses internet; komputer; dokumen aplikasi layanan perpustakaan.',
                            'evidence' => [
                                'Katalog digital / software perpustakaan (Inlislite/Senayan)',
                                'Komputer anjungan pencarian buku perpustakaan',
                                'Koleksi BSE / buku digital yang dapat diakses siswa',
                                'File Dokumen Komputer, LCD dan TV',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'B' => [
            'name' => 'Pelaksanaan Tugas Manajerial',
            'items' => [
                '2.1' => [
                    'name' => 'Menyusun perencanaan madrasah untuk berbagai tingkatan perencanaan',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan RKJM, RKT/RKAM dengan program lainnya berdasarkan data hasil evaluasi dalam pemenuhan SNP.',
                            'expected_evidence' => 'Dokumen RKJM, RKT/RKAM yang meliputi SNP. Bukti fisik: Melalui studi dokumen: dokumen Evaluasi Diri Madrasah (EDM); dokumen RKJM dan RKT berbasis EDM.',
                            'evidence' => [
                                'File EDM',
                                'File RKJM/RKM',
                                'File RKT/RKAM',
                            ],
                        ],
                        [
                            'description' => 'Mampu merumuskan visi-misi sebagai arah pengembangan program RKJM, RKT/RKAS dan program lainnya.',
                            'expected_evidence' => 'Visi-misi madrasah merupakan rumusan hasil keputusan bersama. Bukti fisik: Melalui studi dokumen: visi, misi yang telah ditetapkan oleh Kamad; berita acara dan daftar hadir kegiatan perumusan/peninjauan kembali dan penetapan visi dan misi.',
                            'evidence' => [
                                'File Visi dan Misi Madrasah',
                                'File Berita Acara dan Daftar Hadir',
                            ],
                        ],
                        [
                            'description' => 'Mampu menentukan strategi pencapaian tujuan madrasah, dilengkapi dengan indikator pencapaian yang terukur.',
                            'expected_evidence' => 'Dokumen program yang memuat strategi pencapaian tujuan madrasah. Bukti fisik: Melalui studi dokumen: program kerja; RKJM dan RKTM.',
                            'evidence' => [
                                'File Program Kerja Tahunan Kepala',
                                'File RKJM dan RKTM',
                                'Matrik strategi dan target capaian mutu dalam RKTM /RKAM',
                            ],
                        ],
                        [
                            'description' => 'Mampu menyusun program dengan rencana evaluasi keterlaksanaan dan pencapaian program.',
                            'expected_evidence' => 'Dokumen rencana evaluasi keterlaksanaan dan pencapaian program. Bukti fisik: Melalui studi dokumen RKJM dan RKTM.',
                            'evidence' => [
                                'Jadwal rencana evaluasi program madrasah',
                                'instrumen evaluasi ketercapaian program RKAM',
                            ],
                        ],
                    ],
                ],
                '2.2' => [
                    'name' => 'Memimpin madrasah dalam rangka pendayagunaan sumber daya madrasah secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu memberi contoh berdisiplin; hadir tepat waktu, disiplin menggunakan waktu, dan tepat waktu mengakhiri pekerjaan.',
                            'expected_evidence' => 'Dokumen daftar hadir semua kegiatan madrasah. Bukti fisik: Observasi, wawancara dan studi dokumen: daftar hadir elektronik kamad; daftar hadir pada kegiatan di madrasah.',
                            'evidence' => [
                                'File Pusaka Kehadiran Kamad',
                                'File Daftar Hadir Kegiatan di Madrasah /kegiatan dinas',
                            ],
                        ],
                        [
                            'description' => 'Mampu melaksanakan peraturan sesuai dengan ketentuan yang berlaku.',
                            'expected_evidence' => 'Menjadi contoh dan mengarahkan guru, staf administrasi, dan peserta didik melaksanakan kegiatan sesuai dengan peraturan. Bukti fisik: Wawancara dengan warga madrasah; laporan kehadiran; notulen rapat/briefing pengarahan kegiatan.',
                            'evidence' => [
                                'Buku catatan pembinaan Tata Tertib',
                                'Dokumen Tata Tertib GTK dan Murid',
                            ],
                        ],
                        [
                            'description' => 'Mampu menunjukkan keteladanan dalam memanfaatkan sumber daya secara efektif dan efisien.',
                            'expected_evidence' => 'Memecahkan masalah madrasah secara bersama-sama, merencanakan pemanfaatan sumber belajar dan sumber informasi, memantau penggunaan sumber daya, dan menilai pemanfaatan sumber daya. Bukti fisik: Wawancara dengan warga madrasah; dokumen monitoring dan evaluasi pemanfaatan sumber belajar; notulensi rapat/diskusi pemanfaatan sumber belajar.',
                            'evidence' => [
                                'Catatan Notulen Musyawarah Pemecahan Masalah Madrasah',
                                'Dokumen pemantauan penggunaan sarana bersama',
                            ],
                        ],
                        [
                            'description' => 'Mampu menunjukkan kedisiplinan sebagai insan pembelajar.',
                            'expected_evidence' => 'Rajin membaca dan pendengar yang baik, mengekspresikan pikiran secara tertulis, mengkomunikasikan ilmu pengetahuan baru, dan menyediakan berbagai media untuk mengembangkan gagasan warga madrasah. Bukti fisik: Wawancara, observasi: koleksi buku referensi/ilmu pengetahuan; karya tulis yang diterbitkan atau tidak; majalah/koran madrasah; website madrasah; blog pribadi.',
                            'evidence' => [
                                'File Koleksi Buku Referensi',
                                'File Karya Tulis yang diterbitkan',
                            ],
                        ],
                    ],
                ],
                '2.3' => [
                    'name' => 'Menciptakan budaya dan iklim madrasah yang kondusif dan inovatif bagi pembelajaran peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Mampu menjadi contoh dan berbudaya mutu yang kompetitif dalam mendorong peningkatan prestasi akademik dan non akademik peserta didik.',
                            'expected_evidence' => 'Dokumen peningkatan KKM, target hasil ulangan, hasil UN dan target keunggulan non akademik peserta didik yang terprogram, terlaksana, dan meningkat hasilnya. Bukti fisik: Wawancara dan studi dokumen: peningkatan KKM; hasil UN; program keunggulan dan inovasi baik akademik maupun non akademik; data prestasi akademik dan non akademik.',
                            'evidence' => [
                                'File KKM/KKTP',
                                'File Hasil ANBK/UM',
                                'File Program Keunggulan Akademik dan Non Akademik',
                                'File Data Prestasi Akademik dan Non Akademik',
                            ],
                        ],
                        [
                            'description' => 'Mampu melengkapi sarana dan prasarana untuk menciptakan suasana belajar kondusif dan inovatif bagi peserta didik.',
                            'expected_evidence' => 'Suasana lingkungan madrasah yang asri, bersih, rindang, aman, dan menyenangkan peserta didik. Bukti fisik: Observasi lingkungan madrasah: suasana lingkungan yang asri, bersih, rindang, aman, dan menyenangkan peserta didik.',
                            'evidence' => [
                                'File Foto/dokumen kebersihan Lingkungan Madrasah',
                                'Program penataan taman dan keamanan lingkungan madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu memfasilitasi kegiatan-kegiatan untuk meningkatkan budaya baca dan budaya tulis peserta didik.',
                            'expected_evidence' => 'Data kunjungan perpustakaan, peminjaman buku oleh peserta didik, pembaharuan buku dan bahan bacaan, ketersediaan sumber belajar berbasis TIK, dan sarana publikasi karya tulis, serta mengembangkan kompetisi karya tulis peserta didik tingkat madrasah. Bukti fisik: Observasi, wawancara dan studi dokumen: rencana dan laporan pelaksanaan kegiatan literasi; dokumen kegiatan pengembangan budaya baca; dokumen/pajangan hasil karya tulis siswa; data kunjungan dan peminjaman buku perpustakaan.',
                            'evidence' => [
                                'File Rencana , Program dan Laporan Kegiatan Literasi',
                                'File Dokumen Buku Karya Murid(Pengembangan Budaya Baca)',
                                'Dokumen pojok baca dan mading',
                            ],
                        ],
                        [
                            'description' => 'Mampu memfasilitasi kegiatan-kegiatan lomba di bidang akademik dan non akademik bagi peserta didik.',
                            'expected_evidence' => 'Dokumen penyelenggaraan kegiatan kompetisi yang dimulai dari tingkat madrasah, perolehan piagam penghargaan, piala, trofi perlombaan bidang akademik dan non akademik. Bukti fisik: Observasi dan studi dokumen: dokumen penyelenggaraan kegiatan kompetisi yang dimulai dari tingkat madrasah; daftar perolehan piagam, penghargaan, piala, trofi perlombaan di semua jenjang.',
                            'evidence' => [
                                'File Dokumen Kegiatan Lomba Dari Tingkat Madrasah sampai Nasional ( SK Panitia lomba)',
                                'File Daftar Perolehan Piagam Penghargaan',
                            ],
                        ],
                    ],
                ],
                '2.4' => [
                    'name' => 'Mengelola guru dan staf dalam rangka pendayagunaan sumber daya manusia secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu menyusun perencanaan pengembangan pendidik dan tenaga kependidikan.',
                            'expected_evidence' => 'Dokumen program pembinaan pendidik dan tenaga kependidikan di madrasah. Bukti fisik: Studi dokumen dan wawancara: program kerja kepala madrasah; laporan kegiatan workshop/pelatihan kompetensi guru; dokumentasi (foto/video) kegiatan workshop/pelatihan guru.',
                            'evidence' => [
                                'File Program Pembinaan SDM',
                            ],
                        ],
                        [
                            'description' => 'Mampu melakukan pembinaan berkala untuk meningkatkan mutu SDM madrasah.',
                            'expected_evidence' => 'Dokumen pelaksanaan kegiatan pembinaan guru. Bukti fisik: Studi dokumen dan wawancara: buku/catatan pembinaan guru dan tendik (notulen dan daftar hadir rapat pembinaan); laporan kinerja kepala madrasah.',
                            'evidence' => [
                                'File Buku/Catatan Pembinaan Guru (Notulen, Daftar Hadir,Undangan Pemanggilan )',
                                'File Laporan Kinerja Kamad ( Nilai PKKM 4 Tahunan atau Tahun Sebelumnnya )',
                            ],
                        ],
                        [
                            'description' => 'Memfasilitasi guru dan staf administrasi untuk meningkatkan kegiatan pembinaan kompetensi.',
                            'expected_evidence' => 'Data dukungan Kepala Madrasah dalam memfasilitasi staf administrasi untuk meningkatkan mutu profesi. Bukti fisik: Studi dokumen dan wawancara: buku/catatan pembinaan guru dan tendik (notulen dan daftar hadir rapat pembinaan); laporan kinerja kepala madrasah.',
                            'evidence' => [
                                'Surat Tugas keikut sertaan pelatihan GTK',
                                'Sertifikat pelatihan/MOOC',
                            ],
                        ],
                        [
                            'description' => 'Memantau dan menilai penerapan hasil pelatihan dalam pekerjaan di madrasah.',
                            'expected_evidence' => 'Dokumen program evaluasi pelatihan atau pengembangan profesi pendidik dan tenaga kependidikan. Bukti fisik: Observasi dan studi dokumen: program pelatihan pengembangan profesi guru dan tendik; laporan pelaksanaan pelatihan pengembangan profesi guru dan tendik.',
                            'evidence' => [
                                'Instrumen evaluasi tingkat lanjut pasca pelatihan',
                                'laporan diseminasi hasil diklat',
                            ],
                        ],
                    ],
                ],
                '2.5' => [
                    'name' => 'Mengelola sarana dan prasarana madrasah dalam rangka pendayagunaan secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola fasilitas prasarana, perabot dan sarana madrasah (gedung, bangunan, dan lahan meja, kursi, lemari, peralatan kantor, dan alat kebersihan).',
                            'expected_evidence' => 'Data fasilitas prasarana, perabot, dan sarana madrasah dikelola dengan baik. Bukti fisik: Observasi dan studi dokumen: buku inventaris; buku pemeliharaan sarana dan prasarana.',
                            'evidence' => [
                                'File Buku Induk Inventaris Sarana dan Prasarana (BIIB)',
                                'Buku inventaris Ruangan (DIR)',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola perpustakaan madrasah.',
                            'expected_evidence' => 'Data perpustakaan dikelola dengan baik. Bukti fisik: Observasi fisik dan studi dokumen: buku induk perpustakaan; buku/data/grafik layanan perpustakaan.',
                            'evidence' => [
                                'File Buku Induk Perpustakaan',
                                'File Buku/Data/Grafik Layanan Perpustakaan',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola laboratorium madrasah.',
                            'expected_evidence' => 'Data laboratorium dikelola dengan baik. Bukti fisik: Observasi fisik dan studi dokumen: daftar inventaris laboratorium; buku/jurnal/data/grafik layanan laboratorium.',
                            'evidence' => [
                                'Daftar Inventaris Laboratorium',
                                'File Buku /Data/Jurnal/Grafik Layanan Laboratorium',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola fasilitas penunjang madrasah lainnya (bengkel, toko, koperasi, kebun dsb).',
                            'expected_evidence' => 'Data fasilitas penunjang terkelola dengan baik. Bukti fisik: Observasi fisik, wawancara dan studi dokumen: data fasilitas penunjang wirausaha yang dikelola oleh madrasah.',
                            'evidence' => [
                                'Dokumen inventaris fasilitas pendukung madrasah /File data Wirausaha ( Koperasi,Kantin, Asrama )',
                                'Dokumen kondisi fisik sarana',
                            ],
                        ],
                    ],
                ],
                '2.6' => [
                    'name' => 'Mengelola peserta didik dalam rangka penerimaan peserta didik baru, penempatan, dan pengembangan kapasitas peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Menyusun perencanaan penerimaan, pengelolaan dan pengembangan kompetensi peserta didik.',
                            'expected_evidence' => 'Dokumen program penerimaan peserta didik baru, kriteria penerimaan peserta didik, data hasil analisis bekal ajar peserta didik awal. Bukti fisik: Studi dokumen: dokumen program penerimaan peserta didik baru; brosur; data hasil analisis kemampuan peserta didik baru; hasil psikotes minat bakat peserta didik baru.',
                            'evidence' => [
                                'File Dokumen PPDB ( SK/Surat Tugas Panitia PPDB)',
                                'File Brosur PPDB',
                                'Dokumen kriteria seleksi dan formulir pendaftaran',
                            ],
                        ],
                        [
                            'description' => 'Memiliki program pengembangan potensi diri dan prestasi peserta didik.',
                            'expected_evidence' => 'Dokumen program pengembangan potensi diri dan prestasi peserta didik. Bukti fisik: Observasi dan studi dokumen: program pengembangan diri peserta didik baik akademik maupun non akademik; laporan pengembangan diri peserta didik (akademik dan non akademik).',
                            'evidence' => [
                                'File Program pengembangan diri Peserta Didik',
                                'Jadwal bimbingan lomba',
                            ],
                        ],
                        [
                            'description' => 'Memfasilitasi kegiatan-kegiatan untuk meningkatkan pembiasaan melalui penanaman nilai-nilai.',
                            'expected_evidence' => 'Data program kegiatan akademik dan non akademik melalui penanaman nilai-nilai. Bukti fisik: Observasi lingkungan aktivitas siswa, wawancara dan studi dokumen: program kegiatan akademik dan non akademik dan laporan pelaksanaannya; laporan kegiatan pembiasaan diri peserta didik; dokumentasi kegiatan.',
                            'evidence' => [
                                'File Program Kegiatan Akademik dan Non Akademik serta Laporannya',
                                'Jadwal Pembiasaan',
                                'Buku cattaan pemantauan karakter',
                                'Dokumen sholat dan tadarus',
                            ],
                        ],
                        [
                            'description' => 'Memfasilitasi kegiatan pengembangan diri bagi peserta didik, pendidik, dan tenaga kependidikan lainnya secara optimal.',
                            'expected_evidence' => 'Data keterlaksanaan program pengembangan diri peserta didik, pendidik, dan tenaga kependidikan. Bukti fisik: Observasi lingkungan aktivitas siswa dan guru, wawancara dan studi dokumen: program kegiatan pengembangan diri; dokumentasi kegiatan; data prestasi siswa, guru dan tendik.',
                            'evidence' => [
                                'File Program Kegiatan Pengembangan Diri',
                                'Rekapitulasi data prestasi siswa dan Guru',
                                'Dokumen pelatihan',
                            ],
                        ],
                    ],
                ],
                '2.7' => [
                    'name' => 'Mengelola pengembangan kurikulum dan kegiatan pembelajaran sesuai dengan arah dan tujuan pendidikan nasional',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengarahkan secara efektif dalam menerapkan prinsip-prinsip pengembangan KTSP dalam kegiatan IHT, Workshop, Rapat Koordinasi, dan kegiatan MGMP/KKG.',
                            'expected_evidence' => 'Dokumen hasil pengembangan kurikulum yang disusun melalui rapat kerja, IHT, Workshop, Rakor, atau kegiatan MGMP/KKG. Bukti fisik: Studi dokumen: dokumen kurikulum yang berlaku; SK tim pengembang kurikulum; dokumen penyusunan dokumen kurikulum (daftar hadir, berita acara, notulen).',
                            'evidence' => [
                                'File Dokumen Kurikulum yang berlaku/KOM',
                                'File SK Tim Pengembang Kurikulum',
                                'File Dokumen Daftar Hadir, Berita Acara, Notulen Workshop',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengendalikan pelaksanaan KTSP berlandaskan kalender pendidikan, menerbitkan surat keputusan pembagian tugas mengajar, dan menerapkan aturan akademik.',
                            'expected_evidence' => 'Pelaksanaan kurikulum sesuai dengan kalender pendidikan tingkat madrasah, surat keputusan pembagian tugas mengajar, dan aturan akademik. Bukti fisik: Studi dokumen: struktur kurikulum; jadwal pelajaran; daftar hadir guru; peraturan akademik.',
                            'evidence' => [
                                'SK Pembagian Tugas /Beban Kerja',
                                'File Jadwal pelajaran',
                                'Buku Panduan Peraturan Akademik',
                                'Kalender Akademik',
                            ],
                        ],
                        [
                            'description' => 'Memfasilitasi efektivitas tim kerja guru dalam rangka meningkatkan mutu pembelajaran.',
                            'expected_evidence' => 'Bukti pelaksanaan kerja sama guru pada tingkat satuan pendidikan, antar satuan pendidikan dalam meningkatkan mutu perencanaan, proses, pembelajaran. Bukti fisik: Studi dokumen: program KKG/MGMP di madrasah; laporan pelaksanaan KKG/MGMP; dokumentasi kegiatan (foto/video).',
                            'evidence' => [
                                'File Program KKG/MGMP/ FGD Rumpun',
                                'File Laporan Pelaksanaan KKG/MGMP/FGD Rumpun',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan pelayanan belajar yang inovatif melalui pengembangan perangkat dan sumber belajar yang terbarukan.',
                            'expected_evidence' => 'Bukti penggunaan metode hasil pelatihan paling akhir, memanfaatkan teknologi informasi dan komunikasi, penggunaan alat peraga, teknik evaluasi baru yang menghasilkan produk belajar peserta didik yang dipublikasikan di lingkungan madrasah atau media lain. Bukti fisik: Observasi kelas, studi dokumen, wawancara dengan siswa dan guru: menelaah ragam metode, media dan sumber belajar yang digunakan dalam RPP.',
                            'evidence' => [
                                'File RPP/ Modul Ajar',
                                'Pameran/hasil karya pelajar',
                                'Alat peraga dan media pembelajaaran dikelas',
                            ],
                        ],
                        [
                            'description' => 'Memfasilitasi peserta didik dalam mengembangkan kolaborasi dan kompetisi bidang akademik dan non akademik.',
                            'expected_evidence' => 'Data kegiatan kolaborasi dan kompetisi peserta didik tingkat madrasah, baik akademik dan non akademik. Bukti fisik: Wawancara dan studi dokumen: program, laporan dan dokumen kegiatan kesiswaan (kegiatan akademik maupun non akademik); data prestasi akademik maupun non akademik.',
                            'evidence' => [
                                'File Program Laporan dan Dokumen Kegiatan Kesiswaan Lomba',
                                'Fil sertifikat lomba Prestasi Akademik maupun Non Akademik',
                            ],
                        ],
                    ],
                ],
                '2.8' => [
                    'name' => 'Mengelola keuangan madrasah sesuai dengan prinsip pengelolaan yang akuntabel, transparan, dan efisien',
                    'indicators' => [
                        [
                            'description' => 'Mampu merencanakan kebutuhan keuangan madrasah sesuai dengan rencana pengembangan madrasah, baik jangka pendek maupun jangka panjang.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen: RKJM dan RKTM; rencana anggaran; laporan keuangan; buku kas.',
                            'evidence' => [
                                'File RKJM dan RKTM',
                                'File Laporan Keuangan Semesteran',
                                'File Buku Kas Umum dan Buku Pembantu Kas',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengupayakan sumber-sumber keuangan terutama dari luar madrasah dan dari unit usaha madrasah.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen RKJM, RKTM, laporan keuangan.',
                            'evidence' => [
                                'File RKJM dan RKTM',
                                'Catatan penerimaan bantuan atau sumbangan tidak mengikat',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengkoordinasikan pembelanjaan keuangan sesuai dengan peraturan dan perundang-undangan berdasarkan asas prioritas dan efisiensi.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen RKJM, RKTM, laporan keuangan.',
                            'evidence' => [
                                'Dokumen alokasi belanja prioritas BOS/BOSP di RKAM',
                                'Bukti verifikasi SPJ keuangan',
                            ],
                        ],
                        [
                            'description' => 'Mampu membuat laporan dan evaluasi pengelolaan keuangan madrasah sesuai dengan prinsip efisien, transparan, dan akuntabel.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen: RKJM dan RKTM; laporan keuangan; buku kas.',
                            'evidence' => [
                                'Laporan Pertanggungjawaban (LPJ) BOS semesteran lengkap kuitansi',
                                'Buku Kas Umum, Bank, dan Pajak',
                                'Papan pengumuman transparansi penggunaan dana BOS di madrasah',
                            ],
                        ],
                    ],
                ],
                '2.9' => [
                    'name' => 'Mengelola ketatausahaan madrasah dalam mendukung pencapaian tujuan madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola administrasi surat masuk dan surat keluar sesuai dengan pedoman persuratan yang berlaku.',
                            'expected_evidence' => 'Adanya bukti dokumen surat masuk dan keluar. Bukti fisik: Melalui studi dokumen surat masuk dan keluar.',
                            'evidence' => [
                                'Buku agenda surat masuk dan surat keluar',
                                'Lembar disposisi kepala madrasah',
                                'Buku ekspedisi persuratan',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi madrasah yang meliputi administrasi akademik, kesiswaan, sarana/prasarana, keuangan, dan hubungan madrasah dengan masyarakat.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi madrasah (akademik, kesiswaan, sarana/prasarana, keuangan, dan hubungan madrasah dengan masyarakat).',
                            'evidence' => [
                                'Buku administrasi kurikulum/akademik',
                                'Buku induk siswa & mutasi',
                                'Buku inventaris sarpras & LPJ keuangan',
                                'Buku agenda komite madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi kearsipan madrasah baik arsip dinamis maupun arsip lainnya.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi madrasah.',
                            'evidence' => [
                                'Buku daftar arsip berkas pegawai/guru',
                                'Folder arsip dinamis dan statis madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi akreditasi madrasah sesuai dengan prinsip-prinsip tersedianya dokumen pendukung dan bukti fisik.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi pemenuhan SNP madrasah.',
                            'evidence' => [
                                'File portofolio dokumen akreditasi madrasah (BAN-PDM)',
                                'Sertifikat akreditasi terakhir dan dokumen rekomendasi',
                            ],
                        ],
                    ],
                ],
                '2.10' => [
                    'name' => 'Melakukan monitoring, evaluasi, dan pelaporan pelaksanaan program kegiatan madrasah dengan prosedur yang tepat, serta merencanakan tindak lanjutnya',
                    'indicators' => [
                        [
                            'description' => 'Menyusun standar kinerja program pendidikan yang dapat diukur dan dinilai.',
                            'expected_evidence' => 'Dokumen SKP yang terukur. Bukti fisik: Melalui studi dokumen SKP yang terukur.',
                            'evidence' => [
                                'Dokumen Sasaran Kinerja Pegawai (SKP) Kepala Madrasah',
                                'Matriks target kinerja tahunan',
                            ],
                        ],
                        [
                            'description' => 'Melakukan monitoring dan evaluasi kinerja program pendidikan dengan menggunakan teknik yang sesuai.',
                            'expected_evidence' => 'Dokumen pelaksanaan monitoring dan evaluasi yang sesuai. Bukti fisik: Melalui studi dokumen pelaksanaan monitoring dan evaluasi yang sesuai.',
                            'evidence' => [
                                'Instrumen monitoring dan evaluasi keterlaksanaan program',
                                'Catatan hasil pengawasan lapangan',
                            ],
                        ],
                        [
                            'description' => 'Menyusun laporan sesuai dengan standar pelaporan monitoring dan evaluasi.',
                            'expected_evidence' => 'Dokumen laporan pelaksanaan monitoring dan evaluasi. Bukti fisik: Melalui studi dokumen laporan pelaksanaan monitoring dan evaluasi.',
                            'evidence' => [
                                'Dokumen Laporan Tahunan Kinerja Madrasah kepada Kemenag / Yayasan',
                                'Notula rapat penyampaian laporan monev',
                            ],
                        ],
                        [
                            'description' => 'Merumuskan program tindak lanjut berdasarkan hasil evaluasi pelaksanaan program sebelumnya.',
                            'expected_evidence' => 'Dokumen program tindak lanjut berdasarkan hasil monitoring dan evaluasi. Bukti fisik: Melalui studi dokumen program tindak lanjut berdasarkan hasil monitoring dan evaluasi.',
                            'evidence' => [
                                'Dokumen rekomendasi tindak lanjut hasil monev',
                                'Matriks perbaikan program pada RKAM tahun berikutnya',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'C' => [
            'name' => 'Pengembangan Kewirausahaan',
            'items' => [
                '3.1' => [
                    'name' => 'Menciptakan inovasi yang bermanfaat dan tepat bagi pengembangan madrasah',
                    'indicators' => [
                        [
                            'description' => 'Memahami dan menghayati arti dan tujuan perubahan (inovasi) madrasah.',
                            'expected_evidence' => 'Adanya bukti perubahan madrasah yang lebih baik dari tahun ke tahun. Bukti fisik: Melalui studi dokumen program pengembangan kewirausahaan.',
                            'evidence' => [
                                'Dokumen Program Pengembangan Kewirausahaan Madrasah',
                                'Deskripsi target perubahan madrasah dari tahun ke tahun',
                            ],
                        ],
                        [
                            'description' => 'Menggunakan metode, teknik dan proses perubahan madrasah.',
                            'expected_evidence' => 'Adanya bukti strategi dalam perubahan madrasah yang lebih baik. Bukti fisik: Melalui observasi: pemanfaatan hasil inovasi dan kreativitas; membudayakan hasil inovasi dan kreativitas; pengembangan pembudayaan inovasi dan kreativitas.',
                            'evidence' => [
                                'Dokumentasi produk inovasi pembelajaran/manajemen',
                                'Bukti diseminasi gagasan inovatif bagi guru dan siswa',
                            ],
                        ],
                        [
                            'description' => 'Menumbuhkan iklim yang mendorong kebebasan berfikir untuk menciptakan kreativitas dan inovasi.',
                            'expected_evidence' => 'Adanya bukti iklim yang mendorong kebebasan berpikir kreatif dan inovatif. Bukti fisik: Melalui observasi dan studi dokumen: data jenis usaha produktif yang dimiliki; program pengelolaan dan pendayagunaan hasil usaha.',
                            'evidence' => [
                                'Data profil unit usaha produktif madrasah',
                                'Program pemanfaatan hasil usaha untuk madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mendorong warga madrasah untuk melakukan prakarsa/keberanian moral untuk melakukan hal-hal baru.',
                            'expected_evidence' => 'Adanya bukti warga madrasah yang memiliki keberanian untuk melakukan hal-hal baru. Bukti fisik: Melalui observasi dan studi dokumen: data jenis usaha produktif yang dimiliki; program pengelolaan dan pendayagunaan hasil usaha.',
                            'evidence' => [
                                'Dokumentasi karya kreatif/prakarsa baru warga madrasah',
                                'Catatan apresiasi/dukungan kepala madrasah terhadap inisiatif baru',
                            ],
                        ],
                    ],
                ],
                '3.2' => [
                    'name' => 'Bekerja keras untuk mencapai keberhasilan madrasah sebagai organisasi pembelajaran yang efektif',
                    'indicators' => [
                        [
                            'description' => 'Mampu bertindak kreatif dan inovatif dalam melaksanakan pekerjaan melalui cara berfikir dan cara bertindak.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang kreatif dan inovatif dalam melaksanakan pekerjaan melalui cara berfikir dan cara bertindak. Bukti fisik: Melalui observasi dan studi dokumen: RPP yang memuat rencana pembelajaran untuk menumbuhkan keterampilan berpikir dan bertindak kreatif, produktif, kritis, mandiri, kolaboratif, dan komunikatif; hasil kerja dan karya siswa; foto-foto aktivitas pembelajaran siswa.',
                            'evidence' => [
                                'RPP / Modul Ajar pembelajaran kreatif & kolaboratif',
                                'Koleksi portofolio karya mandiri siswa',
                                'Dokumentasi foto aktivitas pembelajaran aktif',
                            ],
                        ],
                        [
                            'description' => 'Mampu memberdayakan potensi madrasah secara optimal kedalam berbagai kegiatan-kegiatan produktif yang menguntungkan madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan pemberdayaan potensi madrasah secara optimal kedalam berbagai kegiatan-kegiatan produktif yang menguntungkan madrasah. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: Rencana Pengembangan Madrasah (RPM); dokumen penanganan permasalahan/kasus; dokumen hasil kegiatan sekolah; dokumen hasil kegiatan pengembangan madrasah.',
                            'evidence' => [
                                'Dokumen Rencana Pengembangan Madrasah (RPM)',
                                'Laporan kegiatan pemanfaatan aset produktif',
                                'Catatan penyelesaian hambatan operasional',
                            ],
                        ],
                        [
                            'description' => 'Mampu menumbuhkan jiwa kewirausahaan (kreatif, inovatif dan produktif) di kalangan warga madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang menumbuhkan jiwa kewirausahaan (kreatif, inovatif dan produktif) di kalangan warga madrasah. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: Rencana Pengembangan Madrasah (RPM); dokumen penanganan permasalahan/kasus; dokumen hasil kegiatan sekolah; dokumen hasil kegiatan pengembangan madrasah.',
                            'evidence' => [
                                'Program bazar / market day / pameran karya siswa',
                                'Dokumentasi penanaman jiwa wirausaha di madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu mencatat ide-ide baru, kemudian mengembangkannya.',
                            'expected_evidence' => 'Adanya bukti kegiatan mencatat ide-ide baru, kemudian mengembangkannya. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen Rencana Pengembangan Madrasah.',
                            'evidence' => [
                                'Buku catatan ide kreatif & gagasan kepala madrasah',
                                'Dokumen Rencana Pengembangan Madrasah (RPM)',
                            ],
                        ],
                    ],
                ],
                '3.3' => [
                    'name' => 'Memiliki motivasi yang kuat untuk sukses dalam melaksanakan tugas pokok dan fungsinya sebagai pemimpin madrasah',
                    'indicators' => [
                        [
                            'description' => 'Bersedia belajar dari orang lain.',
                            'expected_evidence' => 'Adanya bukti kemauan belajar dari orang lain. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: forum komunikasi dengan lembaga pendidikan lain dan orang tua siswa per tingkat kelas/kelas/angkatan; foto-foto kegiatan.',
                            'evidence' => [
                                'Dokumen studi tiru / benchmarking ke madrasah berprestasi',
                                'Dokumentasi forum komunikasi orang tua / paguyuban kelas',
                            ],
                        ],
                        [
                            'description' => 'Ingin selalu melakukan yang terbaik.',
                            'expected_evidence' => 'Adanya bukti keinginan selalu melakukan yang terbaik. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: dokumen/foto pelaksanaan kegiatan; keikutsertaan dalam lomba-lomba pembelajaran/pendidikan maupun manajemen; prestasi dalam lomba guru, tenaga kependidikan dan kepala madrasah.',
                            'evidence' => [
                                'Piagam / sertifikat keikutsertaan lomba guru dan kepala madrasah',
                                'Dokumentasi penghargaan kinerja unggul madrasah',
                            ],
                        ],
                        [
                            'description' => 'Menciptakan perubahan yang kuat.',
                            'expected_evidence' => 'Adanya bukti keinginan untuk melakukan perubahan yang kuat. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: program inovasi madrasah atau Rencana Pengembangan Madrasah (RPM); laporan target yang sudah dicapai.',
                            'evidence' => [
                                'Dokumen target mutu dan program unggulan madrasah',
                                'Laporan capaian target tahunan',
                            ],
                        ],
                    ],
                ],
                '3.4' => [
                    'name' => 'Pantang menyerah dan selalu mencari solusi terbaik dalam menghadapi kendala yang dihadapi madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu melibatkan tokoh agama, masyarakat dan pemerintah dalam memecahkan masalah kelembagaan.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang melibatkan tokoh agama, masyarakat dan pemerintah dalam memecahkan masalah kelembagaan. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: MoU dengan pihak lain; sister school; kemitraan dengan sekolah lain.',
                            'evidence' => [
                                'Naskah MoU kerjasama kemitraan dengan tokoh/pihak luar',
                                'Notula musyawarah penanganan kendala kelembagaan',
                            ],
                        ],
                        [
                            'description' => 'Mampu bersikap obyektif/tidak memihak dalam mengatasi konflik internal madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang menunjukkan sikap obyektif/tidak memihak dalam mengatasi konflik internal madrasah. Bukti fisik: Dokumen kegiatan dan foto.',
                            'evidence' => [
                                'Dokumen mediasi / musyawarah kekeluargaan penanganan kendala internal',
                                'Dokumentasi kegiatan pembinaan kerukunan warga madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu bersikap simpatik/tenggang rasa terhadap orang lain.',
                            'expected_evidence' => 'Adanya bukti sikap simpatik/tenggang rasa terhadap orang lain. Bukti fisik: Melalui studi dokumen kegiatan dan foto.',
                            'evidence' => [
                                'Dokumentasi program bakti sosial / santunan / kepedulian warga madrasah',
                                'Foto-foto kegiatan empati dan kekeluargaan',
                            ],
                        ],
                    ],
                ],
                '3.5' => [
                    'name' => 'Memiliki naluri kewirausahaan dalam mengelola kegiatan produksi/jasa madrasah sebagai sumber pembelajaran peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Mampu merencanakan kegiatan produksi/jasa sesuai dengan potensi madrasah.',
                            'expected_evidence' => 'Dokumen perencanaan kegiatan produksi sesuai potensi madrasah. Bukti fisik: Melalui studi dokumen laporan yang memuat pelaksanaan dan hasil Program Pengembangan Unit Produksi Kewirausahaan.',
                            'evidence' => [
                                'Dokumen perencanaan unit produksi/jasa madrasah',
                                'Proposal analisis potensi usaha madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu membina kegiatan produksi/jasa sesuai dengan prinsip-prinsip pengelolaan yang profesional dan akuntabel.',
                            'expected_evidence' => 'Adanya dokumen pembinaan kegiatan produksi/jasa sesuai dengan prinsip-prinsip pengelolaan yang profesional dan akuntabel. Bukti fisik: Melalui studi dokumen laporan yang memuat pelaksanaan dan hasil Program Pengembangan Unit Produksi Kewirausahaan.',
                            'evidence' => [
                                'Laporan pembukuan keuangan unit produksi/jasa',
                                'Dokumen SOP pengelolaan operasional usaha',
                            ],
                        ],
                        [
                            'description' => 'Mampu melaksanakan pengawasan kegiatan produksi/jasa dan menyusun laporan.',
                            'expected_evidence' => 'Adanya dokumen pelaksanaan pengawasan kegiatan produksi/jasa dan menyusun laporan. Bukti fisik: Melalui wawancara dan studi dokumen: laporan hasil Evaluasi Program Pengembangan Kewirausahaan yang memuat hasil evaluasi; Program Pengembangan Jiwa Kewirausahaan; Program Pengembangan Unit Produksi Kewirausahaan.',
                            'evidence' => [
                                'Laporan evaluasi berkala unit produksi/jasa',
                                'Program tindak lanjut pengembangan wirausaha',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan kegiatan produksi/jasa dan pemasarannya.',
                            'expected_evidence' => 'Adanya dokumen pengembangan kegiatan produksi/jasa dan pemasarannya. Bukti fisik: Melalui wawancara dan studi dokumen: laporan hasil Evaluasi Program Pengembangan Kewirausahaan yang memuat hasil evaluasi; Program Pengembangan Jiwa Kewirausahaan; Program Pengembangan Unit Produksi Kewirausahaan.',
                            'evidence' => [
                                'Dokumentasi produk/jasa yang dipasarkan',
                                'Brosur / media promosi pemasaran produk madrasah',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'D' => [
            'name' => 'Supervisi kepada Guru dan Tenaga Kependidikan',
            'items' => [
                '4.1' => [
                    'name' => 'Menyusun program supervisi akademik dalam rangka peningkatan profesionalisme guru',
                    'indicators' => [
                        [
                            'description' => 'Mengidentifikasi masalah yang guru hadapi dalam pelaksanaan pembelajaran.',
                            'expected_evidence' => 'Terdapat rumusan masalah yang Kepala Madrasah peroleh dari pemantauan perencanaan, pelaksanaan, dan penilaian pembelajaran. Bukti fisik: Melalui studi dokumen: program pengawasan pembelajaran/supervisi pembelajaran; jadwal pelaksanaan supervisi; SK tim supervisor.',
                            'evidence' => [
                                'Dokumen Program Supervisi Pembelajaran Tahunan disahkan Pengawas',
                                'Jadwal pelaksanaan supervisi kelas untuk semua guru',
                                'SK Tim Supervisor Madrasah',
                            ],
                        ],
                        [
                            'description' => 'Mampu merumuskan tujuan yang dilengkapi dengan target pencapaian yang terukur.',
                            'expected_evidence' => 'Terdapat rumusan tujuan supervisi yang dilengkapi dengan target pencapaian yang terukur. Bukti fisik: Melalui studi dokumen: program pengawasan pembelajaran/supervisi pembelajaran; jadwal pelaksanaan supervisi.',
                            'evidence' => [
                                'Target capaian peningkatan kualitas mengajar guru pada dokumen program supervisi',
                                'Rekapitulasi jadwal kunjungan supervisi semester ganjil dan genap',
                            ],
                        ],
                        [
                            'description' => 'Mampu mengembangkan instrumen supervisi.',
                            'expected_evidence' => 'Instrumen yang digunakan relevan dengan target indikator pencapaian tujuan madrasah. Bukti fisik: Melalui studi dokumen instrumen supervisi pembelajaran.',
                            'evidence' => [
                                'Instrumen telaah perangkat pembelajaran / modul ajar',
                                'Instrumen observasi pelaksanaan kegiatan belajar mengajar di kelas',
                                'Instrumen supervisi penilaian hasil belajar',
                            ],
                        ],
                    ],
                ],
                '4.2' => [
                    'name' => 'Melaksanakan supervisi akademik terhadap guru dengan menggunakan pendekatan dan teknik supervisi yang tepat',
                    'indicators' => [
                        [
                            'description' => 'Mengadakan pertemuan awal untuk menjaring data rencana pembelajaran dan menetapkan fokus kegiatan supervisi.',
                            'expected_evidence' => 'Terdapat data hasil pertemuan awal seperti masalah, tujuan, fokus utama supervisi, dan instrumen yang disepakati. Bukti fisik: Melalui wawancara dan studi dokumen program pengawasan pembelajaran/supervisi pembelajaran.',
                            'evidence' => [
                                'Catatan notulen pertemuan awal / pra-observasi supervisi',
                                'Lembar kesepakatan fokus amatan supervisi guru',
                            ],
                        ],
                        [
                            'description' => 'Melaksanakan kegiatan pemantauan pembelajaran dan membuat catatan yang objektif dan selektif sebagai bahan pemecahan masalah supervisi.',
                            'expected_evidence' => 'Dokumen hasil observasi pembelajaran, lengkap, objektif dan selektif serta relevan dengan masalah yang menjadi fokus supervisi. Bukti fisik: Melalui wawancara dan studi dokumen: instrumen supervisi pembelajaran; dokumen laporan hasil supervisi pembelajaran.',
                            'evidence' => [
                                'Instrumen observasi kelas yang telah diisi lengkap oleh kepala madrasah',
                                'Foto pelaksanaan supervisi kunjungan kelas',
                                'Laporan rekapitulasi hasil supervisi pembelajaran',
                            ],
                        ],
                        [
                            'description' => 'Melakukan pertemuan refleksi, menganalisis catatan hasil observasi, dan menyimpulkan hasil observasi.',
                            'expected_evidence' => 'Dokumen catatan pelaksanaan kegiatan, melaksanakan refleksi, himpunan data hasil supervisi, analisis data, penafsiran, penilaian keunggulan dan kelemahan, serta rekomendasi perbaikan. Bukti fisik: Melalui wawancara dan studi dokumen analisis hasil supervisi pembelajaran.',
                            'evidence' => [
                                'Buku catatan konseling pasca-supervisi (refleksi bersama guru)',
                                'Dokumen analisis keunggulan dan kelemahan hasil supervisi guru',
                            ],
                        ],
                        [
                            'description' => 'Bersama guru menyusun rekomendasi tindak lanjut perbaikan dalam bentuk kegiatan analisis butir soal, remedial, dan pengayaan.',
                            'expected_evidence' => 'Data tindak lanjut pelaksanaan supervisi penilaian, bukti analisis butir soal, kegiatan remedial dan pengayaan. Bukti fisik: Melalui wawancara dan studi dokumen: dokumen hasil analisis dan tindak lanjut supervisi pembelajaran; program kegiatan workshop/diklat untuk guru; hasil analisis butir soal; program remedial dan pengayaan.',
                            'evidence' => [
                                'Dokumen rencana tindak lanjut perbaikan penilaian guru',
                                'Bukti analisis butir soal dan program remedial/pengayaan guru',
                                'Rencana workshop/IHT perbaikan mutu guru',
                            ],
                        ],
                    ],
                ],
                '4.3' => [
                    'name' => 'Menilai dan menindaklanjuti kegiatan supervisi akademik dalam rangka peningkatan profesionalisme guru',
                    'indicators' => [
                        [
                            'description' => 'Memfasilitasi guru dalam merencanakan tindak lanjut perbaikan sistem penilaian hasil belajar.',
                            'expected_evidence' => 'Terdapat bukti tindak lanjut perbaikan sistem penilaian hasil belajar. Bukti fisik: Melalui wawancara dan studi dokumen: dokumen hasil analisis dan tindak lanjut supervisi pembelajaran; hasil kegiatan workshop/diklat untuk guru; data dan piagam hasil pelatihan guru.',
                            'evidence' => [
                                'Dokumentasi bimbingan perbaikan kisi-kisi dan instrumen asesmen',
                                'Laporan tindak lanjut penyempurnaan sistem penilaian guru',
                            ],
                        ],
                        [
                            'description' => 'Mengecek ulang keterlaksanaan rekomendasi oleh guru.',
                            'expected_evidence' => 'Dokumen rekomendasi perbaikan sistem penilaian hasil belajar secara berkala. Bukti fisik: Melalui wawancara dan studi dokumen rekomendasi hasil perbaikan sistem penilaian hasil belajar.',
                            'evidence' => [
                                'Lembar monitoring keterlaksanaan rekomendasi supervisi',
                                'Catatan kemajuan perbaikan metode mengajar guru',
                            ],
                        ],
                        [
                            'description' => 'Melaksanakan pembinaan dan pengembangan guru sebagai tindak lanjut kegiatan supervisi.',
                            'expected_evidence' => 'Terdapat bukti berupa laporan tindak lanjut hasil supervisi sebagai dasar pelaksanaan pembinaan guru. Bukti fisik: Laporan tindak lanjut supervisi; program PKB guru; laporan kegiatan pembinaan guru; daftar hadir, notulen, foto kegiatan PKB guru.',
                            'evidence' => [
                                'Laporan pelaksanaan pembinaan guru pasca supervisi',
                                'Surat tugas keikutsertaan guru pada kegiatan PKB / BDK / MOOC',
                            ],
                        ],
                        [
                            'description' => 'Menggunakan data hasil supervisi untuk pemetaan ketercapaian program sebagai dasar perbaikan siklus berikutnya.',
                            'expected_evidence' => 'Dokumen pemetaan ketercapaian program hasil supervisi sebagai dasar perbaikan siklus berikutnya. Bukti fisik: Melalui wawancara dan studi dokumen: dokumen hasil analisis dan tindak lanjut supervisi pembelajaran; program kegiatan workshop/diklat untuk guru.',
                            'evidence' => [
                                'Dokumen pemetaan mutu pedagogik & profesional dewan guru',
                                'Laporan evaluasi komprehensif supervisi madrasah',
                                'Rencana perbaikan siklus supervisi tahun berikutnya',
                            ],
                        ],
                    ],
                ],
            ],
        ],
        'E' => [
            'name' => 'Hasil Kinerja Kepala Madrasah',
            'items' => [
                '5.1' => [
                    'name' => 'Prestasi peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Prestasi akademik peserta didik.',
                            'expected_evidence' => 'Terdapat prestasi akademik peserta didik pada berbagai tingkat. Bukti fisik: Melalui studi piagam dan piala prestasi akademik.',
                        ],
                        [
                            'description' => 'Prestasi non akademik peserta didik.',
                            'expected_evidence' => 'Terdapat prestasi non akademik peserta didik pada berbagai tingkat. Bukti fisik: Melalui studi piagam dan piala prestasi non akademik.',
                        ],
                    ],
                ],
                '5.2' => [
                    'name' => 'Prestasi pendidik dan tenaga kependidikan',
                    'indicators' => [
                        [
                            'description' => 'Prestasi akademik pendidik dan tenaga kependidikan.',
                            'expected_evidence' => 'Terdapat prestasi akademik pendidik dan tenaga kependidikan pada berbagai tingkat. Bukti fisik: Melalui studi piagam dan piala prestasi akademik pendidik dan tenaga kependidikan.',
                        ],
                        [
                            'description' => 'Prestasi non akademik pendidik dan tenaga kependidikan.',
                            'expected_evidence' => 'Terdapat prestasi non akademik pendidik dan tenaga kependidikan pada berbagai tingkat. Bukti fisik: Melalui studi piagam dan piala prestasi non akademik pendidik dan tenaga kependidikan.',
                        ],
                    ],
                ],
                '5.3' => [
                    'name' => 'Prestasi madrasah',
                    'indicators' => [
                        [
                            'description' => 'Kelebihan prestasi akademik dari madrasah/sekolah lainnya.',
                            'expected_evidence' => 'Terdapat bukti keunggulan prestasi akademik madrasah. Bukti fisik: Melalui studi piagam, piala, dan laporan kegiatan lomba akademik yang diikuti.',
                        ],
                        [
                            'description' => 'Kelebihan prestasi non akademik dari madrasah/sekolah lainnya.',
                            'expected_evidence' => 'Terdapat bukti keunggulan prestasi non akademik madrasah. Bukti fisik: Melalui studi piagam, piala, dan laporan kegiatan lomba non akademik yang diikuti.',
                        ],
                    ],
                ],
                '5.4' => [
                    'name' => 'Prestasi kepala madrasah',
                    'indicators' => [
                        [
                            'description' => 'Ijazah yang dimiliki kepala madrasah.',
                            'expected_evidence' => 'Terdapat bukti ijazah kepala madrasah. Bukti fisik: Bukti dokumen ijazah kepala madrasah.',
                        ],
                        [
                            'description' => 'Pendidikan dan pelatihan yang pernah diikuti oleh kepala madrasah.',
                            'expected_evidence' => 'Terdapat bukti keikutsertaan dalam diklat. Bukti fisik: Bukti dokumen sertifikat diklat.',
                        ],
                        [
                            'description' => 'Penguasaan ICT kepala madrasah.',
                            'expected_evidence' => 'Terdapat bukti penguasaan ICT. Bukti fisik: Praktik penggunaan ICT.',
                        ],
                        [
                            'description' => 'Prestasi (akademik maupun non akademik) yang diraih oleh kepala madrasah.',
                            'expected_evidence' => 'Terdapat bukti prestasi kepala madrasah. Bukti fisik: Bukti piagam, medali, piala, SK.',
                        ],
                        [
                            'description' => 'Kegiatan penelitian kependidikan yang telah dilakukan oleh kepala madrasah.',
                            'expected_evidence' => 'Terdapat bukti karya penelitian kependidikan. Bukti fisik: Bukti karya ilmiah hasil penelitian bidang pendidikan.',
                        ],
                        [
                            'description' => 'Kegiatan pelibatan masyarakat (komite madrasah) dalam mendukung program madrasah.',
                            'expected_evidence' => 'Terdapat bukti pelibatan komite madrasah dalam mendukung program madrasah. Bukti fisik: Bukti dokumen pelibatan komite: program kegiatan; laporan kegiatan; notulen rapat-rapat dengan komite madrasah.',
                        ],
                        [
                            'description' => 'Kegiatan kemitraan dengan stakeholder pendidikan dalam meningkatkan kompetensi guru madrasah.',
                            'expected_evidence' => 'Terdapat bukti kerjasama kemitraan untuk peningkatan kompetensi guru madrasah. Bukti fisik: Bukti dokumen program kegiatan, perjanjian kerjasama kemitraan.',
                        ],
                    ],
                ],
            ],
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = now()->year;

        $year = PkkmYear::query()->firstOrCreate(
            ['year' => $currentYear],
            [
                'title' => "Penilaian Kinerja Kepala Madrasah (PKKM) Tahun {$currentYear}",
                'slug' => "pkkm-tahun-{$currentYear}",
                'is_published' => false,
            ],
        );

        $componentSort = 0;

        foreach (self::TEMPLATE as $code => $component) {
            $newComponent = $year->components()->firstOrCreate(
                ['code' => $code],
                [
                    'name' => $component['name'],
                    'sort' => ++$componentSort,
                ],
            );

            $itemSort = 0;

            foreach ($component['items'] as $itemCode => $item) {
                $newItem = $newComponent->items()->firstOrCreate(
                    ['code' => (string) $itemCode],
                    [
                        'name' => $item['name'],
                        'sort' => ++$itemSort,
                    ],
                );

                foreach ($item['indicators'] as $index => $indicator) {
                    $number = $index + 1;

                    $newIndicator = $newItem->indicators()->firstOrCreate(
                        ['number' => (string) $number],
                        [
                            'description' => $indicator['description'],
                            'expected_evidence' => $indicator['expected_evidence'],
                            'sort' => $number,
                        ],
                    );

                    $evidenceLabels = $indicator['evidence'] ?? [];

                    if ($evidenceLabels === [] || $newIndicator->evidence()->exists()) {
                        continue;
                    }

                    foreach ($evidenceLabels as $evidenceIndex => $label) {
                        $newIndicator->evidence()->create([
                            'label' => $label,
                            'type' => EvidenceType::Link,
                            'url' => null,
                            'file_path' => null,
                            'sort' => $evidenceIndex + 1,
                        ]);
                    }
                }
            }
        }
    }
}
