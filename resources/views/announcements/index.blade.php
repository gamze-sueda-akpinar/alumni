<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyurular - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">📢</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-emerald-200 inline-flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span> MySQL Veritabanı Bağlantılı
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Mezunlar</a>
                <a href="/announcements" class="text-sm font-semibold text-indigo-600 transition px-3 py-2">Duyurular</a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">İş İlanları</a>
                <a href="/api/swagger" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Swagger UI</a>
                <a href="/admin" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Admin Paneli</a>
                <a href="/announcements/create" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <span>+</span> Yeni Duyuru
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
                    <span>📢</span>
                    <span>Full CRUD: GET & POST /announcements &rarr; AnnouncementController</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Mezuniyet Duyuruları & Etkinlikler</h1>
                <p class="text-sm text-slate-500 mt-1">Mezunlarımıza özel etkinlikler, burslar, mentorluk programları ve resmi duyurular.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700">
                    Toplam Duyuru: <span class="text-indigo-600 font-bold">{{ count($announcements) }}</span>
                </span>
                <a href="/announcements/create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm text-sm font-semibold transition">
                    + Hızlı Ekle
                </a>
            </div>
        </div>

        <!-- Quick Create Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>✨</span> Hızlı Duyuru Yayınla (POST /announcements)
                </h2>
                <span class="text-xs text-emerald-700 font-semibold bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200">🟢 MySQL (announcements) tablosuna doğrudan kaydeder</span>
            </div>

            <form action="/announcements" method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="lg:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Duyuru Başlığı *</label>
                        <input type="text" name="title" required placeholder="Örn: 2026 Mezunlar Zirvesi" value="{{ old('title') }}"
                               class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Kategori</label>
                        <select name="category" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                            <option value="Etkinlik">Etkinlik</option>
                            <option value="Kariyer">Kariyer</option>
                            <option value="Burs & Akademi">Burs & Akademi</option>
                            <option value="Genel" selected>Genel</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Yayınlayan Birim</label>
                        <input type="text" name="author" placeholder="Mezunlar Ofisi" value="{{ old('author', 'Mezunlar Ofisi') }}"
                               class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Duyuru İçeriği *</label>
                    <textarea name="content" rows="3" required placeholder="Duyuru metnini buraya giriniz..."
                              class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">{{ old('content') }}</textarea>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pt-2">
                    <label class="inline-flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="is_pinned" value="1" class="rounded text-indigo-600 focus:ring-indigo-500">
                        <span class="font-medium">📌 Bu duyuruyu başa tuttur (Öne Çıkar)</span>
                    </label>

                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-2">
                        <span>📢</span> Duyuruyu Yayınla
                    </button>
                </div>
            </form>
        </div>

        <!-- Announcements Cards Grid / List -->
        <div class="space-y-4">
            @forelse($announcements as $announcement)
            @php $aid = $announcement->id ?? $announcement['id']; @endphp
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @if($announcement->is_pinned ?? $announcement['is_pinned'] ?? false)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1">
                            <span>📌</span> Öne Çıkan
                        </span>
                        @endif

                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 border border-indigo-200">
                            {{ $announcement->category ?? $announcement['category'] ?? 'Genel' }}
                        </span>

                        <span class="text-xs text-slate-400">
                            ID: #{{ $aid }} &bull; {{ $announcement->created_at ?? $announcement['created_at'] }}
                        </span>
                    </div>

                    <h3 class="text-xl font-bold text-slate-900 mb-2">
                        <a href="/announcements/{{ $aid }}" class="hover:text-indigo-600 transition">
                            {{ $announcement->title ?? $announcement['title'] }}
                        </a>
                    </h3>

                    <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed">
                        {{ $announcement->content ?? $announcement['content'] }}
                    </p>

                    <div class="mt-3 flex items-center gap-4 text-xs text-slate-500 font-medium">
                        <span>✍️ {{ $announcement->author ?? $announcement['author'] ?? 'Mezunlar Ofisi' }}</span>
                        <span>🎯 {{ $announcement->target_audience ?? $announcement['target_audience'] ?? 'Tüm Mezunlar' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t md:border-t-0 pt-4 md:pt-0">
                    <a href="/announcements/{{ $aid }}"
                       class="px-3 py-1.5 text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition border border-indigo-200">
                        👁️ Oku / İncele
                    </a>
                    <a href="/announcements/{{ $aid }}/edit"
                       class="px-3 py-1.5 text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition border border-amber-200">
                        ✏️ Düzenle
                    </a>
                    <form action="/announcements/{{ $aid }}" method="POST" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
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
                <span class="text-4xl block mb-2">📭</span>
                Sistemde henüz yayınlanmış duyuru bulunmamaktadır.
            </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Duyuru Yönetim Katmanı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
