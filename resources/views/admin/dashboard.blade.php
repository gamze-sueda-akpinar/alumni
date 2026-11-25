<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli | İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        cream: {
                            50: '#FDFBF7',
                            100: '#FAF6EF',
                            200: '#F4ECE0',
                            300: '#EADFCF',
                            400: '#D5C4AF',
                        },
                        forest: {
                            900: '#062B21',
                            800: '#0B382C',
                            700: '#114D3D',
                            600: '#1A6753',
                        },
                        sticker: {
                            yellow: '#FFDE37',
                            green: '#8ED462',
                            coral: '#FF5C38',
                            violet: '#8A53FF',
                            sky: '#C2E2FA',
                            blush: '#FFE9CE',
                        },
                        ink: {
                            black: '#121214',
                            charcoal: '#282726',
                            muted: '#63615E',
                        }
                    },
                    fontFamily: {
                        serif: ['"Fraunces"', 'Georgia', 'serif'],
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,400;0,9..144,600;0,9..144,700;0,9..144,800;1,9..144,400;1,9..144,600&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #FAF6EF; color: #121214; }
        .font-editorial { font-family: 'Fraunces', Georgia, serif; }
        .retro-card {
            background-color: #FFFFFF;
            border: 2px solid #121214;
            box-shadow: 4px 4px 0px #121214;
        }
        .retro-input {
            border: 2px solid #121214;
            box-shadow: 2px 2px 0px #121214;
        }
        .retro-btn {
            border: 2px solid #121214;
            box-shadow: 3px 3px 0px #121214;
            transition: all 0.15s ease-in-out;
        }
        .retro-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 4px 4px 0px #121214;
        }
        .retro-btn:active {
            transform: translate(1px, 1px);
            box-shadow: 1px 1px 0px #121214;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-sticker-yellow selection:text-ink-black">

    <!-- Top Status Tape -->
    <div class="bg-ink-black text-sticker-yellow py-2 px-4 border-b-2 border-black text-xs font-mono tracking-wide text-center flex items-center justify-between">
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ REKTÖRLÜĞÜ • MERKEZİ YÖNETİM SİSTEMİ (SUPER ADMIN) ★</span>
        <div class="flex items-center gap-2">
            <span class="w-2 h-2 rounded-full bg-sticker-green animate-pulse"></span>
            <span>Antigravity AI Aktif</span>
        </div>
    </div>

    <!-- Header Navigation Bar -->
    <header class="max-w-7xl mx-auto px-4 sm:px-6 pt-6 pb-4 w-full">
        <div class="bg-white border-2 border-ink-black rounded-full px-5 py-3 shadow-[4px_4px_0px_#121214] flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-3">
                <div class="w-11 h-11 rounded-full bg-white border-2 border-ink-black flex items-center justify-center p-0.5 shadow-[2px_2px_0px_#121214] overflow-hidden">
                    <img src="/istanbul_university_logo.svg" alt="İÜ Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-editorial text-lg sm:text-xl font-bold tracking-tight text-ink-black block leading-none">
                            Yönetici Kontrol Paneli
                        </span>
                        <span class="bg-forest-800 text-sticker-yellow font-mono text-[10px] font-bold px-2 py-0.5 rounded-full border border-ink-black">
                            SUPER ADMIN
                        </span>
                    </div>
                    <span class="text-[11px] font-mono text-ink-muted block mt-0.5">
                        Aktif Yönetici: <strong>Antigravity AI</strong> (antigravity@alumni.edu.tr)
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-2">
                <a href="/main" class="text-xs font-bold px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">
                    &larr; Web Uygulamasına Dön
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="retro-btn px-4 py-1.5 bg-sticker-coral text-white text-xs font-bold rounded-full">
                        Oturumu Kapat
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Main Admin Dashboard Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 py-6 w-full flex-1">

        <!-- Flash Notifications -->
        @if(session('admin_success'))
            <div class="retro-card p-4 rounded-2xl bg-sticker-green/20 border-2 border-ink-black mb-6 flex items-center gap-3">
                <span class="w-6 h-6 rounded-full bg-sticker-green text-ink-black font-bold flex items-center justify-center text-xs">✓</span>
                <span class="text-xs font-bold text-ink-black">{{ session('admin_success') }}</span>
            </div>
        @endif

        @if(session('admin_warning'))
            <div class="retro-card p-4 rounded-2xl bg-sticker-coral/20 border-2 border-ink-black mb-6 flex items-center gap-3">
                <span class="w-6 h-6 rounded-full bg-sticker-coral text-white font-bold flex items-center justify-center text-xs">!</span>
                <span class="text-xs font-bold text-ink-black">{{ session('admin_warning') }}</span>
            </div>
        @endif

        <!-- KPI Metric Counters Ribbon -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-8">
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Toplam Kayıt</span>
                <span class="font-editorial text-2xl font-extrabold text-ink-black">{{ $stats['total_users'] ?? '14.850+' }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-sticker-yellow/30 border-2 border-ink-black">
                <span class="text-[10px] font-mono uppercase text-ink-charcoal font-bold block">Onay Bekleyen</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-900">{{ $stats['pending_verifications'] ?? 1 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Onaylı Mezun</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-700">{{ $stats['approved_alumni'] ?? 420 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Aktif Öğrenci</span>
                <span class="font-editorial text-2xl font-extrabold text-ink-black">{{ $stats['active_students'] ?? 1150 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">Aktif İlanlar</span>
                <span class="font-editorial text-2xl font-extrabold text-sticker-coral">{{ $stats['active_jobs'] ?? 48 }}</span>
            </div>
            <div class="retro-card p-4 rounded-2xl text-center bg-white">
                <span class="text-[10px] font-mono uppercase text-ink-muted font-bold block">İş Başvuruları</span>
                <span class="font-editorial text-2xl font-extrabold text-forest-900">{{ $stats['total_applications'] ?? 128 }}</span>
            </div>
        </div>

        <!-- SECTION 1: Pending Verification Queue (Unverified Users) -->
        <section class="retro-card p-6 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-sticker-yellow border border-ink-black animate-pulse"></span>
                        <h2 class="font-editorial text-xl font-bold text-ink-black">
                            Doğrulama &amp; Onay Bekleyenler (Verification Queue)
                        </h2>
                    </div>
                    <p class="text-xs text-ink-muted mt-0.5">
                        Sisteme yeni kaydolup 'unverified' veya 'pending' durumundaki adayları inceleyin, onaylayın veya reddedin.
                    </p>
                </div>
                <span class="bg-sticker-yellow font-mono text-xs font-bold px-3 py-1 rounded-full border border-ink-black">
                    {{ $pendingUsers->count() }} Bekleyen Talep
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-cream-100 text-ink-charcoal font-bold uppercase tracking-wider text-[10px] border-b border-ink-black">
                            <th class="py-2.5 px-3">Aday / Kullanıcı</th>
                            <th class="py-2.5 px-3">Bölüm &amp; Öğrenci No</th>
                            <th class="py-2.5 px-3">Mezuniyet</th>
                            <th class="py-2.5 px-3">Mevcut Rol</th>
                            <th class="py-2.5 px-3">Hedef Rol</th>
                            <th class="py-2.5 px-3 text-right">İşlemler (Veri Manipülasyonu)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200">
                        @forelse($pendingUsers as $pUser)
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3">
                                    <span class="font-bold text-ink-black block">{{ $pUser->name }}</span>
                                    <span class="font-mono text-[10px] text-ink-muted">{{ $pUser->email }}</span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="block text-ink-black">{{ $pUser->alumniProfile->department->name ?? 'Belirtilmedi' }}</span>
                                    <span class="font-mono text-[10px] text-ink-muted">No: {{ $pUser->alumniProfile->student_number ?? 'Yok' }}</span>
                                </td>
                                <td class="py-3 px-3 font-mono font-bold">
                                    {{ $pUser->alumniProfile->graduation_year ?? '-' }}
                                </td>
                                <td class="py-3 px-3">
                                    <span class="bg-sticker-yellow text-ink-black px-2 py-0.5 rounded text-[10px] font-mono font-bold border border-ink-black">
                                        {{ strtoupper($pUser->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="bg-cream-200 text-forest-800 px-2 py-0.5 rounded text-[10px] font-mono font-bold">
                                        Mezun (Alumni)
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Approve Button -->
                                        <form action="{{ route('admin.users.approve', $pUser->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="role" value="alumni">
                                            <button type="submit" class="retro-btn px-2.5 py-1 bg-sticker-green text-ink-black font-bold text-[11px] rounded-lg">
                                                ✓ Onayla &amp; Mezun Yap
                                            </button>
                                        </form>
                                        <!-- Reject Button -->
                                        <form action="{{ route('admin.users.reject', $pUser->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="retro-btn px-2.5 py-1 bg-white text-sticker-coral font-bold text-[11px] rounded-lg">
                                                ✕ Reddet
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-ink-muted">
                                    Şu anda onay bekleyen kullanıcı bulunmamaktadır.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 2: User & Role Manipulation -->
        <section class="retro-card p-6 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black">
                        Kullanıcı Rolü &amp; Yetki Yönetimi (Role Manipulation)
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        Kullanıcıların rollerini anlık olarak değiştirin (`student`, `alumni`, `academic`, `admin`).
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-cream-100 text-ink-charcoal font-bold uppercase tracking-wider text-[10px] border-b border-ink-black">
                            <th class="py-2.5 px-3">ID</th>
                            <th class="py-2.5 px-3">Kullanıcı</th>
                            <th class="py-2.5 px-3">E-posta</th>
                            <th class="py-2.5 px-3">Mevcut Rol</th>
                            <th class="py-2.5 px-3">Rolü Değiştir &amp; Kaydet</th>
                            <th class="py-2.5 px-3 text-right">Sil</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3 font-mono text-[10px] text-ink-muted">#{{ $user->id }}</td>
                                <td class="py-3 px-3 font-bold text-ink-black">{{ $user->name }}</td>
                                <td class="py-3 px-3 font-mono text-ink-muted">{{ $user->email }}</td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold border border-ink-black 
                                        {{ $user->role === 'admin' ? 'bg-ink-black text-white' : ($user->role === 'alumni' ? 'bg-forest-800 text-sticker-yellow' : ($user->role === 'academic' ? 'bg-sticker-sky text-ink-black' : 'bg-sticker-yellow text-ink-black')) }}">
                                        {{ strtoupper($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <form action="{{ route('admin.users.role', $user->id) }}" method="POST" class="flex items-center gap-2">
                                        @csrf
                                        <select name="role" class="retro-input px-2 py-1 rounded bg-cream-50 text-xs">
                                            <option value="student" {{ $user->role === 'student' ? 'selected' : '' }}>Öğrenci (Student)</option>
                                            <option value="alumni" {{ $user->role === 'alumni' ? 'selected' : '' }}>Mezun (Alumni)</option>
                                            <option value="academic" {{ $user->role === 'academic' ? 'selected' : '' }}>Akademisyen</option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Yönetici (Admin)</option>
                                            <option value="unverified" {{ $user->role === 'unverified' ? 'selected' : '' }}>Unverified</option>
                                        </select>
                                        <button type="submit" class="retro-btn px-2.5 py-1 bg-ink-black text-white text-[10px] font-bold rounded">
                                            Güncelle
                                        </button>
                                    </form>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST" onsubmit="return confirm('Kullanıcıyı silmek istediğinize emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sticker-coral font-bold text-xs hover:underline">
                                            Sil
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

        <!-- SECTION 3: Job Postings Moderation -->
        <section class="retro-card p-6 rounded-3xl bg-white mb-8">
            <div class="flex items-center justify-between mb-4 border-b-2 border-cream-200 pb-3 flex-wrap gap-2">
                <div>
                    <h2 class="font-editorial text-xl font-bold text-ink-black">
                        İş İlanları Moderasyonu (Job Postings Control)
                    </h2>
                    <p class="text-xs text-ink-muted mt-0.5">
                        İlanları anlık olarak yayından kaldırın, yayına alın veya silin.
                    </p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-cream-100 text-ink-charcoal font-bold uppercase tracking-wider text-[10px] border-b border-ink-black">
                            <th class="py-2.5 px-3">İlan Başlığı</th>
                            <th class="py-2.5 px-3">Şirket / Kurum</th>
                            <th class="py-2.5 px-3">Şehir / Çalışma Modeli</th>
                            <th class="py-2.5 px-3">Maaş</th>
                            <th class="py-2.5 px-3">Durum</th>
                            <th class="py-2.5 px-3 text-right">Moderasyon İşlemleri</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-cream-200">
                        @foreach($jobPostings as $job)
                            <tr class="hover:bg-cream-50 transition">
                                <td class="py-3 px-3 font-bold text-ink-black">{{ $job->title }}</td>
                                <td class="py-3 px-3 font-medium text-ink-charcoal">{{ $job->company_name }}</td>
                                <td class="py-3 px-3 text-ink-muted">{{ $job->city ?? 'İstanbul' }} &bull; {{ ucfirst($job->workplace_type) }}</td>
                                <td class="py-3 px-3 font-mono font-bold text-forest-700">₺{{ number_format($job->salary, 0, ',', '.') }}</td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold {{ $job->is_active ? 'bg-sticker-green text-ink-black' : 'bg-sticker-coral text-white' }}">
                                        {{ $job->is_active ? 'YAYINDA' : 'PASİF' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <form action="{{ route('admin.job-postings.toggle', $job->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="retro-btn px-2.5 py-1 {{ $job->is_active ? 'bg-cream-200 text-ink-black' : 'bg-sticker-green text-ink-black' }} text-[10px] font-bold rounded">
                                                {{ $job->is_active ? 'Yayından Kaldır' : 'Yayına Al' }}
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.job-postings.delete', $job->id) }}" method="POST" onsubmit="return confirm('Bu ilanı silmek istediğinize emin misiniz?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="retro-btn px-2 py-1 bg-sticker-coral text-white text-[10px] font-bold rounded">
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-8 border-t-2 border-black mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 text-center text-xs text-cream-300">
            <p>&copy; 1453 - 2026 T.C. İstanbul Üniversitesi Rektörlüğü &bull; Bilgi İşlem Daire Başkanlığı</p>
        </div>
    </footer>

</body>
</html>
