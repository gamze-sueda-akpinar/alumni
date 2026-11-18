<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş ve Staj Başvuruları | Mezun Takip Sistemi</title>
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

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-violet-600 via-indigo-700 to-slate-900 flex items-center justify-center text-white text-2xl shadow-sm group-hover:scale-105 transition-transform">
                    📋
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Applications &amp; Candidate Tracking
                    </span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/70">
                <a href="/main" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Ana Sayfa</a>
                <a href="/users" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Mezunlar</a>
                <a href="/job-postings" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Duyurular</a>
                <a href="/applications" class="text-xs font-bold text-brand-700 bg-white px-4 py-2 rounded-full shadow-sm transition">Başvurular</a>
                <a href="/about" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Hakkımızda</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/job-postings" class="text-xs font-bold text-slate-700 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                    İş İlanlarına Git &rarr;
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

        <!-- Banner -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-violet-50 border border-violet-100 text-violet-700 text-xs font-semibold mb-3">
                    <span>📋</span>
                    <span>Aday &amp; Başvuru Takip Portalı (ATS)</span>
                </div>
                <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                    Kariyer &amp; Staj Başvuruları
                </h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Açık pozisyonlara gönderilen başvurular, değerlendirme durumları ve aday özgeçmişleri.
                </p>
            </div>
        </div>

        <!-- Metric Badges Row -->
        @if(isset($stats))
        <div class="grid grid-cols-2 sm:grid-cols-6 gap-3 mb-8">
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-slate-400 font-bold uppercase block">Toplam</span>
                <span class="text-xl font-extrabold text-slate-900 font-mono">{{ $stats['total'] ?? 0 }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-amber-600 font-bold uppercase block">Beklemede</span>
                <span class="text-xl font-extrabold text-amber-600 font-mono">{{ $stats['pending'] ?? 0 }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-blue-600 font-bold uppercase block">İncelendi</span>
                <span class="text-xl font-extrabold text-blue-600 font-mono">{{ $stats['reviewed'] ?? 0 }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-purple-600 font-bold uppercase block">Mülakat</span>
                <span class="text-xl font-extrabold text-purple-600 font-mono">{{ $stats['shortlisted'] ?? 0 }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-emerald-600 font-bold uppercase block">Kabul</span>
                <span class="text-xl font-extrabold text-emerald-600 font-mono">{{ $stats['accepted'] ?? 0 }}</span>
            </div>
            <div class="bg-white p-4 rounded-2xl hairline-border text-center">
                <span class="text-[11px] text-rose-600 font-bold uppercase block">Red</span>
                <span class="text-xl font-extrabold text-rose-600 font-mono">{{ $stats['rejected'] ?? 0 }}</span>
            </div>
        </div>
        @endif

        <!-- Applications Grid / Table -->
        <div class="bg-white rounded-3xl hairline-border shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/70 border-b border-slate-200 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="py-4 px-5"># ID</th>
                            <th class="py-4 px-5">Aday Bilgisi</th>
                            <th class="py-4 px-5">İlgili İş İlanı &amp; Şirket</th>
                            <th class="py-4 px-5">Başvuru Tarihi</th>
                            <th class="py-4 px-5">Durum</th>
                            <th class="py-4 px-5 text-right">İşlem</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse($applications as $app)
                        @php 
                            $appid = $app->id ?? $app['id'];
                            $applicantName = $app->applicant_name ?? $app['applicant_name'] ?? ($app->user->name ?? 'Aday');
                            $applicantEmail = $app->applicant_email ?? $app['applicant_email'] ?? ($app->user->email ?? '—');
                            $jobTitle = $app->jobPosting->title ?? $app['job_posting']['title'] ?? 'İlan #' . ($app->job_posting_id ?? '');
                            $company = $app->jobPosting->company_name ?? $app['job_posting']['company_name'] ?? 'Şirket';
                            $status = $app->status ?? $app['status'] ?? 'pending';
                            $appliedAt = $app->applied_at ?? $app['applied_at'] ?? $app->created_at ?? '—';

                            $statusBadge = match($status) {
                                'pending' => ['label' => 'Beklemede', 'class' => 'bg-amber-50 text-amber-700 border-amber-200'],
                                'reviewed' => ['label' => 'İncelendi', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                                'shortlisted' => ['label' => 'Mülakata Alındı', 'class' => 'bg-purple-50 text-purple-700 border-purple-200'],
                                'accepted' => ['label' => 'Kabul Edildi', 'class' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                                'rejected' => ['label' => 'Reddedildi', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'],
                                default => ['label' => ucfirst($status), 'class' => 'bg-slate-50 text-slate-700 border-slate-200'],
                            };
                        @endphp
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3.5 px-5 font-mono text-slate-400">#{{ $appid }}</td>
                            <td class="py-3.5 px-5">
                                <span class="font-bold text-slate-900 block text-sm">{{ $applicantName }}</span>
                                <span class="text-slate-400 text-[11px]">{{ $applicantEmail }}</span>
                            </td>
                            <td class="py-3.5 px-5">
                                <span class="font-semibold text-slate-800 block">{{ $jobTitle }}</span>
                                <span class="text-brand-600 font-medium text-[11px]">🏢 {{ $company }}</span>
                            </td>
                            <td class="py-3.5 px-5 font-mono text-slate-500">{{ $appliedAt }}</td>
                            <td class="py-3.5 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border {{ $statusBadge['class'] }}">
                                    {{ $statusBadge['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-5 text-right whitespace-nowrap">
                                <a href="/applications/{{ $appid }}" class="px-3 py-1.5 rounded-xl bg-violet-50 hover:bg-violet-100 text-violet-700 font-semibold border border-violet-200 transition">
                                    Başvuruyu İncele &rarr;
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">📭</span>
                                Sistemde henüz kayıtlı başvuru bulunmuyor.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Başvuru Takip Modülü</p>
            <div class="flex items-center gap-4">
                <a href="/main" class="hover:text-brand-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-brand-600 transition">İş İlanları</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-brand-600 transition">Mezunlar</a>
            </div>
        </div>
    </footer>

</body>
</html>
