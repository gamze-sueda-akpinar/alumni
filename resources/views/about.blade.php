<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hakkımızda - Mezun Takip Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <a href="/main" class="flex items-center space-x-3">
                    <span class="text-2xl">🎓</span>
                    <span class="font-bold text-xl tracking-tight text-indigo-900">Mezun Takip Sistemi</span>
                </a>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-blue-200">
                    Geçici Hakkımızda Sayfası
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">Ana Sayfa</a>
                <a href="/about" class="text-sm font-semibold text-indigo-600 transition">Hakkımızda</a>
                <a href="/admin" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    Yönetim Paneli &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 py-12 flex-1">
        
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-semibold mb-4">
                <span>ℹ️</span>
                <span>Hakkımızda / About Us</span>
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight mb-4">
                Mezun Takip Sistemi Nedir?
            </h1>
            <p class="text-lg text-slate-600 max-w-2xl mx-auto">
                Bu sayfa, platformun hedeflerini, vizyonunu ve sunduğu imkanları özetleyen geçici hakkında sayfasıdır (Temporary About Page).
            </p>
        </div>

        <!-- Mission & Vision Cards -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <span>🎯</span> Misyonumuz
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    Mezun Takip Sistemi, üniversitemizden mezun olan tüm öğrencilerimizin kariyer basamaklarını yakından izlemek,
                    öğrencilik yıllarında kurulan dostluk ve akademik bağları kalıcı hale getirmek ve mezunlarımız arasında güçlü bir
                    profesyonel dayanışma ağı oluşturmak amacıyla hayata geçirilmiştir.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-2xl font-bold text-slate-900 mb-3 flex items-center gap-2">
                    <span>🚀</span> Neler Sağlıyoruz?
                </h2>
                <ul class="space-y-3 text-slate-600">
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-600 font-bold">✓</span>
                        <span><strong>Kapsamlı Mezun Veritabanı:</strong> Mezuniyet yılı, bölüm ve sektörel dağılım verileriyle güncel mezun haritası.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-600 font-bold">✓</span>
                        <span><strong>Kariyer Fırsatları:</strong> Mezunlarımızın kendi şirketlerindeki açık pozisyonları diğer mezunlarla paylaşabilmesi.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-600 font-bold">✓</span>
                        <span><strong>Networking ve Etkinlikler:</strong> Dönem buluşmaları, online webinarlar ve tecrübe paylaşım panelleri.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="text-indigo-600 font-bold">✓</span>
                        <span><strong>Filament v3 ile Kolay Yönetim:</strong> Bölüm koordinatörleri ve yöneticiler için modern onay ve raporlama mekanizması.</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Back to Home Button -->
        <div class="mt-10 text-center">
            <a href="/main" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl transition shadow-md">
                &larr; Ana Sayfaya Dön
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi. Tüm hakları saklıdır.</p>
            <div class="flex gap-4">
                <a href="/main" class="hover:text-indigo-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/about" class="text-indigo-600 font-medium">Hakkımızda</a>
                <span>&bull;</span>
                <a href="/admin" class="hover:text-indigo-600 transition">Admin Paneli</a>
            </div>
        </div>
    </footer>

</body>
</html>
