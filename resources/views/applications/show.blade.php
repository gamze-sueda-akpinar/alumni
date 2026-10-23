<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Başvuru Detayı #{{ $application->id }} - Mezun Takip Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">📋</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200">
                    Başvuru Detayı
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/applications" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">
                    &larr; Tüm Başvurular
                </a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">İş İlanları</a>
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">Mezunlar</a>
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-2.5 py-2">Ana Sayfa</a>
            </div>
        </div>
    </header>

    @php
        $statusColors = [
            'pending' => ['bg' => 'bg-amber-100', 'text' => 'text-amber-800', 'border' => 'border-amber-200', 'label' => '🟡 Beklemede'],
            'reviewed' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'border' => 'border-blue-200', 'label' => '🔵 İncelendi'],
            'shortlisted' => ['bg' => 'bg-purple-100', 'text' => 'text-purple-800', 'border' => 'border-purple-200', 'label' => '🟣 Kısa Listede (Mülakat)'],
            'accepted' => ['bg' => 'bg-emerald-100', 'text' => 'text-emerald-800', 'border' => 'border-emerald-200', 'label' => '🟢 Kabul Edildi'],
            'rejected' => ['bg' => 'bg-rose-100', 'text' => 'text-rose-800', 'border' => 'border-rose-200', 'label' => '🔴 Reddedildi'],
        ];
        $st = $statusColors[$application->status] ?? $statusColors['pending'];
        $user = $application->user;
        $profile = $user->alumniProfile ?? null;
        $job = $application->jobPosting;
    @endphp

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        <!-- Flash Messages -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium text-sm">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium text-sm">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Breadcrumb & Top Bar -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-2 text-xs text-slate-500 mb-2">
                    <a href="/applications" class="hover:text-indigo-600 transition font-medium">Başvurular</a>
                    <span>/</span>
                    <span>Başvuru #{{ $application->id }}</span>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">
                        {{ $user->name ?? 'Aday' }} &rarr; {{ $job->title ?? 'İlan' }}
                    </h1>
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $st['bg'] }} {{ $st['text'] }} {{ $st['border'] }}">
                        {{ $st['label'] }}
                    </span>
                </div>
                <p class="text-sm text-slate-500 mt-1">
                    Başvuru No: <strong class="text-slate-700">#{{ $application->id }}</strong> &bull; Başvuru Zamanı: <strong class="text-slate-700">{{ $application->applied_at ? \Carbon\Carbon::parse($application->applied_at)->translatedFormat('d F Y, H:i') : $application->created_at }}</strong>
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a href="/job-postings/{{ $job->id ?? '' }}"
                   class="px-4 py-2 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 rounded-xl shadow-xs text-sm font-semibold transition flex items-center gap-1.5">
                    <span>💼</span> İlanı Görüntüle
                </a>
                <a href="/applications"
                   class="px-4 py-2 bg-indigo-50 border border-indigo-200 text-indigo-700 hover:bg-indigo-100 rounded-xl shadow-xs text-sm font-semibold transition">
                    &larr; Listeye Dön
                </a>
            </div>
        </div>

        <!-- 2-Column Layout: Left Details, Right Evaluation Sidebar -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- LEFT 2 COLUMNS: Application & Candidate Info -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Applicant Profile Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-start justify-between border-b border-slate-100 pb-5 mb-5">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center font-extrabold text-2xl shadow-sm">
                                {{ strtoupper(mb_substr($user->name ?? 'A', 0, 1, 'UTF-8')) }}
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
                                    {{ $user->name ?? 'İsimsiz Aday' }}
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 font-semibold border border-slate-200">
                                        Kullanıcı #{{ $user->id ?? '' }}
                                    </span>
                                </h2>
                                <p class="text-sm text-slate-500 flex items-center gap-2 mt-0.5">
                                    <span>✉️ {{ $user->email ?? '—' }}</span>
                                    @if(!empty($profile->phone))
                                    <span>&bull; 📞 {{ $profile->phone }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <a href="/users" class="px-3 py-1.5 text-xs font-semibold bg-indigo-50 text-indigo-700 hover:bg-indigo-100 rounded-lg transition border border-indigo-200">
                            👤 Mezunlar Listesi &rarr;
                        </a>
                    </div>

                    <!-- Academic & Career Highlights -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Bölüm / Fakülte</span>
                            <span class="font-bold text-slate-800 text-sm">
                                {{ $profile->department->name ?? 'Belirtilmedi' }}
                            </span>
                            @if(!empty($profile->department->faculty->name))
                            <span class="block text-[11px] text-slate-500 mt-0.5">{{ $profile->department->faculty->name }}</span>
                            @endif
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Mezuniyet Yılı</span>
                            <span class="font-bold text-slate-800 text-sm">
                                {{ $profile->graduation_year ?? 'Belirtilmedi' }}
                            </span>
                            @if(!empty($profile->student_number))
                            <span class="block text-[11px] text-slate-500 mt-0.5">Öğr. No: {{ $profile->student_number }}</span>
                            @endif
                        </div>

                        <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="block text-slate-400 font-semibold uppercase tracking-wider mb-1">Mevcut Pozisyon / Şirket</span>
                            <span class="font-bold text-slate-800 text-sm">
                                {{ $profile->current_job_title ?? 'Öğrenci / Mezun' }}
                            </span>
                            <span class="block text-[11px] text-slate-500 mt-0.5">
                                {{ $profile->current_company ?? 'Belirtilmemiş' }}
                            </span>
                        </div>
                    </div>

                    <!-- Work Experiences (if any) -->
                    @if(isset($user->experiences) && count($user->experiences) > 0)
                    <div class="mt-6 pt-5 border-t border-slate-100">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Kayıtlı İş Deneyimleri</h3>
                        <div class="space-y-2">
                            @foreach($user->experiences as $exp)
                            <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50/70 border border-slate-100 text-xs">
                                <div>
                                    <span class="font-bold text-slate-800">{{ $exp->position_title ?? 'Pozisyon' }}</span>
                                    <span class="text-slate-500"> &bull; {{ $exp->company_name ?? 'Şirket' }}</span>
                                </div>
                                <span class="text-slate-400 font-medium">
                                    {{ $exp->start_date ?? '' }} - {{ $exp->is_current ? 'Devam Ediyor' : ($exp->end_date ?? '') }}
                                </span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Cover Letter Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-base font-bold text-slate-900 flex items-center gap-2">
                            <span>✍️</span> Adayın Ön Yazısı (Cover Letter)
                        </h2>
                        @if($application->resume_path)
                        <a href="{{ $application->resume_path }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 rounded-lg border border-indigo-200 transition">
                            <span>📄</span> CV / Özgeçmişi Aç &rarr;
                        </a>
                        @endif
                    </div>

                    @if(!empty($application->cover_letter))
                    <div class="prose max-w-none text-slate-700 leading-relaxed text-sm whitespace-pre-line bg-slate-50 p-5 rounded-xl border border-slate-100">
                        {{ $application->cover_letter }}
                    </div>
                    @else
                    <div class="p-6 rounded-xl bg-slate-50 border border-dashed border-slate-200 text-center text-xs text-slate-400 italic">
                        Bu başvuru için aday tarafından ön yazı metni girilmemiştir.
                    </div>
                    @endif

                    @if(!empty($application->resume_path))
                    <div class="mt-4 p-3.5 rounded-xl bg-indigo-50/50 border border-indigo-100 flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2 text-indigo-900">
                            <span class="text-base">📎</span>
                            <span class="font-semibold">Özgeçmiş Belgesi / Portfolyo Linki:</span>
                            <span class="text-slate-600 font-mono truncate max-w-md">{{ $application->resume_path }}</span>
                        </div>
                        <a href="{{ $application->resume_path }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 font-bold underline">
                            Görüntüle
                        </a>
                    </div>
                    @endif
                </div>

                <!-- Target Job Posting Summary -->
                @if($job)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider block mb-1">Başvurulan İş İlanı Detayı</span>
                            <h3 class="text-lg font-bold text-slate-900">
                                <a href="/job-postings/{{ $job->id }}" class="hover:text-indigo-600 transition">
                                    {{ $job->title }}
                                </a>
                            </h3>
                            <p class="text-xs text-slate-500 mt-0.5">
                                {{ $job->company_name }} &bull; {{ $job->location ?? 'İstanbul' }} &bull; {{ $job->type ?? 'Tam Zamanlı' }}
                            </p>
                        </div>
                        <a href="/job-postings/{{ $job->id }}" class="px-3 py-1.5 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition border border-slate-200">
                            İlan Detayı &rarr;
                        </a>
                    </div>

                    <p class="text-xs text-slate-600 line-clamp-3 leading-relaxed bg-slate-50 p-4 rounded-xl border border-slate-100">
                        {{ $job->description }}
                    </p>

                    <div class="mt-4 flex flex-wrap items-center gap-4 text-xs text-slate-500">
                        <span>✉️ Şirket İletişim: <strong class="text-slate-700">{{ $job->contact_email ?? '—' }}</strong></span>
                        @if($job->application_deadline)
                        <span>⏰ Son Başvuru: <strong class="text-slate-700">{{ $job->application_deadline }}</strong></span>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <!-- RIGHT 1 COLUMN: Recruiter Evaluation & Status Controls -->
            <div class="space-y-6">

                <!-- Evaluation & Status Updater Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h2 class="text-base font-bold text-slate-900 flex items-center gap-2 mb-4">
                        <span>⚖️</span> İK / Başvuru Değerlendirmesi
                    </h2>
                    <p class="text-xs text-slate-500 mb-5">
                        Adayın durumunu güncelleyebilir ve şirket içi değerlendirme notlarınızı kaydedebilirsiniz.
                    </p>

                    <form action="/applications/{{ $application->id }}/status" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Başvuru Durumu *</label>
                            <select name="status" required class="w-full px-3.5 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50 font-semibold text-slate-800">
                                <option value="pending" {{ $application->status === 'pending' ? 'selected' : '' }}>🟡 Beklemede (pending)</option>
                                <option value="reviewed" {{ $application->status === 'reviewed' ? 'selected' : '' }}>🔵 İncelendi (reviewed)</option>
                                <option value="shortlisted" {{ $application->status === 'shortlisted' ? 'selected' : '' }}>🟣 Mülakat / Kısa Liste (shortlisted)</option>
                                <option value="accepted" {{ $application->status === 'accepted' ? 'selected' : '' }}>🟢 Kabul Edildi (accepted)</option>
                                <option value="rejected" {{ $application->status === 'rejected' ? 'selected' : '' }}>🔴 Reddedildi (rejected)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">İç Değerlendirme & Mülakat Notları</label>
                            <textarea name="notes" rows="4" placeholder="Adayın mülakat performansı, teklif detayları veya red gerekçesi..."
                                      class="w-full px-3.5 py-2.5 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50 leading-relaxed">{{ old('notes', $application->notes) }}</textarea>
                        </div>

                        <button type="submit"
                                class="w-full py-2.5 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm transition shadow-sm flex items-center justify-center gap-2">
                            <span>💾</span> Durumu & Notu Kaydet
                        </button>
                    </form>
                </div>

                <!-- Direct Candidate Contact Card -->
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
                    <h3 class="text-sm font-bold text-slate-900 mb-2 flex items-center gap-2">
                        <span>✉️</span> Aday ile İletişim
                    </h3>
                    <p class="text-xs text-slate-500 mb-4 leading-relaxed">
                        Adaya doğrudan e-posta ile ulaşıp mülakat daveti gönderebilirsiniz.
                    </p>
                    <a href="mailto:{{ $user->email ?? '' }}?subject={{ urlencode('İş Başvurunuz Hakkında: ' . ($job->title ?? '')) }}"
                       class="w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold rounded-xl text-xs transition border border-slate-200 flex items-center justify-center gap-2">
                        <span>📧</span> {{ $user->email ?? 'E-posta Gönder' }}
                    </a>
                </div>

                <!-- Delete / Withdraw Action -->
                <div class="bg-rose-50/50 rounded-2xl border border-rose-100 p-6">
                    <h3 class="text-sm font-bold text-rose-900 mb-1">Tehlikeli İşlem</h3>
                    <p class="text-xs text-rose-600 mb-4 leading-relaxed">
                        Bu başvuruyu kalıcı olarak veritabanından silebilir veya adayın başvurusunu geri çekebilirsiniz.
                    </p>
                    <form action="/applications/{{ $application->id }}" method="POST" onsubmit="return confirm('Bu başvuruyu silmek istediğinize emin misiniz? Bu işlem geri alınamaz.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="w-full py-2 px-3 bg-white hover:bg-rose-600 text-rose-700 hover:text-white font-bold rounded-xl text-xs transition border border-rose-300 shadow-xs flex items-center justify-center gap-1.5">
                            <span>🗑️</span> Başvuruyu Sil / Geri Çek
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Mezun Takip Sistemi &bull; Kariyer Yönetim Katmanı (MySQL) &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
