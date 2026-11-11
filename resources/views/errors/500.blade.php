<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $statusCode ?? 500 }} - Sunucu Hatası &bull; 5xx Guardian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
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
                    5xx Guardian Active
                </span>
            </div>
            <div class="flex items-center space-x-3 text-sm">
                <a href="/main" class="text-slate-600 hover:text-indigo-600 transition px-2 py-1">Ana Sayfa</a>
                <a href="/job-postings" class="text-slate-600 hover:text-indigo-600 transition px-2 py-1">İş İlanları</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-2xl mx-auto px-6 py-16 flex-1 flex flex-col justify-center items-center text-center w-full">
        <div class="w-20 h-20 bg-rose-100 rounded-3xl flex items-center justify-center text-4xl mb-6 shadow-sm border border-rose-200 text-rose-600">
            🛡️
        </div>

        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 border border-rose-200 text-rose-700 text-xs font-bold mb-4">
            <span>5XX GUARDIAN MIDDLEWARE</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
            {{ $statusCode ?? 500 }} - Beklenmeyen Bir Sunucu Hatası Oluştu
        </h1>

        <p class="text-slate-500 text-sm mb-6 max-w-md">
            İsteğiniz işlenirken sunucuda bir hata meydana geldi. Bu durum sistem loglarına kaydedildi.
        </p>

        <!-- Reason Card -->
        <div class="w-full bg-white border border-rose-200 rounded-2xl p-6 shadow-sm text-left mb-6">
            <div class="flex items-center gap-2 mb-2 text-rose-900 font-bold text-sm">
                <span>⚠️</span>
                <span>Hata Nedeni (Reason):</span>
            </div>
            <p class="text-sm font-semibold text-rose-700 bg-rose-50/70 p-3.5 rounded-xl border border-rose-100">
                {{ $reason ?? 'Sunucu tarafında beklenmeyen bir hata oluştu.' }}
            </p>

            <div class="mt-4 pt-3 border-t border-slate-100 flex flex-wrap items-center justify-between text-xs text-slate-500 font-mono gap-2">
                <span>Hata Referans Kodu: <strong class="text-indigo-600 font-bold font-mono">{{ $referenceId ?? 'ERR-SYSTEM' }}</strong></span>
                <span>Yol: <strong class="text-slate-700">{{ $path ?? '/' }}</strong></span>
            </div>

            @if(!empty($exception) && config('app.debug'))
            <div class="mt-4 pt-3 border-t border-slate-100">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-1">Geliştirici Detayları (Debug Mode):</span>
                <pre class="bg-slate-900 text-slate-200 text-xs p-3 rounded-xl overflow-x-auto font-mono text-left">{{ get_class($exception) }}: {{ $exception->getMessage() }}
in {{ $exception->getFile() }}:{{ $exception->getLine() }}</pre>
            </div>
            @endif
        </div>

        <!-- Navigation Buttons -->
        <div class="flex flex-wrap gap-3 justify-center">
            <button onclick="window.location.reload()" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                <span>🔄</span> Sayfayı Yenile
            </button>
            <a href="/main" class="px-5 py-2.5 bg-white hover:bg-slate-100 text-slate-700 font-semibold rounded-xl border border-slate-200 text-sm transition shadow-xs">
                🏠 Ana Sayfaya Dön
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-4 text-center text-xs text-slate-400">
        Mezun Takip Sistemi &bull; 5xx Guardian Security Layer &bull; &copy; 2026
    </footer>

</body>
</html>
