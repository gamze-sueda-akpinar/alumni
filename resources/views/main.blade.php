<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İstanbul Üniversitesi | Mezun Takip Sistemi</title>
    <meta name="description" content="Üniversitemizin küresel mezun ağı, doğrulanmış mezun rehberi, kariyer fırsatları, şeffaf iş ilanları ve etkinlik takip portalı.">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: {
                            50: '#FDFBF7',
                            100: '#FAF6EF',
                            200: '#F4ECE0',
                            300: '#EADFCF',
                            400: '#D5C4AF',
                        },
                        forest: {
                            900: '#062B21',
                            800: '#0B382C',
                            700: '#114D3D',
                            600: '#1A6753',
                        },
                        sticker: {
                            yellow: '#FFDE37',
                            green: '#8ED462',
                            coral: '#FF5C38',
                            violet: '#8A53FF',
                            sky: '#C2E2FA',
                            blush: '#FFE9CE',
                        },
                        ink: {
                            black: '#121214',
                            charcoal: '#282726',
                            muted: '#63615E',
                        }
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
    <!-- Google Fonts: Fraunces (Literary Editorial Serif) + Plus Jakarta Sans + JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400..900;1,9..144,400..900&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FAF6EF;
            color: #121214;
        }
        .font-editorial {
            font-family: 'Fraunces', Georgia, serif;
        }
        .retro-card {
            background-color: #FFFDF9;
            border: 2px solid #121214;
            box-shadow: 4px 4px 0px #121214;
            border-radius: 28px;
        }
        .retro-card-sm {
            background-color: #FFFDF9;
            border: 1.5px solid #121214;
            box-shadow: 3px 3px 0px #121214;
            border-radius: 20px;
        }
        .retro-btn {
            border: 2px solid #121214;
            box-shadow: 3px 3px 0px #121214;
            transition: all 0.15s ease;
        }
        .retro-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0px #121214;
        }
        .retro-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #121214;
        }
        .sticker-pill {
            border: 1.5px solid #121214;
            box-shadow: 2px 2px 0px #121214;
            font-weight: 800;
        }
        @keyframes marquee {
            0% { transform: translateX(0%); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            display: flex;
            width: 200%;
            animation: marquee 22s linear infinite;
        }
    </style>
</head>
<body class="selection:bg-sticker-yellow selection:text-ink-black min-h-screen flex flex-col justify-between">

    <!-- 1. TOMO Style Analog Zine Running Marquee Ticker -->
    <div class="bg-sticker-yellow border-b-2 border-ink-black overflow-hidden py-2 text-ink-black select-none">
        <div class="animate-marquee whitespace-nowrap flex items-center gap-6 font-mono text-xs font-bold uppercase tracking-wider">
            <span>★ 2026 MEZUNLAR GÜNÜ BAHAR BULUŞMASI BAŞVURULARI BAŞLADI</span>
            <span>&bull;</span>
            <span>★ ŞEFFAF MAAŞ VE ÇALIŞMA MODELİ GARANTİLİ 480+ AÇIK POZİSYON</span>
            <span>&bull;</span>
            <span>★ 14.850+ DOĞRULANMIŞ AKADEMİK MEZUN PROFİLİ</span>
            <span>&bull;</span>
            <span>★ FABLE &bull; FICTIONAL &bull; SUPERHI &bull; TOMO &bull; MINDMARKET SENTEZİ</span>
            <span>&bull;</span>
            <span>★ DİPLOMADAN SONRA ÖMÜR BOYU DAYANIŞMA VE MENTÖRLÜK AĞI</span>
            <span>&bull;</span>
            <span>★ 2026 MEZUNLAR GÜNÜ BAHAR BULUŞMASI BAŞVURULARI BAŞLADI</span>
            <span>&bull;</span>
            <span>★ ŞEFFAF MAAŞ VE ÇALIŞMA MODELİ GARANTİLİ 480+ AÇIK POZİSYON</span>
        </div>
    </div>

    <!-- 2. Family & Fable Warm Capsule Navigation Bar -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-4 w-full">
        <div class="bg-white border-2 border-ink-black rounded-full px-5 py-3 shadow-[3px_3px_0px_#121214] flex items-center justify-between">
            <!-- Brand Logo Monogram -->
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-white border-2 border-ink-black flex items-center justify-center p-0.5 shadow-[2px_2px_0px_#121214] group-hover:scale-105 transition-transform overflow-hidden">
                    <img src="/istanbul_university_logo.svg" alt="İstanbul Üniversitesi Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <span class="font-editorial text-lg sm:text-xl font-bold tracking-tight text-ink-black block leading-none">
                        İstanbul Üniversitesi
                    </span>
                    <span class="text-[10px] font-mono text-ink-muted uppercase tracking-widest block mt-0.5">
                        Mezun Takip Sistemi &bull; 1453
                    </span>
                </div>
            </a>

            <!-- Nav Links -->
            <nav class="hidden md:flex items-center gap-2 text-xs font-bold">
                <a href="/main" class="px-3.5 py-1.5 rounded-full bg-cream-200 text-ink-black transition">Ana Sayfa</a>
                <a href="/users" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Mezunlar</a>
                <a href="/job-postings" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Duyurular</a>
                <a href="/applications" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Başvurular</a>
                <a href="/about" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Hakkımızda</a>
            </nav>

            <!-- Action Button -->
            <div class="flex items-center gap-2">
                <a href="/users/create" class="retro-btn px-4 py-2 bg-ink-black text-white text-xs font-bold rounded-full flex items-center gap-1.5">
                    <span>Rehbere Katıl</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>
    </header>

    <!-- 3. Hero Section (Fable + Fictional + MindMarket) -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 pb-16 text-center relative w-full flex-1">
        
        <!-- Sticker Decal (Fictional Style) -->
        <div class="inline-block transform -rotate-2 hover:rotate-0 transition-transform mb-4">
            <span class="sticker-pill bg-sticker-yellow text-ink-black px-4 py-1.5 rounded-full text-xs uppercase tracking-wider inline-flex items-center gap-1.5">
                <span class="w-2 h-2 rounded-full bg-ink-black"></span>
                <span>★ Doğrulanmış Üniversite Mezunlar Gazetesi &amp; Portalı ★</span>
            </span>
        </div>

        <!-- Big Literary Serif Headline -->
        <h1 class="font-editorial text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-ink-black leading-[1.05] max-w-5xl mx-auto mb-6">
            Diplomanız bir son değil; <br class="hidden sm:inline">
            <em class="font-serif italic font-normal text-forest-700">ömür boyu süren</em> bir entelektüel <br class="hidden sm:inline">
            ve mesleki dayanışmadır.
        </h1>

        <p class="text-sm sm:text-base text-ink-charcoal max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
            Fakültelerimizden mezun olan binlerce araştırmacıyı, mühendisi ve lideri tek çatı altında buluşturuyoruz. 
            Doğrulanmış profilleri keşfedin, şeffaf maaşlı iş ilanlarına başvurun.
        </p>

        <!-- Tactile Search Box -->
        <div class="max-w-3xl mx-auto retro-card p-4 sm:p-5 mb-12 text-left">
            <div class="flex items-center gap-2 mb-3">
                <span class="sticker-pill bg-sticker-green text-ink-black px-3 py-1 rounded-full text-xs">
                    🔍 Canlı Dizin
                </span>
                <span class="text-xs font-mono text-ink-muted">14.850 kayıt içinden filtreleyin</span>
            </div>
            <form action="/users" method="GET" class="flex flex-col sm:flex-row gap-2.5">
                <input type="text" name="search" placeholder="İsim, unvan, şirket, bölüm (örn: Bilgisayar Mühendisliği)..." 
                       class="flex-1 px-4 py-3 bg-cream-50 border-2 border-ink-black rounded-2xl text-xs sm:text-sm font-medium focus:outline-none focus:bg-white">
                <button type="submit" class="retro-btn px-6 py-3 bg-sticker-yellow text-ink-black font-extrabold rounded-2xl text-xs sm:text-sm flex items-center justify-center gap-2">
                    <span>Arama Yap</span>
                    <span>&rarr;</span>
                </button>
            </form>
            <div class="mt-3 flex items-center gap-2 flex-wrap text-xs">
                <span class="font-bold text-ink-muted">Öne Çıkanlar:</span>
                <a href="/job-postings?type=remote" class="sticker-pill bg-cream-100 hover:bg-sticker-blush px-2.5 py-1 rounded-full transition text-[11px]">🟢 Uzaktan (Remote)</a>
                <a href="/job-postings?type=hybrid" class="sticker-pill bg-cream-100 hover:bg-sticker-blush px-2.5 py-1 rounded-full transition text-[11px]">🟠 Hibrit Pozisyonlar</a>
                <a href="/users?graduation_year=2024" class="sticker-pill bg-cream-100 hover:bg-sticker-blush px-2.5 py-1 rounded-full transition text-[11px]">🎓 2024 Mezunları</a>
                <a href="/users?city=İstanbul" class="sticker-pill bg-cream-100 hover:bg-sticker-blush px-2.5 py-1 rounded-full transition text-[11px]">📍 İstanbul</a>
            </div>
        </div>

        <!-- 4 Storybook Metric Decals -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 max-w-5xl mx-auto mb-16">
            <div class="retro-card-sm p-5 bg-[#FFE9CE] transform -rotate-1 hover:rotate-0 transition-transform">
                <div class="font-editorial text-3xl sm:text-4xl font-bold text-ink-black font-mono">14.850+</div>
                <div class="text-xs font-bold text-ink-charcoal uppercase tracking-wider mt-1">Doğrulanmış Mezun</div>
            </div>
            <div class="retro-card-sm p-5 bg-[#E1EDFF] transform rotate-1 hover:rotate-0 transition-transform">
                <div class="font-editorial text-3xl sm:text-4xl font-bold text-ink-black font-mono">480+</div>
                <div class="text-xs font-bold text-ink-charcoal uppercase tracking-wider mt-1">Açık Kariyer İlanı</div>
            </div>
            <div class="retro-card-sm p-5 bg-[#D5F5C5] transform -rotate-1 hover:rotate-0 transition-transform">
                <div class="font-editorial text-3xl sm:text-4xl font-bold text-ink-black font-mono">%94.2</div>
                <div class="text-xs font-bold text-ink-charcoal uppercase tracking-wider mt-1">İstihdam Başarısı</div>
            </div>
            <div class="retro-card-sm p-5 bg-[#FDE2FF] transform rotate-2 hover:rotate-0 transition-transform">
                <div class="font-editorial text-3xl sm:text-4xl font-bold text-ink-black font-mono">42 Ülke</div>
                <div class="text-xs font-bold text-ink-charcoal uppercase tracking-wider mt-1">Küresel Ağ</div>
            </div>
        </div>

        <!-- Botanical Forest Band (Fable Style) -->
        <div class="bg-forest-800 text-cream-50 rounded-[40px] p-8 sm:p-14 border-2 border-ink-black shadow-[6px_6px_0px_#121214] text-left relative overflow-hidden mb-16">
            <div class="max-w-2xl">
                <span class="sticker-pill bg-sticker-yellow text-ink-black px-3.5 py-1 rounded-full text-xs uppercase tracking-wider inline-block mb-4">
                    Fable &bull; Kurumsal Değerler
                </span>
                <h2 class="font-editorial text-3xl sm:text-5xl font-bold text-white mb-4 leading-tight">
                    Özgür, şeffaf ve <br>
                    <em class="font-serif italic text-sticker-yellow">bağımsız</em> mezun topluluğu.
                </h2>
                <p class="text-xs sm:text-sm text-cream-200 leading-relaxed mb-8">
                    Kariyer ilanlarında net maaş açıklamayı zorunlu kılan, mezun profillerini kurumsal diploma veritabanıyla doğrulayan Türkiye'nin ilk açık akademik mezunlar ağı.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="/users" class="retro-btn px-6 py-3 bg-sticker-yellow text-ink-black font-extrabold text-xs rounded-full inline-block">
                        Rehberi Keşfet &rarr;
                    </a>
                    <a href="/job-postings" class="retro-btn px-6 py-3 bg-white text-ink-black font-extrabold text-xs rounded-full inline-block">
                        Açık Pozisyonları İncele &rarr;
                    </a>
                </div>
            </div>
        </div>

        <!-- Featured Job Cards -->
        <div class="text-left mb-8">
            <span class="sticker-pill bg-sticker-green text-ink-black px-3 py-1 rounded-full text-xs uppercase tracking-wider">
                Kariyer Vitrini
            </span>
            <h2 class="font-editorial text-3xl font-bold text-ink-black mt-2">Güncel Açık Pozisyonlar</h2>
            <p class="text-xs text-ink-muted mt-1">Zorunlu maaş şeffaflığı ve açık çalışma modeli garantisi.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
            <div class="retro-card p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4 flex-wrap">
                        <span class="sticker-pill bg-[#C2E2FA] text-ink-black px-3 py-1 rounded-full text-xs">
                            🟢 UZAKTAN / REMOTE
                        </span>
                        <span class="sticker-pill bg-sticker-green text-ink-black font-mono text-xs px-3 py-1 rounded-full">
                            ₺75.000 / AY NET
                        </span>
                    </div>
                    <h3 class="font-editorial text-2xl font-bold text-ink-black mb-1">
                        Senior Backend Developer (PHP &amp; Laravel)
                    </h3>
                    <p class="text-xs font-bold text-forest-700 mb-3">🏢 Algoritmik Bilişim A.Ş. &bull; 📍 İstanbul / Dağıtık</p>
                    <p class="text-xs text-ink-charcoal leading-relaxed mb-4">
                        Büyük ölçekli mezun ve öğrenci veri yönetimi projemizde mikroservis mimarisini tasarlayacak kıdemli yazılım mühendisi arıyoruz.
                    </p>
                </div>
                <div class="pt-4 border-t-2 border-cream-200 flex items-center justify-between text-xs">
                    <span class="font-mono text-ink-muted">2 gün önce</span>
                    <a href="/job-postings" class="retro-btn px-4 py-2 bg-sticker-yellow text-ink-black font-bold rounded-full text-xs">
                        İncele &amp; Başvur &rarr;
                    </a>
                </div>
            </div>

            <div class="retro-card p-7 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-4 flex-wrap">
                        <span class="sticker-pill bg-[#FFE9CE] text-ink-black px-3 py-1 rounded-full text-xs">
                            🟠 HİBRİT / HYBRID
                        </span>
                        <span class="sticker-pill bg-sticker-green text-ink-black font-mono text-xs px-3 py-1 rounded-full">
                            ₺55.000 / AY NET
                        </span>
                    </div>
                    <h3 class="font-editorial text-2xl font-bold text-ink-black mb-1">
                        Frontend Engineer (Vue.js / Tailwind CSS)
                    </h3>
                    <p class="text-xs font-bold text-forest-700 mb-3">🏢 NextGen FinTech Labs &bull; 📍 Maslak, İstanbul</p>
                    <p class="text-xs text-ink-charcoal leading-relaxed mb-4">
                        Finansal analitik dashboard panellerimizin kullanıcı deneyimini modern web standartlarına taşıyacak arayüz geliştirici arayışımız bulunmaktadır.
                    </p>
                </div>
                <div class="pt-4 border-t-2 border-cream-200 flex items-center justify-between text-xs">
                    <span class="font-mono text-ink-muted">Dün</span>
                    <a href="/job-postings" class="retro-btn px-4 py-2 bg-sticker-yellow text-ink-black font-bold rounded-full text-xs">
                        İncele &amp; Başvur &rarr;
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-12 border-t-2 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-xs text-cream-300">
            <div class="flex items-center justify-center gap-2 mb-2">
                <img src="/istanbul_university_logo.svg" alt="İÜ Logo" class="w-6 h-6 rounded-full bg-white p-0.5 inline-block">
                <p class="font-editorial text-lg text-sticker-yellow">T.C. İstanbul Üniversitesi &bull; Mezun Takip Sistemi</p>
            </div>
            <p class="mb-4">&copy; 1453 - 2026 T.C. İstanbul Üniversitesi Rektörlüğü. Tüm hakları saklıdır.</p>
            <div class="flex items-center justify-center gap-4 text-xs font-bold">
                <a href="/main" class="hover:text-sticker-yellow">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-sticker-yellow">Mezunlar</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-sticker-yellow">İş İlanları</a>
                <span>&bull;</span>
                <a href="/announcements" class="hover:text-sticker-yellow">Duyurular</a>
                <span>&bull;</span>
                <a href="/api/swagger" class="hover:text-sticker-yellow">Swagger API</a>
            </div>
        </div>
    </footer>

</body>
</html>
