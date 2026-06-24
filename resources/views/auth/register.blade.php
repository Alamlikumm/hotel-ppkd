<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Guest — Dido's Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33%       { transform: translateY(-20px) rotate(1deg); }
            66%       { transform: translateY(-10px) rotate(-1deg); }
        }
        @keyframes floatDelay {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33%       { transform: translateY(-15px) rotate(-1deg); }
            66%       { transform: translateY(-25px) rotate(1deg); }
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .float-1 { animation: float 7s ease-in-out infinite; }
        .float-2 { animation: floatDelay 9s ease-in-out infinite; }
        .float-3 { animation: float 11s ease-in-out infinite reverse; }
        .fade-up-1 { animation: fadeUp 0.6s ease forwards; }
        .fade-up-2 { animation: fadeUp 0.6s ease 0.1s forwards; opacity: 0; }
        .fade-up-3 { animation: fadeUp 0.6s ease 0.2s forwards; opacity: 0; }
        .fade-up-4 { animation: fadeUp 0.6s ease 0.3s forwards; opacity: 0; }
        .pulse-ring::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: 50%;
            border: 2px solid rgba(59,130,246,0.5);
            animation: pulse-ring 2s ease-out infinite;
        }
        @keyframes pulse-ring {
            0%   { transform: scale(0.8); opacity: 0.8; }
            100% { transform: scale(1.6); opacity: 0; }
        }
    </style>
</head>
<body class="h-full bg-[#121214] overflow-hidden">

    {{-- Background --}}
    <div class="absolute inset-0 bg-[#121214]"></div>
    <div class="absolute top-[15%] left-[10%] float-1 opacity-20">
        <div class="w-16 h-16 border border-blue-500/30 rounded-xl rotate-12"></div>
    </div>
    <div class="absolute top-[60%] left-[6%] float-2 opacity-15">
        <div class="w-10 h-10 border border-blue-400/20 rounded-full"></div>
    </div>
    <div class="absolute top-[30%] right-[8%] float-3 opacity-20">
        <div class="w-20 h-20 border border-blue-400/30 rounded-2xl rotate-45"></div>
    </div>

    {{-- Main Content --}}
    <div class="relative z-10 min-h-screen flex">
        {{-- Left — Branding --}}
        <div class="hidden lg:flex flex-col justify-between w-[55%] p-14">
            <div class="fade-up-1">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600/20 border border-blue-500/30 flex items-center justify-center">
                        <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'" class="w-6 h-6 object-contain" alt="Logo">
                    </div>
                    <span class="text-white/80 text-sm font-medium tracking-widest uppercase">Dido's Hotel</span>
                </div>
            </div>
            <div>
                <div class="fade-up-2">
                    <p class="text-blue-450 text-sm font-medium tracking-widest uppercase mb-4">Guest Registration</p>
                    <h1 class="text-5xl font-bold leading-tight mb-6">
                        <span class="text-white">Create Account</span>
                        <br>
                        <span class="text-white/40">&amp; Book Rooms</span>
                    </h1>
                </div>
                <div class="fade-up-3">
                    <p class="text-white/40 text-base leading-relaxed max-w-md">
                        Join us to book rooms online instantly, manage your bookings, and access exclusive hotel F&B orders.
                    </p>
                </div>
            </div>
            <div class="fade-up-4">
                <p class="text-white/20 text-xs">© 2026 Dido's Hotel. All rights reserved.</p>
            </div>
        </div>

        {{-- Right — Register Form --}}
        <div class="flex-1 flex items-center justify-center p-6 lg:p-14 overflow-y-auto max-h-screen">
            <div class="w-full max-w-[420px] fade-up-2 py-8">
                <div class="relative bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl">
                    {{-- Logo mobile --}}
                    <div class="flex lg:hidden items-center gap-2 mb-6">
                        <div class="w-8 h-8 rounded-lg bg-blue-600/30 border border-blue-500/30 flex items-center justify-center">
                            <img src="{{ asset('images/logo.jpg') }}" onerror="this.style.display='none'" class="w-5 h-5 object-contain" alt="Logo">
                        </div>
                        <span class="text-white/70 text-sm font-medium">Dido's Hotel</span>
                    </div>

                    {{-- Header --}}
                    <div class="relative inline-block mb-4 pulse-ring">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center bg-blue-600 border border-blue-500">
                            <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl font-bold text-white">Sign Up</h2>
                    <p class="text-white/40 text-sm mt-1 mb-6">Create your guest account to continue booking</p>

                    {{-- Error Alert --}}
                    @if ($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 flex items-start gap-3">
                        <svg class="w-4 h-4 text-red-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                        </svg>
                        <p class="text-red-400 text-sm">{{ $errors->first() }}</p>
                    </div>
                    @endif

                    {{-- Form --}}
                    <form method="POST" action="{{ route('register') }}" class="space-y-4">
                        @csrf

                        {{-- Name --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-1 uppercase tracking-wider">Full Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm text-white bg-white/5 border border-white/10 placeholder:text-white/20 focus:outline-none focus:border-blue-500/60 focus:bg-white/8 transition-all">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-1 uppercase tracking-wider">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="example@email.com" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm text-white bg-white/5 border border-white/10 placeholder:text-white/20 focus:outline-none focus:border-blue-500/60 focus:bg-white/8 transition-all">
                        </div>

                        {{-- Password --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-1 uppercase tracking-wider">Password</label>
                            <input type="password" name="password" placeholder="••••••••" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm text-white bg-white/5 border border-white/10 placeholder:text-white/20 focus:outline-none focus:border-blue-500/60 focus:bg-white/8 transition-all">
                        </div>

                        {{-- Confirm Password --}}
                        <div>
                            <label class="block text-xs font-medium text-white/50 mb-1 uppercase tracking-wider">Confirm Password</label>
                            <input type="password" name="password_confirmation" placeholder="••••••••" required
                                   class="w-full px-4 py-2.5 rounded-xl text-sm text-white bg-white/5 border border-white/10 placeholder:text-white/20 focus:outline-none focus:border-blue-500/60 focus:bg-white/8 transition-all">
                        </div>

                        {{-- Submit --}}
                        <button type="submit" class="w-full py-3 mt-2 rounded-xl text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 transition-all focus:outline-none focus:ring-2 focus:ring-blue-500/50">
                            Create Account
                        </button>
                    </form>

                    {{-- Footer --}}
                    <div class="mt-6 pt-4 border-t border-white/5 text-center">
                        <p class="text-white/40 text-xs">
                            Already have an account? <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Login here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
