<?php

namespace Database\Seeders;

use App\Models\PkkmYear;
use Illuminate\Database\Seeder;

/**
 * Seeds the complete PKKM instrument (Komponen, Unsur/Tugas Utama, and Indikator Kinerja)
 * based on SK Direktur Jenderal Pendidikan Islam Nomor 1111 Tahun 2019 for the current year.
 * Evidence links/files are filled in through the admin panel.
 */
class PkkmTemplateSeeder extends Seeder
{
    /**
     * @var array<string, array{
     *     name: string,
     *     items: array<string, array{
     *         name: string,
     *         indicators: list<array{description: string, expected_evidence: string}>
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
                        ],
                        [
                            'description' => 'Mampu menempatkan personalia yang sesuai dengan kebutuhan.',
                            'expected_evidence' => 'Dokumen uraian tugas personalia di madrasah. Bukti fisik: Melalui studi dokumen: dokumen penetapan/pengesahan susunan organisasi madrasah; rincian tugas setiap personil pada struktur organisasi madrasah; SOP personalia; sertifikat.',
                        ],
                        [
                            'description' => 'Mampu mengembangkan pedoman dan prosedur kerja organisasi madrasah.',
                            'expected_evidence' => 'Pedoman dan prosedur kerja organisasi madrasah. Bukti fisik: Melalui observasi dokumen SOP madrasah atau Pedoman Sistem Informasi Madrasah.',
                        ],
                    ],
                ],
                '1.2' => [
                    'name' => 'Mengelola perubahan dan pengembangan madrasah menuju organisasi pembelajar yang efektif',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan program baru untuk meningkatkan pencapaian target yang lebih tinggi.',
                            'expected_evidence' => 'Program pengembangan madrasah mengandung target pencapaian pada indikator keunggulan khas satuan pendidikan, kerja sama tim, dan data realisasi target yang meningkat daripada pencapaian sebelumnya. Bukti fisik: Melalui studi dokumen: visi dan misi madrasah; data prestasi madrasah; data hasil UN 3 tahun terakhir; data alumni; RKJM.',
                        ],
                        [
                            'description' => 'Mampu dan terampil dalam membangun tim kerja yang efektif untuk mendapatkan produk kinerja yang lebih unggul.',
                            'expected_evidence' => 'Terdapat struktur organisasi yang dilengkapi dengan distribusi dan deskripsi pembagian tugas. Bukti fisik: Melalui observasi dan studi dokumen: bagan/struktur organisasi; SK; tugas dan fungsi; pedoman monitoring dan evaluasi kerja; pedoman reward dan punishment.',
                        ],
                        [
                            'description' => 'Mampu menerapkan berbagai teknik pembaharuan dalam pengelolaan pembelajaran.',
                            'expected_evidence' => 'Terdapat penerapan strategi pembaharuan dengan strategi yang terprogram. Bukti fisik: Melalui studi dokumen: kurikulum; kalender pendidikan; perangkat pembelajaran; penilaian; peraturan akademik; notulen diskusi evaluasi rutin pembelajaran.',
                        ],
                        [
                            'description' => 'Mampu mengembangkan potensi dan meningkatkan prestasi madrasah.',
                            'expected_evidence' => 'Dokumen bukti perkembangan potensi dan prestasi peserta didik yang meningkat dari waktu ke waktu. Bukti fisik: Melalui studi dokumen: data prestasi madrasah 1 tahun terakhir; data hasil UN 1 tahun terakhir; dokumen akreditasi; program ekstrakurikuler; program unggulan madrasah.',
                        ],
                    ],
                ],
                '1.3' => [
                    'name' => 'Mengelola hubungan antara madrasah dan masyarakat dalam rangka pencarian dukungan ide, sumber belajar, dan pembiayaan',
                    'indicators' => [
                        [
                            'description' => 'Merencanakan kerjasama dengan lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Data kerjasama dengan lembaga pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: SK komite madrasah; AD/ART komite madrasah; program kerja komite madrasah; laporan kegiatan komite madrasah; dokumen tertulis kerja sama (MoU); foto-foto; sertifikat/plakat kerja sama; laporan kegiatan.',
                        ],
                        [
                            'description' => 'Melakukan pendekatan-pendekatan dalam rangka mendapatkan dukungan dari lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Dokumen program kerjasama dengan pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: program kegiatan kerja sama; foto kegiatan; jadwal kegiatan; laporan kegiatan.',
                        ],
                        [
                            'description' => 'Memanfaatkan dan memelihara hubungan kerjasama dengan lembaga pemerintah, swasta dan masyarakat.',
                            'expected_evidence' => 'Data hasil kerjasama dengan lembaga pemerintah, swasta, dan masyarakat. Bukti fisik: Melalui studi dokumen: laporan kegiatan kerja sama; laporan monitoring/evaluasi kegiatan; dokumentasi foto/video pelaksanaan kerjasama.',
                        ],
                    ],
                ],
                '1.4' => [
                    'name' => 'Mengelola proses pencapaian SNP sesuai dengan arah dan tujuan pendidikan nasional',
                    'indicators' => [
                        [
                            'description' => 'Mengaplikasikan pengembangan kurikulum yang mengacu kepada standar isi.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar isi. Bukti fisik: Melalui studi dokumen: kurikulum; kalender pendidikan; perangkat pembelajaran; pedoman penilaian; peraturan akademik; buku kerja guru; dokumen rapat penyusunan kurikulum (daftar hadir, daftar peserta, foto).',
                        ],
                        [
                            'description' => 'Mengaplikasikan pengembangan proses pembelajaran yang mengacu kepada standar proses.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar proses. Bukti fisik: Melalui studi dokumen: dokumen pengembangan silabus; RPP; struktur kurikulum; pembagian jam mengajar; jadwal mengajar; RPE; buku teks; jurnal mengajar guru; data siswa per kelas; dokumen supervisi (laporan pemantauan pembelajaran, laporan supervisi, laporan evaluasi pembelajaran dan rencana tindak lanjut).',
                        ],
                        [
                            'description' => 'Mengaplikasikan sistem penilaian pembelajaran yang mengacu kepada standar penilaian.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar penilaian. Bukti fisik: Melalui studi dokumen: instrumen penilaian; kisi-kisi soal; kumpulan naskah soal; analisis butir soal; dokumen analisis hasil belajar siswa; laporan hasil belajar siswa; tindak lanjut hasil penilaian; dokumen pelaksanaan PAS; dokumen pelaksanaan PAT.',
                        ],
                        [
                            'description' => 'Melaksanakan penjaminan mutu pencapaian standar kompetensi lulusan.',
                            'expected_evidence' => 'Dokumen analisis SNP dalam hal standar kompetensi lulusan. Bukti fisik: Melalui studi dokumen: dokumen program kegiatan kesiswaan; laporan kegiatan kesiswaan; dokumentasi kegiatan kesiswaan; laporan kegiatan pembiasaan siswa; dokumen kegiatan literasi; data rata-rata hasil ujian 2 tahun terakhir; data prestasi akademik 2 tahun terakhir; data prestasi non akademik 2 tahun terakhir.',
                        ],
                    ],
                ],
                '1.5' => [
                    'name' => 'Mengelola unit layanan khusus madrasah dalam mendukung kegiatan pembelajaran dan kegiatan peserta didik di madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola laboratorium madrasah agar dapat dimanfaatkan secara optimal untuk kepentingan pembelajaran peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan laboratorium dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: luas sesuai standar; sarana pendukung laboratorium; jurnal dan laporan pengelolaan laboratorium; program kerja lab.',
                        ],
                        [
                            'description' => 'Mampu mengelola perpustakaan madrasah dalam menyiapkan sumber belajar yang diperlukan oleh peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan perpustakaan dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: luas sesuai standar; sarana pendukung; daftar buku induk perpustakaan; laporan pengelolaan perpustakaan; program kerja perpustakaan.',
                        ],
                        [
                            'description' => 'Mampu mengelola usaha madrasah untuk pembelajaran peserta didik dan pemasukan tambahan dana bagi madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan usaha madrasah dalam pembelajaran. Bukti fisik: Melalui studi dokumen: data/laporan kegiatan usaha madrasah; dokumentasi kegiatan (foto/video).',
                        ],
                        [
                            'description' => 'Mampu mengelola koperasi madrasah baik sebagai media praktik maupun sebagai sumber belajar bagi peserta didik.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan koperasi dalam pembelajaran, jadwal, kegiatan, dll. Bukti fisik: Observasi dan studi dokumen: instrumen hasil praktek pembelajaran; foto kegiatan praktik; AD/ART koperasi; laporan RAT.',
                        ],
                    ],
                ],
                '1.6' => [
                    'name' => 'Mengelola sistem informasi madrasah dalam mendukung penyusunan program dan pengambilan keputusan',
                    'indicators' => [
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam manajemen madrasah.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam manajemen madrasah. Bukti fisik: Observasi, studi dokumen dan wawancara: fasilitas teknologi dan informasi; sumber daya informasi; website madrasah; pedoman Sistem Informasi Madrasah.',
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam pembelajaran, baik sebagai sumber belajar maupun sebagai alat/media pembelajaran.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi sebagai sumber belajar dan media pembelajaran. Bukti fisik: Observasi lingkungan madrasah dan wawancara: ketersediaan komputer; jaringan internet; website madrasah; alamat email madrasah; pemanfaatan TIK untuk pembelajaran.',
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam menjalin kerjasama dengan pihak lain.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam menjalin kerjasama dengan pihak lain. Bukti fisik: Observasi lingkungan madrasah, wawancara dan studi dokumen: pengelolaan SIM; fasilitas SIM; surat tugas pengelola SIM; pelaporan data dan informasi.',
                        ],
                        [
                            'description' => 'Memanfaatkan teknologi informasi dan komunikasi dalam promosi program madrasah dan prestasi yang telah dicapai.',
                            'expected_evidence' => 'Adanya bukti pemanfaatan teknologi informasi dan komunikasi dalam promosi program madrasah dan prestasi yang telah dicapai. Bukti fisik: Observasi lingkungan madrasah, wawancara dan studi dokumen: pengelolaan SIM; fasilitas SIM; surat tugas pengelola SIM; pelaporan data dan informasi.',
                        ],
                    ],
                ],
                '1.7' => [
                    'name' => 'Memanfaatkan kemajuan teknologi informasi bagi peningkatan pembelajaran dan manajemen madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengembangkan sistem administrasi pengelolaan secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Terdapat penerapan TIK (berbasis komputer, CD, jejaring intranet, internet) dalam pengelolaan administrasi persuratan, sarana prasarana, kepegawaian, kepesertadidikan, dan keuangan. Bukti fisik: Observasi lingkungan madrasah dan wawancara: jumlah komputer dan LCD yang cukup; memiliki jaringan internet; memiliki web sekolah; memiliki e-mail madrasah; laporan absensi elektronik; dokumen lain pemanfaatan TIK untuk administrasi madrasah.',
                        ],
                        [
                            'description' => 'Mengelola administrasi pembelajaran secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Model penerapan TIK dalam pengelolaan administrasi kurikulum dan pembelajaran, misalnya pengelolaan kurikulum berbasis komputer, intranet, dan internet. Bukti fisik: Observasi lingkungan madrasah dan wawancara: jumlah komputer dan LCD yang cukup; memiliki jaringan internet; pemanfaatan TIK untuk pembelajaran (Edmodo, Google Classroom, dll); pengelolaan penilaian berbasis TIK.',
                        ],
                        [
                            'description' => 'Mampu mengembangkan sistem pengelolaan perpustakaan secara efektif dengan dukungan penerapan teknologi informasi dan komunikasi.',
                            'expected_evidence' => 'Model pemanfaatan TIK dalam sistem pengelolaan perpustakaan berbasis komputer, intranet, atau internet. Bukti fisik: Observasi lingkungan madrasah dan studi dokumen: katalog digital; BSE; akses internet; komputer; dokumen aplikasi layanan perpustakaan.',
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
                        ],
                        [
                            'description' => 'Mampu merumuskan visi-misi sebagai arah pengembangan program RKJM, RKT/RKAS dan program lainnya.',
                            'expected_evidence' => 'Visi-misi madrasah merupakan rumusan hasil keputusan bersama. Bukti fisik: Melalui studi dokumen: visi, misi yang telah ditetapkan oleh Kamad; berita acara dan daftar hadir kegiatan perumusan/peninjauan kembali dan penetapan visi dan misi.',
                        ],
                        [
                            'description' => 'Mampu menentukan strategi pencapaian tujuan madrasah, dilengkapi dengan indikator pencapaian yang terukur.',
                            'expected_evidence' => 'Dokumen program yang memuat strategi pencapaian tujuan madrasah. Bukti fisik: Melalui studi dokumen: program kerja; RKJM dan RKTM.',
                        ],
                        [
                            'description' => 'Mampu menyusun program dengan rencana evaluasi keterlaksanaan dan pencapaian program.',
                            'expected_evidence' => 'Dokumen rencana evaluasi keterlaksanaan dan pencapaian program. Bukti fisik: Melalui studi dokumen RKJM dan RKTM.',
                        ],
                    ],
                ],
                '2.2' => [
                    'name' => 'Memimpin madrasah dalam rangka pendayagunaan sumber daya madrasah secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu memberi contoh berdisiplin; hadir tepat waktu, disiplin menggunakan waktu, dan tepat waktu mengakhiri pekerjaan.',
                            'expected_evidence' => 'Dokumen daftar hadir semua kegiatan madrasah. Bukti fisik: Observasi, wawancara dan studi dokumen: daftar hadir elektronik kamad; daftar hadir pada kegiatan di madrasah.',
                        ],
                        [
                            'description' => 'Mampu melaksanakan peraturan sesuai dengan ketentuan yang berlaku.',
                            'expected_evidence' => 'Menjadi contoh dan mengarahkan guru, staf administrasi, dan peserta didik melaksanakan kegiatan sesuai dengan peraturan. Bukti fisik: Wawancara dengan warga madrasah; laporan kehadiran; notulen rapat/briefing pengarahan kegiatan.',
                        ],
                        [
                            'description' => 'Mampu menunjukkan keteladanan dalam memanfaatkan sumber daya secara efektif dan efisien.',
                            'expected_evidence' => 'Memecahkan masalah madrasah secara bersama-sama, merencanakan pemanfaatan sumber belajar dan sumber informasi, memantau penggunaan sumber daya, dan menilai pemanfaatan sumber daya. Bukti fisik: Wawancara dengan warga madrasah; dokumen monitoring dan evaluasi pemanfaatan sumber belajar; notulensi rapat/diskusi pemanfaatan sumber belajar.',
                        ],
                        [
                            'description' => 'Mampu menunjukkan kedisiplinan sebagai insan pembelajar.',
                            'expected_evidence' => 'Rajin membaca dan pendengar yang baik, mengekspresikan pikiran secara tertulis, mengkomunikasikan ilmu pengetahuan baru, dan menyediakan berbagai media untuk mengembangkan gagasan warga madrasah. Bukti fisik: Wawancara, observasi: koleksi buku referensi/ilmu pengetahuan; karya tulis yang diterbitkan atau tidak; majalah/koran madrasah; website madrasah; blog pribadi.',
                        ],
                    ],
                ],
                '2.3' => [
                    'name' => 'Menciptakan budaya dan iklim madrasah yang kondusif dan inovatif bagi pembelajaran peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Mampu menjadi contoh dan berbudaya mutu yang kompetitif dalam mendorong peningkatan prestasi akademik dan non akademik peserta didik.',
                            'expected_evidence' => 'Dokumen peningkatan KKM, target hasil ulangan, hasil UN dan target keunggulan non akademik peserta didik yang terprogram, terlaksana, dan meningkat hasilnya. Bukti fisik: Wawancara dan studi dokumen: peningkatan KKM; hasil UN; program keunggulan dan inovasi baik akademik maupun non akademik; data prestasi akademik dan non akademik.',
                        ],
                        [
                            'description' => 'Mampu melengkapi sarana dan prasarana untuk menciptakan suasana belajar kondusif dan inovatif bagi peserta didik.',
                            'expected_evidence' => 'Suasana lingkungan madrasah yang asri, bersih, rindang, aman, dan menyenangkan peserta didik. Bukti fisik: Observasi lingkungan madrasah: suasana lingkungan yang asri, bersih, rindang, aman, dan menyenangkan peserta didik.',
                        ],
                        [
                            'description' => 'Mampu memfasilitasi kegiatan-kegiatan untuk meningkatkan budaya baca dan budaya tulis peserta didik.',
                            'expected_evidence' => 'Data kunjungan perpustakaan, peminjaman buku oleh peserta didik, pembaharuan buku dan bahan bacaan, ketersediaan sumber belajar berbasis TIK, dan sarana publikasi karya tulis, serta mengembangkan kompetisi karya tulis peserta didik tingkat madrasah. Bukti fisik: Observasi, wawancara dan studi dokumen: rencana dan laporan pelaksanaan kegiatan literasi; dokumen kegiatan pengembangan budaya baca; dokumen/pajangan hasil karya tulis siswa; data kunjungan dan peminjaman buku perpustakaan.',
                        ],
                        [
                            'description' => 'Mampu memfasilitasi kegiatan-kegiatan lomba di bidang akademik dan non akademik bagi peserta didik.',
                            'expected_evidence' => 'Dokumen penyelenggaraan kegiatan kompetisi yang dimulai dari tingkat madrasah, perolehan piagam penghargaan, piala, trofi perlombaan bidang akademik dan non akademik. Bukti fisik: Observasi dan studi dokumen: dokumen penyelenggaraan kegiatan kompetisi yang dimulai dari tingkat madrasah; daftar perolehan piagam, penghargaan, piala, trofi perlombaan di semua jenjang.',
                        ],
                    ],
                ],
                '2.4' => [
                    'name' => 'Mengelola guru dan staf dalam rangka pendayagunaan sumber daya manusia secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu menyusun perencanaan pengembangan pendidik dan tenaga kependidikan.',
                            'expected_evidence' => 'Dokumen program pembinaan pendidik dan tenaga kependidikan di madrasah. Bukti fisik: Studi dokumen dan wawancara: program kerja kepala madrasah; laporan kegiatan workshop/pelatihan kompetensi guru; dokumentasi (foto/video) kegiatan workshop/pelatihan guru.',
                        ],
                        [
                            'description' => 'Mampu melakukan pembinaan berkala untuk meningkatkan mutu SDM madrasah.',
                            'expected_evidence' => 'Dokumen pelaksanaan kegiatan pembinaan guru. Bukti fisik: Studi dokumen dan wawancara: buku/catatan pembinaan guru dan tendik (notulen dan daftar hadir rapat pembinaan); laporan kinerja kepala madrasah.',
                        ],
                        [
                            'description' => 'Memfasilitasi guru dan staf administrasi untuk meningkatkan kegiatan pembinaan kompetensi.',
                            'expected_evidence' => 'Data dukungan Kepala Madrasah dalam memfasilitasi staf administrasi untuk meningkatkan mutu profesi. Bukti fisik: Studi dokumen dan wawancara: buku/catatan pembinaan guru dan tendik (notulen dan daftar hadir rapat pembinaan); laporan kinerja kepala madrasah.',
                        ],
                        [
                            'description' => 'Memantau dan menilai penerapan hasil pelatihan dalam pekerjaan di madrasah.',
                            'expected_evidence' => 'Dokumen program evaluasi pelatihan atau pengembangan profesi pendidik dan tenaga kependidikan. Bukti fisik: Observasi dan studi dokumen: program pelatihan pengembangan profesi guru dan tendik; laporan pelaksanaan pelatihan pengembangan profesi guru dan tendik.',
                        ],
                    ],
                ],
                '2.5' => [
                    'name' => 'Mengelola sarana dan prasarana madrasah dalam rangka pendayagunaan secara optimal',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola fasilitas prasarana, perabot dan sarana madrasah (gedung, bangunan, dan lahan meja, kursi, lemari, peralatan kantor, dan alat kebersihan).',
                            'expected_evidence' => 'Data fasilitas prasarana, perabot, dan sarana madrasah dikelola dengan baik. Bukti fisik: Observasi dan studi dokumen: buku inventaris; buku pemeliharaan sarana dan prasarana.',
                        ],
                        [
                            'description' => 'Mampu mengelola perpustakaan madrasah.',
                            'expected_evidence' => 'Data perpustakaan dikelola dengan baik. Bukti fisik: Observasi fisik dan studi dokumen: buku induk perpustakaan; buku/data/grafik layanan perpustakaan.',
                        ],
                        [
                            'description' => 'Mampu mengelola laboratorium madrasah.',
                            'expected_evidence' => 'Data laboratorium dikelola dengan baik. Bukti fisik: Observasi fisik dan studi dokumen: daftar inventaris laboratorium; buku/jurnal/data/grafik layanan laboratorium.',
                        ],
                        [
                            'description' => 'Mampu mengelola fasilitas penunjang madrasah lainnya (bengkel, toko, koperasi, kebun dsb).',
                            'expected_evidence' => 'Data fasilitas penunjang terkelola dengan baik. Bukti fisik: Observasi fisik, wawancara dan studi dokumen: data fasilitas penunjang wirausaha yang dikelola oleh madrasah.',
                        ],
                    ],
                ],
                '2.6' => [
                    'name' => 'Mengelola peserta didik dalam rangka penerimaan peserta didik baru, penempatan, dan pengembangan kapasitas peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Menyusun perencanaan penerimaan, pengelolaan dan pengembangan kompetensi peserta didik.',
                            'expected_evidence' => 'Dokumen program penerimaan peserta didik baru, kriteria penerimaan peserta didik, data hasil analisis bekal ajar peserta didik awal. Bukti fisik: Studi dokumen: dokumen program penerimaan peserta didik baru; brosur; data hasil analisis kemampuan peserta didik baru; hasil psikotes minat bakat peserta didik baru.',
                        ],
                        [
                            'description' => 'Memiliki program pengembangan potensi diri dan prestasi peserta didik.',
                            'expected_evidence' => 'Dokumen program pengembangan potensi diri dan prestasi peserta didik. Bukti fisik: Observasi dan studi dokumen: program pengembangan diri peserta didik baik akademik maupun non akademik; laporan pengembangan diri peserta didik (akademik dan non akademik).',
                        ],
                        [
                            'description' => 'Memfasilitasi kegiatan-kegiatan untuk meningkatkan pembiasaan melalui penanaman nilai-nilai.',
                            'expected_evidence' => 'Data program kegiatan akademik dan non akademik melalui penanaman nilai-nilai. Bukti fisik: Observasi lingkungan aktivitas siswa, wawancara dan studi dokumen: program kegiatan akademik dan non akademik dan laporan pelaksanaannya; laporan kegiatan pembiasaan diri peserta didik; dokumentasi kegiatan.',
                        ],
                        [
                            'description' => 'Memfasilitasi kegiatan pengembangan diri bagi peserta didik, pendidik, dan tenaga kependidikan lainnya secara optimal.',
                            'expected_evidence' => 'Data keterlaksanaan program pengembangan diri peserta didik, pendidik, dan tenaga kependidikan. Bukti fisik: Observasi lingkungan aktivitas siswa dan guru, wawancara dan studi dokumen: program kegiatan pengembangan diri; dokumentasi kegiatan; data prestasi siswa, guru dan tendik.',
                        ],
                    ],
                ],
                '2.7' => [
                    'name' => 'Mengelola pengembangan kurikulum dan kegiatan pembelajaran sesuai dengan arah dan tujuan pendidikan nasional',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengarahkan secara efektif dalam menerapkan prinsip-prinsip pengembangan KTSP dalam kegiatan IHT, Workshop, Rapat Koordinasi, dan kegiatan MGMP/KKG.',
                            'expected_evidence' => 'Dokumen hasil pengembangan kurikulum yang disusun melalui rapat kerja, IHT, Workshop, Rakor, atau kegiatan MGMP/KKG. Bukti fisik: Studi dokumen: dokumen kurikulum yang berlaku; SK tim pengembang kurikulum; dokumen penyusunan dokumen kurikulum (daftar hadir, berita acara, notulen).',
                        ],
                        [
                            'description' => 'Mampu mengendalikan pelaksanaan KTSP berlandaskan kalender pendidikan, menerbitkan surat keputusan pembagian tugas mengajar, dan menerapkan aturan akademik.',
                            'expected_evidence' => 'Pelaksanaan kurikulum sesuai dengan kalender pendidikan tingkat madrasah, surat keputusan pembagian tugas mengajar, dan aturan akademik. Bukti fisik: Studi dokumen: struktur kurikulum; jadwal pelajaran; daftar hadir guru; peraturan akademik.',
                        ],
                        [
                            'description' => 'Memfasilitasi efektivitas tim kerja guru dalam rangka meningkatkan mutu pembelajaran.',
                            'expected_evidence' => 'Bukti pelaksanaan kerja sama guru pada tingkat satuan pendidikan, antar satuan pendidikan dalam meningkatkan mutu perencanaan, proses, pembelajaran. Bukti fisik: Studi dokumen: program KKG/MGMP di madrasah; laporan pelaksanaan KKG/MGMP; dokumentasi kegiatan (foto/video).',
                        ],
                        [
                            'description' => 'Mampu mengembangkan pelayanan belajar yang inovatif melalui pengembangan perangkat dan sumber belajar yang terbarukan.',
                            'expected_evidence' => 'Bukti penggunaan metode hasil pelatihan paling akhir, memanfaatkan teknologi informasi dan komunikasi, penggunaan alat peraga, teknik evaluasi baru yang menghasilkan produk belajar peserta didik yang dipublikasikan di lingkungan madrasah atau media lain. Bukti fisik: Observasi kelas, studi dokumen, wawancara dengan siswa dan guru: menelaah ragam metode, media dan sumber belajar yang digunakan dalam RPP.',
                        ],
                        [
                            'description' => 'Memfasilitasi peserta didik dalam mengembangkan kolaborasi dan kompetisi bidang akademik dan non akademik.',
                            'expected_evidence' => 'Data kegiatan kolaborasi dan kompetisi peserta didik tingkat madrasah, baik akademik dan non akademik. Bukti fisik: Wawancara dan studi dokumen: program, laporan dan dokumen kegiatan kesiswaan (kegiatan akademik maupun non akademik); data prestasi akademik maupun non akademik.',
                        ],
                    ],
                ],
                '2.8' => [
                    'name' => 'Mengelola keuangan madrasah sesuai dengan prinsip pengelolaan yang akuntabel, transparan, dan efisien',
                    'indicators' => [
                        [
                            'description' => 'Mampu merencanakan kebutuhan keuangan madrasah sesuai dengan rencana pengembangan madrasah, baik jangka pendek maupun jangka panjang.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen: RKJM dan RKTM; rencana anggaran; laporan keuangan; buku kas.',
                        ],
                        [
                            'description' => 'Mampu mengupayakan sumber-sumber keuangan terutama dari luar madrasah dan dari unit usaha madrasah.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen RKJM, RKTM, laporan keuangan.',
                        ],
                        [
                            'description' => 'Mampu mengkoordinasikan pembelanjaan keuangan sesuai dengan peraturan dan perundang-undangan berdasarkan asas prioritas dan efisiensi.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen RKJM, RKTM, laporan keuangan.',
                        ],
                        [
                            'description' => 'Mampu membuat laporan dan evaluasi pengelolaan keuangan madrasah sesuai dengan prinsip efisien, transparan, dan akuntabel.',
                            'expected_evidence' => 'Dokumen RKJM dan RKTM. Bukti fisik: Studi dokumen: RKJM dan RKTM; laporan keuangan; buku kas.',
                        ],
                    ],
                ],
                '2.9' => [
                    'name' => 'Mengelola ketatausahaan madrasah dalam mendukung pencapaian tujuan madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu mengelola administrasi surat masuk dan surat keluar sesuai dengan pedoman persuratan yang berlaku.',
                            'expected_evidence' => 'Adanya bukti dokumen surat masuk dan keluar. Bukti fisik: Melalui studi dokumen surat masuk dan keluar.',
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi madrasah yang meliputi administrasi akademik, kesiswaan, sarana/prasarana, keuangan, dan hubungan madrasah dengan masyarakat.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi madrasah (akademik, kesiswaan, sarana/prasarana, keuangan, dan hubungan madrasah dengan masyarakat).',
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi kearsipan madrasah baik arsip dinamis maupun arsip lainnya.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi madrasah.',
                        ],
                        [
                            'description' => 'Mampu mengelola administrasi akreditasi madrasah sesuai dengan prinsip-prinsip tersedianya dokumen pendukung dan bukti fisik.',
                            'expected_evidence' => 'Adanya bukti dokumen administrasi madrasah. Bukti fisik: Melalui studi dokumen administrasi pemenuhan SNP madrasah.',
                        ],
                    ],
                ],
                '2.10' => [
                    'name' => 'Melakukan monitoring, evaluasi, dan pelaporan pelaksanaan program kegiatan madrasah dengan prosedur yang tepat, serta merencanakan tindak lanjutnya',
                    'indicators' => [
                        [
                            'description' => 'Menyusun standar kinerja program pendidikan yang dapat diukur dan dinilai.',
                            'expected_evidence' => 'Dokumen SKP yang terukur. Bukti fisik: Melalui studi dokumen SKP yang terukur.',
                        ],
                        [
                            'description' => 'Melakukan monitoring dan evaluasi kinerja program pendidikan dengan menggunakan teknik yang sesuai.',
                            'expected_evidence' => 'Dokumen pelaksanaan monitoring dan evaluasi yang sesuai. Bukti fisik: Melalui studi dokumen pelaksanaan monitoring dan evaluasi yang sesuai.',
                        ],
                        [
                            'description' => 'Menyusun laporan sesuai dengan standar pelaporan monitoring dan evaluasi.',
                            'expected_evidence' => 'Dokumen laporan pelaksanaan monitoring dan evaluasi. Bukti fisik: Melalui studi dokumen laporan pelaksanaan monitoring dan evaluasi.',
                        ],
                        [
                            'description' => 'Merumuskan program tindak lanjut berdasarkan hasil evaluasi pelaksanaan program sebelumnya.',
                            'expected_evidence' => 'Dokumen program tindak lanjut berdasarkan hasil monitoring dan evaluasi. Bukti fisik: Melalui studi dokumen program tindak lanjut berdasarkan hasil monitoring dan evaluasi.',
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
                        ],
                        [
                            'description' => 'Menggunakan metode, teknik dan proses perubahan madrasah.',
                            'expected_evidence' => 'Adanya bukti strategi dalam perubahan madrasah yang lebih baik. Bukti fisik: Melalui observasi: pemanfaatan hasil inovasi dan kreativitas; membudayakan hasil inovasi dan kreativitas; pengembangan pembudayaan inovasi dan kreativitas.',
                        ],
                        [
                            'description' => 'Menumbuhkan iklim yang mendorong kebebasan berfikir untuk menciptakan kreativitas dan inovasi.',
                            'expected_evidence' => 'Adanya bukti iklim yang mendorong kebebasan berpikir kreatif dan inovatif. Bukti fisik: Melalui observasi dan studi dokumen: data jenis usaha produktif yang dimiliki; program pengelolaan dan pendayagunaan hasil usaha.',
                        ],
                        [
                            'description' => 'Mendorong warga madrasah untuk melakukan prakarsa/keberanian moral untuk melakukan hal-hal baru.',
                            'expected_evidence' => 'Adanya bukti warga madrasah yang memiliki keberanian untuk melakukan hal-hal baru. Bukti fisik: Melalui observasi dan studi dokumen: data jenis usaha produktif yang dimiliki; program pengelolaan dan pendayagunaan hasil usaha.',
                        ],
                    ],
                ],
                '3.2' => [
                    'name' => 'Bekerja keras untuk mencapai keberhasilan madrasah sebagai organisasi pembelajaran yang efektif',
                    'indicators' => [
                        [
                            'description' => 'Mampu bertindak kreatif dan inovatif dalam melaksanakan pekerjaan melalui cara berfikir dan cara bertindak.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang kreatif dan inovatif dalam melaksanakan pekerjaan melalui cara berfikir dan cara bertindak. Bukti fisik: Melalui observasi dan studi dokumen: RPP yang memuat rencana pembelajaran untuk menumbuhkan keterampilan berpikir dan bertindak kreatif, produktif, kritis, mandiri, kolaboratif, dan komunikatif; hasil kerja dan karya siswa; foto-foto aktivitas pembelajaran siswa.',
                        ],
                        [
                            'description' => 'Mampu memberdayakan potensi madrasah secara optimal kedalam berbagai kegiatan-kegiatan produktif yang menguntungkan madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan pemberdayaan potensi madrasah secara optimal kedalam berbagai kegiatan-kegiatan produktif yang menguntungkan madrasah. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: Rencana Pengembangan Madrasah (RPM); dokumen penanganan permasalahan/kasus; dokumen hasil kegiatan sekolah; dokumen hasil kegiatan pengembangan madrasah.',
                        ],
                        [
                            'description' => 'Mampu menumbuhkan jiwa kewirausahaan (kreatif, inovatif dan produktif) di kalangan warga madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang menumbuhkan jiwa kewirausahaan (kreatif, inovatif dan produktif) di kalangan warga madrasah. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: Rencana Pengembangan Madrasah (RPM); dokumen penanganan permasalahan/kasus; dokumen hasil kegiatan sekolah; dokumen hasil kegiatan pengembangan madrasah.',
                        ],
                        [
                            'description' => 'Mampu mencatat ide-ide baru, kemudian mengembangkannya.',
                            'expected_evidence' => 'Adanya bukti kegiatan mencatat ide-ide baru, kemudian mengembangkannya. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen Rencana Pengembangan Madrasah.',
                        ],
                    ],
                ],
                '3.3' => [
                    'name' => 'Memiliki motivasi yang kuat untuk sukses dalam melaksanakan tugas pokok dan fungsinya sebagai pemimpin madrasah',
                    'indicators' => [
                        [
                            'description' => 'Bersedia belajar dari orang lain.',
                            'expected_evidence' => 'Adanya bukti kemauan belajar dari orang lain. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: forum komunikasi dengan lembaga pendidikan lain dan orang tua siswa per tingkat kelas/kelas/angkatan; foto-foto kegiatan.',
                        ],
                        [
                            'description' => 'Ingin selalu melakukan yang terbaik.',
                            'expected_evidence' => 'Adanya bukti keinginan selalu melakukan yang terbaik. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: dokumen/foto pelaksanaan kegiatan; keikutsertaan dalam lomba-lomba pembelajaran/pendidikan maupun manajemen; prestasi dalam lomba guru, tenaga kependidikan dan kepala madrasah.',
                        ],
                        [
                            'description' => 'Menciptakan perubahan yang kuat.',
                            'expected_evidence' => 'Adanya bukti keinginan untuk melakukan perubahan yang kuat. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: program inovasi madrasah atau Rencana Pengembangan Madrasah (RPM); laporan target yang sudah dicapai.',
                        ],
                    ],
                ],
                '3.4' => [
                    'name' => 'Pantang menyerah dan selalu mencari solusi terbaik dalam menghadapi kendala yang dihadapi madrasah',
                    'indicators' => [
                        [
                            'description' => 'Mampu melibatkan tokoh agama, masyarakat dan pemerintah dalam memecahkan masalah kelembagaan.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang melibatkan tokoh agama, masyarakat dan pemerintah dalam memecahkan masalah kelembagaan. Bukti fisik: Melalui observasi, wawancara, dan studi dokumen: MoU dengan pihak lain; sister school; kemitraan dengan sekolah lain.',
                        ],
                        [
                            'description' => 'Mampu bersikap obyektif/tidak memihak dalam mengatasi konflik internal madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan yang menunjukkan sikap obyektif/tidak memihak dalam mengatasi konflik internal madrasah. Bukti fisik: Dokumen kegiatan dan foto.',
                        ],
                        [
                            'description' => 'Mampu bersikap simpatik/tenggang rasa terhadap orang lain.',
                            'expected_evidence' => 'Adanya bukti sikap simpatik/tenggang rasa terhadap orang lain. Bukti fisik: Melalui studi dokumen kegiatan dan foto.',
                        ],
                    ],
                ],
                '3.5' => [
                    'name' => 'Memiliki naluri kewirausahaan dalam mengelola kegiatan produksi/jasa madrasah sebagai sumber pembelajaran peserta didik',
                    'indicators' => [
                        [
                            'description' => 'Mampu merencanakan kegiatan produksi/jasa sesuai dengan potensi madrasah.',
                            'expected_evidence' => 'Dokumen perencanaan kegiatan produksi sesuai potensi madrasah. Bukti fisik: Melalui studi dokumen laporan yang memuat pelaksanaan dan hasil Program Pengembangan Unit Produksi Kewirausahaan.',
                        ],
                        [
                            'description' => 'Mampu membina kegiatan produksi/jasa sesuai dengan prinsip-prinsip pengelolaan yang profesional dan akuntabel.',
                            'expected_evidence' => 'Adanya dokumen pembinaan kegiatan produksi/jasa sesuai dengan prinsip-prinsip pengelolaan yang profesional dan akuntabel. Bukti fisik: Melalui studi dokumen laporan yang memuat pelaksanaan dan hasil Program Pengembangan Unit Produksi Kewirausahaan.',
                        ],
                        [
                            'description' => 'Mampu mengelola usaha madrasah untuk pembelajaran peserta didik dan pemasukan tambahan dana bagi madrasah.',
                            'expected_evidence' => 'Adanya bukti kegiatan usaha madrasah dalam pembelajaran. Bukti fisik: Melalui studi dokumen data/laporan kegiatan usaha madrasah.',
                        ],
                        [
                            'description' => 'Mampu melaksanakan pengawasan kegiatan produksi/jasa dan menyusun laporan.',
                            'expected_evidence' => 'Adanya dokumen pelaksanaan pengawasan kegiatan produksi/jasa dan menyusun laporan. Bukti fisik: Melalui wawancara dan studi dokumen: laporan hasil Evaluasi Program Pengembangan Kewirausahaan yang memuat hasil evaluasi; Program Pengembangan Jiwa Kewirausahaan; Program Pengembangan Unit Produksi Kewirausahaan.',
                        ],
                        [
                            'description' => 'Mampu mengembangkan kegiatan produksi/jasa dan pemasarannya.',
                            'expected_evidence' => 'Adanya dokumen pengembangan kegiatan produksi/jasa dan pemasarannya. Bukti fisik: Melalui wawancara dan studi dokumen: laporan hasil Evaluasi Program Pengembangan Kewirausahaan yang memuat hasil evaluasi; Program Pengembangan Jiwa Kewirausahaan; Program Pengembangan Unit Produksi Kewirausahaan.',
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
                        ],
                        [
                            'description' => 'Mampu merumuskan tujuan yang dilengkapi dengan target pencapaian yang terukur.',
                            'expected_evidence' => 'Terdapat rumusan tujuan supervisi yang dilengkapi dengan target pencapaian yang terukur. Bukti fisik: Melalui studi dokumen: program pengawasan pembelajaran/supervisi pembelajaran; jadwal pelaksanaan supervisi.',
                        ],
                        [
                            'description' => 'Mampu mengembangkan instrumen supervisi.',
                            'expected_evidence' => 'Instrumen yang digunakan relevan dengan target indikator pencapaian tujuan madrasah. Bukti fisik: Melalui studi dokumen instrumen supervisi pembelajaran.',
                        ],
                    ],
                ],
                '4.2' => [
                    'name' => 'Melaksanakan supervisi akademik terhadap guru dengan menggunakan pendekatan dan teknik supervisi yang tepat',
                    'indicators' => [
                        [
                            'description' => 'Mengadakan pertemuan awal untuk menjaring data rencana pembelajaran dan menetapkan fokus kegiatan supervisi.',
                            'expected_evidence' => 'Terdapat data hasil pertemuan awal seperti masalah, tujuan, fokus utama supervisi, dan instrumen yang disepakati. Bukti fisik: Melalui wawancara dan studi dokumen program pengawasan pembelajaran/supervisi pembelajaran.',
                        ],
                        [
                            'description' => 'Melaksanakan kegiatan pemantauan pembelajaran dan membuat catatan yang objektif dan selektif sebagai bahan pemecahan masalah supervisi.',
                            'expected_evidence' => 'Dokumen hasil observasi pembelajaran, lengkap, objektif dan selektif serta relevan dengan masalah yang menjadi fokus supervisi. Bukti fisik: Melalui wawancara dan studi dokumen: instrumen supervisi pembelajaran; dokumen laporan hasil supervisi pembelajaran.',
                        ],
                        [
                            'description' => 'Melakukan pertemuan refleksi, menganalisis catatan hasil observasi, dan menyimpulkan hasil observasi.',
                            'expected_evidence' => 'Dokumen catatan pelaksanaan kegiatan, melaksanakan refleksi, himpunan data hasil supervisi, analisis data, penafsiran, penilaian keunggulan dan kelemahan, serta rekomendasi perbaikan. Bukti fisik: Melalui wawancara dan studi dokumen analisis hasil supervisi pembelajaran.',
                        ],
                        [
                            'description' => 'Bersama guru menyusun rekomendasi tindak lanjut perbaikan dalam bentuk kegiatan analisis butir soal, remedial, dan pengayaan.',
                            'expected_evidence' => 'Data tindak lanjut pelaksanaan supervisi penilaian, bukti analisis butir soal, kegiatan remedial dan pengayaan. Bukti fisik: Melalui wawancara dan studi dokumen: dokumen hasil analisis dan tindak lanjut supervisi pembelajaran; program kegiatan workshop/diklat untuk guru; hasil analisis butir soal; program remedial dan pengayaan.',
                        ],
                    ],
                ],
                '4.3' => [
                    'name' => 'Menilai dan menindaklanjuti kegiatan supervisi akademik dalam rangka peningkatan profesionalisme guru',
                    'indicators' => [
                        [
                            'description' => 'Memfasilitasi guru dalam merencanakan tindak lanjut perbaikan sistem penilaian hasil belajar.',
                            'expected_evidence' => 'Terdapat bukti tindak lanjut perbaikan sistem penilaian hasil belajar. Bukti fisik: Melalui wawancara dan studi dokumen: dokumen hasil analisis dan tindak lanjut supervisi pembelajaran; hasil kegiatan workshop/diklat untuk guru; data dan piagam hasil pelatihan guru.',
                        ],
                        [
                            'description' => 'Mengecek ulang keterlaksanaan rekomendasi oleh guru.',
                            'expected_evidence' => 'Dokumen rekomendasi perbaikan sistem penilaian hasil belajar secara berkala. Bukti fisik: Melalui wawancara dan studi dokumen rekomendasi hasil perbaikan sistem penilaian hasil belajar.',
                        ],
                        [
                            'description' => 'Melaksanakan pembinaan dan pengembangan guru sebagai tindak lanjut kegiatan supervisi.',
                            'expected_evidence' => 'Terdapat bukti berupa laporan tindak lanjut hasil supervisi sebagai dasar pelaksanaan pembinaan guru. Bukti fisik: Laporan tindak lanjut supervisi; program PKB guru; laporan kegiatan pembinaan guru; daftar hadir, notulen, foto kegiatan PKB guru.',
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

                if ($newItem->indicators()->exists()) {
                    continue;
                }

                foreach ($item['indicators'] as $index => $indicator) {
                    $number = $index + 1;

                    $newItem->indicators()->create([
                        'number' => (string) $number,
                        'description' => $indicator['description'],
                        'expected_evidence' => $indicator['expected_evidence'],
                        'sort' => $number,
                    ]);
                }
            }
        }
    }
}
