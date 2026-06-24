<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Success — Dido's Hotel</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes scaleIn {
            0% { transform: scale(0.9); opacity: 0; }
            100% { transform: scale(1); opacity: 1; }
        }
        @keyframes drawCheck {
            0% { stroke-dashoffset: 35; }
            100% { stroke-dashoffset: 0; }
        }
        .scale-in {
            animation: scaleIn 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .check-anim {
            stroke-dasharray: 35;
            stroke-dashoffset: 35;
            animation: drawCheck 0.6s cubic-bezier(0.65, 0, 0.45, 1) 0.2s forwards;
        }
    </style>
</head>
<body class="bg-[#121214] text-white min-h-screen flex flex-col justify-between">

    {{-- Navbar --}}
    <nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
        style="background: rgba(18,18,20,0.8)">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-semibold">Dido's Hotel</span>
            </a>

            <div class="flex items-center gap-2 sm:gap-4">
                @auth
                    <span class="text-xs text-white/50 hidden md:inline">
                        Hi, <span class="font-medium text-white">{{ auth()->user()->name }}</span>
                    </span>
                    <a href="{{ route('admin.dashboard') }}" class="text-xs px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg bg-white/5 border border-white/10 hover:bg-white/10 text-white transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                        </svg>
                        <span class="hidden sm:inline">Dashboard</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg bg-red-500/10 border border-red-500/20 hover:bg-red-500/20 text-red-400 transition-colors flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-xs px-2.5 py-1.5 sm:px-3 sm:py-1.5 rounded-lg bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/20 text-blue-400 transition-colors flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Login</span>
                    </a>
                @endauth
                <a href="{{ route('rooms') }}" class="text-xs text-white/50 hover:text-white transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Rooms</span>
                </a>
            </div>
        </div>
    </nav>

    {{-- Content --}}
    <div class="max-w-md mx-auto px-6 pt-28 pb-16 w-full flex-1 flex flex-col justify-center">
        <div class="scale-in bg-white/5 backdrop-blur-2xl border border-white/10 rounded-3xl p-8 shadow-2xl text-center">
            
            {{-- Success Animation --}}
            <div class="w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center bg-green-500/10 border-2 border-green-500/30">
                <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none">
                    <path class="check-anim" d="M10 20 L17 27 L30 13"
                          stroke="#10B981" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="text-2xl font-bold mb-2 text-white">Booking Successful! 🎉</h1>
            <p class="text-white/40 text-sm mb-6 leading-relaxed">
                Thank you, <span class="text-white font-medium">{{ $booking->guest_name }}</span>!<br>
                Your booking is currently awaiting our confirmation.
            </p>

            {{-- Booking Details --}}
            <div class="bg-white/4 border border-white/8 rounded-2xl p-5 text-left mb-6">
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-white/5">
                    <span class="text-xs text-white/40 uppercase tracking-wider font-semibold">Booking Code</span>
                    <span class="font-mono font-bold text-blue-400 text-lg">{{ $booking->booking_code }}</span>
                </div>

                <div class="space-y-2.5 text-sm">
                    @foreach([
                        ['Room',        $booking->room->room_number . ' · ' . $booking->room->roomType->name],
                        ['Floor',       'Floor ' . $booking->room->floor],
                        ['Check-in',    $booking->check_in->format('d M Y')],
                        ['Check-out',   $booking->check_out->format('d M Y')],
                        ['Duration',    $booking->total_nights . ' night' . ($booking->total_nights > 1 ? 's' : '')],
                        ['Total Price', 'Rp ' . number_format($booking->total_price, 0, ',', '.')],
                        ['Status',      'Pending Confirmation'],
                    ] as [$label, $value])

                    <div class="flex justify-between items-center">
                        <span class="text-white/40 text-xs">{{ $label }}</span>
                        <span class="{{ $label === 'Status' ? 'text-amber-400 font-semibold text-xs px-2.5 py-0.5 rounded-full bg-amber-500/10 border border-amber-500/20' : 'text-white/90 font-medium' }}">
                            {{ $value }}
                        </span>
                    </div>

                    @endforeach
                </div>
            </div>

            {{-- Contact Information --}}
            <div class="bg-blue-500/10 border border-blue-500/20 rounded-2xl px-4 py-3.5 text-left mb-6">
                <p class="text-xs text-blue-300 leading-relaxed">
                    📧 A confirmation email will be sent to <strong>{{ $booking->guest_email }}</strong>.
                    Our team will also contact you via WhatsApp at
                    <strong>{{ $booking->guest_phone }}</strong>
                    for further confirmation.
                </p>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('home') }}"
                   class="flex-1 py-3 rounded-xl text-sm font-medium text-white/60 border border-white/10
                          hover:bg-white/5 hover:text-white transition-all text-center">
                    Back to Home
                </a>

                <a href="{{ route('rooms') }}"
                   class="flex-1 py-3 rounded-xl text-sm font-semibold text-white transition-all bg-blue-600 hover:bg-blue-700 text-center shadow-lg shadow-blue-600/25">
                    Book Another Room
                </a>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="py-6 text-center border-t border-white/5">
        <p class="text-white/20 text-xs">
            © 2026 Dido's Hotel. All rights reserved.
        </p>
    </footer>
</body>
</html>
