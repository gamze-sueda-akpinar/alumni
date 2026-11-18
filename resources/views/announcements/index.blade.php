<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Duyurular &amp; Kampüs Etkinlikleri | Mezun Takip Sistemi</title>
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

    <!-- Top Ribbon -->
    <div class="bg-gradient-to-r from-amber-950 via-slate-900 to-brand-950 text-white text-xs py-2 px-4 text-center font-medium border-b border-amber-950/60">
        <div class="max-w-7xl mx-auto flex items-center justify-center gap-2 flex-wrap">
            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-amber-400 text-slate-950 uppercase tracking-wider">Etkinlik Takvimi</span>
            <span>2026 Bahar Dönemi Mezunlar Günü Buluşması ve Kariyer Panelleri Yayınlandı!</span>
        </div>
    </div>

    <!-- Header / Navbar -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-amber-500 via-orange-600 to-brand-900 flex items-center justify-center text-white text-2xl shadow-sm group-hover:scale-105 transition-transform">
                    📢
                </div>
                <div>
                    <span class="font-bold text-lg sm:text-xl tracking-tight text-slate-900 block leading-tight group-hover:text-brand-600 transition">
                        Mezun Takip Sistemi
                    </span>
                    <span class="text-[11px] text-slate-500 font-medium tracking-wide block">
                        Announcements &amp; Campus Events
                    </span>
                </div>
            </a>

            <!-- Desktop Nav -->
            <nav class="hidden md:flex items-center gap-1 bg-slate-100/80 p-1.5 rounded-full border border-slate-200/70">
                <a href="/main" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Ana Sayfa</a>
                <a href="/users" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Mezunlar</a>
                <a href="/job-postings" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Kariyer &amp; İlanlar</a>
                <a href="/announcements" class="text-xs font-bold text-brand-700 bg-white px-4 py-2 rounded-full shadow-sm transition">Duyurular</a>
                <a href="/applications" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Başvurular</a>
                <a href="/about" class="text-xs font-semibold text-slate-600 hover:text-brand-600 px-4 py-2 rounded-full transition">Hakkımızda</a>
            </nav>

            <div class="flex items-center gap-3">
                <a href="/announcements/create" class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-white bg-amber-600 hover:bg-amber-700 rounded-full transition shadow-sm">
                    <span>+</span> Yeni Duyuru
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Banner -->
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold mb-3">
                    <span>📢</span>
                    <span>Resmi Haberler, Zirveler &amp; Mezunlar Günü</span>
                </div>
                <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 tracking-tight">
                    Duyurular &amp; Kampüs Etkinlikleri
                </h1>
                <p class="text-slate-600 text-sm mt-1 max-w-2xl">
                    Üniversite rektörlüğü, fakülteler ve mezunlar derneği tarafından organize edilen panel, buluşma ve kariyer duyuruları.
                </p>
            </div>

            <div class="px-4 py-2 bg-white rounded-2xl hairline-border shadow-sm text-xs text-slate-600">
                Toplam Duyuru: <span class="font-bold text-amber-700 font-mono text-sm ml-1">{{ count($announcements) }}</span>
            </div>
        </div>

        <!-- Announcements Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($announcements as $announcement)
            @php 
                $aid = $announcement->id ?? $announcement['id'];
                $atitle = $announcement->title ?? $announcement['title'];
                $acontent = $announcement->content ?? $announcement['content'];
                $isPinned = $announcement->is_pinned ?? $announcement['is_pinned'] ?? false;
                $adate = $announcement->created_at ?? $announcement['created_at'] ?? 'Bugün';
            @endphp
            <div class="bg-white rounded-3xl p-6 hairline-border hover:border-amber-300 hover:shadow-md transition duration-200 flex flex-col justify-between {{ $isPinned ? 'ring-2 ring-amber-400/40 bg-amber-50/20' : '' }}">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        @if($isPinned)
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-400 text-slate-950 uppercase tracking-wider">
                            📌 Öne Çıkan
                        </span>
                        @else
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600">
                            Haber &bull; Etkinlik
                        </span>
                        @endif
                        <span class="text-xs text-slate-400 font-mono">{{ $adate }}</span>
                    </div>

                    <h3 class="text-lg font-bold text-slate-900 mb-2 leading-snug">
                        <a href="/announcements/{{ $aid }}" class="hover:text-amber-700 transition">
                            {{ $atitle }}
                        </a>
                    </h3>

                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed mb-4">
                        {{ $acontent }}
                    </p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs">
                    <span class="text-slate-400 font-mono">#{{ $aid }}</span>
                    <div class="flex items-center gap-2">
                        <a href="/announcements/{{ $aid }}" class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 font-bold transition border border-amber-200">
                            Detayları Oku &rarr;
                        </a>
                        <a href="/announcements/{{ $aid }}/edit" class="px-2 py-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold transition">
                            ✏️
                        </a>
                        <form action="/announcements/{{ $aid }}" method="POST" class="inline" onsubmit="return confirm('Bu duyuruyu silmek istediğinize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-2 py-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 font-semibold border border-rose-200 transition">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-full bg-white rounded-3xl p-12 text-center hairline-border">
                <span class="text-5xl block mb-3">📢</span>
                <h3 class="font-serif-editorial text-xl font-bold text-slate-900 mb-1">Henüz Yayınlanmış Duyuru Yok</h3>
                <p class="text-slate-500 text-xs mb-4">Yeni bir etkinlik veya duyuru paylaşarak mezunları bilgilendirebilirsiniz.</p>
                <a href="/announcements/create" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-600 text-white rounded-full text-xs font-bold">
                    + İlk Duyuruyu Ekle
                </a>
            </div>
            @endforelse
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-8 text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; 2026 Mezun Takip Sistemi &bull; Duyuru &amp; Etkinlik Modülü</p>
            <div class="flex items-center gap-4">
                <a href="/main" class="hover:text-brand-600 transition">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-brand-600 transition">Mezun Rehberi</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-brand-600 transition">İş İlanları</a>
            </div>
        </div>
    </footer>

</body>
</html>
