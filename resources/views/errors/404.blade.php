<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Sayfa Bulunamadı &bull; Mezun Takip Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta http-equiv="refresh" content="8;url=/main">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">🎓</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-rose-100 text-rose-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-rose-200">
                    404 Guardian &bull; Generic Page
                </span>
            </div>
            <div class="flex items-center space-x-3 text-sm">
                <a href="/main" class="text-slate-600 hover:text-indigo-600 transition px-2 py-1">Ana Sayfa</a>
                <a href="/job-postings" class="text-slate-600 hover:text-indigo-600 transition px-2 py-1">İş İlanları</a>
                <a href="/applications" class="text-slate-600 hover:text-indigo-600 transition px-2 py-1">Başvurular</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-6 py-12 flex-1 flex flex-col justify-center items-center text-center w-full">
        
        <!-- Big Icon -->
        <div class="w-20 h-20 bg-rose-100 rounded-3xl flex items-center justify-center text-4xl mb-5 shadow-sm border border-rose-200 text-rose-600">
            🔍
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold mb-3">
            <span>GENERIC 404 PAGE &bull; GEÇERSİZ İSTEK</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
            Sayfa veya Kaynak Bulunamadı
        </h1>

        <p class="text-slate-500 text-sm mb-6 max-w-md">
            Girdiğiniz adres sistemde kayıtlı değil veya kaldırılmış olabilir.
        </p>

        <!-- Reason Card -->
        <div class="w-full bg-white border border-rose-200 rounded-2xl p-6 shadow-sm text-left mb-6">
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2 text-rose-900 font-bold text-sm">
                    <span>⚠️</span>
                    <span>Bulunamama Nedeni (Reason):</span>
                </div>
                <span class="text-xs px-2 py-0.5 rounded bg-rose-100 text-rose-800 font-bold">404</span>
            </div>
            
            <p class="text-sm font-semibold text-rose-700 bg-rose-50/70 p-3.5 rounded-xl border border-rose-100 leading-relaxed">
                {{ $reason ?? 'Geçersiz veya var olmayan bir adrese erişmeye çalıştınız.' }}
            </p>

            <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 font-mono gap-2">
                <span>Talep Edilen Yol: <strong class="text-slate-800 font-sans">{{ $path ?? '/' }}</strong></span>
                <span>Metot: <strong class="text-indigo-600 font-sans">{{ $method ?? 'GET' }}</strong></span>
            </div>
        </div>

        <!-- Auto-Redirect Countdown Notification -->
        <div class="w-full bg-indigo-50 border border-indigo-200 rounded-2xl p-4 mb-6 text-indigo-900 text-xs flex flex-col sm:flex-row items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-2">
                <span class="text-lg">⏳</span>
                <span>
                    <strong>Otomatik Yönlendirme:</strong> <span id="countdown" class="font-extrabold text-indigo-700 text-sm">6</span> saniye sonra ana sayfaya aktarılacaksınız...
                </span>
            </div>
            <div class="flex items-center gap-2">
                <button id="cancel-redirect" onclick="stopRedirect()" class="px-2.5 py-1 bg-white border border-indigo-300 text-indigo-700 hover:bg-indigo-100 font-bold rounded-lg transition">
                    Yönlendirmeyi Durdur
                </button>
                <a href="/main" class="px-2.5 py-1 bg-indigo-600 text-white hover:bg-indigo-700 font-bold rounded-lg transition">
                    Hemen Git &rarr;
                </a>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="flex flex-wrap gap-3 justify-center w-full">
            <a href="/main" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-1.5">
                <span>🏠</span> Ana Sayfa
            </a>
            <a href="/job-postings" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 text-sm transition shadow-xs flex items-center gap-1.5">
                <span>💼</span> İş İlanları
            </a>
            <a href="/applications" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 text-sm transition shadow-xs flex items-center gap-1.5">
                <span>📋</span> Başvurular
            </a>
            <a href="/users" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 text-sm transition shadow-xs flex items-center gap-1.5">
                <span>👥</span> Mezunlar
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400">
        Mezun Takip Sistemi &bull; 404 Guardian Layer &bull; &copy; 2026
    </footer>

    <!-- Countdown Javascript -->
    <script>
        let seconds = 6;
        let countdownEl = document.getElementById('countdown');
        let cancelBtn = document.getElementById('cancel-redirect');
        
        let interval = setInterval(function() {
            seconds--;
            if (countdownEl) {
                countdownEl.textContent = seconds;
            }
            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = '/main';
            }
        }, 1000);

        function stopRedirect() {
            clearInterval(interval);
            if (countdownEl && countdownEl.parentElement) {
                countdownEl.parentElement.innerHTML = '<strong>Yönlendirme iptal edildi.</strong> İstediğiniz butona tıklayarak devam edebilirsiniz.';
            }
            if (cancelBtn) {
                cancelBtn.remove();
            }
        }
    </script>

</body>
</html>
