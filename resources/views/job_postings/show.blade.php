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
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">💼</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; İlanlar Listesi (GET /job-postings)
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
    @endphp

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>🔍</span>
                    <span>GET /job-postings/{{ $jid }} (Read Single - View Layer)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">İş İlanı Detayı</h1>
            </div>
            <div class="flex items-center gap-2">
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
                <div class="self-start sm:self-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $isActive ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : 'bg-slate-500/20 text-slate-300 border border-slate-400/30' }}">
                        {{ $isActive ? '● Aktif Başvuruya Açık' : '○ Başvuruya Kapalı' }}
                    </span>
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
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Yayınlanma Tarihi</span>
                    <span class="text-xs font-semibold text-slate-700">{{ $createdAt }}</span>
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

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (In-Memory) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
