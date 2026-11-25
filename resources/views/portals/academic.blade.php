<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akademisyen Portalı &bull; İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <meta name="description" content="İstanbul Üniversitesi Akademisyen Portalı - Etkinlik ve panel oluşturma, mezun istatistikleri ve akademik duyurular.">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: { 50: '#FDFBF7', 100: '#FAF6EF', 200: '#F4ECE0', 300: '#EADFCF' },
                        forest: { 900: '#062B21', 800: '#0B382C', 700: '#114D3D', 600: '#1A6753' },
                        sticker: { yellow: '#FFDE37', green: '#8ED462', coral: '#FF5C38', sky: '#C2E2FA' },
                        ink: { black: '#121214', charcoal: '#282726', muted: '#63615E' }
                    },
                    fontFamily: {
                        serif: ['"Fraunces"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF6EF; color: #121214; }
        .font-editorial { font-family: 'Fraunces', Georgia, serif; }
        .retro-card { background-color: #FFFFFF; border: 2px solid #121214; box-shadow: 4px 4px 0px #121214; transition: all 0.2s; }
        .retro-card:hover { transform: translate(-1px, -1px); box-shadow: 6px 6px 0px #121214; }
        .retro-btn { border: 2px solid #121214; box-shadow: 3px 3px 0px #121214; transition: all 0.15s; }
        .retro-btn:hover { transform: translate(-1px, -1px); box-shadow: 5px 5px 0px #121214; }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-sticker-yellow selection:text-ink-black">

    <!-- Top Status Ribbon -->
    <div class="bg-forest-900 text-sticker-yellow py-2 px-4 border-b-2 border-black text-xs font-mono tracking-wide text-center flex items-center justify-between">
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ • AKADEMİK PERSONEL &amp; MEZUN İLİŞKİLERİ PORTALI ★</span>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-sticker-green animate-pulse"></span>
            <span>Akademik Yetki Devrede</span>
        </div>
    </div>

    <!-- Header Navigation Bar -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 pb-4 w-full">
        <div class="bg-white border-2 border-ink-black rounded-full px-5 py-3 shadow-[4px_4px_0px_#121214] flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <a href="/main" class="w-11 h-11 rounded-full bg-white border-2 border-ink-black flex items-center justify-center p-0.5 shadow-[2px_2px_0px_#121214] overflow-hidden">
                    <img src="/istanbul_university_logo.svg" alt="İÜ Logo" class="w-full h-full object-contain">
                </a>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-editorial text-lg sm:text-xl font-bold tracking-tight text-ink-black block leading-none">
                            Akademisyen Portalı
                        </span>
                        <span class="bg-sticker-sky text-ink-black font-mono text-[10px] font-bold px-2 py-0.5 rounded-full border border-ink-black">
                            AKADEMİSYEN
                        </span>
                    </div>
                    <span class="text-[11px] font-mono text-ink-muted block mt-0.5">
                        {{ $user->name ?? 'Prof. Dr. Ahmet Yılmaz' }} &bull; {{ $department->name ?? 'Bilgisayar Mühendisliği' }}
                    </span>
                </div>
            </div>

            <!-- Dynamic Navigation Links -->
            <nav class="hidden md:flex items-center gap-2 text-xs font-bold">
                <a href="/main" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Ana Sayfa</a>
                <a href="/academic/dashboard" class="px-3.5 py-1.5 rounded-full bg-cream-200 text-ink-black border border-ink-black/20 font-bold transition">Portalım</a>
                <a href="/announcements" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Etkinlikler &amp; Paneller</a>
                <a href="#create-event-section" class="px-3.5 py-1.5 rounded-full bg-forest-800 text-sticker-yellow border border-ink-black hover:bg-forest-900 transition flex items-center gap-1 font-bold shadow-[2px_2px_0px_#121214]">
                    <span>➕ Etkinlik Oluştur</span>
                </a>
                <a href="/users" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Mezun Veritabanı</a>
            </nav>

            <div class="flex items-center gap-2">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="retro-btn px-4 py-1.5 bg-sticker-coral text-white text-xs font-bold rounded-full">
                        Çıkış Yap
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 w-full flex-1">

        <!-- Welcome Banner -->
        <div class="retro-card p-6 sm:p-8 rounded-3xl bg-forest-900 text-white mb-8 border-2 border-black flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-sticker-sky text-ink-black flex items-center justify-center text-3xl font-extrabold shadow-[3px_3px_0px_#fff]">
                    🏛️
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="font-editorial text-2xl sm:text-3xl font-bold text-white">
                            {{ $user->name ?? 'Prof. Dr. Ahmet Yılmaz' }}
                        </h1>
                        <span class="bg-sticker-yellow text-ink-black font-mono font-bold text-xs px-2.5 py-0.5 rounded-full">
                            Bölüm Başkanı
                        </span>
                    </div>
                    <p class="text-xs text-cream-200 mt-1 font-mono">
                        {{ $department->name ?? 'Bilgisayar Mühendisliği Bölümü' }} &bull; Mezun Ağı &amp; Etkinlik Koordinasyonu
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="#create-event-section" class="retro-btn px-5 py-2.5 bg-sticker-yellow text-ink-black font-bold text-xs rounded-full flex items-center gap-2 shadow-[2px_2px_0px_#fff]">
                    <span>+ Yeni Panel / Buluşma Yayınla</span>
                </a>
            </div>
        </div>

        <!-- KPI Metrics -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Düzenlenen Etkinlikler</span>
                <span class="font-editorial text-2xl font-extrabold text-ink-black">4</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-sticker-yellow/30 border-2 border-ink-black">
                <span class="text-[10px] font-mono uppercase text-ink-charcoal font-bold block">Bölüm Mezunları</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-900">1.420</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">İstihdam Oranı</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-700">%94.2</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Aktif Öğrenci</span>
                <span class="font-editorial text-2xl font-extrabold text-sticker-coral">1.150</span>
            </div>
        </div>

        <!-- SECTION 1: Hosted Events by Academic (Düzenlediğim Etkinlikler & Paneller) -->
        <section class="retro-card p-6 sm:p-8 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black flex items-center gap-2">
                        <span>📅</span>
                        <span>Düzenlediğim Etkinlikler &amp; Mezunlar Paneli</span>
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        Akademik yetkinizle yayınladığınız geleneksel mezuniyet günleri, webinarlar ve seminerler.
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div class="p-4 rounded-2xl bg-cream-50 border border-ink-black flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <span class="font-bold text-sm text-ink-black block">Webinar: Yapay Zeka Çağında Yazılım Kariyeri</span>
                        <span class="text-xs text-ink-muted">Tarih: 20.11.2026 20:00 &bull; Online (Zoom) &bull; Katılımcı: 240+</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-sticker-green text-ink-black font-mono font-bold text-[10px] px-2.5 py-0.5 rounded">
                            AKTİF YAYINDA
                        </span>
                        <a href="https://zoom.us" target="_blank" class="retro-btn px-3 py-1 bg-white text-ink-black font-bold text-[11px] rounded-lg">
                            Toplantı Linki
                        </a>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-cream-50 border border-ink-black flex items-center justify-between flex-wrap gap-3">
                    <div>
                        <span class="font-bold text-sm text-ink-black block">2026 Geleneksel CENG Mezunlar Bahar Buluşması</span>
                        <span class="text-xs text-ink-muted">Tarih: 15.10.2026 14:00 &bull; Merkez Kampüs Açık Hava Amfi</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-sticker-green text-ink-black font-mono font-bold text-[10px] px-2.5 py-0.5 rounded">
                            AKTİF YAYINDA
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: Create New Event Form (Akademisyen Etkinlik Oluşturma) -->
        <section id="create-event-section" class="retro-card p-6 sm:p-8 rounded-3xl bg-white mb-8 border-2 border-forest-900">
            <h2 class="font-editorial text-xl font-bold text-ink-black mb-2 flex items-center gap-2">
                <span>➕</span>
                <span>Yeni Etkinlik &amp; Panel Yayınla</span>
            </h2>
            <p class="text-xs text-ink-muted mb-6">
                Öğrenciler ve mezunlar için yeni bir panel, webinar veya kampüs etkinliği duyurusu oluşturun.
            </p>

            <form onsubmit="event.preventDefault(); alert('ETKİNLİK YAYINLANDI:\nEtkinlik başarıyla oluşturuldu ve duyurulara eklendi.');" class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-ink-black mb-1.5">Etkinlik Başlığı</label>
                        <input type="text" required placeholder="Örn: 2026 Güz Dönemi Yazılım ve Girişimcilik Paneli" class="w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs border-2 border-ink-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-ink-black mb-1.5">Tarih &amp; Saat</label>
                        <input type="datetime-local" required class="w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs border-2 border-ink-black">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-ink-black mb-1.5">Konum / Platform</label>
                        <input type="text" placeholder="Örn: Merkez Kampüs Amfi veya Online Zoom" class="w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs border-2 border-ink-black">
                    </div>
                </div>
                <button type="submit" class="retro-btn px-6 py-2.5 bg-forest-800 text-sticker-yellow font-bold text-xs rounded-full">
                    ✓ Etkinliği Yayınla &amp; Duyur
                </button>
            </form>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-8 border-t-2 border-black text-center text-xs text-cream-300">
        <p>T.C. İstanbul Üniversitesi &bull; Rektörlük &amp; Akademik İşler Koordinatörlüğü &bull; 2026</p>
    </footer>

</body>
</html>
