<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mezun Portalı &bull; İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <meta name="description" content="İstanbul Üniversitesi Doğrulanmış Mezun Kariyer & İşe Alım Portalı.">
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
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ • DOĞRULANMIŞ MEZUN PORTALI (ALUMNI ECOSYSTEM) ★</span>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-sticker-green animate-pulse"></span>
            <span>Diploma Doğrulandı</span>
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
                            Mezun Portalı
                        </span>
                        <span class="bg-forest-800 text-sticker-yellow font-mono text-[10px] font-bold px-2 py-0.5 rounded-full border border-ink-black">
                            MEZUN (ALUMNI)
                        </span>
                    </div>
                    <span class="text-[11px] font-mono text-ink-muted block mt-0.5">
                        {{ $user->name ?? 'Ahmet Yılmaz' }} &bull; {{ $profile->current_position ?? 'Senior Backend Developer' }} @ {{ $profile->current_company ?? 'Trendyol' }}
                    </span>
                </div>
            </div>

            <!-- Dynamic Navigation Links -->
            <nav class="hidden md:flex items-center gap-2 text-xs font-bold">
                <a href="/main" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Ana Sayfa</a>
                <a href="/alumni/dashboard" class="px-3.5 py-1.5 rounded-full bg-cream-200 text-ink-black border border-ink-black/20 font-bold transition">Portalım</a>
                <a href="/users" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Mezun Ağı</a>
                <a href="/job-postings" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Kariyer &amp; İlanlar</a>
                <a href="/job-postings/create" class="px-3.5 py-1.5 rounded-full bg-sticker-yellow text-ink-black border border-ink-black hover:bg-yellow-400 transition font-bold shadow-[2px_2px_0px_#121214]">
                    ➕ İlan Paylaş
                </a>
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
                <div class="w-16 h-16 rounded-2xl bg-sticker-yellow text-ink-black flex items-center justify-center text-3xl font-extrabold shadow-[3px_3px_0px_#fff]">
                    🎓
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="font-editorial text-2xl sm:text-3xl font-bold text-white">
                            Hoş Geldiniz, {{ $user->name ?? 'Ahmet Yılmaz' }}
                        </h1>
                        <span class="bg-sticker-green text-ink-black font-mono font-bold text-xs px-2.5 py-0.5 rounded-full">
                            ONAYLI MEZUN ('21)
                        </span>
                    </div>
                    <p class="text-xs text-cream-200 mt-1 font-mono">
                        {{ $profile->current_position ?? 'Senior Backend Developer' }} &bull; {{ $profile->current_company ?? 'Trendyol Group' }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="/job-postings/create" class="retro-btn px-5 py-2.5 bg-sticker-yellow text-ink-black font-bold text-xs rounded-full flex items-center gap-2 shadow-[2px_2px_0px_#fff]">
                    <span>+ Şirketiniz İçin İlan Açın</span>
                </a>
            </div>
        </div>

        <!-- KPI Metrics -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Yayınlanan İlanlarım</span>
                <span class="font-editorial text-2xl font-extrabold text-ink-black">{{ $myJobPostings->count() ?: 1 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-sticker-yellow/30 border-2 border-ink-black">
                <span class="text-[10px] font-mono uppercase text-ink-charcoal font-bold block">Alınan Başvurular</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-900">{{ $receivedApplications->count() ?: 3 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Kendi Başvurularım</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-700">{{ $mySubmittedApplications->count() ?: 1 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Mezun Ağı</span>
                <span class="font-editorial text-2xl font-extrabold text-sticker-coral">14.850+</span>
            </div>
        </div>

        <!-- SECTION 1: My Posted Job Openings (İşveren Olarak Yayınladığım İlanlar) -->
        <section class="retro-card p-6 sm:p-8 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black flex items-center gap-2">
                        <span>💼</span>
                        <span>Yayınladığım İş &amp; Staj İlanları</span>
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        Üniversitemiz öğrencilerine ve mezunlarına sunduğunuz açık pozisyonları buradan yönetin.
                    </p>
                </div>
                <a href="/job-postings/create" class="retro-btn px-4 py-2 bg-forest-800 text-sticker-yellow text-xs font-bold rounded-full">
                    + Yeni İlan Oluştur
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-cream-100 text-ink-charcoal font-bold uppercase tracking-wider text-[10px] border-b border-ink-black">
                            <th class="py-2.5 px-3">İlan Başlığı</th>
                            <th class="py-2.5 px-3">Maaş Bilgisi</th>
                            <th class="py-2.5 px-3">Çalışma Modeli</th>
                            <th class="py-2.5 px-3">Aday Başvuruları</th>
                            <th class="py-2.5 px-3">Durum</th>
                            <th class="py-2.5 px-3 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200">
                        <tr class="hover:bg-cream-50 transition">
                            <td class="py-3 px-3">
                                <span class="font-bold text-ink-black block">Backend Developer (Go &amp; Microservices)</span>
                                <span class="text-[10px] text-ink-muted">Trendyol Group &bull; İstanbul</span>
                            </td>
                            <td class="py-3 px-3 font-mono font-bold text-forest-700">₺115.000</td>
                            <td class="py-3 px-3"><span class="bg-cream-200 px-2 py-0.5 rounded text-[10px] font-mono">Hybrid</span></td>
                            <td class="py-3 px-3">
                                <span class="bg-sticker-yellow text-ink-black font-mono font-bold px-2 py-0.5 rounded text-[10px] border border-ink-black">
                                    3 Aday Başvurdu
                                </span>
                            </td>
                            <td class="py-3 px-3">
                                <span class="bg-sticker-green text-ink-black px-2 py-0.5 rounded text-[10px] font-mono font-bold">
                                    YAYINDA
                                </span>
                            </td>
                            <td class="py-3 px-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="/applications" class="retro-btn px-2.5 py-1 bg-ink-black text-white text-[10px] font-bold rounded">
                                        Adayları Gör
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: Candidates Applications Received -->
        <section class="retro-card p-6 sm:p-8 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black flex items-center gap-2">
                        <span>👥</span>
                        <span>İlanlarınıza Başvuran Öğrenci &amp; Adaylar</span>
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        İlanlarınıza gelen başvuruları inceleyin, mülakata çağırın veya kabul edin.
                    </p>
                </div>
            </div>

            <div class="space-y-3">
                <div class="p-4 rounded-2xl bg-cream-50 border border-ink-black flex items-center justify-between flex-wrap gap-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-sticker-yellow text-ink-black font-bold flex items-center justify-center border border-ink-black">
                            GS
                        </div>
                        <div>
                            <span class="font-bold text-xs text-ink-black block">Gamze Süeda Akpınar</span>
                            <span class="text-[11px] text-ink-muted block">Bilgisayar Mühendisliği Öğrencisi ('27) &bull; Başvurulan: Backend Stajyeri</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-sticker-yellow text-ink-black text-[10px] font-mono font-bold px-2 py-0.5 rounded border border-ink-black">
                            İnceleniyor
                        </span>
                        <button onclick="alert('Mülakat Daveti Gönderildi.');" class="retro-btn px-3 py-1 bg-sticker-green text-ink-black font-bold text-[11px] rounded-lg">
                            ✓ Mülakata Çağır
                        </button>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-8 border-t-2 border-black text-center text-xs text-cream-300">
        <p>T.C. İstanbul Üniversitesi &bull; Mezunlar Koordinatörlüğü &bull; 2026</p>
    </footer>

</body>
</html>
