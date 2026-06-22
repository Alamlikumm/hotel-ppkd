<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room {{ $room->room_number }} — Dido Hotel</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#121214] text-white min-h-screen">

    <nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
        style="background: rgba(18,18,20,0.8)">
        <div class="max-w-5xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                    <img src="{{ asset('images/logo.png') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-semibold">Dido Hotel</span>
            </a>

            <a href="{{ route('rooms') }}" class="text-sm text-white/50 hover:text-white transition-colors">
                ← Choose Another Room
            </a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 pt-28 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Room Information --}}
            <div>
                <p class="text-blue-400 text-xs font-medium tracking-widest uppercase mb-3">
                    Room Details
                </p>

                <div class="bg-white/4 border border-white/8 rounded-2xl overflow-hidden mb-4">

                    <div class="h-48 flex items-center justify-center bg-zinc-950 border-b border-white/8">
                        <span class="text-6xl opacity-30">🛏️</span>
                    </div>

                    <div class="p-5">

                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <h2 class="text-xl font-bold">
                                    Room {{ $room->room_number }}
                                </h2>

                                <p class="text-white/40 text-sm mt-0.5">
                                    {{ $room->roomType->name }} · Floor {{ $room->floor }}
                                </p>
                            </div>

                            <span
                                class="text-xs px-2.5 py-1 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/20">
                                Available
                            </span>
                        </div>

                        <p class="text-white/50 text-sm leading-relaxed mb-4">
                            {{ $room->roomType->description }}
                        </p>

                        @if($room->roomType->facilities)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($room->roomType->facilities as $f)
                                    <span class="text-xs px-2.5 py-1 rounded-lg bg-white/5 text-white/50 border border-white/8">
                                        {{ $f }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="pt-4 border-t border-white/5">
                            <span class="text-2xl font-bold text-blue-400">
                                Rp {{ number_format($room->roomType->price_per_night,0,',','.') }}
                            </span>

                            <span class="text-white/30 text-sm">
                                /night
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Price Estimate --}}
                <div id="price-estimate"
                    class="hidden bg-blue-500/10 border border-blue-500/20 rounded-2xl p-4">

                    <p class="text-xs text-blue-300 font-medium mb-2">
                        Estimated Total
                    </p>

                    <div class="flex justify-between text-sm text-white/60 mb-1">
                        <span id="nights-text">0 nights</span>

                        <span id="price-per-night">
                            Rp {{ number_format($room->roomType->price_per_night,0,',','.') }}/Night
                        </span>
                    </div>

                    <div class="flex justify-between text-lg font-bold text-white mt-2 pt-2 border-t border-white/10">
                        <span>Total</span>
                        <span id="total-price" class="text-blue-400">
                            Rp 0
                        </span>
                    </div>
                </div>

            </div>

            {{-- Guest Information --}}
            <div>
                <p class="text-blue-400 text-xs font-medium tracking-widest uppercase mb-3">
                    Guest Information
                </p>

                <div class="bg-white/4 border border-white/8 rounded-2xl p-6">

                    @if($errors->any())
                        <div class="mb-5 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('booking.store', $room) }}" class="space-y-4">
                        @csrf

                        {{-- Full Name --}}
                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Full Name
                            </label>

                            <input
                                type="text"
                                name="guest_name"
                                value="{{ old('guest_name') }}"
                                placeholder="Enter your full name"
                                class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                       text-white placeholder:text-white/20
                                       focus:outline-none focus:ring-2 focus:ring-blue-500/40
                                       focus:border-blue-500/50 transition duration-200">
                        </div>

                        {{-- Email --}}
                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Email
                            </label>

                            <input
                                type="email"
                                name="guest_email"
                                value="{{ old('guest_email') }}"
                                placeholder="example@email.com"
                                class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                       text-white placeholder:text-white/20
                                       focus:outline-none focus:ring-2 focus:ring-blue-500/40
                                       focus:border-blue-500/50 transition duration-200">
                        </div>

                        {{-- WhatsApp --}}
                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                WhatsApp Number
                            </label>

                            <input
                                type="text"
                                name="guest_phone"
                                value="{{ old('guest_phone') }}"
                                placeholder="+62 812 3456 7890"
                                class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                       text-white placeholder:text-white/20
                                       focus:outline-none focus:ring-2 focus:ring-blue-500/40
                                       focus:border-blue-500/50 transition duration-200">
                        </div>

                        {{-- Check In / Out --}}
                        <div class="grid grid-cols-2 gap-3">

                            <div>
                                <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                    Check-in
                                </label>

                                <input
                                    type="date"
                                    name="check_in"
                                    id="check_in"
                                    value="{{ old('check_in') }}"
                                    min="{{ date('Y-m-d') }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                           text-white focus:outline-none
                                           focus:ring-2 focus:ring-blue-500/40
                                           transition duration-200">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                    Check-out
                                </label>

                                <input
                                    type="date"
                                    name="check_out"
                                    id="check_out"
                                    value="{{ old('check_out') }}"
                                    min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                    class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                           text-white focus:outline-none
                                           focus:ring-2 focus:ring-blue-500/40
                                           transition duration-200">
                            </div>

                        </div>

                        {{-- Notes --}}
                        <div>
                            <label class="block text-xs font-semibold text-white/40 uppercase tracking-wider mb-2">
                                Notes
                                <span class="normal-case font-normal opacity-60">(Optional)</span>
                            </label>

                            <textarea
                                name="notes"
                                rows="2"
                                placeholder="Special requests, arrival time, etc..."
                                class="w-full px-4 py-3 rounded-xl text-sm bg-white/5 border border-white/10
                                       text-white placeholder:text-white/20 resize-none
                                       focus:outline-none focus:ring-2 focus:ring-blue-500/40
                                       transition duration-200">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Submit --}}
                        <button
                            type="submit"
                            class="w-full py-3.5 rounded-xl text-sm font-semibold text-white
                                   transition-all bg-blue-600 hover:bg-blue-700 active:scale-95 mt-2">

                            Confirm Booking

                        </button>

                        <p class="text-center text-xs text-white/25">
                            Your booking will remain
                            <span class="text-amber-400">Pending</span>
                            Until Confirmed By Our Staff.
                        </p>

                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        const pricePerNight = {{ $room->roomType->price_per_night }};

        function updateEstimate() {
            const checkIn = new Date(document.getElementById('check_in').value);
            const checkOut = new Date(document.getElementById('check_out').value);

            if (checkIn && checkOut && checkOut > checkIn) {

                const nights = Math.round(
                    (checkOut - checkIn) / (1000 * 60 * 60 * 24)
                );

                const total = nights * pricePerNight;

                document.getElementById('nights-text').textContent =
                    nights + (nights === 1 ? ' night' : ' nights');

                document.getElementById('price-per-night').textContent =
                    'Rp ' + pricePerNight.toLocaleString('id-ID') + '/night';

                document.getElementById('total-price').textContent =
                    'Rp ' + total.toLocaleString('id-ID');

                document.getElementById('price-estimate').classList.remove('hidden');

            } else {

                document.getElementById('price-estimate').classList.add('hidden');

            }
        }

        document
            .getElementById('check_in')
            .addEventListener('change', updateEstimate);

        document
            .getElementById('check_out')
            .addEventListener('change', updateEstimate);

        updateEstimate();
    </script>

</body>

</html>


</body>

</html>