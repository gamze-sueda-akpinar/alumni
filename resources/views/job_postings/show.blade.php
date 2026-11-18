<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title ?? $job['title'] }} | İş İlanı Detayı</title>
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

    @php 
        $jid = $job->id ?? $job['id'];
        $jtitle = $job->title ?? $job['title'];
        $jcompany = $job->company_name ?? $job['company_name'];
        $wtype = strtolower($job->workplace_type ?? $job['workplace_type'] ?? 'remote');
        $jsalary = $job->salary ?? $job['salary'] ?? null;
        $jcity = $job->city ?? $job['city'] ?? $job->location ?? $job['location'] ?? 'İstanbul';
        $jdesc = $job->description ?? $job['description'] ?? 'Detaylı görev açıklaması ilanda belirtilmemiştir.';
        $jbenefits = $job->benefits ?? $job['benefits'] ?? null;
        $jreqs = $job->requirements ?? $job['requirements'] ?? null;
        $jcreated = $job->created_at ?? $job['created_at'] ?? 'Bugün';
        $applications = $job->applications ?? collect([]);

        $typeBadge = match($wtype) {
            'remote' => ['label' => '🟢 Uzaktan / Remote', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            'hybrid' => ['label' => '🟠 Hibrit / Hybrid', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
            'in-office' => ['label' => '🔵 Ofiste / In-Office', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
            default => ['label' => '🟢 ' . ucfirst($wtype), 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        };
    @endphp

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-600 flex items-center justify-center text-white text-xl">
                    💼
                </div>
                <span class="font-bold text-lg text-slate-900">Mezun Takip Sistemi</span>
            </a>

            <div class="flex items-center gap-3">
                <a href="/job-postings" class="text-xs font-bold text-slate-600 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                    &larr; Tüm İlanlar
                </a>
                <a href="/job-postings/{{ $jid }}/edit" class="text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 hover:bg-amber-100 px-3.5 py-2 rounded-full transition">
                    ✏️ Düzenle
                </a>
            </div>
        </div>
    </header>

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

        <!-- Job Hero Banner -->
        <div class="bg-gradient-to-br from-slate-900 via-indigo-950 to-brand-950 text-white rounded-3xl p-8 sm:p-10 hairline-border shadow-xl mb-8 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-2 mb-3 flex-wrap">
                        <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $typeBadge['class'] }}">
                            {{ $typeBadge['label'] }}
                        </span>

                        @if($jsalary)
                        <span class="font-mono text-xs font-bold bg-[#8ed462] text-slate-950 px-3 py-1 rounded-full shadow-sm">
                            ₺{{ number_format((float)$jsalary, 0, ',', '.') }} / ay
                        </span>
                        @endif

                        <span class="text-xs text-slate-400 font-mono">İlan No: #{{ $jid }}</span>
                    </div>

                    <h1 class="font-serif-editorial text-2xl sm:text-4xl font-bold tracking-tight text-white mb-2">
                        {{ $jtitle }}
                    </h1>
                    
                    <p class="text-brand-200 text-sm sm:text-base font-medium flex items-center gap-2">
                        <span>🏢 {{ $jcompany }}</span>
                        <span>&bull;</span>
                        <span>📍 {{ $jcity }}</span>
                        <span>&bull;</span>
                        <span>📅 {{ $jcreated }}</span>
                    </p>
                </div>

                <div>
                    <a href="#applyCard" class="px-7 py-3.5 bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold rounded-2xl text-xs transition shadow-lg flex items-center justify-center gap-2">
                        <span>🚀</span> Pozisyona Başvur
                    </a>
                </div>
            </div>
        </div>

        <!-- 2-Column Job Layout -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Main Job Details & Application Form (2 Cols) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Description Card -->
                <div class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span>📋</span> Pozisyon Tanımı &amp; Sorumluluklar
                    </h3>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed space-y-3">
                        <p>{{ $jdesc }}</p>
                    </div>
                </div>

                @if($jreqs)
                <div class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span>🎯</span> Aranan Beceriler &amp; Nitelikler
                    </h3>
                    <div class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        <p>{{ $jreqs }}</p>
                    </div>
                </div>
                @endif

                @if($jbenefits)
                <div class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-base mb-4 flex items-center gap-2">
                        <span>🎁</span> Sunulan Avantajlar &amp; Yan Haklar (Benefits)
                    </h3>
                    <div class="text-xs sm:text-sm text-emerald-800 bg-emerald-50/60 p-4 rounded-2xl hairline-border leading-relaxed">
                        <p>{{ $jbenefits }}</p>
                    </div>
                </div>
                @endif

                <!-- Application Submission Card -->
                <div id="applyCard" class="bg-white rounded-3xl p-7 hairline-border shadow-sm">
                    <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-100">
                        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                            <span>🚀</span> Hızlı İş Başvurusu
                        </h3>
                        <span class="text-xs text-brand-700 bg-brand-50 px-2.5 py-0.5 rounded-full border border-brand-200">
                            Doğrudan İlan Sahibine İletilir
                        </span>
                    </div>

                    <form action="/applications" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="job_posting_id" value="{{ $jid }}">

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Adınız ve Soyadınız *</label>
                            <input type="text" name="applicant_name" required placeholder="Örn: Mehmet Can"
                                   class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">E-Posta Adresiniz *</label>
                            <input type="email" name="applicant_email" required placeholder="mehmet@example.com"
                                   class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Özgeçmiş / LinkedIn / GitHub Bağlantısı</label>
                            <input type="url" name="resume_url" placeholder="https://linkedin.com/in/... veya CV linki"
                                   class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1">Ön Yazı / Motivasyon Notu</label>
                            <textarea name="cover_letter" rows="3" placeholder="Bu pozisyon için neden uygun olduğunuzu kısaca açıklayınız..."
                                      class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3.5 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-2xl text-xs transition shadow-md flex items-center justify-center gap-2">
                            <span>📤</span> Başvurumu Gönder
                        </button>
                    </form>
                </div>

            </div>

            <!-- Sidebar: Job Metadata & Applications (1 Col) -->
            <div class="space-y-6">
                <!-- Meta Info Card -->
                <div class="bg-white rounded-3xl p-6 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span>ℹ️</span> İlan Bilgileri
                    </h3>
                    <div class="space-y-3 text-xs">
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Şirket</span>
                            <span class="font-bold text-slate-800 text-sm">{{ $jcompany }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Çalışma Şekli</span>
                            <span class="font-bold text-slate-800">{{ $typeBadge['label'] }}</span>
                        </div>
                        @if($jsalary)
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Taban Ücret</span>
                            <span class="font-bold text-emerald-700 font-mono text-sm">₺{{ number_format((float)$jsalary, 0, ',', '.') }} / ay</span>
                        </div>
                        @endif
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Konum</span>
                            <span class="font-bold text-slate-800">📍 {{ $jcity }}</span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-2xl hairline-border">
                            <span class="text-slate-400 block mb-0.5">Yayın Tarihi</span>
                            <span class="font-bold text-slate-800">{{ $jcreated }}</span>
                        </div>
                    </div>
                </div>

                <!-- Applications Count Card -->
                <div class="bg-white rounded-3xl p-6 hairline-border shadow-sm">
                    <h3 class="font-bold text-slate-900 text-xs uppercase tracking-wider mb-3 flex items-center justify-between">
                        <span>📋 Başvurular</span>
                        <span class="font-mono text-brand-600">{{ count($applications) }} Kayıt</span>
                    </h3>
                    <p class="text-xs text-slate-500 mb-4">
                        Bu pozisyona sistem üzerinden gönderilen tüm başvurular incelenmektedir.
                    </p>
                    <a href="/applications?job_posting_id={{ $jid }}" class="block text-center py-2.5 bg-slate-100 hover:bg-slate-200 rounded-xl text-xs font-bold text-slate-800 transition">
                        Başvuru Havuzunu Yönet &rarr;
                    </a>
                </div>
            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-xs text-slate-500">
        <div class="max-w-6xl mx-auto px-4 flex items-center justify-between">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; İş İlanı Detayı</p>
            <a href="/job-postings" class="text-brand-600 font-semibold hover:underline">&larr; İlanlar Listesine Dön</a>
        </div>
    </footer>

</body>
</html>
