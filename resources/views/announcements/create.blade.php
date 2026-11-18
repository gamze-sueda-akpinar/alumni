<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni Duyuru Yayınla | Mezun Takip Sistemi</title>
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
<body class="text-slate-800 antialiased min-h-screen flex flex-col justify-between">

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500 flex items-center justify-center text-white text-xl">
                    📢
                </div>
                <span class="font-bold text-lg text-slate-900">Mezun Takip Sistemi</span>
            </a>
            <a href="/announcements" class="text-xs font-bold text-slate-600 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                &larr; Duyurular Listesi
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        @if($errors->any())
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm text-xs">
            <div class="flex items-center gap-2 mb-2 font-bold text-sm">
                <span>⚠️</span> Lütfen aşağıdaki alanları kontrol ediniz:
            </div>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white rounded-3xl p-8 sm:p-10 hairline-border shadow-sm">
            <div class="mb-8 pb-6 border-b border-slate-100">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-widest bg-amber-50 px-3 py-1 rounded-full border border-amber-200">
                    Etkinlik &bull; YENİ DUYURU
                </span>
                <h1 class="font-serif-editorial text-2xl sm:text-3xl font-bold text-slate-900 mt-3 mb-1">
                    Yeni Duyuru veya Etkinlik Yayınla
                </h1>
                <p class="text-xs text-slate-500">
                    Tüm mezunlarımızın ana sayfa ve duyurular akışında göreceği kurumsal bilgilendirme oluşturun.
                </p>
            </div>

            <form action="/announcements" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Duyuru Başlığı *</label>
                    <input type="text" name="title" required placeholder="Örn: 2026 Mezunlar Günü Geleneksel Buluşması" value="{{ old('title') }}"
                           class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Kategori</label>
                        <select name="category" class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            <option value="Etkinlik" {{ old('category') == 'Etkinlik' ? 'selected' : '' }}>🎉 Etkinlik / Buluşma</option>
                            <option value="Kariyer" {{ old('category') == 'Kariyer' ? 'selected' : '' }}>💼 Kariyer &amp; Zirve</option>
                            <option value="Akademik" {{ old('category') == 'Akademik' ? 'selected' : '' }}>🎓 Akademik Haber</option>
                            <option value="Genel" {{ old('category') == 'Genel' ? 'selected' : '' }}>📢 Genel Duyuru</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1">Yayınlayan Birim / Yazar</label>
                        <input type="text" name="author" placeholder="Mezunlar Koordinatörlüğü" value="{{ old('author', 'Mezunlar Koordinatörlüğü') }}"
                               class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Duyuru İçeriği *</label>
                    <textarea name="content" rows="6" required placeholder="Duyuru metni, etkinlik tarihi, yer ve katılım koşulları..."
                              class="w-full px-4 py-3 text-xs bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">{{ old('content') }}</textarea>
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_pinned" name="is_pinned" value="1" {{ old('is_pinned') ? 'checked' : '' }} class="rounded text-amber-500 focus:ring-amber-400">
                    <label for="is_pinned" class="text-xs font-bold text-slate-700">📌 Bu duyuruyu başa tuttur (Öne Çıkar)</label>
                </div>

                <!-- Actions -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="/announcements" class="px-5 py-3 rounded-2xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition">
                        Vazgeç
                    </a>
                    <button type="submit" class="px-7 py-3 bg-amber-600 hover:bg-amber-700 text-white rounded-2xl text-xs font-bold transition shadow-md flex items-center gap-2">
                        <span>📢</span> Duyuruyu Yayınla
                    </button>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        Mezun Takip Sistemi &bull; Duyuru Editörü
    </footer>
</body>
</html>
