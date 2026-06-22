<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Room — Dido Hotel</title>
    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#121214] text-white min-h-screen">

    {{-- Navbar --}}
    <nav class="fixed top-0 inset-x-0 z-50 backdrop-blur-md border-b border-white/5"
        style="background: rgba(18,18,20,0.8)">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg overflow-hidden bg-white/10 border border-white/20">
                    <img src="{{ asset('images/logo.jpg') }}" onerror="this.style.display='none'"
                        class="w-full h-full object-cover" alt="Logo">
                </div>
                <span class="text-sm font-semibold">Dido Hotel</span>
            </a>
            <a href="{{ route('home') }}" class="text-sm text-white/50 hover:text-white transition-colors">
                ← Return
            </a>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-6 pt-28 pb-20">
        <div class="mb-10">
            <p class="text-black-400 text-sm font-medium tracking-widest uppercase mb-2">Select Room</p>
            <h1 class="text-3xl font-bold mb-2">Rooms Available</h1>
            <p class="text-white/40 text-sm">All Rooms Below Are Ready To Be Booked</p>
        </div>

        @if(session('error'))
            <div class="mb-6 px-4 py-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @foreach($rooms as $typeId => $roomsInType)
            @php $type = $roomTypes_model[$typeId] ?? null; @endphp
            <div class="mb-12">
                <div class="flex items-center gap-4 mb-5">
                    <h2 class="text-xl font-semibold">{{ $roomsInType->first()->roomType->name }}</h2>
                    <span
                        class="text-xs px-3 py-1 rounded-full bg-blue-500/20 text-blue-300 border border-blue-500/20">
                        Rp {{ number_format($roomsInType->first()->roomType->price_per_night, 0, ',', '.') }}/Night
                    </span>
                    <span class="text-xs text-white/30">{{ $roomsInType->count() }} Rooms Available </span>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($roomsInType as $room)
                        <div
                            class="bg-white/4 border border-white/8 rounded-2xl p-5
                                                                                                                hover:border-black-500/40 hover:bg-white/6 transition-all duration-200 group">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <div class="text-2xl font-bold text-white">{{ $room->room_number }}</div>
                                    <div class="text-xs text-white/30 mt-0.5">Floor {{ $room->floor }}</div>
                                </div>
                                <span class="text-xs px-2 py-1 rounded-lg bg-blue-500/20 text-blue-300 font-medium">
                                    Available
                                </span>
                            </div>

                            @if($room->roomType->facilities)
                                <div class="flex flex-wrap gap-1 mb-4">
                                    @foreach(array_slice($room->roomType->facilities, 0, 3) as $f)
                                        <span class="text-[10px] px-2 py-0.5 rounded-md bg-white/5 text-white/40">{{ $f }}</span>
                                    @endforeach
                                </div>
                            @endif

                            <a href="{{ route('booking.create', $room) }}"
                                class="block w-full text-center py-2.5 rounded-xl text-xs font-semibold text-white
                                                                                                                  transition-all duration-200 bg-blue-600 hover:bg-blue-700 active:scale-95">
                                Book This Room
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        @if($rooms->isEmpty())
            <div class="text-center py-20">
                <div class="text-5xl mb-4 opacity-30">🛏️</div>
                <p class="text-white/40">Sorry, There Are No Rooms Available At This Time.</p>
                <a href="{{ route('home') }}" class="inline-block mt-4 text-blue-400 text-sm hover:underline">
                    Return To Main Page
                </a>
            </div>
        @endif
    </div>

</body>

</html>
