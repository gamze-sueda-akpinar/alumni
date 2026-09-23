<?php

namespace Database\Seeders;

use App\Models\AlumniProfile;
use App\Models\Department;
use App\Models\Event;
use App\Models\Faculty;
use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin Kullanıcısı
        $admin = User::firstOrCreate(
            ['email' => 'admin@alumni.com'],
            [
                'name' => 'Gamze Şüeda Akpınar',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Fakülteler
        $muhendislik = Faculty::firstOrCreate(
            ['name' => 'Mühendislik ve Doğa Bilimleri Fakültesi'],
            ['code' => 'MDBF']
        );

        $iibf = Faculty::firstOrCreate(
            ['name' => 'İktisadi, İdari ve Sosyal Bilimler Fakültesi'],
            ['code' => 'İİSBF']
        );

        // 3. Bölümler
        $ceng = Department::firstOrCreate(
            ['name' => 'Bilgisayar Mühendisliği'],
            ['faculty_id' => $muhendislik->id, 'code' => 'CENG']
        );

        $seng = Department::firstOrCreate(
            ['name' => 'Yazılım Mühendisliği'],
            ['faculty_id' => $muhendislik->id, 'code' => 'SENG']
        );

        $ie = Department::firstOrCreate(
            ['name' => 'Endüstri Mühendisliği'],
            ['faculty_id' => $muhendislik->id, 'code' => 'IE']
        );

        $econ = Department::firstOrCreate(
            ['name' => 'İktisat'],
            ['faculty_id' => $iibf->id, 'code' => 'ECON']
        );

        $ba = Department::firstOrCreate(
            ['name' => 'İşletme'],
            ['faculty_id' => $iibf->id, 'code' => 'BA']
        );

        // 4. Örnek Mezun Kullanıcıları & Profilleri
        $mezun1 = User::firstOrCreate(
            ['email' => 'ahmet.yilmaz@example.com'],
            ['name' => 'Ahmet Yılmaz', 'password' => Hash::make('password123')]
        );
        AlumniProfile::firstOrCreate(
            ['user_id' => $mezun1->id],
            [
                'department_id' => $ceng->id,
                'student_number' => '170102045',
                'graduation_year' => 2021,
                'phone' => '+90 532 111 2233',
                'current_company' => 'Trendyol',
                'current_position' => 'Senior Backend Developer',
                'city' => 'İstanbul',
                'country' => 'Türkiye',
                'linkedin_url' => 'https://linkedin.com/in/ahmetyilmaz',
                'github_url' => 'https://github.com/ahmetyilmaz',
                'bio' => '2021 Bilgisayar Müh. mezunuyum. Go ve PHP tabanlı yüksek trafikli mikroservisler geliştiriyorum.',
                'status' => 'approved',
            ]
        );

        $mezun2 = User::firstOrCreate(
            ['email' => 'elif.kaya@example.com'],
            ['name' => 'Elif Kaya', 'password' => Hash::make('password123')]
        );
        AlumniProfile::firstOrCreate(
            ['user_id' => $mezun2->id],
            [
                'department_id' => $seng->id,
                'student_number' => '190104012',
                'graduation_year' => 2023,
                'phone' => '+90 533 222 3344',
                'current_company' => 'Getir',
                'current_position' => 'Frontend Developer',
                'city' => 'İzmir',
                'country' => 'Türkiye',
                'linkedin_url' => 'https://linkedin.com/in/elifkaya',
                'github_url' => 'https://github.com/elifkaya',
                'bio' => 'React ve React Native ile mobil/web arayüzleri geliştiriyorum.',
                'status' => 'approved',
            ]
        );

        $mezun3 = User::firstOrCreate(
            ['email' => 'zeynep.sahin@example.com'],
            ['name' => 'Zeynep Şahin', 'password' => Hash::make('password123')]
        );
        AlumniProfile::firstOrCreate(
            ['user_id' => $mezun3->id],
            [
                'department_id' => $ba->id,
                'student_number' => '200201088',
                'graduation_year' => 2024,
                'phone' => '+90 535 333 4455',
                'current_company' => 'PwC',
                'current_position' => 'Audit Associate',
                'city' => 'Ankara',
                'country' => 'Türkiye',
                'linkedin_url' => 'https://linkedin.com/in/zeynepsahin',
                'bio' => 'Finans ve denetim alanında kariyerime devam ediyorum.',
                'status' => 'pending', // Onay bekleyen mezun örneği
            ]
        );

        // 5. İş & Staj İlanları
        JobPosting::firstOrCreate(
            ['title' => 'Junior Full-Stack Geliştirici (Laravel / Vue.js)'],
            [
                'user_id' => $admin->id,
                'company_name' => 'TeknoPlus Yazılım',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Full-time',
                'description' => 'Mezun takip ve kurumsal web projelerimizde görev alacak çalışma arkadaşı arıyoruz.',
                'requirements' => 'PHP, Laravel, MySQL ve Tailwind CSS bilgisi olan, yeni mezun adaylar değerlendirilecektir.',
                'application_deadline' => '2026-11-30',
                'is_active' => true,
            ]
        );

        JobPosting::firstOrCreate(
            ['title' => 'Stajyer Veri Analisti (Yaz Dönemi)'],
            [
                'user_id' => $admin->id,
                'company_name' => 'Analytica Insights',
                'location' => 'Uzaktan (Remote)',
                'type' => 'Internship',
                'description' => 'Büyük veri ve iş zekası projelerimizde staj yapacak hevesli öğrenciler ve mezunlar.',
                'requirements' => 'Python veya R, SQL temeli olan adaylar.',
                'application_deadline' => '2026-10-31',
                'is_active' => true,
            ]
        );

        // 6. Etkinlikler
        Event::firstOrCreate(
            ['title' => '2026 Geleneksel Mezunlar Buluşması'],
            [
                'description' => 'Tüm dönem mezunlarımızı kampüsümüzde ağırlamaktan mutluluk duyarız. Kokteyl, networking ve anı tazeleme!',
                'event_date' => '2026-10-15 14:00:00',
                'location' => 'Üniversite Merkez Kampüs - Açık Hava Amfi',
                'is_online' => false,
                'is_active' => true,
            ]
        );

        Event::firstOrCreate(
            ['title' => 'Webinar: Yapay Zeka Çağında Yazılım Kariyeri'],
            [
                'description' => 'Yurt dışında çalışan mezunlarımızın katılımıyla yapay zeka ve kariyer dinamikleri üzerine online panel.',
                'event_date' => '2026-11-20 20:00:00',
                'location' => 'Online (Zoom)',
                'is_online' => true,
                'meeting_link' => 'https://zoom.us/j/1234567890',
                'is_active' => true,
            ]
        );
    }
}
