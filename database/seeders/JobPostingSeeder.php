<?php

namespace Database\Seeders;

use App\Models\JobPosting;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Yayıncı kullanıcıları belirle
        $admin = User::where('email', 'admin@alumni.com')->first() ?? User::first();
        $alumnus = User::where('email', 'ahmet.yilmaz@example.com')->first() ?? $admin;

        $postings = [
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'Senior Backend Developer (PHP / Laravel)',
                'company_name' => 'Peak Games',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Full-time',
                'description' => 'Milyonlarca aktif kullanıcıya hizmet veren mikroservis mimarimizin backend geliştirmelerinde yer alacak, yüksek trafikli sistemlerde deneyimli kıdemli yazılımcı arıyoruz.',
                'requirements' => 'En az 4 yıl PHP & Laravel deneyimi, Redis, Docker, RabbitMQ ve MySQL optimizasyonu konusunda yetkinlik.',
                'application_deadline' => '2026-12-15',
                'contact_email' => 'careers@peakgames.net',
                'is_active' => true,
            ],
            [
                'user_id' => $alumnus?->id ?? 1,
                'title' => 'Junior Frontend Developer (Vue.js / Tailwind)',
                'company_name' => 'Trendyol Tech',
                'location' => 'İstanbul (Uzaktan / Remote)',
                'type' => 'Full-time',
                'description' => 'E-ticaret arayüzlerimizin modernizasyonu, web performans optimizasyonu ve bileşen kütüphanesi geliştirmesinde görev alacak yeni mezun ve genç yetenekler arıyoruz.',
                'requirements' => 'Modern JavaScript (ES6+), Vue.js 3 / Nuxt veya React, responsive CSS (Tailwind) ve Git bilgisi.',
                'application_deadline' => '2026-11-20',
                'contact_email' => 'talent@trendyol.com',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'DevOps & Cloud Infrastructure Engineer',
                'company_name' => 'Getir Teknoloji',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Full-time',
                'description' => 'Bulut altyapımızın güvenliği, CI/CD pipeline süreçlerinin otomasyonu ve Kubernetes kümelerinin yönetiminde kritik rol alacak DevOps mühendisi arıyoruz.',
                'requirements' => 'AWS veya GCP deneyimi, Terraform / IaC, Kubernetes, Docker, Helm ve Prometheus / Grafana bilgisi.',
                'application_deadline' => '2026-12-30',
                'contact_email' => 'devops-jobs@getir.com',
                'is_active' => true,
            ],
            [
                'user_id' => $alumnus?->id ?? 1,
                'title' => 'Veri Analitiği ve İş Zekası Uzmanı',
                'company_name' => 'Analytica Insights',
                'location' => 'Ankara (Uzaktan / Remote)',
                'type' => 'Full-time',
                'description' => 'Büyük veri setleri üzerinde analitik modeller kuracak, Power BI ve Tableau gösterge panelleri oluşturacak ekip arkadaşı aramaktayız.',
                'requirements' => 'İleri düzey SQL, Python (Pandas, NumPy), BI araçları (PowerBI/Tableau) ve istatistiksel analiz.',
                'application_deadline' => '2026-11-15',
                'contact_email' => 'hr@analyticainsights.com',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'Yazılım Stajyeri (Yapay Zeka ve Savunma Teknolojileri)',
                'company_name' => 'STM Savunma',
                'location' => 'Ankara (Ofis)',
                'type' => 'Internship',
                'description' => 'Mühendislik fakültesi 3. ve 4. sınıf öğrencileri ile yeni mezunlar için yapay zeka destekli otonom sistemler projesinde staj imkanı.',
                'requirements' => 'Bilgisayar veya Yazılım Mühendisliği öğrencisi/mezunu, temel C++ veya Python bilgisi, veri yapıları ve algoritmalar.',
                'application_deadline' => '2026-10-31',
                'contact_email' => 'staj@stm.com.tr',
                'is_active' => true,
            ],
            [
                'user_id' => $alumnus?->id ?? 1,
                'title' => 'Mobile Application Developer (Flutter & Dart)',
                'company_name' => 'Papara',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Full-time',
                'description' => 'Fintech sektörünün öncüsü Papara mobil uygulamasının yeni nesil kullanıcı deneyimi ve ödeme özellikleri geliştirmesinde yer alacaksınız.',
                'requirements' => 'Flutter/Dart ile en az 2 yıl ticari uygulama geliştirme tecrübesi, Bloc/Provider state management bilgisi.',
                'application_deadline' => '2026-12-01',
                'contact_email' => 'careers@papara.com',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'Part-Time Araştırma Mühendisi (NLP & LLM)',
                'company_name' => 'DeepLab AI Research',
                'location' => 'İzmir (Uzaktan / Remote)',
                'type' => 'Part-time',
                'description' => 'Büyük dil modellerinin yerel dillerde ince ayarı (fine-tuning) ve RAG mimarileri üzerine çalışan Ar-Ge laboratuvarımıza yarı zamanlı araştırmacı arıyoruz.',
                'requirements' => 'PyTorch, Hugging Face ekosistemi, vektör veritabanları (Milvus/Pinecone) ve LangChain deneyimi.',
                'application_deadline' => '2026-11-10',
                'contact_email' => 'research@deeplab.ai',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'Product Manager (B2B SaaS)',
                'company_name' => 'Insider Enterprise',
                'location' => 'İstanbul (Hibrit)',
                'type' => 'Full-time',
                'description' => 'Yapay zeka odaklı müşteri deneyimi platformumuzun ürün yol haritasını yönetecek, mühendislik ve tasarım ekipleriyle koordinasyonu sağlayacak Ürün Yöneticisi arıyoruz.',
                'requirements' => 'SaaS ürün yönetiminde en az 3 yıl deneyim, çevik (Scrum/Agile) metodolojilere hakimiyet, güçlü analitik düşünme yeteneği.',
                'application_deadline' => '2026-11-25',
                'contact_email' => 'jobs@useinsider.com',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'QA Test Automation Engineer',
                'company_name' => 'Hepsiburada Tech',
                'location' => 'İstanbul (Uzaktan / Remote)',
                'type' => 'Full-time',
                'description' => 'Web ve mobil platformlarımız için uçtan uca otomatik test senaryoları yazacak ve test süreçlerini CI/CD boru hattına entegre edecek Test Mühendisi.',
                'requirements' => 'Cypress, Selenium, Postman API testing deneyimi, test otomasyon mimarisi kurulum bilgisi.',
                'application_deadline' => '2026-12-20',
                'contact_email' => 'qa-careers@hepsiburada.com',
                'is_active' => true,
            ],
            [
                'user_id' => $admin?->id ?? 1,
                'title' => 'Sistem Yöneticisi (Linux & Sanallaştırma)',
                'company_name' => 'Turkcell Teknoloji',
                'location' => 'Kocaeli (Ofis)',
                'type' => 'Full-time',
                'description' => 'Kurumsal veri merkezi sunucularının bakım, izleme, yedekleme ve güvenlik operasyonlarını yönetecek sistem uzmanı.',
                'requirements' => 'RHEL/Ubuntu sunucu yönetimi, VMware/KVM, Bash scripting, ağ ve firewall temelleri.',
                'application_deadline' => '2026-10-15',
                'contact_email' => 'ik@turkcell.com.tr',
                'is_active' => false, // Süresi dolmuş/arşivlenmiş ilan örneği
            ],
        ];

        foreach ($postings as $posting) {
            JobPosting::updateOrCreate(
                [
                    'title' => $posting['title'],
                    'company_name' => $posting['company_name'],
                ],
                $posting
            );
        }

        $this->command->info('JobPostingSeeder: Standard curated enterprise postings seeded successfully.');

        // İsteğe bağlı olarak 3 adet dinamik factory kaydı ekle
        JobPosting::factory()->count(3)->create([
            'user_id' => $admin?->id ?? 1,
        ]);

        $this->command->info('JobPostingSeeder: Total job postings in database: ' . JobPosting::count());
    }
}
