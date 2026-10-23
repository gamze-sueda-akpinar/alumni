<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yeni İş Başvurusu Oluştur - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">📋</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/applications" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; Başvurular Listesi
                </a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    İş İlanları
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <!-- Notification Alerts -->
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-semibold text-sm">
                <span>⚠️</span> Lütfen formdaki hataları düzeltiniz:
            </div>
            <ul class="list-disc list-inside text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="mb-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                <span>📝</span>
                <span>POST /applications (JobApplicationController@store)</span>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">İş Başvuru Formu</h1>
            <p class="text-sm text-slate-500 mt-1">İlgilendiğiniz açık pozisyona CV bilgilerinizi ve ön yazınızı iletiniz.</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <form action="/applications" method="POST" class="space-y-6">
                @csrf

                <!-- Target Job Posting -->
                <div>
                    <label for="job_posting_id" class="block text-sm font-bold text-slate-700 mb-1">
                        Başvurulacak İş İlanı <span class="text-rose-500">*</span>
                    </label>
                    <select id="job_posting_id" name="job_posting_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">-- Lütfen bir iş ilanı seçiniz --</option>
                        @foreach($jobPostings as $job)
                            <option value="{{ $job->id }}" {{ (old('job_posting_id', $selectedJobId) == $job->id) ? 'selected' : '' }}>
                                [{{ $job->company_name }}] {{ $job->title }} ({{ $job->type }} &bull; {{ $job->location }})
                            </option>
                        @endforeach
                    </select>
                    <span class="text-xs text-slate-400 mt-1 block">Açık ve başvuru kabul eden ilanlar listelenmektedir.</span>
                </div>

                <!-- Candidate / Applicant -->
                <div>
                    <label for="user_id" class="block text-sm font-bold text-slate-700 mb-1">
                        Başvuran Aday / Mezun <span class="text-rose-500">*</span>
                    </label>
                    <select id="user_id" name="user_id" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                        <option value="">-- Lütfen aday kullanıcısını seçiniz --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ (old('user_id') == $user->id) ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }}) 
                                @if($user->alumniProfile?->department)
                                    - {{ $user->alumniProfile->department->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    <span class="text-xs text-slate-400 mt-1 block">Sisteme kayıtlı mezun aday profilleri.</span>
                </div>

                <!-- Cover Letter -->
                <div>
                    <label for="cover_letter" class="block text-sm font-bold text-slate-700 mb-1">
                        Ön Yazı / Motivasyon Mektubu (Cover Letter)
                    </label>
                    <textarea id="cover_letter" name="cover_letter" rows="5"
                              placeholder="Bu pozisyon için neden uygun olduğunuzu, hedeflerinizi ve ilgili deneyimlerinizi özetleyiniz..."
                              class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('cover_letter') }}</textarea>
                </div>

                <!-- Resume / CV Path -->
                <div>
                    <label for="resume_path" class="block text-sm font-bold text-slate-700 mb-1">
                        Özgeçmiş / CV Dosya Yolu veya Bağlantısı
                    </label>
                    <input type="text" id="resume_path" name="resume_path" value="{{ old('resume_path') }}"
                           placeholder="Örn: resumes/cv_ahmet_yilmaz_2026.pdf veya LinkedIn / Drive linki"
                           class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    <span class="text-xs text-slate-400 mt-1 block">CV dosyasının depolama yolu veya genel erişim linki.</span>
                </div>

                <!-- Initial Status (Default pending) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-sm font-bold text-slate-700 mb-1">
                            Başlangıç Durumu
                        </label>
                        <select id="status" name="status"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent bg-white">
                            <option value="pending" {{ old('status', 'pending') === 'pending' ? 'selected' : '' }}>🟡 Beklemede (pending)</option>
                            <option value="reviewed" {{ old('status') === 'reviewed' ? 'selected' : '' }}>🔵 İncelendi (reviewed)</option>
                            <option value="shortlisted" {{ old('status') === 'shortlisted' ? 'selected' : '' }}>🟣 Mülakatta (shortlisted)</option>
                            <option value="accepted" {{ old('status') === 'accepted' ? 'selected' : '' }}>🟢 Kabul Edildi (accepted)</option>
                            <option value="rejected" {{ old('status') === 'rejected' ? 'selected' : '' }}>🔴 Reddedildi (rejected)</option>
                        </select>
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-bold text-slate-700 mb-1">
                            Değerlendirme Notu (Opsiyonel)
                        </label>
                        <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                               placeholder="Örn: Portfolyo çalışması incelendi"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                    </div>
                </div>

                <!-- Form Action Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="/applications" class="px-5 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition">
                        İptal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition transform hover:-translate-y-0.5">
                        🚀 Başvuruyu Gönder
                    </button>
                </div>

            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Portalı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
