<?php

namespace Database\Seeders;

use App\Models\Blog;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title' => 'Kegiatan Belajar Mengajar di TK Al Ikhlas',
                'image' => 'blog1.png',
                'description' => 'Kegiatan belajar mengajar di TK Al Ikhlas dilakukan dengan metode yang menyenangkan dan interaktif. Anak-anak diajak belajar melalui permainan edukatif, kegiatan kreatif, dan pembiasaan nilai-nilai islami sejak dini. Lingkungan yang nyaman dan guru yang berpengalaman membuat proses belajar menjadi lebih optimal.',
                'category' => 'Kegiatan',
                'status' => 'published',
            ],
            [
                'title' => 'Pentingnya Pendidikan Islami Sejak Dini',
                'image' => 'blog2.png',
                'description' => 'Pendidikan islami sejak dini sangat penting untuk membentuk karakter dan akhlak anak. Di Yayasan Al Ikhlas, siswa tidak hanya diajarkan ilmu pengetahuan umum, tetapi juga nilai-nilai agama yang menjadi dasar kehidupan. Hal ini diharapkan dapat membentuk generasi yang berakhlak mulia.',
                'category' => 'Edukasi',
                'status' => 'published',
            ],
            [
                'title' => 'Prestasi Siswa SD Al Ikhlas Tahun 2025',
                'image' => 'blog3.png',
                'description' => 'Siswa SD Al Ikhlas berhasil meraih berbagai prestasi di tingkat kota dan provinsi, baik dalam bidang akademik maupun non-akademik. Prestasi ini menjadi bukti bahwa sistem pendidikan yang diterapkan mampu menghasilkan siswa yang unggul dan berdaya saing.',
                'category' => 'Prestasi',
                'status' => 'published',
            ],
            [
                'title' => 'Kegiatan Ekstrakurikuler di SMP Al Ikhlas',
                'image' => 'blog4.png',
                'description' => 'SMP Al Ikhlas menyediakan berbagai kegiatan ekstrakurikuler seperti pramuka, olahraga, dan seni. Kegiatan ini bertujuan untuk mengembangkan minat dan bakat siswa di luar kegiatan akademik serta membentuk karakter yang disiplin dan mandiri.',
                'category' => 'Kegiatan',
                'status' => 'published',
            ],
            [
                'title' => 'Fasilitas Pendidikan yang Nyaman dan Modern',
                'image' => 'blog5.png',
                'description' => 'Yayasan Al Ikhlas menyediakan fasilitas pendidikan yang lengkap dan modern, seperti ruang kelas nyaman, laboratorium, perpustakaan, dan area bermain. Semua fasilitas ini dirancang untuk mendukung proses belajar yang efektif dan menyenangkan bagi siswa.',
                'category' => 'Fasilitas',
                'status' => 'published',
            ],
        ];

        foreach ($data as $item) {
            Blog::updateOrCreate(['title' => $item['title']], $item);
        }
    }
}
