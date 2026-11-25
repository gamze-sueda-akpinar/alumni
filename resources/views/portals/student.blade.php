<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öğrenci Portalı &bull; İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <meta name="description" content="İstanbul Üniversitesi Öğrenci Kariyer Portalı - Staj ve iş başvuruları, mezun mentörlüğü ve akademik fırsatlar.">
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF6EF; color: #121214; }
        .font-editorial { font-family: 'Fraunces', Georgia, serif; }
        .retro-card {
            background-color: #FFFFFF;
            border: 2px solid #121214;
            box-shadow: 4px 4px 0px #121214;
            transition: all 0.2s ease-in-out;
        }
        .retro-card:hover {
            transform: translate(-1px, -1px);
            box-shadow: 6px 6px 0px #121214;
        }
        .retro-btn {
            border: 2px solid #121214;
            box-shadow: 3px 3px 0px #121214;
            transition: all 0.15s ease-in-out;
        }
        .retro-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 5px 5px 0px #121214;
        }
        .retro-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #121214;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-sticker-yellow selection:text-ink-black">

    <!-- Top Status Ribbon -->
    <div class="bg-forest-900 text-sticker-yellow py-2 px-4 border-b-2 border-black text-xs font-mono tracking-wide text-center flex items-center justify-between">
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ • ÖĞRENCİ KARİYER &amp; GELİŞİM PORTALI ★</span>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-sticker-green animate-pulse"></span>
            <span>Öğrenci Hesabı Aktif (2027)</span>
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
                            Öğrenci Portalı
                        </span>
                        <span class="bg-sticker-green text-ink-black font-mono text-[10px] font-bold px-2 py-0.5 rounded-full border border-ink-black">
                            AKTİF ÖĞRENCİ
                        </span>
                    </div>
                    <span class="text-[11px] font-mono text-ink-muted block mt-0.5">
                        {{ $user->name ?? 'Gamze Süeda Akpınar' }} &bull; No: {{ $profile->student_number ?? '1306200045' }}
                    </span>
                </div>
            </div>

            <!-- Dynamic Navigation Links -->
            <nav class="hidden md:flex items-center gap-2 text-xs font-bold">
                <a href="/main" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Ana Sayfa</a>
                <a href="/student/dashboard" class="px-3.5 py-1.5 rounded-full bg-cream-200 text-ink-black border border-ink-black/20 font-bold transition">Portalım</a>
                <a href="/users" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Mezun Rehberi</a>
                <a href="/job-postings" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Staj &amp; İş İlanları</a>
                <a href="/applications" class="px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">Başvurularım</a>
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

    <!-- Student Dashboard Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 w-full flex-1">

        <!-- Student Identity Welcome Card -->
        <div class="retro-card p-6 sm:p-8 rounded-3xl bg-forest-800 text-white mb-8 border-2 border-black flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-sticker-yellow text-ink-black flex items-center justify-center text-3xl font-extrabold shadow-[3px_3px_0px_#fff]">
                    📚
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <h1 class="font-editorial text-2xl sm:text-3xl font-bold text-white">
                            Hoş Geldin, {{ $user->name ?? 'Gamze Süeda Akpınar' }}!
                        </h1>
                        <span class="bg-sticker-green text-ink-black font-mono font-bold text-xs px-2.5 py-0.5 rounded-full border border-ink-black">
                            ÖĞRENCİ ONAYLI
                        </span>
                    </div>
                    <p class="text-xs text-cream-200 mt-1 font-mono">
                        {{ $department->name ?? 'Bilgisayar Mühendisliği' }} &bull; Beklenen Mezuniyet Yılı: <strong>{{ $profile->graduation_year ?? 2027 }}</strong>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="/job-postings" class="retro-btn px-5 py-2.5 bg-sticker-yellow text-ink-black font-bold text-xs rounded-full flex items-center gap-2">
                    <span>Staj İlanlarını Keşfet</span>
                    <span>&rarr;</span>
                </a>
            </div>
        </div>

        <!-- Student Quick KPI Metrics Ribbon -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Başvurularım</span>
                <span class="font-editorial text-2xl font-extrabold text-ink-black">{{ $myApplications->count() ?? 2 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-sticker-yellow/30 border-2 border-ink-black">
                <span class="text-[10px] font-mono uppercase text-ink-charcoal font-bold block">İncelenenler</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-900">1</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Bölüm İlanları</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-700">{{ $recommendedJobs->count() ?? 12 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Mezun Mentörler</span>
                <span class="font-editorial text-2xl font-extrabold text-sticker-coral">{{ $mentors->count() ?? 4 }}</span>
            </div>
        </div>

        <!-- SECTION 1: My Submitted Job / Internship Applications -->
        <section class="retro-card p-6 sm:p-8 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black flex items-center gap-2">
                        <span>📋</span>
                        <span>Staj ve İş Başvurularım</span>
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        Başvurduğunuz ilanların güncel işe alım ve inceleme statülerini buradan anlık takip edin.
                    </p>
                </div>
                <a href="/job-postings" class="text-xs font-bold text-forest-700 hover:underline">
                    + Yeni Başvuru Yap &rarr;
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-cream-100 text-ink-charcoal font-bold uppercase tracking-wider text-[10px] border-b border-ink-black">
                            <th class="py-2.5 px-3">Pozisyon / İlan</th>
                            <th class="py-2.5 px-3">Şirket</th>
                            <th class="py-2.5 px-3">Çalışma Şekli</th>
                            <th class="py-2.5 px-3">Başvuru Tarihi</th>
                            <th class="py-2.5 px-3 text-right">Durum</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200">
                        @forelse($myApplications as $app)
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3 font-bold text-ink-black">
                                    {{ $app->jobPosting->title ?? 'Yazılım Stajyeri (Frontend)' }}
                                </td>
                                <td class="py-3 px-3">
                                    {{ $app->jobPosting->company_name ?? 'Getir Teknoloji' }}
                                </td>
                                <td class="py-3 px-3">
                                    <span class="bg-cream-200 text-ink-black px-2 py-0.5 rounded text-[10px] font-mono">
                                        {{ ucfirst($app->jobPosting->workplace_type ?? 'Hybrid') }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 font-mono text-ink-muted">
                                    {{ $app->created_at ? $app->created_at->format('d.m.Y') : '25.11.2026' }}
                                </td>
                                <td class="py-3 px-3 text-right">
                                    @php
                                        $st = $app->status ?? 'pending';
                                    @endphp
                                    @if($st === 'accepted')
                                        <span class="bg-sticker-green text-ink-black px-2.5 py-1 rounded-full text-[10px] font-mono font-bold border border-ink-black">
                                            ✓ KABUL EDİLDİ
                                        </span>
                                    @elseif($st === 'shortlisted' || $st === 'reviewed')
                                        <span class="bg-sticker-yellow text-ink-black px-2.5 py-1 rounded-full text-[10px] font-mono font-bold border border-ink-black">
                                            🔍 MÜLAKATA ALINDI
                                        </span>
                                    @elseif($st === 'rejected')
                                        <span class="bg-sticker-coral text-white px-2.5 py-1 rounded-full text-[10px] font-mono font-bold">
                                            ✕ REDDEDİLDİ
                                        </span>
                                    @else
                                        <span class="bg-cream-200 text-forest-800 px-2.5 py-1 rounded-full text-[10px] font-mono font-bold">
                                            ⏳ İNCELENİYOR
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <!-- Sample Mock Row for Demonstration -->
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3 font-bold text-ink-black">Backend Stajyeri (PHP &amp; Laravel)</td>
                                <td class="py-3 px-3">Trendyol Group</td>
                                <td class="py-3 px-3"><span class="bg-cream-200 px-2 py-0.5 rounded text-[10px] font-mono">Hybrid</span></td>
                                <td class="py-3 px-3 font-mono text-ink-muted">24.11.2026</td>
                                <td class="py-3 px-3 text-right">
                                    <span class="bg-sticker-yellow text-ink-black px-2.5 py-1 rounded-full text-[10px] font-mono font-bold border border-ink-black">
                                        🔍 İNCELENİYOR
                                    </span>
                                </td>
                            </tr>
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3 font-bold text-ink-black">Junior Frontend Developer</td>
                                <td class="py-3 px-3">Getir Teknoloji</td>
                                <td class="py-3 px-3"><span class="bg-cream-200 px-2 py-0.5 rounded text-[10px] font-mono">Remote</span></td>
                                <td class="py-3 px-3 font-mono text-ink-muted">22.11.2026</td>
                                <td class="py-3 px-3 text-right">
                                    <span class="bg-sticker-green text-ink-black px-2.5 py-1 rounded-full text-[10px] font-mono font-bold border border-ink-black">
                                        ✓ MÜLAKATA ALINDI
                                    </span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: Recommended Jobs for Computer Engineering & Mentors -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            
            <!-- Recommended Job Cards (2 Columns) -->
            <div class="lg:col-span-2 retro-card p-6 rounded-3xl bg-white">
                <div class="flex items-center justify-between mb-4 border-b border-cream-200 pb-2">
                    <h2 class="font-editorial text-lg font-bold text-ink-black flex items-center gap-2">
                        <span>🎯</span>
                        <span>Bölümünüz İçin Önerilen Staj &amp; Giriş Pozisyonları</span>
                    </h2>
                    <a href="/job-postings" class="text-xs font-bold text-forest-700 hover:underline">Tümünü Gör</a>
                </div>

                <div class="space-y-3">
                    <div class="p-4 rounded-2xl bg-cream-50 border border-ink-black flex items-center justify-between flex-wrap gap-2 hover:bg-cream-100 transition">
                        <div>
                            <span class="font-bold text-ink-black block text-sm">Junior Go Developer</span>
                            <span class="text-xs text-ink-muted">Algoritmik Bilişim &bull; İstanbul (Hybrid) &bull; ₺45.000</span>
                        </div>
                        <a href="/job-postings" class="retro-btn px-3 py-1.5 bg-forest-800 text-sticker-yellow text-xs font-bold rounded-full">
                            Başvur
                        </a>
                    </div>

                    <div class="p-4 rounded-2xl bg-cream-50 border border-ink-black flex items-center justify-between flex-wrap gap-2 hover:bg-cream-100 transition">
                        <div>
                            <span class="font-bold text-ink-black block text-sm">Yazılım Kalite &amp; Test Stajyeri</span>
                            <span class="text-xs text-ink-muted">NextGen Labs &bull; Remote &bull; ₺25.000</span>
                        </div>
                        <a href="/job-postings" class="retro-btn px-3 py-1.5 bg-forest-800 text-sticker-yellow text-xs font-bold rounded-full">
                            Başvur
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alumni Mentors from Same Department (1 Column) -->
            <div class="retro-card p-6 rounded-3xl bg-white">
                <h2 class="font-editorial text-lg font-bold text-ink-black mb-3 flex items-center gap-2">
                    <span>🤝</span>
                    <span>Bölüm Mezun Mentörleri</span>
                </h2>
                <p class="text-xs text-ink-muted mb-4">
                    Aynı fakülte ve bölümden mezun olup sektörde çalışan mezunlarımızla iletişime geçin.
                </p>

                <div class="space-y-3">
                    <div class="flex items-center gap-3 p-2.5 rounded-xl border border-cream-200">
                        <div class="w-10 h-10 rounded-full bg-forest-800 text-sticker-yellow flex items-center justify-center font-bold text-sm">
                            AY
                        </div>
                        <div class="flex-1">
                            <span class="font-bold text-xs text-ink-black block">Ahmet Yılmaz</span>
                            <span class="text-[11px] text-ink-muted block">Senior Backend @ Trendyol ('21)</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3 p-2.5 rounded-xl border border-cream-200">
                        <div class="w-10 h-10 rounded-full bg-sticker-yellow text-ink-black flex items-center justify-center font-bold text-sm border border-ink-black">
                            EK
                        </div>
                        <div class="flex-1">
                            <span class="font-bold text-xs text-ink-black block">Elif Kaya</span>
                            <span class="text-[11px] text-ink-muted block">Frontend Engineer @ Getir ('23)</span>
                        </div>
                    </div>
                </div>

                <a href="/users" class="retro-btn w-full mt-4 py-2 bg-cream-100 text-ink-black font-bold text-xs rounded-xl flex items-center justify-center gap-1.5">
                    <span>Tüm Mezun Rehberini Aç</span>
                    <span>&rarr;</span>
                </a>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-8 border-t-2 border-black text-center text-xs text-cream-300">
        <p>T.C. İstanbul Üniversitesi &bull; Öğrenci İşleri ve Mezunlar Koordinatörlüğü &bull; 2026</p>
    </footer>

</body>
</html>
