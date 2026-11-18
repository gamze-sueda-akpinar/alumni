<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mezunlar Rehberi | Mezun Takip Sistemi</title>
    <meta name="description" content="Üniversitemizin doğrulanmış mezun dizini, bölüm ve mezuniyet yılına göre mezun arama, kariyer profilleri.">
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

    <!-- 1. Top Ribbon -->
    <div class="bg-gradient-to-r from-brand-950 via-slate-900 to-indigo-950 text-white text-xs py-2 px-4 text-center font-medium border-b border-indigo-950/60">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 flex-wrap">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#8ed462] text-slate-950 uppercase tracking-wider">Doğrulanmış Dizin</span>
            <span>Öğrenci işleri ve mezun kayıtları doğrudan MySQL veritabanıyla senkronizedir.</span>
            <a href="/about" class="underline underline-offset-2 hover:text-brand-300 font-semibold transition ml-1">Doğrulama Koşulları &rarr;</a>
        </div>
    </div>

    <!-- 2. Sticky Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-brand-600 via-indigo-700 to-brand-900 flex items-center justify-center text-white text-2xl shadow-sm group-hover:scale-105 transition-transform">
                    🎓
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Alumni Directory &amp; Networking
                    </span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/70">
                <a href="/main" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Ana Sayfa</a>
                <a href="/users" class="text-xs font-bold text-brand-700 bg-white px-4 py-2 rounded-full shadow-sm transition">Mezunlar</a>
                <a href="/job-postings" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Duyurular</a>
                <a href="/applications" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Başvurular</a>
                <a href="/about" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Hakkımızda</a>
            </nav>

            <!-- Actions -->
            <div class="flex items-center gap-3">
                <a href="/users/create" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-brand-600 hover:bg-brand-700 rounded-full transition shadow-sm">
                    <span>+</span> Yeni Mezun Ekle
                </a>
            </div>
        </div>
    </header>

    <!-- 3. Main Content Container -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

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

        @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                <span>⚠️</span> Lütfen formdaki hataları kontrol ediniz:
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Directory Header & Breadcrumb -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-700 text-xs font-semibold mb-3">
                    <span>👥</span>
                    <span>Doğrulanmış Akademik Mezunlar Rehberi (Alumni Directory)</span>
                </div>
                <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                    Kayıtlı Mezunlar &amp; Profesyoneller
                </h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Üniversitemizden mezun olan tüm profesyonellerin profil, deneyim ve iletişim bilgileri. Filtreleyebilir veya anında detay inceleyebilirsiniz.
                </p>
            </div>

            <!-- Stats & Quick Actions -->
            <div class="flex items-center gap-3 flex-wrap">
                <div class="px-4 py-2 bg-white rounded-2xl hairline-border shadow-sm text-xs text-slate-600">
                    Toplam Mezun: <span class="font-bold text-brand-600 font-mono text-sm ml-1">{{ count($users) }}</span>
                </div>
                <button onclick="toggleQuickCreate()" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 text-white rounded-2xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span id="quickToggleIcon">⚡</span>
                    <span id="quickToggleText">Hızlı Ekleme Paneli</span>
                </button>
            </div>
        </div>

        <!-- 4. Quick Create Accordion (Collapsible) -->
        <div id="quickCreateCard" class="hidden bg-white rounded-3xl p-6 hairline-border shadow-sm mb-8 transition-all duration-300">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="text-lg">✨</span>
                    <h3 class="font-bold text-slate-900 text-sm">Yeni Mezun Kaydı Oluştur (Hızlı Form)</h3>
                </div>
                <span class="text-xs text-emerald-700 bg-emerald-50 px-2.5 py-0.5 rounded-full border border-emerald-200 font-medium">
                    Doğrudan MySQL veritabanına eklenir
                </span>
            </div>

            <form action="/users" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Ad Soyad *</label>
                    <input type="text" name="name" required placeholder="Örn: Selin Kaya" value="{{ old('name') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">E-Posta Adresi *</label>
                    <input type="email" name="email" required placeholder="selin@example.com" value="{{ old('email') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Öğrenci No</label>
                    <input type="text" name="student_number" placeholder="202011045" value="{{ old('student_number') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Bölüm</label>
                    <input type="text" name="department" placeholder="Bilgisayar Mühendisliği" value="{{ old('department') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mevcut Şirket</label>
                    <input type="text" name="current_company" placeholder="Amazon, Trendyol..." value="{{ old('current_company') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mevcut Unvan / Pozisyon</label>
                    <input type="text" name="current_position" placeholder="Frontend Developer" value="{{ old('current_position') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Şehir</label>
                    <input type="text" name="city" placeholder="İstanbul" value="{{ old('city', 'İstanbul') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl text-xs transition shadow-sm flex items-center justify-center gap-2">
                        <span>💾</span> Mezunu Kaydet
                    </button>
                </div>
            </form>
        </div>

        <!-- 5. Search & Live Filter Bar -->
        <div class="bg-white rounded-3xl p-4 hairline-border shadow-sm mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    🔍
                </span>
                <input type="text" id="alumniSearchInput" onkeyup="filterAlumniList()" 
                       placeholder="Mezun adı, şirket, bölüm, unvan veya şehre göre filtreleyin..." 
                       class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto justify-end">
                <!-- View Switcher -->
                <div class="bg-slate-100 p-1 rounded-2xl flex items-center border border-slate-200">
                    <button type="button" id="btnGridView" onclick="setViewMode('grid')" 
                            class="px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-sm transition">
                        🪟 Kart Görünümü
                    </button>
                    <button type="button" id="btnTableView" onclick="setViewMode('table')" 
                            class="px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition">
                        📋 Tablo Görünümü
                    </button>
                </div>
            </div>
        </div>

        <!-- 6. Alumni Grid View (Default) -->
        <div id="alumniGridContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($users as $user)
            @php 
                $uid = $user->id ?? $user['id'];
                $uname = $user->name ?? $user['name'];
                $uemail = $user->email ?? $user['email'];
                $snumber = $user->student_number ?? $user['student_number'] ?? '—';
                $dept = $user->department ?? $user['department'] ?? 'Belirtilmedi';
                $company = $user->current_company ?? $user['current_company'] ?? 'Serbest / Belirtilmedi';
                $position = $user->current_position ?? $user['current_position'] ?? 'Mezun';
                $city = $user->city ?? $user['city'] ?? 'İstanbul';
                $status = $user->status ?? $user['status'] ?? 'approved';
                
                // Avatar initials
                $initials = 'MT';
                if ($uname) {
                    $parts = explode(' ', trim($uname));
                    $initials = mb_substr($parts[0], 0, 1) . (isset($parts[1]) ? mb_substr($parts[1], 0, 1) : '');
                }
            @endphp
            <div class="alumni-card bg-white rounded-3xl p-6 hairline-border hover:border-brand-300 hover:shadow-md transition duration-200 flex flex-col justify-between"
                 data-search="{{ strtolower($uname . ' ' . $dept . ' ' . $company . ' ' . $position . ' ' . $city) }}">
                <div>
                    <!-- Card Top Bar -->
                    <div class="flex items-start justify-between gap-3 mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-brand-100 to-indigo-100 text-brand-800 font-bold flex items-center justify-center text-sm shadow-inner uppercase font-mono">
                                {{ $initials }}
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-base leading-snug">
                                    <a href="/users/{{ $uid }}" class="hover:text-brand-600 transition">
                                        {{ $uname }}
                                    </a>
                                </h3>
                                <span class="text-xs text-slate-500 block truncate max-w-[180px]">{{ $uemail }}</span>
                            </div>
                        </div>

                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            {{ $status }}
                        </span>
                    </div>

                    <!-- Details Box -->
                    <div class="bg-slate-50/80 rounded-2xl p-3.5 space-y-2 mb-4 text-xs hairline-border">
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Bölüm:</span>
                            <span class="font-semibold text-slate-800 truncate max-w-[180px]">{{ $dept }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Öğrenci No:</span>
                            <span class="font-mono text-slate-600">{{ $snumber }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Şirket / Rol:</span>
                            <span class="font-semibold text-brand-700 truncate max-w-[180px]">
                                {{ $company }} &bull; {{ $position }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-slate-400">Lokasyon:</span>
                            <span class="text-slate-700">📍 {{ $city }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Bar -->
                <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-mono text-[11px]">#{{ $uid }}</span>
                    <div class="flex items-center gap-1.5">
                        <a href="/users/{{ $uid }}" class="px-3 py-1.5 rounded-xl bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold transition border border-brand-200">
                            İncele &rarr;
                        </a>
                        <a href="/users/{{ $uid }}/edit" class="px-2.5 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold transition border border-amber-200">
                            ✏️
                        </a>
                        <form action="/users/{{ $uid }}" method="POST" class="inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold transition border border-rose-200">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center hairline-border">
                <span class="text-5xl block mb-3">🎓</span>
                <h3 class="font-serif-editorial text-xl font-bold text-slate-900 mb-1">Henüz Kayıtlı Mezun Bulunmuyor</h3>
                <p class="text-slate-500 text-xs mb-4">Sistemde henüz kayıtlı kullanıcı yok veya filtreleme kriterine uyan sonuç bulunamadı.</p>
                <a href="/users/create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white rounded-full text-xs font-bold">
                    + İlk Mezunu Kaydet
                </a>
            </div>
            @endforelse
        </div>

        <!-- 7. Alumni Table View (Hidden by default, toggled via JS) -->
        <div id="alumniTableContainer" class="hidden bg-white rounded-3xl hairline-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="py-4 px-5"># ID</th>
                            <th class="py-4 px-5">Mezun Bilgisi</th>
                            <th class="py-4 px-5">Öğrenci No</th>
                            <th class="py-4 px-5">Bölüm</th>
                            <th class="py-4 px-5">Mevcut Şirket &amp; Pozisyon</th>
                            <th class="py-4 px-5">Şehir</th>
                            <th class="py-4 px-5">Durum</th>
                            <th class="py-4 px-5 text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @foreach($users as $user)
                        @php 
                            $uid = $user->id ?? $user['id'];
                            $uname = $user->name ?? $user['name'];
                            $uemail = $user->email ?? $user['email'];
                        @endphp
                        <tr class="alumni-row hover:bg-slate-50/75 transition"
                            data-search="{{ strtolower($uname . ' ' . ($user->department ?? '') . ' ' . ($user->current_company ?? '') . ' ' . ($user->current_position ?? '')) }}">
                            <td class="py-3.5 px-5 font-mono text-slate-400">#{{ $uid }}</td>
                            <td class="py-3.5 px-5">
                                <div class="font-bold text-slate-900">{{ $uname }}</div>
                                <div class="text-[11px] text-slate-400">{{ $uemail }}</div>
                            </td>
                            <td class="py-3.5 px-5 font-mono text-slate-600">{{ $user->student_number ?? $user['student_number'] ?? '—' }}</td>
                            <td class="py-3.5 px-5 text-slate-700 font-medium">{{ $user->department ?? $user['department'] ?? '—' }}</td>
                            <td class="py-3.5 px-5">
                                <span class="font-semibold text-slate-900 block">{{ $user->current_company ?? $user['current_company'] ?? '—' }}</span>
                                <span class="text-brand-600 font-medium text-[11px]">{{ $user->current_position ?? $user['current_position'] ?? '' }}</span>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">📍 {{ $user->city ?? $user['city'] ?? 'İstanbul' }}</td>
                            <td class="py-3.5 px-5">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                    {{ $user->status ?? $user['status'] ?? 'approved' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="/users/{{ $uid }}" class="px-2.5 py-1 rounded-lg bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold border border-brand-200">
                                        İncele
                                    </a>
                                    <a href="/users/{{ $uid }}/edit" class="px-2 py-1 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold border border-amber-200">
                                        ✏️
                                    </a>
                                    <form action="/users/{{ $uid }}" method="POST" class="inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold border border-rose-200">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- 8. Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Akademik Mezun Rehberi Modülü</p>
            <div class="flex items-center gap-4">
                <a href="/main" class="hover:text-brand-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-brand-600 transition">İş İlanları</a>
                <span>&bull;</span>
                <a href="/announcements" class="hover:text-brand-600 transition">Duyurular</a>
                <span>&bull;</span>
                <a href="/api/swagger" class="hover:text-brand-600 transition">Swagger API</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts: Search & View Toggle -->
    <script>
        function toggleQuickCreate() {
            const card = document.getElementById('quickCreateCard');
            const isHidden = card.classList.contains('hidden');
            if (isHidden) {
                card.classList.remove('hidden');
                document.getElementById('quickToggleText').textContent = 'Paneli Kapat';
            } else {
                card.classList.add('hidden');
                document.getElementById('quickToggleText').textContent = 'Hızlı Ekleme Paneli';
            }
        }

        function setViewMode(mode) {
            const grid = document.getElementById('alumniGridContainer');
            const table = document.getElementById('alumniTableContainer');
            const btnGrid = document.getElementById('btnGridView');
            const btnTable = document.getElementById('btnTableView');

            if (mode === 'table') {
                grid.classList.add('hidden');
                table.classList.remove('hidden');
                btnTable.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-sm transition';
                btnGrid.className = 'px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition';
            } else {
                table.classList.add('hidden');
                grid.classList.remove('hidden');
                btnGrid.className = 'px-3 py-1.5 rounded-xl text-xs font-bold bg-white text-slate-900 shadow-sm transition';
                btnTable.className = 'px-3 py-1.5 rounded-xl text-xs font-semibold text-slate-600 hover:text-slate-900 transition';
            }
        }

        function filterAlumniList() {
            const query = document.getElementById('alumniSearchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.alumni-card');
            const rows = document.querySelectorAll('.alumni-row');

            cards.forEach(card => {
                const text = card.getAttribute('data-search') || '';
                card.style.display = text.includes(query) ? 'flex' : 'none';
            });

            rows.forEach(row => {
                const text = row.getAttribute('data-search') || '';
                row.style.display = text.includes(query) ? '' : 'none';
            });
        }
    </script>
</body>
</html>
