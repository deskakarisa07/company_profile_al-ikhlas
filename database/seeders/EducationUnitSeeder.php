<?php

namespace Database\Seeders;

use App\Models\EducationUnit;
use Illuminate\Database\Seeder;

class EducationUnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            ['name' => 'TK Al Ikhlas', 'short_description' => 'Pembelajaran islami menyenangkan untuk anak usia dini.', 'description' => 'Pendidikan anak usia dini dengan pendekatan bermain, kreativitas, dan pembiasaan nilai islami. Mengembangkan dasar pengetahuan serta karakter anak dalam lingkungan belajar yang menyenangkan.', 'image' => 'tk.png', 'sort_order' => 1],
            ['name' => 'SD Al Ikhlas', 'short_description' => 'Pengembangan akademik dan karakter secara seimbang.', 'description' => 'Mengembangkan kemampuan akademik dan karakter siswa secara seimbang. Didukung kegiatan ekstrakurikuler untuk mengasah minat dan bakat siswa.', 'image' => 'sd.png', 'sort_order' => 2],
            ['name' => 'SMP Al Ikhlas', 'short_description' => 'Membentuk generasi unggul dan siap masa depan.', 'description' => 'Fokus pada pengembangan akademik dan non-akademik dengan pendekatan modern dan islami. Dilengkapi program unggulan dan fasilitas untuk mendukung potensi siswa.', 'image' => 'smp.png', 'sort_order' => 3],
        ];

        foreach ($units as $unit) {
            EducationUnit::updateOrCreate(['name' => $unit['name']], $unit + ['status' => 'published']);
        }
    }
}
