<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mezun Takip Sistemi - Geçici Ana Sayfa</title>
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
                <span class="text-2xl">🎓</span>
                <span class="font-bold text-xl tracking-tight text-indigo-900">Mezun Takip Sistemi</span>
                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-amber-200">
                    Geçici Ana Sayfa
                </span>
            </div>
            <div>
                <a href="/admin" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    Yönetim Paneli (Admin) &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <main class="max-w-5xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center">
        
        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-6">
            <span>✨</span>
            <span>Laravel 11 + Filament v3 ile Güçlendirildi</span>
        </div>

        <h1 class="text-4xl sm:text-5xl font-extrabold text-slate-900 tracking-tight max-w-3xl leading-tight mb-4">
            Mezunlarımızla Geleceğe Güçlü Bir Bağ Kuruyoruz
        </h1>

        <p class="text-lg text-slate-600 max-w-2xl mb-8 leading-relaxed">
            Bu sayfa, sistemin ana portalı tamamlanana kadar hizmet veren geçici ana sayfadır (Temporary Main Page).
            Mezun profilleri, iş fırsatları ve etkinlikler arka planda aktif olarak yönetilmektedir.
        </p>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 justify-center mb-12">
            <a href="/admin" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                Yönetim Paneline Giriş Yap
            </a>
            <a href="/hello/gamze" class="px-6 py-3 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 shadow-sm transition">
                Dinamik Rota (/hello/gamze)
            </a>
            <a href="/sum/15/25" class="px-6 py-3 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 shadow-sm transition">
                Toplama Rotası (/sum/15/25)
            </a>
        </div>

        <!-- System Modules Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-left w-full max-w-4xl">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="text-3xl mb-3">👥</div>
                <h3 class="font-bold text-lg text-slate-900 mb-1">Mezun Profilleri</h3>
                <p class="text-sm text-slate-500">Mezuniyet yılı, bölüm, unvan ve güncel şirket bilgileriyle zenginleştirilmiş mezun rehberi.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="text-3xl mb-3">💼</div>
                <h3 class="font-bold text-lg text-slate-900 mb-1">Kariyer & İlanlar</h3>
                <p class="text-sm text-slate-500">Mezunlar arası iş ve staj fırsatlarını paylaşma, başvuru ve istihdam takibi.</p>
            </div>
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition">
                <div class="text-3xl mb-3">📅</div>
                <h3 class="font-bold text-lg text-slate-900 mb-1">Etkinlikler & Ağ</h3>
                <p class="text-sm text-slate-500">Geleneksel mezun buluşmaları, online paneller, webinar ve kariyer zirveleri.</p>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-6xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi. Tüm hakları saklıdır.</p>
            <div class="flex gap-4">
                <a href="/admin" class="hover:text-indigo-600 transition">Admin Paneli</a>
                <span>&bull;</span>
                <a href="/hello" class="hover:text-indigo-600 transition">/hello</a>
                <span>&bull;</span>
                <a href="/sum/10/20" class="hover:text-indigo-600 transition">/sum</a>
            </div>
        </div>
    </footer>

</body>
</html>
