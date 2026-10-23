<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş ve Staj Başvuruları - Mezun Takip Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">📋</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200">
                    Başvurular Portalı
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">Ana Sayfa</a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">İş İlanları</a>
                <a href="/applications" class="text-sm font-bold text-indigo-600 border-b-2 border-indigo-600 px-2.5 py-2">Başvurular</a>
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">Mezunlar</a>
                <a href="/announcements" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">Duyurular</a>
                <a href="/admin" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-xs">Admin &rarr;</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        <!-- Flash Notifications -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Title & Action Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>⚡</span>
                    <span>İş Başvuruları ve Aday Değerlendirme Modülü (GET /applications)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kariyer & Staj Başvuruları</h1>
                <p class="text-sm text-slate-500 mt-1">Mezunların iş ilanlarına ilettiği başvurular, ön yazılar ve işveren değerlendirme süreçleri.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/job-postings" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl shadow-xs text-sm font-semibold transition flex items-center gap-1.5">
                    <span>💼</span> İlan Panosu
                </a>
                <a href="/applications/create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                    <span>+</span> Yeni Başvuru Yap
                </a>
            </div>
        </div>

        <!-- Metrics Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
            <a href="/applications" class="bg-white p-4 rounded-2xl border {{ empty($status) ? 'border-indigo-500 ring-2 ring-indigo-100' : 'border-slate-200' }} shadow-xs hover:border-indigo-400 transition">
                <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tüm Başvurular</span>
                <span class="text-2xl font-extrabold text-slate-900">{{ $stats['total'] }}</span>
            </a>
            <a href="/applications?status=pending" class="bg-white p-4 rounded-2xl border {{ $status === 'pending' ? 'border-amber-500 ring-2 ring-amber-100' : 'border-slate-200' }} shadow-xs hover:border-amber-400 transition">
                <span class="block text-xs font-bold text-amber-600 uppercase tracking-wider mb-1">🟡 Beklemede</span>
                <span class="text-2xl font-extrabold text-amber-900">{{ $stats['pending'] }}</span>
            </a>
            <a href="/applications?status=reviewed" class="bg-white p-4 rounded-2xl border {{ $status === 'reviewed' ? 'border-blue-500 ring-2 ring-blue-100' : 'border-slate-200' }} shadow-xs hover:border-blue-400 transition">
                <span class="block text-xs font-bold text-blue-600 uppercase tracking-wider mb-1">🔵 İncelendi</span>
                <span class="text-2xl font-extrabold text-blue-900">{{ $stats['reviewed'] }}</span>
            </a>
            <a href="/applications?status=shortlisted" class="bg-white p-4 rounded-2xl border {{ $status === 'shortlisted' ? 'border-purple-500 ring-2 ring-purple-100' : 'border-slate-200' }} shadow-xs hover:border-purple-400 transition">
                <span class="block text-xs font-bold text-purple-600 uppercase tracking-wider mb-1">🟣 Mülakat</span>
                <span class="text-2xl font-extrabold text-purple-900">{{ $stats['shortlisted'] }}</span>
            </a>
            <a href="/applications?status=accepted" class="bg-white p-4 rounded-2xl border {{ $status === 'accepted' ? 'border-emerald-500 ring-2 ring-emerald-100' : 'border-slate-200' }} shadow-xs hover:border-emerald-400 transition">
                <span class="block text-xs font-bold text-emerald-600 uppercase tracking-wider mb-1">🟢 Kabul</span>
                <span class="text-2xl font-extrabold text-emerald-900">{{ $stats['accepted'] }}</span>
            </a>
            <a href="/applications?status=rejected" class="bg-white p-4 rounded-2xl border {{ $status === 'rejected' ? 'border-rose-500 ring-2 ring-rose-100' : 'border-slate-200' }} shadow-xs hover:border-rose-400 transition">
                <span class="block text-xs font-bold text-rose-600 uppercase tracking-wider mb-1">🔴 Reddedildi</span>
                <span class="text-2xl font-extrabold text-rose-900">{{ $stats['rejected'] }}</span>
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-sm mb-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <form action="/applications" method="GET" class="w-full flex flex-col sm:flex-row items-center gap-3 flex-1">
                <div class="relative flex-1 w-full">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">🔍</span>
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Aday adı, e-posta, şirket veya ilan başlığı ile ara..."
                           class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                </div>

                <select name="job_posting_id" class="w-full sm:w-64 py-2 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Tüm İlanlar</option>
                    @foreach($jobPostings as $jp)
                        <option value="{{ $jp->id }}" {{ ($jobId ?? '') == $jp->id ? 'selected' : '' }}>
                            {{ $jp->company_name }} - {{ Str::limit($jp->title, 30) }}
                        </option>
                    @endforeach
                </select>

                <select name="status" class="w-full sm:w-44 py-2 px-3 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <option value="">Tüm Durumlar</option>
                    <option value="pending" {{ ($status ?? '') === 'pending' ? 'selected' : '' }}>🟡 Beklemede</option>
                    <option value="reviewed" {{ ($status ?? '') === 'reviewed' ? 'selected' : '' }}>🔵 İncelendi</option>
                    <option value="shortlisted" {{ ($status ?? '') === 'shortlisted' ? 'selected' : '' }}>🟣 Mülakatta</option>
                    <option value="accepted" {{ ($status ?? '') === 'accepted' ? 'selected' : '' }}>🟢 Kabul Edildi</option>
                    <option value="rejected" {{ ($status ?? '') === 'rejected' ? 'selected' : '' }}>🔴 Reddedildi</option>
                </select>

                <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-sm font-semibold transition">
                    Filtrele
                </button>

                @if(!empty($search) || !empty($jobId) || !empty($status))
                <a href="/applications" class="w-full sm:w-auto px-3 py-2 text-slate-500 hover:text-slate-800 text-sm font-medium text-center">
                    Temizle
                </a>
                @endif
            </form>
        </div>

        <!-- Applications Table Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($applications->isEmpty())
                <div class="p-16 text-center text-slate-500">
                    <span class="text-5xl block mb-3">📭</span>
                    <h3 class="text-lg font-bold text-slate-800">Başvuru Bulunamadı</h3>
                    <p class="text-sm text-slate-500 mt-1">Arama kriterlerinize uyan bir başvuru kaydı bulunamadı veya henüz başvuru yapılmadı.</p>
                    <div class="mt-6 flex justify-center gap-3">
                        <a href="/applications/create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-semibold transition">
                            Yeni Başvuru Oluştur
                        </a>
                        <a href="/job-postings" class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl text-sm font-semibold transition">
                            İş İlanlarını Görüntüle
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-500 uppercase text-xs font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Başvuran Aday</th>
                                <th class="px-6 py-4">Başvurulan İlan & Şirket</th>
                                <th class="px-6 py-4">Ön Yazı / Motivasyon</th>
                                <th class="px-6 py-4">Durum</th>
                                <th class="px-6 py-4">Tarih</th>
                                <th class="px-6 py-4 text-right">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach($applications as $app)
                                <tr class="hover:bg-slate-50/80 transition group">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-400">#{{ $app->id }}</td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900 flex items-center gap-1.5">
                                            <span>👤</span>
                                            <span>{{ $app->user?->name ?? 'Kullanıcı #' . $app->user_id }}</span>
                                        </div>
                                        <div class="text-xs text-slate-400 pl-6">{{ $app->user?->email }}</div>
                                        @if($app->user?->alumniProfile?->department)
                                            <div class="text-xs text-indigo-600 font-medium pl-6 mt-0.5">
                                                🎓 {{ $app->user->alumniProfile->department->name }} ({{ $app->user->alumniProfile->graduation_year ?? '—' }})
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-bold text-indigo-900 hover:text-indigo-600 transition">
                                            <a href="/job-postings/{{ $app->job_posting_id }}">
                                                {{ $app->jobPosting?->title ?? 'İlan #' . $app->job_posting_id }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-slate-500 flex items-center gap-2 mt-0.5">
                                            <span class="font-semibold text-slate-700">🏢 {{ $app->jobPosting?->company_name }}</span>
                                            <span>&bull;</span>
                                            <span>📍 {{ $app->jobPosting?->location }}</span>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 max-w-xs">
                                        @if(!empty($app->cover_letter))
                                            <p class="text-xs text-slate-600 line-clamp-2 italic" title="{{ $app->cover_letter }}">
                                                "{{ $app->cover_letter }}"
                                            </p>
                                        @else
                                            <span class="text-xs text-slate-400">—</span>
                                        @endif
                                        @if(!empty($app->resume_path))
                                            <span class="inline-flex items-center gap-1 text-[11px] text-indigo-600 font-semibold mt-1">
                                                📎 CV Eklendi
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $badges = [
                                                'pending' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-700', 'border' => 'border-amber-200', 'label' => '🟡 Beklemede'],
                                                'reviewed' => ['bg' => 'bg-blue-50', 'text' => 'text-blue-700', 'border' => 'border-blue-200', 'label' => '🔵 İncelendi'],
                                                'shortlisted' => ['bg' => 'bg-purple-50', 'text' => 'text-purple-700', 'border' => 'border-purple-200', 'label' => '🟣 Mülakatta'],
                                                'accepted' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-700', 'border' => 'border-emerald-200', 'label' => '🟢 Kabul Edildi'],
                                                'rejected' => ['bg' => 'bg-rose-50', 'text' => 'text-rose-700', 'border' => 'border-rose-200', 'label' => '🔴 Reddedildi'],
                                            ];
                                            $b = $badges[$app->status] ?? ['bg' => 'bg-slate-50', 'text' => 'text-slate-700', 'border' => 'border-slate-200', 'label' => $app->status];
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold border {{ $b['bg'] }} {{ $b['text'] }} {{ $b['border'] }}">
                                            {{ $b['label'] }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                        {{ $app->applied_at ? $app->applied_at->format('d.m.Y H:i') : $app->created_at->format('d.m.Y') }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="/applications/{{ $app->id }}"
                                               class="px-3 py-1.5 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg text-xs font-bold transition border border-indigo-200">
                                                İncele &rarr;
                                            </a>
                                            <form action="/applications/{{ $app->id }}" method="POST" onsubmit="return confirm('Bu başvuruyu silmek istediğinize emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg text-xs font-semibold transition border border-rose-200" title="Sil">
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
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Kariyer & Başvuru Yönetimi &bull; Gamze Şüeda Akpınar</p>
            <div class="flex items-center gap-4 text-xs font-semibold text-slate-400">
                <a href="/job-postings" class="hover:text-indigo-600">İş İlanları</a>
                <span>&bull;</span>
                <a href="/applications" class="hover:text-indigo-600">Başvurular</a>
                <span>&bull;</span>
                <a href="/api/swagger" class="hover:text-indigo-600">REST API</a>
            </div>
        </div>
    </footer>

</body>
</html>
