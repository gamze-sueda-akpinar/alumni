<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Standart Resmi Duyurular
        $officialAnnouncements = [
            [
                'title' => '2026 Yıllık Mezunlar Zirvesi ve Kariyer Fuarı',
                'content' => 'Üniversitemizin geleneksel mezunlar zirvesi bu yıl 25 Kasım tarihinde ana kampüs kongre merkezinde gerçekleştirilecektir. Sektör liderleriyle paneller ve mezun buluşmaları sizleri bekliyor.',
                'category' => 'Etkinlik',
                'author' => 'Mezunlar İlişkileri Koordinatörlüğü',
                'target_audience' => 'Tüm Mezunlar',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => '2026-10-01 10:00:00',
            ],
            [
                'title' => 'Global Teknoloji Şirketleri Mentorluk Programı Başvuruları Başladı',
                'content' => 'Google, Trendyol ve Microsoft bünyesinde çalışan kıdemli mezunlarımızın, yeni mezun ve son sınıf öğrencilerimize rehberlik edeceği 6 aylık kariyer mentorluk programı başvuruları açıldı.',
                'category' => 'Kariyer',
                'author' => 'Kariyer Geliştirme Merkezi',
                'target_audience' => 'Mühendislik ve İİBF Mezunları',
                'is_pinned' => true,
                'status' => 'published',
                'published_at' => '2026-10-05 14:00:00',
            ],
            [
                'title' => 'Yurt Dışı Yüksek Lisans ve Araştırma Bursu Başvuru Rehberi',
                'content' => 'Avrupa ve Amerika\'daki anlaşmalı üniversitelerimizle mezunlarımıza özel sağlanan tam kapsamlı araştırma bursları ve son başvuru tarihleri portalımıza eklendi.',
                'category' => 'Burs & Akademi',
                'author' => 'Uluslararası İlişkiler Ofisi',
                'target_audience' => 'Lisansüstü Adayları',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => '2026-10-08 11:00:00',
            ],
            [
                'title' => '2026-2027 Mezun Kartı Yenileme ve Kampüs Giriş Hakları',
                'content' => 'Yeni dönemde kütüphane, spor salonu ve teknokent olanaklarından indirimli yararlanabilmeniz için dijital mezun kartlarınızı mobil uygulama üzerinden aktive edebilirsiniz.',
                'category' => 'Genel',
                'author' => 'Öğrenci ve Mezun İşleri',
                'target_audience' => 'Tüm Mezunlar',
                'is_pinned' => false,
                'status' => 'published',
                'published_at' => '2026-10-10 09:00:00',
            ],
        ];

        foreach ($officialAnnouncements as $item) {
            Announcement::firstOrCreate(
                ['title' => $item['title']],
                $item
            );
        }

        // 2. Factory ile Ekstra Örnek Duyurular Üretme
        Announcement::factory()->count(5)->create();
    }
}
