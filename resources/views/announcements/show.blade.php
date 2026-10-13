<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title ?? $announcement['title'] }} - Duyuru Detayı</title>
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
                <span class="text-2xl">📢</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/announcements" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; Duyurular Listesi (GET /announcements)
                </a>
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Ana Sayfa</a>
            </div>
        </div>
    </header>

    @php 
        $aid = $announcement->id ?? $announcement['id'];
        $title = $announcement->title ?? $announcement['title'];
        $content = $announcement->content ?? $announcement['content'];
        $category = $announcement->category ?? $announcement['category'] ?? 'Genel';
        $author = $announcement->author ?? $announcement['author'] ?? 'Mezunlar Ofisi';
        $targetAudience = $announcement->target_audience ?? $announcement['target_audience'] ?? 'Tüm Mezunlar';
        $isPinned = $announcement->is_pinned ?? $announcement['is_pinned'] ?? false;
        $status = $announcement->status ?? $announcement['status'] ?? 'published';
        $publishedAt = $announcement->published_at ?? $announcement['published_at'] ?? '—';
        $createdAt = $announcement->created_at ?? $announcement['created_at'] ?? '—';
        $updatedAt = $announcement->updated_at ?? $announcement['updated_at'] ?? 'Henüz güncellenmedi';
    @endphp

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>🔍</span>
                    <span>GET /announcements/{{ $aid }} (Read Single - View Layer)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Duyuru Detayı</h1>
            </div>
            <div class="flex items-center gap-2">
                <a href="/announcements/{{ $aid }}/edit"
                   class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                    <span>✏️</span> Düzenle
                </a>
                <form action="/announcements/{{ $aid }}" method="POST" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                        <span>🗑️</span> Sil
                    </button>
                </form>
            </div>
        </div>

        <!-- Announcement Detail Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-900 px-8 py-6 text-white flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        @if($isPinned)
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-400 text-amber-950 flex items-center gap-1">
                            <span>📌</span> Öne Çıkan Duyuru
                        </span>
                        @endif
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-400/20 text-indigo-200 border border-indigo-400/30">
                            {{ $category }}
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold leading-tight">{{ $title }}</h2>
                    <p class="text-indigo-200 text-sm mt-1">Yayınlayan: <span class="font-semibold text-white">{{ $author }}</span></p>
                </div>
                <div class="self-start sm:self-center">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $status === 'published' ? 'bg-emerald-500/20 text-emerald-200 border border-emerald-400/30' : 'bg-amber-500/20 text-amber-200 border border-amber-400/30' }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>
            </div>

            <!-- Metadata Info Grid -->
            <div class="p-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 text-sm border-b border-slate-100 bg-slate-50/50">
                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Duyuru No</span>
                    <span class="text-base font-bold text-slate-800">#{{ $aid }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Hedef Kitle</span>
                    <span class="text-base font-bold text-indigo-700">{{ $targetAudience }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Yayın Tarihi</span>
                    <span class="text-xs font-semibold text-slate-700">{{ $publishedAt }}</span>
                </div>

                <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-xs">
                    <span class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Kayıt Tarihi</span>
                    <span class="text-xs font-semibold text-slate-700">{{ $createdAt }}</span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="p-8">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider mb-3">Duyuru Metni</h3>
                <div class="prose max-w-none text-slate-700 leading-relaxed text-base whitespace-pre-line bg-slate-50/60 p-6 rounded-xl border border-slate-100">
                    {{ $content }}
                </div>
            </div>

            <!-- Footer bar -->
            <div class="px-8 py-4 bg-slate-50 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>Son Güncelleme: {{ $updatedAt }}</span>
                <a href="/announcements" class="text-indigo-600 hover:text-indigo-800 font-semibold">&larr; Duyurular Listesine Dön</a>
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
