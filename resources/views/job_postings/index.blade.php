<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kariyer Portalı &amp; İş İlanları | Mezun Takip Sistemi</title>
    <meta name="description" content="Üniversitemizin şeffaf kariyer ve iş ilanları portalı. Zorunlu çalışma modeli ve net maaş bilgisi ile açık pozisyonlar.">
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
    <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-brand-950 text-white text-xs py-2 px-4 text-center font-medium border-b border-indigo-950/60">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 flex-wrap">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-[#8ed462] text-slate-950 uppercase tracking-wider">Şeffaf Maaş İlkesi</span>
            <span>Platformumuzda yayınlanan her ilanda taban maaş ve çalışma modeli (Uzaktan/Hibrit/Ofiste) zorunludur.</span>
            <a href="/about" class="underline underline-offset-2 hover:text-brand-300 font-semibold transition ml-1">Standartlar &rarr;</a>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-emerald-600 via-teal-700 to-indigo-900 flex items-center justify-center text-white text-2xl shadow-sm group-hover:scale-105 transition-transform">
                    💼
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Career &amp; Employment Portal
                    </span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/70">
                <a href="/main" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Ana Sayfa</a>
                <a href="/users" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Mezunlar</a>
                <a href="/job-postings" class="text-xs font-bold text-brand-700 bg-white px-4 py-2 rounded-full shadow-sm transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Duyurular</a>
                <a href="/applications" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Başvurular</a>
                <a href="/about" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Hakkımızda</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/job-postings/create" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-slate-900 hover:bg-slate-800 rounded-full transition shadow-sm">
                    <span>+</span> İlan Yayınla
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
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
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm text-xs">
            <div class="flex items-center gap-2 mb-2 font-bold text-sm">
                <span>⚠️</span> Lütfen aşağıdaki alanları kontrol ediniz:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Header Banner -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-semibold mb-3">
                    <span>💼</span>
                    <span>Şeffaf Mezun Kariyer Portalı (Job Board)</span>
                </div>
                <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                    Kariyer Fırsatları &amp; Açık Pozisyonlar
                </h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Üniversitemiz mezunları ve partner kurumsal şirketler tarafından açılan güncel iş ilanları. Şeffaf maaş ve net çalışma modeli garantisiyle.
                </p>
            </div>

            <div class="flex items-center gap-3 flex-wrap">
                <div class="px-4 py-2 bg-white rounded-2xl hairline-border shadow-sm text-xs text-slate-600">
                    Aktif İlan: <span class="font-bold text-brand-600 font-mono text-sm ml-1">{{ count($jobPostings) }}</span>
                </div>
                <button onclick="toggleJobCreate()" class="px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-2xl text-xs font-bold transition shadow-sm flex items-center gap-1.5">
                    <span id="jobToggleIcon">⚡</span>
                    <span id="jobToggleText">Hızlı İlan Ekle</span>
                </button>
            </div>
        </div>

        <!-- Quick Job Create Accordion -->
        <div id="quickJobCard" class="hidden bg-white rounded-3xl p-6 sm:p-8 hairline-border shadow-sm mb-8 transition-all">
            <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                <div class="flex items-center gap-2">
                    <span class="text-lg">✨</span>
                    <h3 class="font-bold text-slate-900 text-sm">Yeni İş İlanı Yayınla (Zorunlu Alanlar Entegre)</h3>
                </div>
                <span class="text-xs text-brand-700 bg-brand-50 px-2.5 py-0.5 rounded-full border border-brand-200 font-medium">
                    Maaş &amp; Çalışma Modeli Zorunludur
                </span>
            </div>

            <form action="/job-postings" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf
                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Pozisyon Başlığı *</label>
                    <input type="text" name="title" required placeholder="Örn: Senior Backend Developer (PHP & Laravel)" value="{{ old('title') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Şirket / Kurum Adı *</label>
                    <input type="text" name="company_name" required placeholder="Örn: Algoritmik Bilişim" value="{{ old('company_name') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Çalışma Modeli *</label>
                    <select name="workplace_type" required class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        <option value="remote" {{ old('workplace_type') == 'remote' ? 'selected' : '' }}>🟢 Uzaktan (Remote)</option>
                        <option value="hybrid" {{ old('workplace_type') == 'hybrid' ? 'selected' : '' }}>🟠 Hibrit (Hybrid)</option>
                        <option value="in-office" {{ old('workplace_type') == 'in-office' ? 'selected' : '' }}>🔵 Ofiste (In-Office)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Net Taban Maaş (₺) *</label>
                    <input type="number" step="0.01" min="0" name="salary" required placeholder="Örn: 65000" value="{{ old('salary') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition font-mono">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Şehir / Lokasyon</label>
                    <input type="text" name="city" placeholder="İstanbul" value="{{ old('city', 'İstanbul') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div class="sm:col-span-2">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Yan Haklar &amp; Avantajlar (Benefits)</label>
                    <input type="text" name="benefits" placeholder="Örn: Özel sağlık sigortası, yemek kartı, spor salonu, eğitim bütçesi" value="{{ old('benefits') }}"
                           class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div class="sm:col-span-4">
                    <label class="block text-xs font-semibold text-slate-700 mb-1">İş Tanımı &amp; Sorumluluklar</label>
                    <textarea name="description" rows="2" placeholder="Rolün gereksinimleri ve beklenen sorumluluklar..."
                              class="w-full px-3.5 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">{{ old('description') }}</textarea>
                </div>

                <div class="sm:col-span-4 flex items-center justify-end pt-2">
                    <button type="submit" class="px-7 py-3 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl text-xs transition shadow-md flex items-center gap-2">
                        <span>📢</span> İlanı Hemen Yayınla
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Chips & Search Bar -->
        <div class="bg-white rounded-3xl p-4 hairline-border shadow-sm mb-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="relative flex-1 w-full">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    🔍
                </span>
                <input type="text" id="jobSearchInput" onkeyup="filterJobsList()" 
                       placeholder="Pozisyon adı, şirket, şehir veya beceriye göre arayın..." 
                       class="w-full pl-10 pr-4 py-2.5 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
            </div>

            <!-- Workplace Type Filter Pills -->
            <div class="flex items-center gap-1.5 flex-wrap w-full md:w-auto justify-start md:justify-end text-xs">
                <button type="button" onclick="filterByWorkplace('all')" class="workplace-filter-btn px-3 py-1.5 rounded-full font-bold bg-slate-900 text-white transition">
                    Tümü
                </button>
                <button type="button" onclick="filterByWorkplace('remote')" class="workplace-filter-btn px-3 py-1.5 rounded-full font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 transition">
                    🟢 Uzaktan
                </button>
                <button type="button" onclick="filterByWorkplace('hybrid')" class="workplace-filter-btn px-3 py-1.5 rounded-full font-semibold bg-amber-50 text-amber-800 border border-amber-200 hover:bg-amber-100 transition">
                    🟠 Hibrit
                </button>
                <button type="button" onclick="filterByWorkplace('in-office')" class="workplace-filter-btn px-3 py-1.5 rounded-full font-semibold bg-blue-50 text-blue-800 border border-blue-200 hover:bg-blue-100 transition">
                    🔵 Ofiste
                </button>
            </div>
        </div>

        <!-- Jobs Grid -->
        <div id="jobsGridContainer" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($jobPostings as $job)
            @php 
                $jid = $job->id ?? $job['id'];
                $jtitle = $job->title ?? $job['title'];
                $jcompany = $job->company_name ?? $job['company_name'];
                $wtype = strtolower($job->workplace_type ?? $job['workplace_type'] ?? 'remote');
                $jsalary = $job->salary ?? $job['salary'] ?? null;
                $jcity = $job->city ?? $job['city'] ?? $job->location ?? $job['location'] ?? 'İstanbul';
                $jdesc = $job->description ?? $job['description'] ?? 'Detaylı açıklama için ilanı inceleyiniz.';
                $jbenefits = $job->benefits ?? $job['benefits'] ?? null;
                $appCount = $job->applications_count ?? count($job->applications ?? []);

                // Badge mappings
                $typeBadge = match($wtype) {
                    'remote' => ['label' => '🟢 Uzaktan / Remote', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                    'hybrid' => ['label' => '🟠 Hibrit / Hybrid', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                    'in-office' => ['label' => '🔵 Ofiste / In-Office', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                    default => ['label' => '🟢 ' . ucfirst($wtype), 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                };
            @endphp
            <div class="job-card bg-white rounded-3xl p-7 hairline-border hover:border-brand-300 hover:shadow-md transition duration-200 flex flex-col justify-between"
                 data-search="{{ strtolower($jtitle . ' ' . $jcompany . ' ' . $jcity . ' ' . $wtype) }}"
                 data-workplace="{{ $wtype }}">
                <div>
                    <!-- Top Badge Bar -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $typeBadge['class'] }}">
                            {{ $typeBadge['label'] }}
                        </span>

                        @if($jsalary)
                        <span class="font-mono text-xs font-bold bg-slate-900 text-[#8ed462] px-3 py-1 rounded-full shadow-sm">
                            ₺{{ number_format((float)$jsalary, 0, ',', '.') }} / ay
                        </span>
                        @else
                        <span class="font-mono text-xs font-bold bg-slate-100 text-slate-700 px-3 py-1 rounded-full">
                            ₺ Rekabetçi
                        </span>
                        @endif
                    </div>

                    <!-- Title & Company -->
                    <h3 class="text-xl font-bold text-slate-900 mb-1 leading-snug">
                        <a href="/job-postings/{{ $jid }}" class="hover:text-brand-600 transition">
                            {{ $jtitle }}
                        </a>
                    </h3>

                    <div class="flex items-center gap-2 text-xs text-slate-500 mb-3 flex-wrap">
                        <span class="font-semibold text-slate-800">🏢 {{ $jcompany }}</span>
                        <span>&bull;</span>
                        <span>📍 {{ $jcity }}</span>
                        <span>&bull;</span>
                        <a href="/applications?job_posting_id={{ $jid }}" class="font-bold text-brand-600 hover:underline">
                            📋 {{ $appCount }} Başvuru
                        </a>
                    </div>

                    <p class="text-xs text-slate-600 line-clamp-2 leading-relaxed mb-4">
                        {{ $jdesc }}
                    </p>

                    @if($jbenefits)
                    <div class="mb-4 bg-slate-50 p-2.5 rounded-2xl hairline-border text-[11px] text-slate-600 flex items-center gap-1.5">
                        <span class="font-bold text-slate-700">🎁 Avantajlar:</span>
                        <span class="truncate">{{ $jbenefits }}</span>
                    </div>
                    @endif
                </div>

                <!-- Bottom Actions -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-mono text-[11px]">#{{ $jid }}</span>
                    <div class="flex items-center gap-2">
                        <a href="/job-postings/{{ $jid }}" class="px-3.5 py-1.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold transition shadow-sm">
                            İncele &amp; Başvur &rarr;
                        </a>
                        <a href="/job-postings/{{ $jid }}/edit" class="px-2.5 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold border border-amber-200 transition">
                            ✏️
                        </a>
                        <form action="/job-postings/{{ $jid }}" method="POST" class="inline" onsubmit="return confirm('Bu ilanı silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2.5 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold border border-rose-200 transition">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center hairline-border">
                <span class="text-5xl block mb-3">💼</span>
                <h3 class="font-serif-editorial text-xl font-bold text-slate-900 mb-1">Açık İş İlanı Bulunamadı</h3>
                <p class="text-slate-500 text-xs mb-4">Sistemde henüz yayınlanmış aktif bir kariyer fırsatı bulunmuyor.</p>
                <a href="/job-postings/create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-brand-600 text-white rounded-full text-xs font-bold">
                    + İlk İlanı Yayınla
                </a>
            </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Kariyer &amp; İş İlanları Portalı</p>
            <div class="flex items-center gap-4">
                <a href="/main" class="hover:text-brand-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-brand-600 transition">Mezun Rehberi</a>
                <span>&bull;</span>
                <a href="/applications" class="hover:text-brand-600 transition">Başvurular</a>
                <span>&bull;</span>
                <a href="/api/swagger" class="hover:text-brand-600 transition">Swagger API</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Scripts -->
    <script>
        function toggleJobCreate() {
            const card = document.getElementById('quickJobCard');
            const isHidden = card.classList.contains('hidden');
            if (isHidden) {
                card.classList.remove('hidden');
                document.getElementById('jobToggleText').textContent = 'Paneli Kapat';
            } else {
                card.classList.add('hidden');
                document.getElementById('jobToggleText').textContent = 'Hızlı İlan Ekle';
            }
        }

        function filterJobsList() {
            const query = document.getElementById('jobSearchInput').value.toLowerCase();
            const cards = document.querySelectorAll('.job-card');

            cards.forEach(card => {
                const text = card.getAttribute('data-search') || '';
                card.style.display = text.includes(query) ? 'flex' : 'none';
            });
        }

        function filterByWorkplace(type) {
            const cards = document.querySelectorAll('.job-card');
            const btns = document.querySelectorAll('.workplace-filter-btn');

            cards.forEach(card => {
                const wtype = card.getAttribute('data-workplace') || '';
                if (type === 'all' || wtype === type) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
