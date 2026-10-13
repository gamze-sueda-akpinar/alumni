<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $job->title ?? $job['title'] }} Düzenle - Mezun Takip Sistemi</title>
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
                <a href="/job-postings/{{ $job->id ?? $job['id'] }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; İlan Detayına Dön
                </a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">İlanlar Listesi</a>
            </div>
        </div>
    </header>

    @php
        $jid = $job->id ?? $job['id'];
        $currentType = old('type', $job->type ?? $job['type'] ?? 'Tam Zamanlı');
        $isActive = old('is_active', ($job->is_active ?? $job['is_active']) ?? true);
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
                        <span>PUT /job-postings/{id} (Update - View Layer)</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">İş İlanını Düzenle</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        #{{ $jid }} numaralı iş ilanının detaylarını güncelleyiniz.
                    </p>
                </div>
                <span class="text-3xl">🏢</span>
            </div>

            <form action="/job-postings/{{ $jid }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Pozisyon / İlan Başlığı *</label>
                        <input type="text" name="title" required
                               value="{{ old('title', $job->title ?? $job['title'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Şirket / Kurum Adı *</label>
                        <input type="text" name="company_name" required
                               value="{{ old('company_name', $job->company_name ?? $job['company_name'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Konum / Şehir</label>
                        <input type="text" name="location"
                               value="{{ old('location', $job->location ?? $job['location'] ?? 'İstanbul (Hibrit)') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Çalışma Modeli</label>
                        <select name="type" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            <option value="Tam Zamanlı" {{ $currentType === 'Tam Zamanlı' ? 'selected' : '' }}>Tam Zamanlı</option>
                            <option value="Yarı Zamanlı" {{ $currentType === 'Yarı Zamanlı' ? 'selected' : '' }}>Yarı Zamanlı</option>
                            <option value="Staj" {{ $currentType === 'Staj' ? 'selected' : '' }}>Staj</option>
                            <option value="Sözleşmeli" {{ $currentType === 'Sözleşmeli' ? 'selected' : '' }}>Sözleşmeli / Proje</option>
                            <option value="Uzaktan" {{ $currentType === 'Uzaktan' ? 'selected' : '' }}>Uzaktan (Remote)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Başvuru E-Postası</label>
                        <input type="email" name="contact_email"
                               value="{{ old('contact_email', $job->contact_email ?? $job['contact_email'] ?? 'kariyer@alumni.edu.tr') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Son Başvuru Tarihi</label>
                        <input type="date" name="application_deadline"
                               value="{{ old('application_deadline', $job->application_deadline ?? $job['application_deadline'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">İş Tanımı & Sorumluluklar *</label>
                    <textarea name="description" rows="5" required
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('description', $job->description ?? $job['description'] ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Aranan Nitelikler & Teknik Beceriler</label>
                    <textarea name="requirements" rows="3"
                              class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">{{ old('requirements', $job->requirements ?? $job['requirements'] ?? '') }}</textarea>
                </div>

                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="block text-sm font-semibold text-slate-800">İlan Durumu (Aktif)</span>
                        <span class="text-xs text-slate-500">İlan yayında kalsın ve başvuru alsın.</span>
                    </div>
                    <input type="checkbox" name="is_active" value="1" {{ $isActive ? 'checked' : '' }}
                           class="h-5 w-5 text-indigo-600 rounded focus:ring-indigo-500">
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="/job-postings" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
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
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (In-Memory) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
