@extends('layouts.admin')
@section('title', 'Housekeeping')
@section('subtitle', "Housekeeping & Room Inspection Dido's Hotel")

@section('content')

{{-- Filter & Stats --}}
<div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
    <form method="GET" class="flex flex-wrap items-center gap-2">
        <select name="floor" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-zinc-900 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-blue-500/30">
            <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">All Floors</option>
            @foreach($floors as $floor)
            <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">
                Floor {{ $floor }}
            </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-zinc-900 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-blue-500/30">
            <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">All Status</option>
            <option value="available"   {{ request('status') == 'available'   ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Available (Clean & Ready)</option>
            <option value="occupied"    {{ request('status') == 'occupied'    ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Occupied</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Maintenance (Requires Cleaning/Inspection)</option>
        </select>
    </form>

    {{-- Legend / Quick Info --}}
    <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 dark:text-white/40">
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>Clean & Ready ({{ $rooms->where('status','available')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>Occupied ({{ $rooms->where('status','occupied')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Dirty / Maintenance ({{ $rooms->where('status','maintenance')->count() }})</span>
    </div>
</div>

{{-- Rooms Grid --}}
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
    @forelse($rooms as $room)
    @php
    $style = match($room->status) {
        'available'   => [
            'card' => 'border-blue-200 dark:border-blue-500/20 bg-blue-50/10 dark:bg-blue-500/5',
            'badge' => 'bg-blue-50 dark:bg-blue-500/20 text-blue-700 dark:text-blue-300',
            'dot' => 'bg-blue-500',
            'label' => 'Clean & Ready'
        ],
        'occupied'    => [
            'card' => 'border-red-200 dark:border-red-500/20 bg-red-50/10 dark:bg-red-500/5',
            'badge' => 'bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-300',
            'dot' => 'bg-red-400',
            'label' => 'Occupied'
        ],
        'maintenance' => [
            'card' => 'border-amber-300 dark:border-amber-500/30 bg-amber-50/15 dark:bg-amber-500/5 animate-pulse-slow',
            'badge' => 'bg-amber-50 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300',
            'dot' => 'bg-amber-400',
            'label' => 'Dirty / Needs Inspection'
        ],
        default       => [
            'card' => 'border-gray-200 bg-white',
            'badge' => 'bg-gray-100 text-gray-500',
            'dot' => 'bg-gray-400',
            'label' => '-'
        ],
    };
    @endphp
    <div class="border rounded-2xl p-5 flex flex-col justify-between {{ $style['card'] }} hover:shadow-md transition-all duration-200">
        <div>
            <div class="flex items-start justify-between mb-2">
                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white leading-none mb-1">Room {{ $room->room_number }}</h3>
                    <p class="text-xs text-gray-400 dark:text-white/30">Floor {{ $room->floor }} • {{ $room->roomType->name }}</p>
                </div>
                <span class="flex items-center gap-1.5 text-[11px] px-2.5 py-1 rounded-full font-semibold {{ $style['badge'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                    {{ $style['label'] }}
                </span>
            </div>

            {{-- Notes --}}
            <div class="mt-3 p-3 bg-gray-50 dark:bg-white/5 rounded-xl border border-gray-100 dark:border-white/5 min-h-[50px]">
                <p class="text-[11px] font-semibold uppercase text-gray-400 dark:text-white/20 tracking-wider mb-1">Notes Housekeeping</p>
                <p class="text-xs text-gray-600 dark:text-white/70 italic leading-relaxed">
                    {{ $room->notes ?: 'No Records.' }}
                </p>
            </div>
        </div>

        {{-- Actions --}}
        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-white/5 flex gap-2">
            @if($room->status === 'maintenance')
                <form method="POST" action="{{ route('admin.housekeeping.updateRoomStatus', $room) }}" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="Available">
                    <input type="hidden" name="notes" value="The Room Has Been Cleaned And Is Ready For Use.">
                    <button type="submit" class="w-full py-2 rounded-xl text-xs font-semibold text-white bg-blue-600 hover:bg-blue-500 transition duration-200 active:scale-95 shadow-sm">
                        Finish Cleaning
                    </button>
                </form>
            @endif

            <button type="button"
                    onclick="openUpdateStatusModal({{ $room->id }}, '{{ $room->room_number }}', '{{ $room->status }}', '{{ addslashes($room->notes) }}')"
                    class="py-2 px-3 rounded-xl text-xs font-medium text-gray-600 dark:text-white/60 border border-gray-200 dark:border-white/10 hover:bg-gray-100 dark:hover:bg-white/5 transition duration-150 flex-1 text-center">
                Change Status
            </button>
        </div>
    </div>
    @empty
    <div class="col-span-full py-16 text-center text-gray-400 dark:text-white/25 text-sm">
        No Room Data.
    </div>
    @endforelse
</div>

{{-- Modal Ubah Status & Catatan --}}
<div id="modal-update-status" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="document.getElementById('modal-update-status').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5" id="modal-title">Change Room Status</h3>
        <form id="form-update-status" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Room Status</label>
                <select id="edit-room-status" name="status" required
                        class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                    <option value="available" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Available (Clean & Ready)</option>
                    <option value="occupied" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Occupied</option>
                    <option value="maintenance" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Maintenance (Requires Cleaning)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Notes Housekeeping</label>
                <textarea id="edit-room-notes" name="notes" rows="3" placeholder="Contoh: The Bathroom Light Is Out, The AC Isn't Cooling Enough, or Additional Amenities Are Needed."
                          class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                 bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                 placeholder:text-gray-300 dark:placeholder:text-white/20
                                 focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200"></textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                        style="background: #1d4ed8">
                    Save
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-update-status').classList.add('hidden')"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                               border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openUpdateStatusModal(id, number, status, notes) {
        const modal = document.getElementById('modal-update-status');
        const form = document.getElementById('form-update-status');

        form.action = `/admin/housekeeping/rooms/${id}/status`;

        document.getElementById('modal-title').innerText = `Update Status Kamar ${number}`;
        document.getElementById('edit-room-status').value = status;
        document.getElementById('edit-room-notes').value = notes;

        modal.classList.remove('hidden');
    }
</script>
@endpush
