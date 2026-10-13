<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title ?? $announcement['title'] }} Düzenle - Mezun Takip Sistemi</title>
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
                <a href="/announcements/{{ $announcement->id ?? $announcement['id'] }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; Duyuru Detayına Dön
                </a>
                <a href="/announcements" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Duyurular Listesi</a>
            </div>
        </div>
    </header>

    @php
        $aid = $announcement->id ?? $announcement['id'];
        $currentCategory = old('category', $announcement->category ?? $announcement['category'] ?? 'Genel');
        $currentStatus = old('status', $announcement->status ?? $announcement['status'] ?? 'published');
        $isPinned = old('is_pinned', $announcement->is_pinned ?? $announcement['is_pinned'] ?? false);
    @endphp

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-semibold">
                <span>⚠️</span> Lütfen formdaki hataları kontrol ediniz:
            </div>
            <ul class="list-disc list-inside text-sm space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <div class="mb-6 pb-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-100 text-amber-700 text-xs font-semibold mb-2">
                        <span>✏️</span>
                        <span>PUT /announcements/{id} (Update - View Layer)</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Duyuru Bilgilerini Düzenle</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        #{{ $aid }} numaralı duyurunun alanlarını güncelleyiniz.
                    </p>
                </div>
                <span class="text-3xl">📢</span>
            </div>

            <form action="/announcements/{{ $aid }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Duyuru Başlığı *</label>
                    <input type="text" name="title" required
                           value="{{ old('title', $announcement->title ?? $announcement['title'] ?? '') }}"
                           class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Kategori</label>
                        <select name="category" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            <option value="Etkinlik" {{ $currentCategory === 'Etkinlik' ? 'selected' : '' }}>Etkinlik</option>
                            <option value="Kariyer" {{ $currentCategory === 'Kariyer' ? 'selected' : '' }}>Kariyer</option>
                            <option value="Burs & Akademi" {{ $currentCategory === 'Burs & Akademi' ? 'selected' : '' }}>Burs & Akademi</option>
                            <option value="Genel" {{ $currentCategory === 'Genel' ? 'selected' : '' }}>Genel</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Yayınlayan Birim / Yazar</label>
                        <input type="text" name="author"
                               value="{{ old('author', $announcement->author ?? $announcement['author'] ?? 'Mezunlar Ofisi') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Hedef Kitle</label>
                        <input type="text" name="target_audience"
                               value="{{ old('target_audience', $announcement->target_audience ?? $announcement['target_audience'] ?? 'Tüm Mezunlar') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Durum</label>
                        <select name="status" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            <option value="published" {{ $currentStatus === 'published' ? 'selected' : '' }}>Yayında (published)</option>
                            <option value="draft" {{ $currentStatus === 'draft' ? 'selected' : '' }}>Taslak (draft)</option>
                            <option value="archived" {{ $currentStatus === 'archived' ? 'selected' : '' }}>Arşivlendi (archived)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Duyuru Detayı / İçerik *</label>
                    <textarea name="content" rows="6" required
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('content', $announcement->content ?? $announcement['content'] ?? '') }}</textarea>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="block text-sm font-semibold text-slate-800">Başa Tuttur (Öne Çıkar)</span>
                        <span class="text-xs text-slate-500">Bu duyuru listenin en başında vurgulanır.</span>
                    </div>
                    <input type="checkbox" name="is_pinned" value="1" {{ $isPinned ? 'checked' : '' }}
                           class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="/announcements" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                        İptal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-amber-500 hover:bg-amber-600 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                        <span>💾</span> Değişiklikleri Kaydet
                    </button>
                </div>
            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Duyuru Yönetim Katmanı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
