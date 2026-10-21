<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İş Başvuruları - Mezun Takip Sistemi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col justify-between">

    <!-- Header / Navbar -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-40">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <span class="text-2xl">📋</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200">
                    Başvurular Portalı
                </span>
            </div>
            <div class="flex items-center space-x-4">
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">Ana Sayfa</a>
                <a href="/job-postings" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">İş İlanları</a>
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">Mezunlar</a>
                <a href="/announcements" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition">Duyurular</a>
                <a href="/admin" class="text-xs font-semibold px-3 py-1.5 rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition">Admin &rarr;</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>⚡</span>
                    <span>İş ve Staj Başvuruları Takip Tablosu (GET /applications)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kariyer Başvuruları</h1>
                <p class="text-sm text-slate-500 mt-1">Mezunların iş ilanlarına ilettiği başvurular, ön yazılar ve değerlendirme durumları.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="/job-postings" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm text-sm font-semibold transition flex items-center gap-1.5">
                    <span>💼</span> İlanları İncele & Başvur
                </a>
            </div>
        </div>

        <!-- Applications Cards / Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            @if($applications->isEmpty())
                <div class="p-12 text-center text-slate-500">
                    <span class="text-4xl block mb-2">📭</span>
                    <p class="text-base font-semibold">Henüz kayıtlı başvuru bulunmamaktadır.</p>
                    <p class="text-xs text-slate-400 mt-1">İş ilanları sayfasından aday başvuruları oluşturabilirsiniz.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-slate-600 uppercase text-xs font-bold border-b border-slate-200">
                            <tr>
                                <th class="px-6 py-4">ID</th>
                                <th class="px-6 py-4">Başvuran Aday</th>
                                <th class="px-6 py-4">İş İlanı & Şirket</th>
                                <th class="px-6 py-4">Ön Yazı / Motivasyon</th>
                                <th class="px-6 py-4">Başvuru Durumu</th>
                                <th class="px-6 py-4">Başvuru Tarihi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700 font-medium">
                            @foreach($applications as $app)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-6 py-4 font-mono font-bold text-slate-900">#{{ $app->id }}</td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900">{{ $app->user?->name ?? 'Kullanıcı #' . $app->user_id }}</div>
                                        <div class="text-xs text-slate-400">{{ $app->user?->email }}</div>
                                        @if($app->user?->alumniProfile?->department)
                                            <div class="text-xs text-indigo-600 mt-0.5">{{ $app->user->alumniProfile->department->name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-indigo-900">
                                            <a href="/job-postings/{{ $app->job_posting_id }}" class="hover:underline">
                                                {{ $app->jobPosting?->title ?? 'İlan #' . $app->job_posting_id }}
                                            </a>
                                        </div>
                                        <div class="text-xs text-slate-500">{{ $app->jobPosting?->company_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 max-w-xs truncate text-xs text-slate-600" title="{{ $app->cover_letter }}">
                                        {{ Str::limit($app->cover_letter ?? 'Ön yazı eklenmedi.', 80) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusColors = [
                                                'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
                                                'reviewed' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'shortlisted' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                'accepted' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                            ];
                                            $color = $statusColors[$app->status] ?? 'bg-slate-50 text-slate-700 border-slate-200';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold border {{ $color }}">
                                            {{ ucfirst($app->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        {{ $app->applied_at ? $app->applied_at->format('d.m.Y H:i') : $app->created_at->format('d.m.Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-6xl mx-auto px-4">
            Mezun Takip Sistemi &bull; İş Başvuruları Modülü &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
