<?php

namespace Database\Seeders;

use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;

class CompanyProfileSeeder extends Seeder
{
    public function run(): void
    {
        CompanyProfile::updateOrCreate(['name' => 'Yayasan Al Ikhlas'], [
            'summary' => 'Membangun generasi islami yang unggul dan berakhlak mulia.',
            'description' => 'Yayasan Al Ikhlas merupakan lembaga pendidikan islami yang berdedikasi dalam menciptakan generasi yang cerdas, berakhlak, dan berdaya saing. Kami mengintegrasikan ilmu pengetahuan dan nilai-nilai keislaman dengan dukungan tenaga pengajar profesional serta lingkungan belajar yang nyaman dan kondusif.',
            'vision' => 'Menjadi lembaga pendidikan islami yang unggul dalam membentuk generasi berilmu, berakhlak mulia, dan siap menghadapi masa depan.',
            'mission' => "Mengembangkan pendidikan berbasis nilai islami\nMeningkatkan kualitas akademik dan karakter\nMenggali potensi dan kreativitas siswa\nMenyediakan lingkungan belajar yang nyaman",
            'logo' => 'logo.png',
            'address' => 'Jl. Contoh No. 123, Jakarta, Indonesia',
            'phone' => '0812-3456-7890',
            'email' => 'info@alikhlas.sch.id',
            'map_url' => 'https://www.google.com/maps?q=Tangerang&output=embed',
            'is_active' => true,
        ]);
    }
}
