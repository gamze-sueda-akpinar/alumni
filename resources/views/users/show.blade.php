<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name ?? $user['name'] }} | Mezun Profil Detayı</title>
    <meta name="description" content="{{ $user->name ?? $user['name'] }} mezun profil bilgileri, akademik geçmişi ve kariyer deneyimleri.">
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
    <!-- Google Fonts -->
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

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-brand-600 flex items-center justify-center text-white text-2xl shadow-sm">
                    🎓
                </div>
                <div>
                    <span class="font-bold text-lg tracking-tight text-slate-900 block leading-tight">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Alumni Profile Verification
                    </span>
                </div>
            </a>

            <div class="flex items-center gap-3">
                <a href="/users" class="text-xs font-bold text-slate-600 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                    &larr; Mezun Rehberine Dön
                </a>
                <a href="/users/{{ $user->id ?? $user['id'] }}/edit" class="text-xs font-bold text-white bg-amber-500 hover:bg-amber-600 px-4 py-2 rounded-full transition shadow-sm">
                    ✏️ Düzenle
                </a>
            </div>
        </div>
    </header>

    @php
        $uid = $user->id ?? $user['id'];
        $uname = $user->name ?? $user['name'];
        $uemail = $user->email ?? $user['email'];
        $snumber = $user->student_number ?? $user['student_number'] ?? '202011045';
        $dept = $user->department ?? $user['department'] ?? 'Bilgisayar Mühendisliği';
        $gyear = $user->graduation_year ?? $user['graduation_year'] ?? '2024';
        $company = $user->current_company ?? $user['current_company'] ?? 'TechCorp Global';
        $position = $user->current_position ?? $user['current_position'] ?? 'Senior Software Engineer';
        $city = $user->city ?? $user['city'] ?? 'İstanbul';
        $status = $user->status ?? $user['status'] ?? 'approved';

        $initials = 'MT';
        if ($uname) {
            $parts = explode(' ', trim($uname));
            $initials = mb_substr($parts[0], 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : '');
        }
    @endphp

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Profile Hero Header Banner -->
        <div class="bg-gradient-to-br from-brand-950 via-slate-900 to-indigo-950 text-white rounded-3xl p-8 sm:p-10 hairline-border shadow-xl mb-8 relative overflow-hidden">
            <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-brand-600/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <!-- Avatar + Title -->
                <div class="flex items-center gap-5">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-gradient-to-tr from-brand-500 to-indigo-400 text-white font-extrabold text-2xl sm:text-3xl flex items-center justify-center font-mono shadow-md border-2 border-white/20">
                        {{ $initials }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1 flex-wrap">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-[#8ed462] text-slate-950 uppercase tracking-wider">
                                ✓ Doğrulanmış Mezun
                            </span>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-white/10 text-white border border-white/20">
                                🎓 {{ $gyear }} Mezunu
                            </span>
                            <span class="text-xs text-slate-400 font-mono">#{{ $uid }}</span>
                        </div>
                        <h1 class="font-serif-editorial text-2xl sm:text-4xl font-bold tracking-tight text-white mb-1">
                            {{ $uname }}
                        </h1>
                        <p class="text-brand-200 text-sm sm:text-base font-medium">
                            {{ $position }} &bull; <span class="text-white font-semibold">{{ $company }}</span>
                        </p>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center gap-2 flex-wrap">
                    <a href="mailto:{{ $uemail }}" class="px-4 py-2.5 bg-white/10 hover:bg-white/20 text-white rounded-2xl text-xs font-semibold border border-white/20 transition flex items-center gap-1.5">
                        <span>✉️</span> E-Posta Gönder
                    </a>
                    <a href="/users/{{ $uid }}/edit" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-2xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                        <span>✏️</span> Düzenle
                    </a>
                    <form action="/users/{{ $uid }}" method="POST" class="inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2.5 bg-rose-600 hover:bg-rose-700 text-white rounded-2xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                            <span>🗑️</span> Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- 2-Column Modular Profile Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Column: Academic & Personal Info -->
            <div class="space-y-6">
                <!-- Academic Card -->
                <div class="bg-white rounded-3xl p-6 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>🏛️</span> Akademik Bilgiler
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Bölüm &amp; Fakülte</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $dept }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Öğrenci Numarası</span>
                            <span class="font-mono font-bold text-slate-800">{{ $snumber }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Mezuniyet Yılı</span>
                            <span class="font-bold text-slate-800">{{ $gyear }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Onay Durumu</span>
                            <span class="inline-block mt-0.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                {{ strtoupper($status) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contact & Location Card -->
                <div class="bg-white rounded-3xl p-6 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>📍</span> İletişim &amp; Konum
                    </h3>
                    <ul class="space-y-3 text-xs text-slate-600">
                        <li class="flex items-center gap-2.5">
                            <span class="text-base">✉️</span>
                            <span class="font-medium text-slate-800">{{ $uemail }}</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-base">🏙️</span>
                            <span>İkamet: <strong class="text-slate-800">{{ $city }}</strong></span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <span class="text-base">💼</span>
                            <span>Çalışma Modeli: <strong class="text-emerald-700">Uzaktan / Hibrit</strong></span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Right Column: Career & Timeline & Jobs -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Current Employment Spotlight -->
                <div class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>💼</span> Güncel Kariyer &amp; Görev
                        </h3>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            Aktif İstihdam
                        </span>
                    </div>

                    <div class="bg-slate-50/80 rounded-2xl p-5 hairline-border mb-4">
                        <div class="flex items-center justify-between flex-wrap gap-2 mb-2">
                            <h4 class="font-bold text-slate-900 text-base">{{ $position }}</h4>
                            <span class="text-xs font-mono text-slate-500">2024 — Günümüz</span>
                        </div>
                        <p class="text-xs font-bold text-brand-600 mb-2">{{ $company }}</p>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Yüksek ölçekli web uygulamaları geliştirme, mikroservis mimarileri yönetimi, ekip liderliği ve yeni mezun mühendislere mentorluk sağlama.
                        </p>
                    </div>

                    <div class="flex items-center gap-2 flex-wrap text-xs">
                        <span class="font-bold text-slate-400">Teknoloji &amp; Yetenekler:</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-700 font-medium">PHP / Laravel</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-700 font-medium">Docker</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-700 font-medium">MySQL</span>
                        <span class="px-2.5 py-1 bg-white border border-slate-200 rounded-full text-slate-700 font-medium">Tailwind CSS</span>
                    </div>
                </div>

                <!-- Career Timeline -->
                <div class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-6 flex items-center gap-2">
                        <span>📈</span> Kariyer &amp; Eğitim Kronolojisi
                    </h3>

                    <div class="relative pl-6 border-l-2 border-brand-200 space-y-6">
                        <!-- Step 1 -->
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-brand-600 border-4 border-white shadow-sm"></div>
                            <span class="text-xs font-mono text-slate-400">2024</span>
                            <h4 class="font-bold text-slate-900 text-sm mt-0.5">Lisans Mezuniyeti &bull; {{ $dept }}</h4>
                            <p class="text-xs text-slate-600 mt-1">Üniversitemiz Mühendislik Fakültesi'nden yüksek onur derecesiyle mezun oldu.</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative">
                            <div class="absolute -left-[31px] top-1 w-4 h-4 rounded-full bg-emerald-500 border-4 border-white shadow-sm"></div>
                            <span class="text-xs font-mono text-slate-400">2023 — 2024</span>
                            <h4 class="font-bold text-slate-900 text-sm mt-0.5">Yazılım Stajyeri &bull; Trendyol Tech</h4>
                            <p class="text-xs text-slate-600 mt-1">Bulut bilişim ve veri kuyrukları (Kafka/Redis) optimizasyonları üzerinde çalıştı.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Doğrulanmış Profil Görüntüleyici</p>
            <a href="/users" class="text-brand-600 font-semibold hover:underline">&larr; Mezunlar Listesine Dön</a>
        </div>
    </footer>

</body>
</html>
