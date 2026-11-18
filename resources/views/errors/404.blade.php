<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı | Mezun Takip Sistemi</title>
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

    <!-- Header -->
    <header class="bg-white/90 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-20 flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-brand-600 flex items-center justify-center text-white text-xl">
                    🎓
                </div>
                <span class="font-bold text-lg text-slate-900">Mezun Takip Sistemi</span>
            </a>
            <div class="flex items-center gap-2">
                <a href="/main" class="text-xs font-bold text-slate-700 hover:text-brand-600 px-3.5 py-2 rounded-full border border-slate-200 transition">
                    &larr; Ana Sayfaya Dön
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-4 sm:px-6 py-16 flex-1 flex flex-col items-center justify-center text-center w-full">
        
        <!-- Big Badge -->
        <div class="w-24 h-24 rounded-3xl bg-rose-50 border border-rose-200 text-rose-600 text-4xl flex items-center justify-center shadow-inner mb-6">
            🔍
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold mb-3">
            <span>404 GUARDIAN &bull; GEÇERSİZ İSTEK</span>
        </div>

        <h1 class="font-serif-editorial text-3xl sm:text-4xl font-bold text-slate-900 mb-3">
            Sayfa veya Kaynak Bulunamadı
        </h1>

        <p class="text-slate-500 text-xs sm:text-sm max-w-md mx-auto mb-8 leading-relaxed">
            Talep ettiğiniz adres sistemde kayıtlı değil veya taşınmış olabilir. Güvenlik ve loglama servisimiz isteği kayıt altına almıştır.
        </p>

        <!-- Reason Card -->
        <div class="w-full bg-white rounded-3xl p-6 hairline-border shadow-sm text-left mb-8">
            <div class="flex items-center justify-between mb-3 pb-3 border-b border-slate-100">
                <span class="text-xs font-bold text-slate-700 flex items-center gap-1.5">
                    <span>⚠️</span> Hata Teşhis Raporu
                </span>
                <span class="text-[10px] font-mono font-bold bg-rose-100 text-rose-800 px-2 py-0.5 rounded-full">
                    HTTP 404 Not Found
                </span>
            </div>

            <div class="space-y-2 text-xs">
                <div>
                    <span class="text-slate-400 block text-[11px]">Talep Edilen Rota:</span>
                    <span class="font-mono font-bold text-slate-800 break-all bg-slate-50 px-2 py-1 rounded-lg block mt-0.5">
                        {{ $path ?? request()->path() }}
                    </span>
                </div>
                <div>
                    <span class="text-slate-400 block text-[11px]">Açıklama:</span>
                    <span class="text-slate-600 block mt-0.5">
                        {{ $reason ?? "Geçersiz istek: Bu sayfa mevcut değil." }}
                    </span>
                </div>
            </div>

            <!-- Countdown Alert -->
            <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <span>Otomatik Yönlendirme:</span>
                <span class="font-bold text-brand-600">
                    <span id="countdownNumber">8</span> saniye sonra Ana Sayfa'ya aktarılıyorsunuz...
                </span>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="flex flex-wrap items-center justify-center gap-3">
            <a href="/main" class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-2xl text-xs transition shadow-md">
                🏠 Hemen Ana Sayfaya Git
            </a>
            <a href="/job-postings" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-2xl text-xs hairline-border transition shadow-sm">
                💼 İş İlanlarını İncele
            </a>
            <a href="/users" class="px-6 py-3 bg-white hover:bg-slate-50 text-slate-700 font-bold rounded-2xl text-xs hairline-border transition shadow-sm">
                👥 Mezun Rehberine Git
            </a>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-xs text-slate-400">
        Mezun Takip Sistemi &bull; 404 Guardian Servisi
    </footer>

    <!-- Countdown Timer Script -->
    <script>
        let seconds = 8;
        const countdownEl = document.getElementById('countdownNumber');
        const interval = setInterval(function () {
            seconds--;
            if (countdownEl) countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = '/main';
            }
        }, 1000);
    </script>
</body>
</html>
