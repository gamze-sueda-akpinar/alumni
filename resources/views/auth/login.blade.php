<!DOCTYPE html>
<html lang="tr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap | İstanbul Üniversitesi Mezun Takip Sistemi</title>
    <meta name="description" content="İstanbul Üniversitesi Mezun Takip Sistemi kullanıcı giriş ekranı.">
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
        <span>★ T.C. İSTANBUL ÜNİVERSİTESİ REKTÖRLÜĞÜ • MEZUN &amp; ÖĞRENCİ GİRİŞ PORTALI • 1453 ★</span>
    </div>

    <!-- Header Navigation Bar -->
    <header class="max-w-4xl mx-auto px-4 sm:px-6 pt-6 pb-4 w-full">
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
                        Mezun Takip Sistemi &bull; Giriş
                    </span>
                </div>
            </a>
            <div class="flex items-center gap-3">
                <a href="/register" class="text-xs font-bold px-3.5 py-1.5 rounded-full bg-sticker-yellow text-ink-black border border-ink-black hover:bg-sticker-yellow/80 transition">
                    Yeni Kayıt Ol &rarr;
                </a>
            </div>
        </div>
    </header>

    <!-- Main Login Section -->
    <main class="max-w-md mx-auto px-4 py-8 w-full flex-1">

        <!-- Title -->
        <div class="text-center mb-6">
            <h1 class="font-editorial text-3xl sm:text-4xl font-extrabold text-ink-black tracking-tight mb-2">
                Hesabınıza Giriş Yapın
            </h1>
            <p class="text-xs text-ink-muted">
                Mezunlar, öğrenciler ve akademik personel için ortak kimlik doğrulama noktası.
            </p>
        </div>

        <!-- Informational Banner regarding Unverified login & Default Student role -->
        <div class="retro-card p-4 rounded-2xl bg-white mb-6 border-2 border-ink-black">
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-lg bg-sticker-yellow text-ink-black flex items-center justify-center text-sm font-bold border border-ink-black shadow-[1px_1px_0px_#121214] flex-shrink-0">
                    ℹ️
                </div>
                <div class="text-[11px] leading-relaxed text-ink-muted">
                    <strong class="text-ink-black block font-bold mb-0.5">Doğrulanmamış (Unverified) Giriş İzni:</strong>
                    Hesabınız henüz onaylanmamış olsa bile giriş yapabilirsiniz. Onaylanana kadar sistemde 
                    <span class="font-bold text-forest-700 bg-cream-200 px-1 py-0.5 rounded">Öğrenci (Student)</span> 
                    haklarınız aktiftir ve ilanlara başvurabilirsiniz.
                </div>
            </div>
        </div>

        <!-- Validation Errors Banner -->
        @if($errors->any())
            <div class="retro-card p-4 rounded-2xl bg-sticker-coral/20 border-2 border-ink-black mb-6">
                <div class="flex items-start gap-3">
                    <div class="w-6 h-6 rounded-full bg-sticker-coral text-white font-bold text-xs flex items-center justify-center border border-ink-black flex-shrink-0">
                        !
                    </div>
                    <ul class="text-xs text-ink-charcoal space-y-0.5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Login Form Card -->
        <div class="retro-card p-6 sm:p-8 rounded-3xl bg-white">
            <form action="{{ route('login.submit') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div>
                    <label for="email" class="block text-xs font-bold text-ink-black mb-1.5">
                        E-posta Adresi
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           placeholder="ornek@istanbul.edu.tr"
                           class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                </div>

                <!-- Password Input -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-xs font-bold text-ink-black">
                            Şifre
                        </label>
                        <a href="#" class="text-[10px] text-ink-muted hover:text-forest-700 underline">Şifremi Unuttum</a>
                    </div>
                    <input type="password" id="password" name="password" required
                           placeholder="••••••••"
                           class="retro-input w-full px-4 py-2.5 rounded-xl bg-cream-50 text-xs text-ink-black placeholder:text-ink-muted/50">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember" value="1" class="accent-forest-700 w-4 h-4 rounded">
                        <span class="text-xs text-ink-charcoal">Beni Hatırla</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="retro-btn w-full py-3 bg-forest-800 text-sticker-yellow font-bold text-sm rounded-full flex items-center justify-center gap-2 hover:bg-forest-900 shadow-[3px_3px_0px_#121214]">
                        <span>Giriş Yap</span>
                        <span>&rarr;</span>
                    </button>
                </div>

                <!-- Alternative Link -->
                <div class="text-center pt-3 border-t border-cream-200 text-xs text-ink-muted">
                    Henüz bir hesabınız yok mu? 
                    <a href="{{ route('register') }}" class="font-bold text-forest-700 underline ml-1">
                        Hemen Kayıt Olun
                    </a>
                </div>
            </form>
        </div>

    </main>

    <!-- Footer -->
    <footer class="bg-ink-black text-white py-8 border-t-2 border-black mt-12">
        <div class="max-w-4xl mx-auto px-4 text-center text-xs text-cream-300">
            <div class="flex items-center justify-center gap-2 mb-2">
                <img src="/istanbul_university_logo.svg" alt="İÜ Logo" class="w-6 h-6 rounded-full bg-white p-0.5 inline-block">
                <p class="font-editorial text-sm text-sticker-yellow">T.C. İstanbul Üniversitesi &bull; Mezun Takip Sistemi</p>
            </div>
            <p class="text-cream-400 text-[11px]">&copy; 1453 - 2026 T.C. İstanbul Üniversitesi Rektörlüğü</p>
        </div>
    </footer>

</body>
</html>
