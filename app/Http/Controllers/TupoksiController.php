<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TupoksiController extends Controller
{
    /**
     * Menyiapkan dan menampilkan halaman Tugas Pokok dan Fungsi (Tupoksi).
     * Data diambil dari rangkuman Peraturan Wali Kota Bandung Nomor 60 Tahun 2022.
     */
    public function tupoksi()
    {
        $tupoksiUtama = [
            'tugas' => 'Membantu Wali Kota dalam menyelenggarakan Urusan Pemerintahan yang menjadi kewenangan Daerah di bidang komunikasi dan informatika, persandian dan statistik.',
            'fungsi' => [
                'Merumuskan dan menetapkan Renstra, Renja, program kerja dan anggaran serta kinerja Dinas.',
                'Membina dan mengarahkan tugas kepada bawahan.',
                'Merumuskan kebijakan lingkup komunikasi dan informatika, persandian dan statistik.',
                'Menyelenggarakan pengelolaan informasi dan komunikasi publik.',
                'Menyelenggarakan pengelolaan aplikasi informatika.',
                'Menyelenggarakan persandian untuk pengamanan informasi.',
                'Menyelenggarakan statistik sektoral.',
                'Menyelenggarakan administrasi Dinas.',
                'Mengoordinasikan penyusunan laporan kinerja daerah (LKPJ, LPPD, LKIP, dll).',
                'Melaksanakan monitoring dan evaluasi pelaksanaan tugas.',
                'Melaksanakan tugas kedinasan lain yang diberikan oleh Wali Kota.',
            ]
        ];

        // Data Tupoksi untuk setiap Bidang
        // Sumber: Pasal 5, 8, 9, 10, 11, 12
        $bidang = [
            [
                'nama' => 'Sekretariat Dinas',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup kesekretariatan yang meliputi pengelolaan umum dan kepegawaian, pengelolaan keuangan, pengoordinasian penyusunan program, data dan informasi serta pengoordinasian tugas-tugas bidang.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Sekretariat serta mengoordinasikan penyusunan rencana kerja dan anggaran Dinas.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program dan kegiatan lingkup kesekretariatan (pengelolaan umum, kepegawaian, keuangan, program, data, dan informasi).',
                    'Mengoordinasikan perumusan, implementasi dan evaluasi kebijakan lingkup Dinas.',
                    'Mengoordinasikan fasilitasi, pembinaan dan pengendalian tata naskah dinas.',
                    'Mengoordinasikan pengelolaan dokumentasi peraturan, kearsipan, protokol dan hubungan masyarakat.',
                    'Mengkoordinasikan penyusunan rencana kebutuhan formasi dan mutasi pegawai.',
                    'Menyelenggarakan pembinaan Jabatan Fungsional di Lingkungan Dinas.',
                    'Mengoordinasikan penatausahaan Barang Milik Daerah (BMD).',
                    'Mengoordinasikan penatausahaan Keuangan Dinas.',
                    'Mengoordinasikan penyusunan bahan penetapan rencana kerja daerah (RPJPD, RPJMD, RKPD, Renstra dan Renja).',
                    'Mengoordinasikan penyusunan bahan penetapan laporan kinerja daerah (LKPJ, LPPD, IPPD, LKIP).',
                    'Mengoordinasikan pengolahan, penataan dan penyimpanan data dan/atau informasi publik.',
                    'Mengoordinasikan pelayanan informasi publik.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan lingkup sekretariat dan Dinas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
            [
                'nama' => 'Bidang Perencanaan Teknologi Informasi dan Komunikasi',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup perencanaan teknologi informasi dan komunikasi meliputi perencanaan kebijakan, evaluasi, dan pengembangan sumber daya teknologi informasi dan komunikasi.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Bidang Perencanaan TIK.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program dan kegiatan perencanaan TIK (perencanaan kebijakan, evaluasi, dan pengembangan sumber daya TIK).',
                    'Mengoordinasikan perumusan bahan kebijakan lingkup perencanaan TIK.',
                    'Mengoordinasikan perencanaan kebijakan teknologi informasi dan komunikasi.',
                    'Mengoordinasikan evaluasi teknologi informasi dan komunikasi.',
                    'Mengoordinasikan analisis pengembangan sumber daya teknologi informasi dan komunikasi.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan pelaksanaan tugas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
            [
                'nama' => 'Bidang Infrastruktur Teknologi Informasi dan Komunikasi',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup infrastruktur teknologi informasi dan komunikasi meliputi interkoneksi dan jaringan, manajemen perangkat keras teknologi informasi dan komunikasi, infrastruktur teknologi informasi dan komunikasi untuk publik.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Bidang Infrastruktur TIK.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program dan kegiatan infrastruktur TIK (interkoneksi dan jaringan, manajemen perangkat keras, infrastruktur untuk publik).',
                    'Mengoordinasikan perumusan bahan kebijakan lingkup Infrastruktur TIK.',
                    'Mengoordinasikan pengendalian infrastruktur teknologi informasi Komunikasi.',
                    'Mengoordinasikan layanan infrastruktur data center.',
                    'Mengoordinasikan layanan infrastruktur perangkat keras.',
                    'Mengoordinasikan pengelolaan nama domain.',
                    'Mengoordinasikan jaringan infrastruktur teknologi informasi Komunikasi.',
                    'Mengoordinasikan penataan dan penyelenggaraan menara telekomunikasi.',
                    'Mengoordinasikan pengawasan dan pengendalian infrastruktur pasif telekomunikasi.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan pelaksanaan tugas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
            [
                'nama' => 'Bidang Diseminasi Informasi',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup desiminasi informasi meliputi penyuluhan dan pengendalian informasi, keterbukaan informasi publik, dan kemitraan informasi masyarakat.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Bidang Diseminasi Informasi.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program dan kegiatan diseminasi informasi (penyuluhan, pengendalian informasi, keterbukaan informasi publik, kemitraan informasi masyarakat).',
                    'Mengoordinasikan perumusan bahan kebijakan lingkup diseminasi informasi.',
                    'Mengoordinasikan penyediaan informasi penyelenggaraan pemerintahan daerah.',
                    'Mengoordinasikan penyebarluasan informasi penyelenggaraan pemerintahan daerah.',
                    'Mengoordinasikan pelayanan hubungan komunikasi pemerintah daerah dan publik.',
                    'Mengoordinasikan pemberian dukungan pengelolaan komisi informasi daerah.',
                    'Mengoordinasikan pengelolaan informasi dan komunikasi publik.',
                    'Mengoordinasikan penyuluhan informasi penyelenggaraan pemerintahan daerah.',
                    'Mengoordinasikan layanan pengaduan masyarakat dan kegawatdaruratan.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan pelaksanaan tugas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
            [
                'nama' => 'Bidang Aplikasi Informatika, Persandian dan Keamanan Informasi',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup aplikasi informatika, persandian dan keamanan informasi meliputi pengelolaan aplikasi, persandian dan keamanan sistem informasi, dan integrasi sistem informasi.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Bidang Aplikasi Informatika, Persandian dan Keamanan Informasi.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program (pengelolaan aplikasi, persandian, keamanan, dan integrasi sistem informasi).',
                    'Mengoordinasikan perumusan bahan kebijakan.',
                    'Mengoordinasikan pengelolaan, pembangunan dan/atau pengembangan aplikasi.',
                    'Mengoordinasikan perancangan skema integrasi sistem informasi dan komunikasi data.',
                    'Mengoordinasikan penyelenggaraan persandian untuk pengamanan informasi.',
                    'Mengoordinasikan penetapan pola hubungan komunikasi sandi antar Perangkat Daerah.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan pelaksanaan tugas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
            [
                'nama' => 'Bidang Data dan Statistik',
                'tugas' => 'Melaksanakan sebagian tugas Kepala Dinas lingkup data dan statistik meliputi survey dan akuisisi data, pengolahan dan analisa data, publikasi dan data terbuka.',
                'fungsi' => [
                    'Merencanakan program, kegiatan dan kinerja lingkup Bidang Data dan Statistik.',
                    'Membina dan mendistribusikan tugas kepada bawahan.',
                    'Mengoordinasikan pelaksanaan program dan data statistik (survey, akuisisi, pengolahan, analisa, dan publikasi data).',
                    'Mengoordinasikan perumusan bahan kebijakan lingkup data dan statistik.',
                    'Mengoordinasikan penyelenggaraan statistik sektoral.',
                    'Mengoordinasikan manajemen data terbuka di lingkungan Pemerintah Daerah Kota.',
                    'Mengoordinasikan pelaksanaan survei, akuisisi, pengolahan, analisa, serta publikasi data.',
                    'Melaksanakan monitoring, evaluasi dan pelaporan pelaksanaan tugas.',
                    'Melaksanakan tugas kedinasan lain yang diberikan oleh atasan.',
                ]
            ],
        ];

        // Mengirim data ke view yang sesuai
        return view('profile.tupoksi', compact('tupoksiUtama', 'bidang'));
    }
}
