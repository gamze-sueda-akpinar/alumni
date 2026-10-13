<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş İlanları ve Kariyer - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">💼</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200">
                    Kariyer & İlan Modülü (In-Memory)
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Mezunlar</a>
                <a href="/announcements" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Duyurular</a>
                <a href="/job-postings" class="text-sm font-semibold text-indigo-600 transition px-3 py-2">İş İlanları</a>
                <a href="/api/swagger" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Swagger UI</a>
                <a href="/admin" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Admin Paneli</a>
                <a href="/job-postings/create" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <span>+</span> Yeni İlan Ver
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        <!-- Flash Message (Success) -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Flash Message (Error) -->
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-semibold">
                <span>⚠️</span> Lütfen aşağıdaki alanları kontrol ediniz:
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Title & Stats Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>💼</span>
                    <span>Full CRUD: GET & POST /job-postings &rarr; JobPostingController</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kariyer Fırsatları & İş İlanları</h1>
                <p class="text-sm text-slate-500 mt-1">Mezunlarımız ve partner teknoloji şirketleri tarafından paylaşılan aktif kariyer ilanları.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700">
                    Toplam İlan: <span class="text-indigo-600 font-bold">{{ count($jobPostings) }}</span>
                </span>
                <a href="/job-postings/create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm text-sm font-semibold transition">
                    + Hızlı İlan Ekle
                </a>
            </div>
        </div>

        <!-- Quick Create Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>✨</span> Hızlı İş İlanı Yayınla (POST /job-postings)
                </h2>
                <span class="text-xs text-slate-400">Veritabanı gerektirmeden bellekte (cache) saklanır</span>
            </div>

            <form action="/job-postings" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Pozisyon / Unvan *</label>
                        <input type="text" name="title" required placeholder="Örn: Senior Backend Developer" value="{{ old('title') }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Şirket Adı *</label>
                        <input type="text" name="company_name" required placeholder="Örn: Getir, Trendyol" value="{{ old('company_name') }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Konum / Çalışma Modeli</label>
                        <input type="text" name="location" placeholder="İstanbul (Hibrit)" value="{{ old('location', 'İstanbul (Hibrit)') }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Çalışma Şekli</label>
                        <select name="type" class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            <option value="Tam Zamanlı" selected>Tam Zamanlı</option>
                            <option value="Yarı Zamanlı">Yarı Zamanlı</option>
                            <option value="Staj">Staj</option>
                            <option value="Sözleşmeli">Sözleşmeli / Proje Bazlı</option>
                            <option value="Uzaktan">Tamamen Uzaktan (Remote)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Başvuru E-Postası</label>
                        <input type="email" name="contact_email" placeholder="ik@sirket.com" value="{{ old('contact_email', 'kariyer@alumni.edu.tr') }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Son Başvuru Tarihi</label>
                        <input type="date" name="application_deadline" value="{{ old('application_deadline') }}"
                               class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">İş & Görev Tanımı *</label>
                    <textarea name="description" rows="2" required placeholder="Pozisyon görevleri, proje kapsamı vb."
                              class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Aranan Nitelikler & Beceriler</label>
                    <input type="text" name="requirements" placeholder="Örn: PHP, Laravel, Docker, REST API" value="{{ old('requirements') }}"
                           class="w-full px-3.5 py-2 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="inline-flex items-center gap-2 text-xs font-semibold text-slate-600 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="h-4 w-4 text-indigo-600 rounded">
                        <span>İlan hemen aktif olsun</span>
                    </label>

                    <button type="submit"
                            class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-1.5">
                        <span>📢</span> İlanı Yayınla
                    </button>
                </div>
            </form>
        </div>

        <!-- Job Postings List Cards -->
        <div class="space-y-4">
            @forelse($jobPostings as $job)
            @php $jid = $job->id ?? $job['id']; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-200 flex items-center gap-1">
                            <span>🏢</span> {{ $job->company_name ?? $job['company_name'] }}
                        </span>

                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                            {{ $job->type ?? $job['type'] ?? 'Tam Zamanlı' }}
                        </span>

                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                            📍 {{ $job->location ?? $job['location'] ?? 'İstanbul' }}
                        </span>

                        @if(($job->is_active ?? $job['is_active']) ?? true)
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                            ● Aktif
                        </span>
                        @else
                        <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                            ○ Kapalı
                        </span>
                        @endif

                        <span class="text-xs text-slate-400">
                            ID: #{{ $jid }} &bull; {{ $job->created_at ?? $job['created_at'] }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">
                        <a href="/job-postings/{{ $jid }}" class="hover:text-indigo-600 transition">
                            {{ $job->title ?? $job['title'] }}
                        </a>
                    </h3>

                    <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $job->description ?? $job['description'] }}
                    </p>

                    @if(!empty($job->requirements ?? $job['requirements']))
                    <p class="text-xs text-slate-500 mt-2 bg-slate-50 p-2 rounded-lg border border-slate-100">
                        <span class="font-semibold text-slate-700">Aranan Beceriler:</span> {{ $job->requirements ?? $job['requirements'] }}
                    </p>
                    @endif

                    <div class="mt-3 flex flex-wrap items-center gap-4 text-xs text-slate-500 font-medium">
                        <span>✉️ Başvuru: <strong class="text-indigo-600">{{ $job->contact_email ?? $job['contact_email'] ?? '—' }}</strong></span>
                        @if(!empty($job->application_deadline ?? $job['application_deadline']))
                        <span>⏰ Son Başvuru: <strong>{{ $job->application_deadline ?? $job['application_deadline'] }}</strong></span>
                        @endif
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t md:border-t-0 pt-4 md:pt-0">
                    <a href="/job-postings/{{ $jid }}"
                       class="px-3 py-1.5 text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition border border-indigo-200">
                        👁️ İncele
                    </a>
                    <a href="/job-postings/{{ $jid }}/edit"
                       class="px-3 py-1.5 text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition border border-amber-200">
                        ✏️ Düzenle
                    </a>
                    <form action="/job-postings/{{ $jid }}" method="POST" onsubmit="return confirm('Bu iş ilanını silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-3 py-1.5 text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition border border-rose-200">
                            🗑️ Sil
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-500">
                <span class="text-4xl block mb-2">💼</span>
                Sistemde henüz yayınlanmış iş ilanı bulunmamaktadır.
            </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (In-Memory) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
