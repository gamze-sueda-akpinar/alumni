<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol | İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <meta name="description" content="İstanbul Üniversitesi Mezun Takip Sistemi yeni kullanıcı kayıt ve doğrulama portalı.">
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
            transition: all 0.2s ease-in-out;
        }
        .retro-input {
            border: 2px solid #121214;
            box-shadow: 2px 2px 0px #121214;
            transition: all 0.15s ease-in-out;
        }
        .retro-input:focus {
            outline: none;
            box-shadow: 4px 4px 0px #114D3D;
            border-color: #114D3D;
        }
        .retro-btn {
            border: 2px solid #121214;
            box-shadow: 3px 3px 0px #121214;
            transition: all 0.15s ease-in-out;
        }
        .retro-btn:hover {
            transform: translate(-1px, -1px);
            box-shadow: 5px 5px 0px #121214;
        }
        .retro-btn:active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #121214;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between selection:bg-sticker-yellow selection:text-ink-black">

    <!-- Top Announcement Tape -->
    <div class="bg-forest-900 text-cream-100 py-2 px-4 border-b-2 border-ink-black text-xs font-mono tracking-wide text-center">
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ REKTÖRLÜĞÜ • YENİ KULLANICI DOĞRULAMA SİSTEMİ • 1453 ★</span>
    </div>

    <!-- Header Navigation Bar -->
    <header class="max-w-5xl mx-auto px-4 sm:px-6 pt-6 pb-4 w-full">
        <div class="bg-white border-2 border-ink-black rounded-full px-5 py-3 shadow-[3px_3px_0px_#121214] flex items-center justify-between">
            <a href="/main" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-full bg-white border-2 border-ink-black flex items-center justify-center p-0.5 shadow-[2px_2px_0px_#121214] group-hover:scale-105 transition-transform overflow-hidden">
                    <img src="/istanbul_university_logo.svg" alt="İstanbul Üniversitesi Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <span class="font-editorial text-lg sm:text-xl font-bold tracking-tight text-ink-black block leading-none">
                        İstanbul Üniversitesi
                    </span>
                    <span class="text-[10px] font-mono text-ink-muted uppercase tracking-widest block mt-0.5">
                        Mezun Takip Sistemi &bull; Kayıt Portalı
                    </span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="/users" class="hidden sm:inline-block text-xs font-bold px-3.5 py-1.5 rounded-full hover:bg-cream-200 transition">
                    &larr; Mezunlar Rehberi
                </a>
                <a href="/main" class="retro-btn px-4 py-1.5 bg-cream-100 text-xs font-bold rounded-full text-ink-black">
                    Ana Sayfa
                </a>
            </div>
        </div>
    </header>

    <!-- Main Registration Section -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-8 w-full flex-1">

        <!-- Title & Informational Pill -->
        <div class="text-center mb-8">
            <div class="inline-block transform -rotate-1 mb-3">
                <span class="bg-sticker-yellow text-ink-black border-2 border-ink-black px-4 py-1.5 rounded-full text-xs font-mono font-bold uppercase tracking-wider shadow-[2px_2px_0px_#121214] inline-flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-forest-700 animate-pulse"></span>
                    İlk Kayıt: Otomatik "unverified" Rolü
                </span>
            </div>
            <h1 class="font-editorial text-3xl sm:text-4xl font-extrabold text-ink-black tracking-tight mb-2">
                Mezun &amp; Öğrenci Ağına Katılın
            </h1>
            <p class="text-sm text-ink-muted max-w-xl mx-auto">
                Üniversite mezunlarımız, öğrencilerimiz ve akademisyenlerimiz için tek çatı altında güvenilir akademik dayanışma ağı.
            </p>
        </div>

        <!-- Success Notification Card (When user registers) -->
        @if(session('success'))
            <div class="retro-card p-6 rounded-3xl bg-sticker-yellow/20 border-2 border-ink-black mb-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sticker-green border-2 border-ink-black flex items-center justify-center text-2xl shadow-[2px_2px_0px_#121214] flex-shrink-0">
                        ✓
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <h2 class="font-editorial text-xl font-bold text-ink-black">
                                {{ session('success.title') ?? 'Kaydınız Başarıyla Alındı!' }}
                            </h2>
                            <span class="bg-sticker-yellow text-ink-black font-mono font-bold text-xs px-2.5 py-0.5 rounded-full border border-ink-black shadow-[1px_1px_0px_#121214]">
                                Statü: {{ strtoupper(session('success.role') ?? 'UNVERIFIED') }} (Doğrulama Bekliyor)
                            </span>
                        </div>
                        <p class="text-xs text-ink-charcoal mb-3 leading-relaxed">
                            {{ session('success.message') }}
                        </p>
                        <div class="bg-white border border-ink-black rounded-xl p-3 text-xs font-mono text-ink-muted grid grid-cols-1 sm:grid-cols-2 gap-2">
                            <div><strong>Ad Soyad:</strong> {{ session('success.name') }}</div>
                            <div><strong>E-posta:</strong> {{ session('success.email') }}</div>
                            <div><strong>Talep Edilen Rol:</strong> <span class="capitalize text-forest-700 font-bold">{{ session('success.intended_role') }}</span></div>
                            <div><strong>Doğrulama Aşaması:</strong> <span class="text-amber-700 font-bold">Rektörlük İncelemesinde</span></div>
                        </div>
                        <div class="mt-4 flex items-center gap-3">
                            <a href="/main" class="retro-btn px-4 py-2 bg-ink-black text-white text-xs font-bold rounded-full">
                                Ana Sayfaya Dön &rarr;
                            </a>
                            <a href="/users" class="retro-btn px-4 py-2 bg-white text-ink-black text-xs font-bold rounded-full">
                                Mezun Rehberini İncele
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Validation Errors Banner -->
        @if($errors->any())
            <div class="retro-card p-5 rounded-2xl bg-sticker-coral/20 border-2 border-ink-black mb-8">
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-sticker-coral text-white font-bold flex items-center justify-center border border-ink-black flex-shrink-0">
                        !
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-ink-black mb-1">Lütfen formdaki eksik veya hatalı alanları düzeltiniz:</h3>
                        <ul class="list-disc list-inside text-xs text-ink-charcoal space-y-0.5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Role Architecture Explanation Callout -->
        <div class="retro-card p-5 rounded-2xl bg-white mb-8 border-2 border-ink-black">
            <div class="flex items-start gap-3">
                <div class="w-10 h-10 rounded-xl bg-forest-800 text-sticker-yellow flex items-center justify-center text-lg font-bold border-2 border-ink-black shadow-[2px_2px_0px_#121214] flex-shrink-0">
                    🛡️
                </div>
                <div class="text-xs leading-relaxed text-ink-muted">
                    <strong class="text-ink-black block text-sm font-bold mb-0.5">Neden Doğrulanmamış (Unverified) Statüsü?</strong>
                    İstanbul Üniversitesi mezunlar ve kariyer platformumuzda sahte profil ve yanıltıcı iş ilanlarını engellemek amacıyla; yeni kayıt olan kullanıcılar sisteme başlangıçta 
                    <span class="font-bold text-ink-black bg-sticker-yellow px-1.5 py-0.5 rounded border border-ink-black">unverified</span> rolü ile dahil edilir.
                    Öğrenci numarası veya diploma bilginiz doğrulandıktan sonra hedef rolünüz (<span class="font-mono font-bold text-forest-700">student, alumni, academic</span>) aktive edilir.
                </div>
            </div>
        </div>

        <!-- Registration Form Card -->
        <div class="retro-card p-6 sm:p-10 rounded-3xl bg-white">
            <form action="{{ route('register.submit') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Section 1: Account Credentials -->
                <div class="border-b-2 border-cream-200 pb-6">
                    <h2 class="font-editorial text-lg font-bold text-ink-black mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-sticker-yellow border border-ink-black text-xs font-mono flex items-center justify-center font-bold">1</span>
                        Temel Hesap &amp; Giriş Bilgileri
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-xs font-bold text-ink-black mb-1.5">
                                Ad Soyad <span class="text-sticker-coral font-bold">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   placeholder="Örn: Dr. Ayşe Yılmaz"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-xs font-bold text-ink-black mb-1.5">
                                E-posta Adresi <span class="text-sticker-coral font-bold">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   placeholder="isim@istanbul.edu.tr veya gmail.com"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-xs font-bold text-ink-black mb-1.5">
                                Şifre (En az 8 karakter) <span class="text-sticker-coral font-bold">*</span>
                            </label>
                            <input type="password" id="password" name="password" required
                                   placeholder="••••••••"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <label for="password_confirmation" class="block text-xs font-bold text-ink-black mb-1.5">
                                Şifre Tekrarı <span class="text-sticker-coral font-bold">*</span>
                            </label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   placeholder="••••••••"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Intended Role & Academic Credentials -->
                <div class="border-b-2 border-cream-200 pb-6">
                    <h2 class="font-editorial text-lg font-bold text-ink-black mb-4 flex items-center gap-2">
                        <span class="w-6 h-6 rounded-full bg-sticker-sky border border-ink-black text-xs font-mono flex items-center justify-center font-bold">2</span>
                        Üniversite Kimliği &amp; Başvurulan Rol
                    </h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Intended Target Role -->
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-ink-black mb-2">
                                Doğrulanmak İstediğiniz Rol / Profil Türü <span class="text-sticker-coral font-bold">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <label class="retro-card p-3 rounded-2xl flex items-center gap-3 cursor-pointer hover:bg-cream-100 transition">
                                    <input type="radio" name="intended_role" value="alumni" {{ old('intended_role', 'alumni') === 'alumni' ? 'checked' : '' }} class="accent-forest-700 w-4 h-4">
                                    <div>
                                        <span class="block text-xs font-bold text-ink-black">🎓 Mezun (Alumni)</span>
                                        <span class="block text-[10px] text-ink-muted">İş ilanı paylaşma &amp; başvuru</span>
                                    </div>
                                </label>
                                <label class="retro-card p-3 rounded-2xl flex items-center gap-3 cursor-pointer hover:bg-cream-100 transition">
                                    <input type="radio" name="intended_role" value="student" {{ old('intended_role') === 'student' ? 'checked' : '' }} class="accent-forest-700 w-4 h-4">
                                    <div>
                                        <span class="block text-xs font-bold text-ink-black">📚 Öğrenci (Student)</span>
                                        <span class="block text-[10px] text-ink-muted">İlanlara başvuru &amp; staj</span>
                                    </div>
                                </label>
                                <label class="retro-card p-3 rounded-2xl flex items-center gap-3 cursor-pointer hover:bg-cream-100 transition">
                                    <input type="radio" name="intended_role" value="academic" {{ old('intended_role') === 'academic' ? 'checked' : '' }} class="accent-forest-700 w-4 h-4">
                                    <div>
                                        <span class="block text-xs font-bold text-ink-black">🏛️ Akademisyen</span>
                                        <span class="block text-[10px] text-ink-muted">Etkinlik &amp; panel oluşturma</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Department Selection -->
                        <div>
                            <label for="department_id" class="block text-xs font-bold text-ink-black mb-1.5">
                                Fakülte / Bölümünüz
                            </label>
                            <select id="department_id" name="department_id"
                                    class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black">
                                <option value="">-- Bölüm Seçiniz --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                                        {{ $dept->name }} {{ $dept->code ? '(' . $dept->code . ')' : '' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Student / Staff Number -->
                        <div>
                            <label for="student_number" class="block text-xs font-bold text-ink-black mb-1.5">
                                Öğrenci No / Akademik Sicil No
                            </label>
                            <input type="text" id="student_number" name="student_number" value="{{ old('student_number') }}"
                                   placeholder="Örn: 1205010042"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Graduation Year -->
                        <div>
                            <label for="graduation_year" class="block text-xs font-bold text-ink-black mb-1.5">
                                Mezuniyet Yılı (Mezunlar için)
                            </label>
                            <input type="number" id="graduation_year" name="graduation_year" value="{{ old('graduation_year') }}" min="1950" max="2030"
                                   placeholder="Örn: 2024"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-xs font-bold text-ink-black mb-1.5">
                                İletişim Telefonu
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="05XX XXX XX XX"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                        </div>

                        <!-- Verification Document / LinkedIn Link -->
                        <div class="sm:col-span-2">
                            <label for="verification_document_url" class="block text-xs font-bold text-ink-black mb-1.5">
                                Doğrulama Referans Bağlantısı (LinkedIn / YÖKSİS / Kurumsal Profil URL)
                            </label>
                            <input type="url" id="verification_document_url" name="verification_document_url" value="{{ old('verification_document_url') }}"
                                   placeholder="https://www.linkedin.com/in/kullaniciadi"
                                   class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                            <span class="text-[10px] text-ink-muted block mt-1">
                                İsteğe bağlıdır; doğrulama sürecinizi hızlandırmak için kamuya açık LinkedIn veya akademik profilinizi belirtebilirsiniz.
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Agreements & Submit -->
                <div class="pt-2">
                    <label class="flex items-start gap-3 cursor-pointer mb-6">
                        <input type="checkbox" name="terms" value="1" required class="accent-forest-700 w-4 h-4 mt-0.5 rounded">
                        <span class="text-xs text-ink-charcoal leading-relaxed">
                            <a href="#" class="font-bold underline hover:text-forest-700">Kullanım Koşulları</a>'nı ve 
                            <a href="#" class="font-bold underline hover:text-forest-700">KVKK Aydınlatma Metni</a>'ni okudum, kabul ediyorum.
                            Hesabımın inceleme tamamlanana kadar <strong class="text-ink-black">unverified</strong> statüsünde kalacağını biliyorum.
                        </span>
                    </label>

                    <div class="flex items-center justify-between flex-wrap gap-4">
                        <div class="text-xs text-ink-muted">
                            Zaten bir hesabınız var mı? 
                            <a href="/users" class="font-bold text-forest-700 underline">Giriş Yap / Rehber</a>
                        </div>
                        <button type="submit" class="retro-btn px-8 py-3.5 bg-forest-800 text-sticker-yellow font-bold text-sm rounded-full flex items-center gap-2 hover:bg-forest-900 shadow-[3px_3px_0px_#121214]">
                            <span>Kayıt Ol &amp; Doğrulama Başlat</span>
                            <span>&rarr;</span>
                        </button>
                    </div>
                </div>

            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-10 border-t-2 border-black mt-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 text-center text-xs text-cream-300">
            <div class="flex items-center justify-center gap-2 mb-2">
                <img src="/istanbul_university_logo.svg" alt="İÜ Logo" class="w-6 h-6 rounded-full bg-white p-0.5 inline-block">
                <p class="font-editorial text-base text-sticker-yellow">T.C. İstanbul Üniversitesi &bull; Mezun Takip Sistemi</p>
            </div>
            <p class="mb-4 text-cream-400">&copy; 1453 - 2026 T.C. İstanbul Üniversitesi Rektörlüğü. Tüm hakları saklıdır.</p>
            <div class="flex items-center justify-center gap-4 text-xs font-bold text-cream-300">
                <a href="/main" class="hover:text-sticker-yellow">Ana Sayfa</a>
                <span>&bull;</span>
                <a href="/register" class="hover:text-sticker-yellow">Kayıt Ol</a>
                <span>&bull;</span>
                <a href="/users" class="hover:text-sticker-yellow">Mezunlar</a>
                <span>&bull;</span>
                <a href="/job-postings" class="hover:text-sticker-yellow">İş İlanları</a>
                <span>&bull;</span>
                <a href="/announcements" class="hover:text-sticker-yellow">Duyurular</a>
            </div>
        </div>
    </footer>

</body>
</html>
