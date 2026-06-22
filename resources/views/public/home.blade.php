
<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dido's Hotel</title>
    @vite(['resources/css/app.css'])

    <style>
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .fade-up {
            animation: fadeUp 0.8s ease forwards;
        }

        .fade-up-2 {
            animation: fadeUp 0.8s ease 0.2s forwards;
            opacity: 0;
        }

        .fade-up-3 {
            animation: fadeUp 0.8s ease 0.4s forwards;
            opacity: 0;
        }

        .float-anim {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-[#121214] text-white">

<nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
    style="background: rgba(18,18,20,0.8)">

    <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">

        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                <img src="{{ asset('images/logo.jpg') }}"
                    onerror="this.style.display='none'"
                    class="w-full h-full object-cover"
                    alt="Logo">
            </div>

            <span class="text-sm font-semibold">
                Dido's Hotel
            </span>
        </div>


        <div class="hidden md:flex items-center gap-6 text-sm text-white/60">

            <a href="#kamar"
                class="hover:text-white transition-colors">
                Room
            </a>

            <a href="#fasilitas"
                class="hover:text-white transition-colors">
                Facility
            </a>

            <a href="#ulasan"
                class="hover:text-white transition-colors">
                Review
            </a>


            <a href="{{ route('rooms') }}"
                class="px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all hover:opacity-90 bg-red-950 border border-red-800">
                Book Now
            </a>

        </div>

    </div>

</nav>



<section class="relative min-h-screen flex items-center justify-center overflow-hidden">

    <div class="absolute inset-0">

        <div class="absolute inset-0 bg-[#121214]"></div>

    </div>



    <div class="relative z-10 max-w-4xl mx-auto px-6 text-center">


        <div class="fade-up">

            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-medium mb-6
            bg-black-500/20 text-blue-400 border border-black-500/30">

                ✦ {{ $availableCount }} Rooms Available Today

            </span>

        </div>



        <h1 class="fade-up-2 text-5xl md:text-6xl font-bold leading-tight mb-6">

            Welcome To<br>
            Dido<br>Hotel

        </h1>



        <p class="fade-up-3 text-white/50 text-lg max-w-2xl mx-auto mb-10 leading-relaxed">

            Enjoy An Unforgettable Stay With Premium Amenities And Top-Notch Service In The Heart Of The City.

        </p>



        <div class="fade-up-3 flex items-center justify-center gap-4 flex-wrap">


            <a href="{{ route('rooms') }}"
                class="px-8 py-3.5 rounded-2xl font-semibold text-white transition-all hover:opacity-90 active:scale-95 shadow-lg"
                style="background: #121214;
                box-shadow:0 0 30px rgba(124,58,237,0.4)">

                View & Book Rooms

            </a>



            <a href="#ulasan"
                class="px-8 py-3.5 rounded-2xl font-medium text-white/70 border border-white/10
                hover:bg-white/5 hover:text-white transition-all">

                Guest Reviews

            </a>


        </div>


    </div>


    <div class="absolute bottom-8 left-1/2 -translate-x-1/2 float-anim">

        <div class="w-6 h-10 rounded-full border border-white/20 flex items-start justify-center pt-2">

            <div class="w-1 h-2 rounded-full bg-white/40"></div>

        </div>

    </div>


</section>



{{-- ── ROOM TYPES ── --}}

Room Selection

Find Your Dream Room

Choose From a Variety Of Room Types Tailored To Your Needs.

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    @foreach($roomTypes as $type)
        <div
            class="group relative bg-white/4 border border-white/8 rounded-2xl overflow-hidden
                                        hover:border-blue-500/30 hover:bg-white/6 transition-all duration-300">

            {{-- Image placeholder --}}
            <div class="h-48 relative overflow-hidden bg-zinc-950">

                @if($type->thumbnail)
                    <img src="{{ asset('storage/' . $type->thumbnail) }}" alt="{{ $type->name }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <span class="text-5xl opacity-30">🛏️</span>
                    </div>
                @endif

                <div class="absolute inset-0 bg-black/40"></div>

                <div class="absolute bottom-3 left-4">
                    <span class="text-xs px-2.5 py-1 rounded-full bg-blue-600/80 text-white font-medium">
                        {{ $type->rooms_count }} rooms available
                    </span>
                </div>
            </div>

            <div class="p-5">
                <h3 class="text-lg font-semibold mb-1">{{ $type->name }}</h3>
                <p class="text-white/40 text-sm mb-4 leading-relaxed">{{ $type->description }}</p>

                {{-- Facilities --}}
                @if($type->facilities)
                    <div class="flex flex-wrap gap-2 mb-5">
                        @foreach(array_slice($type->facilities, 0, 4) as $facility)
                            <span class="text-xs px-2.5 py-1 rounded-lg bg-white/5 text-white/50 border border-white/8">
                                {{ $facility }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-xl font-bold text-blue-400">
                            Rp {{ number_format($type->price_per_night, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-white/30">/night</span>
                    </div>

                    <a href="{{ route('rooms') }}"
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all bg-blue-600 hover:bg-blue-700">
                        Book Now
                    </a>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ── FACILITIES ── --}}
<section id="fasilitas" class="py-20 px-6 border-t border-white/5">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-blue-400 text-sm font-medium tracking-widest uppercase mb-3">Facilities</p>
            <h2 class="text-3xl font-bold">Everything You Need</h2>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['🍽️', 'Restaurant', 'Open 24 Hours'],
                ['🏊', 'Swimming Pool', 'Indoor & Outdoor'],
                ['🅿️', 'Parking Area', 'Free for Guests'],
                ['📶', 'High-Speed WiFi', 'Free 100 Mbps'],
                ['🏋️', 'Fitness Center', 'Fully Equipped'],
                ['🧖', 'Spa & Sauna', 'Premium Relaxation'],
                ['🎭', 'Ballroom', 'Capacity up to 500 Guests'],
                ['🚗', 'Shuttle Service', 'Airport & Train Station']
            ] as [$icon, $name, $desc])

                <div class="bg-white/4 border border-white/8 rounded-2xl p-5 hover:border-blue-500/30 transition-all duration-200">
                    <div class="text-3xl mb-3">{{ $icon }}</div>
                    <div class="text-sm font-semibold mb-1">{{ $name }}</div>
                    <div class="text-xs text-white/40">{{ $desc }}</div>
                </div>

            @endforeach
        </div>
    </div>
</section>

{{-- ── GUEST REVIEWS ── --}}
<section id="ulasan" class="py-20 px-6 border-t border-white/5">
    <div class="max-w-6xl mx-auto">
        <div class="text-center mb-12">
            <p class="text-blue-400 text-sm font-medium tracking-widest uppercase mb-3">Guest Reviews</p>
            <h2 class="text-3xl font-bold">What Our Guests Say</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            @forelse($reviews as $review)

                <div class="bg-white/4 border border-white/8 rounded-2xl p-6 hover:border-blue-500/20 transition-all">

                    <div class="flex items-center gap-1 mb-4">
                        {{-- Stars --}}
                    </div>

                    <p class="text-white/60 text-sm leading-relaxed mb-5 italic">
                        "{{ $review->comment }}"
                    </p>

                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white bg-zinc-800 border border-zinc-700">
                            {{ strtoupper(substr($review->guest_name, 0, 2)) }}
                        </div>

                        <div>
                            <div class="text-sm font-medium">{{ $review->guest_name }}</div>
                            <div class="text-xs text-white/30">{{ $review->created_at->format('M Y') }}</div>
                        </div>
                    </div>

                </div>

            @empty

                <div class="col-span-3 text-center text-white/30 text-sm py-10">
                    No reviews yet.
                </div>

            @endforelse
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="border-t border-white/5 py-10 px-6">
    <div class="max-w-6xl mx-auto flex flex-col md:flex-row items-center justify-between gap-4">

        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10">
                <img src="{{ asset('images/logo.png') }}"
                    onerror="this.style.display='none'"
                    class="w-full h-full object-cover"
                    alt="Logo">
            </div>

            <span class="text-sm font-medium text-white/60">Dido's Hotel</span>
        </div>

        <p class="text-xs text-white/30">
            © 2026 Dido's Hotel. All Rights Reserved.
        </p>

        <a href="{{ route('login') }}"
            class="text-xs text-white/20 hover:text-white/50 transition-colors">
            Staff Login →
        </a>

    </div>
</footer>
```
