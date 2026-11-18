<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda | Mezun Takip Sistemi</title>
    <meta name="description" content="Üniversitemizin Mezun Takip Sistemi misyonu, vizyonu, değerleri ve kurumsal mezunlar koordinatörlüğü.">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#eef2ff',
                            100: '#e0e7ff',
                            200: '#c7d2fe',
                            300: '#a5b4fc',
                            400: '#818cf8',
                            500: '#6366f1',
                            600: '#4f46e5',
                            700: '#4338ca',
                            800: '#3730a3',
                            900: '#312e81',
                            950: '#1e1b4b',
                        }
                    },
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        serif: ['"Playfair Display"', 'Georgia', 'serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;0,800;1,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #faf9f6; }
        .font-serif-editorial { font-family: 'Playfair Display', Georgia, serif; }
        .hairline-border { border: 1px solid rgba(226, 232, 240, 0.85); }
    </style>
</head>
<body class="text-slate-800 antialiased selection:bg-brand-500 selection:text-white min-h-screen flex flex-col justify-between">

    <!-- Top Ribbon -->
    <div class="bg-gradient-to-r from-brand-950 via-slate-900 to-indigo-950 text-white text-xs py-2 px-4 text-center font-medium border-b border-indigo-950/60">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 flex-wrap">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#8ed462] text-slate-950 uppercase tracking-wider">Kurumsal Misyon</span>
            <span>Ömür boyu süren akademik ve profesyonel dayanışma ekosistemi.</span>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-brand-600 flex items-center justify-center text-white text-2xl shadow-sm group-hover:scale-105 transition-transform">
                    🎓
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Institutional Alumni Network
                    </span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/70">
                <a href="/main" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Ana Sayfa</a>
                <a href="/users" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Mezunlar</a>
                <a href="/job-postings" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Duyurular</a>
                <a href="/applications" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Başvurular</a>
                <a href="/about" class="text-xs font-bold text-brand-700 bg-white px-4 py-2 rounded-full shadow-sm transition">Hakkımızda</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/admin" class="text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 px-4 py-2.5 rounded-full transition shadow-sm">
                    Yönetim Paneli &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 flex-1 w-full">

        <!-- Hero Header -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-bold text-brand-600 uppercase tracking-widest bg-brand-50 px-3 py-1 rounded-full border border-brand-100">
                Vizyon &bull; Değerler &bull; Dayanışma
            </span>
            <h1 class="font-serif-editorial text-4xl sm:text-5xl font-bold text-slate-900 mt-4 mb-4 leading-tight">
                Diplomadan Sonra Başlayan <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-indigo-800">
                    Ömür Boyu Yol Arkadaşlığı
                </span>
            </h1>
            <p class="text-slate-600 text-sm sm:text-base leading-relaxed">
                Mezun Takip Sistemi, üniversitemizin kuruluşundan bugüne kadar mezun ettiği on binlerce öğrencimizin kariyer başarılarını onurlandırmak, genç kuşaklara mentorluk köprüsü kurmak ve şeffaf kariyer fırsatları üretmek üzere tasarlanmış kurumsal ekosistemdir.
            </p>
        </div>

        <!-- 4 Core Pillars Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-16">
            <!-- Pillar 1 -->
            <div class="bg-white rounded-3xl p-8 hairline-border shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 border border-indigo-100 text-brand-600 flex items-center justify-center text-2xl mb-5">
                    🛡️
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">1. Doğruluk ve Güven (Authenticity)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Sistemdeki her mezun profili, üniversitemizin Öğrenci İşleri Daire Başkanlığı kayıtlarıyla doğrulanır. Sahte profiller ve yanıltıcı unvanlar engellenir; güvenli bir kurumsal ağ oluşturulur.
                </p>
            </div>

            <!-- Pillar 2 -->
            <div class="bg-white rounded-3xl p-8 hairline-border shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-2xl mb-5">
                    💎
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">2. Şeffaflık Garantisi (Transparency)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Kariyer panomuzda yayınlanan tüm iş ve staj ilanlarında taban maaş bilgisi ve net çalışma modeli (Uzaktan, Hibrit, Ofiste) zorunludur. Belirsiz şartlara yer verilmez.
                </p>
            </div>

            <!-- Pillar 3 -->
            <div class="bg-white rounded-3xl p-8 hairline-border shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-2xl mb-5">
                    🤝
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">3. Nesiller Arası Dayanışma (Mentorship)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Kıdemli mezunlarımız, yeni mezunlar ve son sınıf öğrencileri için sektörel tecrübe paylaşımı, CV inceleme ve mülakat simülasyonları gerçekleştirir.
                </p>
            </div>

            <!-- Pillar 4 -->
            <div class="bg-white rounded-3xl p-8 hairline-border shadow-sm">
                <div class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-100 text-purple-600 flex items-center justify-center text-2xl mb-5">
                    ⚡
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">4. Modern &amp; Açık Mimari (Open API)</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Laravel 11, Filament v3, Docker ve OpenAPI 3.0 standartlarıyla inşa edilmiştir. Yüksek erişilebilirlik, gerçek zamanlı loglama ve API entegrasyonu sunar.
                </p>
            </div>
        </div>

        <!-- Metrics Banner -->
        <div class="bg-gradient-to-br from-brand-950 via-slate-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-12 mb-16 hairline-border shadow-xl">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                <div>
                    <div class="font-mono text-3xl sm:text-4xl font-extrabold text-white">14.850+</div>
                    <div class="text-xs text-brand-200 mt-1">Kayıtlı Mezun</div>
                </div>
                <div>
                    <div class="font-mono text-3xl sm:text-4xl font-extrabold text-[#8ed462]">%94.2</div>
                    <div class="text-xs text-brand-200 mt-1">İstihdam Başarısı</div>
                </div>
                <div>
                    <div class="font-mono text-3xl sm:text-4xl font-extrabold text-amber-300">320+</div>
                    <div class="text-xs text-brand-200 mt-1">Kurumsal Partner</div>
                </div>
                <div>
                    <div class="font-mono text-3xl sm:text-4xl font-extrabold text-blue-300">42</div>
                    <div class="text-xs text-brand-200 mt-1">Temsil Edilen Ülke</div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto">
            <h2 class="font-serif-editorial text-2xl sm:text-3xl font-bold text-slate-900 text-center mb-8">
                Sıkça Sorulan Sorular
            </h2>

            <div class="space-y-4 text-xs sm:text-sm">
                <div class="bg-white rounded-2xl p-6 hairline-border shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-2">Mezun profilim ne kadar sürede onaylanır?</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Öğrenci işleri sistemimizdeki diploma numaranız eşleştiğinde onay işlemi anında otomatik olarak tamamlanır. Özel durumlarda koordinatörlük 24 saat içinde inceleme yapar.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 hairline-border shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-2">Şirketim adına iş ilanı yayınlayabilir miyim?</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Evet. Mezunlarımız ve kurumsal partnerlerimiz `Kariyer & İlanlar` modülünden zorunlu taban maaş ve çalışma modeli belirterek anında ilan paylaşabilirler.
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-6 hairline-border shadow-sm">
                    <h4 class="font-bold text-slate-900 mb-2">Verilerim üçüncü taraflarla paylaşılıyor mu?</h4>
                    <p class="text-slate-600 leading-relaxed">
                        Hayır. Kişisel Verilerin Korunması Kanunu (KVKK) uyarınca iletişim bilgileriniz yalnızca onay verdiğiniz mezunlar ve kurum koordinatörleri tarafından görüntülenebilir.
                    </p>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Rektörlük Mezunlar Koordinatörlüğü</p>
            <div class="flex items-center gap-4">
                <a href="/main" class="hover:text-brand-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-brand-600 transition">Mezunlar</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-brand-600 transition">İlanlar</a>
                <span>&bull;</span>
                <a href="/api/swagger" class="hover:text-brand-600 transition">API Belgeleri</a>
            </div>
        </div>
    </footer>

</body>
</html>
