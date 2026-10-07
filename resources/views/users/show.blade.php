<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name ?? $user['name'] }} - Mezun Detayı</title>
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
                <span class="text-2xl">🎓</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; Mezunlar Listesi (GET /users)
                </a>
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Ana Sayfa</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>🔍</span>
                    <span>GET /users/{id} (Read Single - View Layer)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mezun Profil Detayı</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="/users/{{ $user->id ?? $user['id'] }}/edit"
                   class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                    <span>✏️</span> Düzenle
                </a>
                <form action="/users/{{ $user->id ?? $user['id'] }}" method="POST" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                        <span>🗑️</span> Sil
                    </button>
                </form>
            </div>
        </div>

        <!-- Profile Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-indigo-900 to-indigo-700 px-8 py-6 text-white flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name ?? $user['name'] }}</h2>
                    <p class="text-indigo-200 text-sm mt-0.5">{{ $user->email ?? $user['email'] }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/20 text-emerald-200 border border-emerald-400/30">
                    {{ ucfirst($user->status ?? $user['status'] ?? 'approved') }}
                </span>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kullanıcı ID</span>
                    <span class="text-base font-bold text-slate-800">#{{ $user->id ?? $user['id'] }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Öğrenci Numarası</span>
                    <span class="text-base font-bold text-slate-800">{{ $user->student_number ?? $user['student_number'] ?? '—' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Bölüm</span>
                    <span class="text-base font-bold text-slate-800">{{ $user->department ?? $user['department'] ?? '—' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Mezuniyet Yılı</span>
                    <span class="text-base font-bold text-slate-800">{{ $user->graduation_year ?? $user['graduation_year'] ?? '—' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Mevcut Şirket</span>
                    <span class="text-base font-bold text-indigo-700">{{ $user->current_company ?? $user['current_company'] ?? '—' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Mevcut Pozisyon</span>
                    <span class="text-base font-bold text-indigo-700">{{ $user->current_position ?? $user['current_position'] ?? '—' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">İkamet Şehri</span>
                    <span class="text-base font-bold text-slate-800">{{ $user->city ?? $user['city'] ?? 'İstanbul' }}</span>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kayıt Tarihi</span>
                    <span class="text-base font-bold text-slate-800">{{ $user->created_at ?? $user['created_at'] ?? '—' }}</span>
                </div>
            </div>

            <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Son Güncelleme: {{ $user->updated_at ?? $user['updated_at'] ?? 'Henüz güncellenmedi' }}</span>
                <a href="/users" class="text-indigo-600 hover:text-indigo-800 font-semibold">&larr; Listeye Geri Dön</a>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; MVC View Katmanı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
