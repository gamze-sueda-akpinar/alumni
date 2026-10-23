<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title ?? $job['title'] }} - İş İlanı Detayı</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">💼</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/job-postings" class="text-sm font-semibold text-indigo-600 transition px-3 py-2">
                    &larr; İlanlar Listesi
                </a>
                <a href="/applications" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    Başvurular ({{ count($job->applications ?? []) }})
                </a>
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Ana Sayfa</a>
            </div>
        </div>
    </header>

    @php 
        $jid = $job->id ?? $job['id'];
        $title = $job->title ?? $job['title'];
        $company = $job->company_name ?? $job['company_name'];
        $location = $job->location ?? $job['location'] ?? 'İstanbul';
        $type = $job->type ?? $job['type'] ?? 'Tam Zamanlı';
        $description = $job->description ?? $job['description'];
        $requirements = $job->requirements ?? $job['requirements'] ?? null;
        $email = $job->contact_email ?? $job['contact_email'] ?? '—';
        $deadline = $job->application_deadline ?? $job['application_deadline'] ?? 'Belirtilmedi';
        $isActive = ($job->is_active ?? $job['is_active']) ?? true;
        $createdAt = $job->created_at ?? $job['created_at'] ?? '—';
        $updatedAt = $job->updated_at ?? $job['updated_at'] ?? 'Henüz güncellenmedi';
        $applications = $job->applications ?? collect([]);

        $statusColors = [
            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'label' => 'Beklemede'],
            'reviewed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'İncelendi'],
            'shortlisted' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'label' => 'Mülakat'],
            'accepted' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'label' => 'Kabul'],
            'rejected' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-800', 'label' => 'Reddedildi'],
        ];
    @endphp

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <!-- Flash Messages -->
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

        <!-- Action Header -->
        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>🔍</span>
                    <span>İş İlanı #{{ $jid }} &bull; {{ count($applications) }} Kayıtlı Başvuru</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $title }}</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="/applications/create?job_posting_id={{ $jid }}"
                   class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-sm text-sm font-bold transition flex items-center gap-1.5">
                    <span>⚡</span> Hemen Başvur
                </a>
                <a href="/job-postings/{{ $jid }}/edit"
                   class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                    <span>✏️</span> Düzenle
                </a>
                <form action="/job-postings/{{ $jid }}" method="POST" onsubmit="return confirm('Bu iş ilanını silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                        <span>🗑️</span> Sil
                    </button>
                </form>
            </div>
        </div>

        <!-- Job Detail Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-900 px-8 py-6 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-amber-950 flex items-center gap-1">
                            <span>🏢</span> {{ $company }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-400/20 text-indigo-200 border border-indigo-400/30">
                            {{ $type }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-400/20 text-indigo-200 border border-indigo-400/30">
                            📍 {{ $location }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold leading-tight">{{ $title }}</h2>
                    <p class="text-indigo-200 text-sm mt-1">İlan No: <span class="font-semibold text-white">#{{ $jid }}</span></p>
                </div>
                <div class="flex flex-col sm:items-end gap-2">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isActive ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : 'bg-slate-500/20 text-slate-300 border border-slate-400/30' }}">
                        {{ $isActive ? '● Aktif Başvuruya Açık' : '○ Başvuruya Kapalı' }}
                    </span>
                    <a href="/applications?job_posting_id={{ $jid }}" class="text-xs text-indigo-200 hover:text-white underline">
                        {{ count($applications) }} Başvuruyu Listede Filtrele &rarr;
                    </a>
                </div>
            </div>

            <!-- Metadata Info Grid -->
            <div class="p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm border-b border-slate-100 bg-slate-50/50">
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Şirket</span>
                    <span class="text-base font-bold text-slate-800">{{ $company }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Başvuru E-Postası</span>
                    <span class="text-sm font-bold text-indigo-600">{{ $email }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Son Başvuru Tarihi</span>
                    <span class="text-sm font-semibold text-slate-700">{{ $deadline }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Toplam Başvuru</span>
                    <span class="text-base font-bold text-indigo-700">{{ count($applications) }} Aday</span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">İş Tanımı & Sorumluluklar</h3>
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-base whitespace-pre-line bg-slate-50/60 p-6 rounded-xl border border-slate-100">
                        {{ $description }}
                    </div>
                </div>

                @if(!empty($requirements))
                <div>
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Aranan Nitelikler</h3>
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-base whitespace-pre-line bg-slate-50/60 p-6 rounded-xl border border-slate-100">
                        {{ $requirements }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Footer bar -->
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Son Güncelleme: {{ $updatedAt }}</span>
                <a href="/job-postings" class="text-indigo-600 hover:text-indigo-800 font-semibold">&larr; İlanlar Listesine Dön</a>
            </div>
        </div>

        <!-- Received Applications Section -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                        <span>📋</span> Bu İlana Yapılan Başvurular ({{ count($applications) }})
                    </h2>
                    <p class="text-xs text-slate-500 mt-1">İlana mezunlarımız tarafından gönderilen başvurular ve anlık durumları.</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="/applications/create?job_posting_id={{ $jid }}"
                       class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl shadow-xs text-xs font-bold transition flex items-center gap-1.5">
                        <span>+</span> Yeni Aday Başvurusu Ekle
                    </a>
                </div>
            </div>

            @if(count($applications) > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50/70 text-slate-600 text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 font-bold">Aday Bilgisi</th>
                            <th class="py-3 px-4 font-bold">Bölüm / Mezuniyet</th>
                            <th class="py-3 px-4 font-bold">Başvuru Tarihi</th>
                            <th class="py-3 px-4 font-bold">Ön Yazı</th>
                            <th class="py-3 px-4 font-bold">Durum</th>
                            <th class="py-3 px-4 font-bold text-right">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($applications as $app)
                        @php
                            $u = $app->user;
                            $prof = $u->alumniProfile ?? null;
                            $stBadge = $statusColors[$app->status] ?? ['bg' => 'bg-slate-100', 'text' => 'text-slate-700', 'label' => $app->status];
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="py-3.5 px-4">
                                <div class="font-bold text-slate-900">{{ $u->name ?? 'Aday #' . $app->user_id }}</div>
                                <div class="text-xs text-slate-500">{{ $u->email ?? '' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs">
                                <div class="font-semibold text-slate-700">{{ $prof->department->name ?? '—' }}</div>
                                <div class="text-slate-400">Mezuniyet: {{ $prof->graduation_year ?? '—' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">
                                {{ $app->applied_at ? \Carbon\Carbon::parse($app->applied_at)->format('d.m.Y H:i') : '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-xs text-slate-600 max-w-xs truncate">
                                {{ $app->cover_letter ? Str::limit($app->cover_letter, 50) : '—' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $stBadge['bg'] }} {{ $stBadge['text'] }}">
                                    {{ $stBadge['label'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="/applications/{{ $app->id }}"
                                   class="px-3 py-1.5 text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition border border-indigo-200 inline-flex items-center gap-1">
                                    <span>👁️</span> İncele
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="p-8 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center text-sm text-slate-500">
                <span class="text-3xl block mb-2">📭</span>
                Bu iş ilanı için henüz kayıtlı başvuru bulunmamaktadır.
                <div class="mt-3">
                    <a href="/applications/create?job_posting_id={{ $jid }}" class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-200">
                        ⚡ İlk Başvuruyu Şimdi Gönder &rarr;
                    </a>
                </div>
            </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-6xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (MySQL) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
