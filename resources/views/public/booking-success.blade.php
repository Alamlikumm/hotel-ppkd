
{{-- Success Animation --}}
<div class="scale-in w-20 h-20 rounded-full mx-auto mb-6 flex items-center justify-center bg-blue-500/20 border-2 border-blue-500/50">
    <svg class="w-10 h-10" viewBox="0 0 40 40" fill="none">
        <path class="check-anim" d="M10 20 L17 27 L30 13"
              stroke="#3B82F6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</div>

<h1 class="text-2xl font-bold mb-2">Booking Successful! 🎉</h1>
<p class="text-white/40 text-sm mb-8">
    Thank you, <span class="text-white font-medium">{{ $booking->guest_name }}</span>!<br>
    Your booking is currently awaiting our confirmation.
</p>

{{-- Booking Details --}}
<div class="bg-white/4 border border-white/8 rounded-2xl p-6 text-left mb-6">
    <div class="flex items-center justify-between mb-5 pb-4 border-b border-white/5">
        <span class="text-sm font-medium">Booking Code</span>
        <span class="font-mono font-bold text-blue-400 text-lg">{{ $booking->booking_code }}</span>
    </div>

    <div class="space-y-3 text-sm">
        @foreach([
            ['Room',        $booking->room->room_number . ' · ' . $booking->room->roomType->name],
            ['Floor',       'Floor ' . $booking->room->floor],
            ['Check-in',    $booking->check_in->format('d M Y')],
            ['Check-out',   $booking->check_out->format('d M Y')],
            ['Duration',    $booking->total_nights . ' night' . ($booking->total_nights > 1 ? 's' : '')],
            ['Total Price', 'Rp ' . number_format($booking->total_price, 0, ',', '.')],
            ['Status',      'Pending Confirmation'],
        ] as [$label, $value])

        <div class="flex justify-between">
            <span class="text-white/40">{{ $label }}</span>
            <span class="{{ $label === 'Status' ? 'text-amber-400 font-medium' : 'text-white font-medium' }}">
                {{ $value }}
            </span>
        </div>

        @endforeach
    </div>
</div>

<div class="bg-amber-500/10 border border-amber-500/20 rounded-xl px-4 py-3 text-left mb-6">
    <p class="text-xs text-amber-400/80 leading-relaxed">
        📧 A confirmation email will be sent to <strong>{{ $booking->guest_email }}</strong>.
        Our team will also contact you via WhatsApp at
        <strong>{{ $booking->guest_phone }}</strong>
        for further confirmation.
    </p>
</div>

<div class="flex gap-3">
    <a href="{{ route('home') }}"
       class="flex-1 py-3 rounded-xl text-sm font-medium text-white/60 border border-white/10
              hover:bg-white/5 hover:text-white transition-all">
        Back to Home
    </a>

    <a href="{{ route('rooms') }}"
       class="flex-1 py-3 rounded-xl text-sm font-semibold text-white transition-all bg-blue-600 hover:bg-blue-700">
        Book Another Room
    </a>
</div>
