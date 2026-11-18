<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $announcement->title ?? $announcement['title'] }} | Duyuru Detayı</title>
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

    @php 
        $aid = $announcement->id ?? $announcement['id'];
        $title = $announcement->title ?? $announcement['title'];
        $content = $announcement->content ?? $announcement['content'];
        $category = $announcement->category ?? $announcement['category'] ?? 'Genel Duyuru';
        $author = $announcement->author ?? $announcement['author'] ?? 'Mezunlar Koordinatörlüğü';
        $isPinned = $announcement->is_pinned ?? $announcement['is_pinned'] ?? false;
        $created = $announcement->created_at ?? $announcement['created_at'] ?? 'Bugün';
    @endphp

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-500 flex items-center justify-center text-white text-xl">
                    📢
                </div>
                <span class="font-bold text-lg text-slate-900">Mezun Takip Sistemi</span>
            </a>
            <div class="flex items-center gap-2">
                <a href="/announcements" class="text-xs font-bold text-slate-600 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                    &larr; Tüm Duyurular
                </a>
                <a href="/announcements/{{ $aid }}/edit" class="text-xs font-bold text-amber-800 bg-amber-50 border border-amber-200 hover:bg-amber-100 px-3.5 py-2 rounded-full transition">
                    ✏️ Düzenle
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <article class="bg-white rounded-3xl p-8 sm:p-12 hairline-border shadow-sm">
            <!-- Badges -->
            <div class="flex items-center gap-2 mb-4 flex-wrap">
                @if($isPinned)
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-400 text-slate-950 uppercase tracking-wider">
                    📌 Sabitlenen Duyuru
                </span>
                @endif
                <span class="px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-700">
                    {{ $category }}
                </span>
                <span class="text-xs text-slate-400 font-mono">
                    📅 {{ $created }} &bull; Yazar: <strong class="text-slate-700">{{ $author }}</strong>
                </span>
            </div>

            <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 leading-tight mb-6">
                {{ $title }}
            </h1>

            <div class="text-sm sm:text-base text-slate-700 leading-relaxed space-y-4 pt-6 border-t border-slate-100">
                <p class="whitespace-pre-line">{{ $content }}</p>
            </div>

            <!-- Footer actions -->
            <div class="mt-10 pt-6 border-t border-slate-100 flex items-center justify-between">
                <a href="/announcements" class="text-xs font-bold text-brand-600 hover:underline">
                    &larr; Duyurular Listesine Dön
                </a>
                <div class="flex items-center gap-2">
                    <a href="/announcements/{{ $aid }}/edit" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-800 transition">
                        Düzenle
                    </a>
                    <form action="/announcements/{{ $aid }}" method="POST" class="inline" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-rose-50 text-rose-700 hover:bg-rose-100 border border-rose-200 transition">
                            Sil
                        </button>
                    </form>
                </div>
            </div>
        </article>

    </main>

    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        Mezun Takip Sistemi &bull; Duyuru Okuyucu
    </footer>
</body>
</html>
