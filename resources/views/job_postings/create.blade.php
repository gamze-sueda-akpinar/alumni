<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İş İlanı Yayınla - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">💼</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/job-postings" class="text-sm font-semibold text-indigo-600 transition px-3 py-2">
                    &larr; İlanlar Listesi
                </a>
                <a href="/applications" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Başvurular</a>
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Ana Sayfa</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

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

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <div class="mb-6 pb-6 border-b border-slate-100">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>✨</span>
                    <span>POST /job-postings (Create View)</span>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Yeni İş İlanı Yayınla</h1>
                <p class="text-sm text-slate-500 mt-1">
                    Bu form üzerinden girilen iş fırsatları `JobPostingController@store` tarafından işlenerek bellekte saklanır.
                </p>
            </div>

            <form action="/job-postings" method="POST" class="space-y-5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pozisyon / İlan Başlığı *</label>
                        <input type="text" name="title" required placeholder="Örn: Senior Software Engineer" value="{{ old('title') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Şirket / Kurum Adı *</label>
                        <input type="text" name="company_name" required placeholder="Örn: Trendyol Tech" value="{{ old('company_name') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konum / Şehir</label>
                        <input type="text" name="location" placeholder="İstanbul (Hibrit)" value="{{ old('location', 'İstanbul (Hibrit)') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Çalışma Modeli</label>
                        <select name="type" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            <option value="Tam Zamanlı" selected>Tam Zamanlı</option>
                            <option value="Yarı Zamanlı">Yarı Zamanlı</option>
                            <option value="Staj">Staj</option>
                            <option value="Sözleşmeli">Sözleşmeli / Proje</option>
                            <option value="Uzaktan">Uzaktan (Remote)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Başvuru E-Postası</label>
                        <input type="email" name="contact_email" placeholder="kariyer@sirket.com" value="{{ old('contact_email', 'kariyer@alumni.edu.tr') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Son Başvuru Tarihi</label>
                        <input type="date" name="application_deadline" value="{{ old('application_deadline') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">İş Tanımı & Sorumluluklar *</label>
                    <textarea name="description" rows="5" required placeholder="İş kapsamı, projeler ve sorumluluklar hakkında detaylı bilgi veriniz..."
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Aranan Nitelikler & Teknik Beceriler</label>
                    <textarea name="requirements" rows="3" placeholder="Örn: 3+ yıl deneyim, PHP/Laravel, Docker, RESTful API..."
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('requirements') }}</textarea>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="block text-sm font-semibold text-slate-800">İlan Durumu (Aktif)</span>
                        <span class="text-xs text-slate-500">İlan kaydedildiği andan itibaren listelerde aktif olarak gösterilir.</span>
                    </div>
                    <input type="checkbox" name="is_active" value="1" checked class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="/job-postings" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
                        İptal
                    </a>
                    <button type="submit"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition shadow-sm flex items-center gap-2">
                        <span>💼</span> İlanı Kaydet & Yayınla
                    </button>
                </div>
            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (In-Memory) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
