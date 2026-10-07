<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $user->name ?? $user['name'] }} Düzenle - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">🎓</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/users/{{ $user->id ?? $user['id'] }}" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">
                    &larr; Profile Dön
                </a>
                <a href="/users" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Mezunlar Listesi</a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-3xl mx-auto px-4 sm:px-6 py-10 flex-1 w-full">

        <!-- Validation Errors -->
        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm">
            <div class="flex items-center gap-2 mb-2 font-semibold">
                <span>⚠️</span> Formda bazı hatalar tespit edildi:
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
                        <span>PUT /users/{id} (Update - View Layer)</span>
                    </div>
                    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Mezun Bilgilerini Düzenle</h1>
                    <p class="text-sm text-slate-500 mt-1">
                        #{{ $user->id ?? $user['id'] }} numaralı kullanıcının bilgilerini güncelleyin.
                    </p>
                </div>
                <span class="text-3xl">👤</span>
            </div>

            <form action="/users/{{ $user->id ?? $user['id'] }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Ad Soyad *</label>
                        <input type="text" name="name" required value="{{ old('name', $user->name ?? $user['name'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">E-Posta Adresi *</label>
                        <input type="email" name="email" required value="{{ old('email', $user->email ?? $user['email'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Öğrenci Numarası</label>
                        <input type="text" name="student_number" value="{{ old('student_number', $user->student_number ?? $user['student_number'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mezuniyet Yılı</label>
                        <input type="number" name="graduation_year" value="{{ old('graduation_year', $user->graduation_year ?? $user['graduation_year'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Bölüm</label>
                        <input type="text" name="department" value="{{ old('department', $user->department ?? $user['department'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">İkamet Şehri</label>
                        <input type="text" name="city" value="{{ old('city', $user->city ?? $user['city'] ?? 'İstanbul') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mevcut Şirket</label>
                        <input type="text" name="current_company" value="{{ old('current_company', $user->current_company ?? $user['current_company'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Mevcut Pozisyon</label>
                        <input type="text" name="current_position" value="{{ old('current_position', $user->current_position ?? $user['current_position'] ?? '') }}"
                               class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Onay Durumu</label>
                        <select name="status" class="w-full px-4 py-2.5 text-sm border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50/50">
                            @php $currentStatus = $user->status ?? $user['status'] ?? 'approved'; @endphp
                            <option value="approved" {{ $currentStatus === 'approved' ? 'selected' : '' }}>Onaylandı (approved)</option>
                            <option value="pending" {{ $currentStatus === 'pending' ? 'selected' : '' }}>Beklemede (pending)</option>
                            <option value="rejected" {{ $currentStatus === 'rejected' ? 'selected' : '' }}>Reddedildi (rejected)</option>
                        </select>
                    </div>
                </div>

                <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100">
                    <a href="/users" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:text-slate-900 transition">
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
    <footer class="bg-white border-t border-slate-200 py-6 text-center text-sm text-slate-500">
        <div class="max-w-5xl mx-auto px-4">
            Mezun Takip Sistemi &bull; MVC View Katmanı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
