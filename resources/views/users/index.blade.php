<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mezunlar Listesi - Mezun Takip Sistemi</title>
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
                <span class="text-2xl">🎓</span>
                <a href="/main" class="font-bold text-xl tracking-tight text-indigo-900 hover:text-indigo-700 transition">
                    Mezun Takip Sistemi
                </a>
                <span class="bg-indigo-100 text-indigo-800 text-xs font-semibold px-2.5 py-0.5 rounded-full border border-indigo-200">
                    Kullanıcı Yönetimi (MVC View)
                </span>
            </div>
            <div class="flex items-center space-x-3">
                <a href="/main" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Ana Sayfa</a>
                <a href="/api/swagger" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Swagger UI</a>
                <a href="/admin" class="text-sm font-medium text-slate-600 hover:text-indigo-600 transition px-3 py-2">Admin Paneli</a>
                <a href="/users/create" class="inline-flex items-center gap-1.5 px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    <span>+</span> Yeni Mezun Ekle
                </a>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-1 w-full">

        <!-- Flash Message (Success) -->
        @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">✅</span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900 font-bold">&times;</button>
        </div>
        @endif

        <!-- Flash Message (Error) -->
        @if(session('error'))
        <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-3">
                <span class="text-xl">❌</span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-rose-600 hover:text-rose-900 font-bold">&times;</button>
        </div>
        @endif

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

        <!-- Title & Stats Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-indigo-50 border border-indigo-100 text-indigo-700 text-xs font-semibold mb-2">
                    <span>👥</span>
                    <span>Full CRUD View: Create (C), Read (R), Update (U), Delete (D)</span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Kayıtlı Mezunlar ve Kullanıcılar</h1>
                <p class="text-sm text-slate-500 mt-1">Sistemde kayıtlı mezunların detaylı listesi, profili inceleme, düzenleme ve silme işlemleri.</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="px-4 py-2 bg-white border border-slate-200 rounded-xl shadow-sm text-sm font-semibold text-slate-700">
                    Toplam Mezun: <span class="text-indigo-600 font-bold">{{ count($users) }}</span>
                </span>
                <a href="/users/create" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-sm text-sm font-semibold transition">
                    + Hızlı Ekle
                </a>
            </div>
        </div>

        <!-- Quick Create Form Accordion / Card -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                    <span>✨</span> Hızlı Mezun Ekle (POST /users &rarr; Create)
                </h2>
                <span class="text-xs text-slate-400">Veritabanı gerektirmeyen InMemoryUser modeline kaydeder</span>
            </div>

            <form action="/users" method="POST" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Ad Soyad *</label>
                    <input type="text" name="name" required placeholder="Örn: Ayşe Demir" value="{{ old('name') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">E-Posta *</label>
                    <input type="email" name="email" required placeholder="ayse@example.com" value="{{ old('email') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Öğrenci No</label>
                    <input type="text" name="student_number" placeholder="202011045" value="{{ old('student_number') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Bölüm</label>
                    <input type="text" name="department" placeholder="Yazılım Mühendisliği" value="{{ old('department') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Şirket</label>
                    <input type="text" name="current_company" placeholder="Google, Trendyol..." value="{{ old('current_company') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Pozisyon</label>
                    <input type="text" name="current_position" placeholder="Backend Developer" value="{{ old('current_position') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Şehir</label>
                    <input type="text" name="city" placeholder="İstanbul" value="{{ old('city', 'İstanbul') }}"
                           class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-slate-50">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                            class="w-full px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-sm transition shadow-sm flex items-center justify-center gap-2">
                        <span>💾</span> Mezunu Kaydet
                    </button>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-100/75 border-b border-slate-200 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="py-3.5 px-4"># ID</th>
                            <th class="py-3.5 px-4">Mezun Bilgisi</th>
                            <th class="py-3.5 px-4">Öğrenci No</th>
                            <th class="py-3.5 px-4">Bölüm</th>
                            <th class="py-3.5 px-4">Mevcut Şirket & Pozisyon</th>
                            <th class="py-3.5 px-4">Şehir</th>
                            <th class="py-3.5 px-4">Durum</th>
                            <th class="py-3.5 px-4 text-right">İşlemler (CRUD)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($users as $user)
                        @php $uid = $user->id ?? $user['id']; @endphp
                        <tr class="hover:bg-slate-50/75 transition">
                            <td class="py-3.5 px-4 font-bold text-slate-500">
                                #{{ $uid }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-900">{{ $user->name ?? $user['name'] }}</div>
                                <div class="text-xs text-slate-500">{{ $user->email ?? $user['email'] }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $user->student_number ?? $user['student_number'] ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $user->department ?? $user['department'] ?? '—' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <div class="font-medium text-slate-900">{{ $user->current_company ?? $user['current_company'] ?? '—' }}</div>
                                <div class="text-xs text-indigo-600 font-medium">{{ $user->current_position ?? $user['current_position'] ?? '' }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-600">
                                {{ $user->city ?? $user['city'] ?? 'İstanbul' }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    {{ $user->status ?? $user['status'] ?? 'approved' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <a href="/users/{{ $uid }}" title="Detayı İncele"
                                       class="px-2.5 py-1 text-xs font-semibold bg-indigo-50 hover:bg-indigo-100 text-indigo-700 rounded-lg transition border border-indigo-200">
                                        👁️ İncele
                                    </a>
                                    <a href="/users/{{ $uid }}/edit" title="Düzenle"
                                       class="px-2.5 py-1 text-xs font-semibold bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg transition border border-amber-200">
                                        ✏️ Düzenle
                                    </a>
                                    <form action="/users/{{ $uid }}" method="POST" class="inline" onsubmit="return confirm('Bu kullanıcıyı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Sil"
                                                class="px-2.5 py-1 text-xs font-semibold bg-rose-50 hover:bg-rose-100 text-rose-700 rounded-lg transition border border-rose-200">
                                            🗑️ Sil
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500">
                                <span class="text-4xl block mb-2">📭</span>
                                Sistemde henüz kayıtlı kullanıcı bulunmamaktadır.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 py-6 mt-12 text-center text-sm text-slate-500">
        <div class="max-w-7xl mx-auto px-4">
            Mezun Takip Sistemi &bull; MVC View Katmanı &bull; &copy; 2026 Gamze Şüeda Akpınar
        </div>
    </footer>

</body>
</html>
