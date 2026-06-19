@extends('layouts.admin')
@section('title', 'Room Management')
@section('subtitle', 'Room Availability Status Dido Hotel')

@section('topbar-actions')
<a href="{{ route('admin.rooms.create') }}"
   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
   style="background: linear-gradient(135deg, #05020a, #060612)">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Add Room
</a>
@endsection

@section('content')

{{-- Filter --}}
<div class="flex items-center gap-3 mb-5">
    <form method="GET" class="flex items-center gap-2">
        <select name="floor" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="">All Floors</option>
            @foreach($floors as $floor)
            <option value="{{ $floor }}" {{ request('floor') == $floor ? 'selected' : '' }}>
                Lantai {{ $floor }}
            </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()"
                class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                       bg-white dark:bg-white/5 text-gray-700 dark:text-white/70
                       focus:outline-none focus:ring-2 focus:ring-purple-500/30">
            <option value="">All Status</option>
            <option value="available"   {{ request('status') == 'available'   ? 'selected' : '' }}>Available</option>
            <option value="occupied"    {{ request('status') == 'occupied'    ? 'selected' : '' }}>Occupied</option>
            <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
        </select>
    </form>

    {{-- Legend --}}
    <div class="ml-auto flex items-center gap-4 text-xs text-gray-500 dark:text-white/40">
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>Available ({{ $rooms->where('status','available')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-red-400"></span>Occupied ({{ $rooms->where('status','occupied')->count() }})</span>
        <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>Maintenance ({{ $rooms->where('status','maintenance')->count() }})</span>
    </div>
</div>

{{-- Room Grid --}}
<div class="grid grid-cols-4 gap-4">
    @forelse($rooms as $room)
    @php
    $style = match($room->status) {
        'available'   => ['card' => 'border-purple-200 dark:border-purple-500/30 bg-white dark:bg-purple-500/8',  'badge' => 'bg-purple-50 dark:bg-purple-500/20 text-purple-700 dark:text-purple-300', 'dot' => 'bg-purple-500', 'label' => 'Available'],
        'occupied'    => ['card' => 'border-red-200 dark:border-red-500/30 bg-white dark:bg-red-500/8',           'badge' => 'bg-red-50 dark:bg-red-500/20 text-red-700 dark:text-red-300',           'dot' => 'bg-red-400',    'label' => 'Occupied'],
        'maintenance' => ['card' => 'border-amber-200 dark:border-amber-500/30 bg-white dark:bg-amber-500/8',     'badge' => 'bg-amber-50 dark:bg-amber-500/20 text-amber-700 dark:text-amber-300',   'dot' => 'bg-amber-400',  'label' => 'Maintenance'],
        default       => ['card' => 'border-gray-200 bg-white', 'badge' => 'bg-gray-100 text-gray-500', 'dot' => 'bg-gray-400', 'label' => '-'],
    };
    @endphp
    <div class="border rounded-2xl p-4 {{ $style['card'] }} hover:shadow-md transition-all duration-200 group" x-data="{ open: false }">
        <div class="flex items-start justify-between mb-3">
            <div>
                <div class="text-xl font-bold text-gray-800 dark:text-white">{{ $room->room_number }}</div>
                <div class="text-xs text-gray-400 dark:text-white/30 mt-0.5">Floor {{ $room->floor }}</div>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="flex items-center gap-1.5 text-xs px-2.5 py-1 rounded-full font-medium {{ $style['badge'] }}">
                    <span class="w-1.5 h-1.5 rounded-full {{ $style['dot'] }}"></span>
                    {{ $style['label'] }}
                </span>

                {{-- Actions Dropdown Menu --}}
                <div class="relative">
                    <button @click="open = !open" @click.outside="open = false"
                            class="p-1 rounded-xl text-gray-400 hover:text-purple-600 dark:hover:text-purple-400 hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors duration-150 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                        </svg>
                    </button>

                    <div x-show="open"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-1.5 w-32 rounded-xl bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 shadow-xl py-1.5 z-10"
                         style="display: none;">
                        <a href="{{ route('admin.rooms.edit', $room) }}"
                           class="flex items-center gap-2 px-3 py-1.5 text-xs text-gray-700 dark:text-purple-200 hover:bg-purple-50 dark:hover:bg-purple-500/10 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.rooms.destroy', $room) }}"
                              onsubmit="return confirm('Delete room {{ $room->room_number }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="w-full flex items-center gap-2 px-3 py-1.5 text-xs text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors text-left">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-sm font-medium text-gray-600 dark:text-white/60 mb-2">
            {{ $room->roomType->name }}
        </div>
        <div class="text-xs text-gray-400 dark:text-white/30">
            Rp {{ number_format($room->roomType->price_per_night, 0, ',', '.') }} / Night
        </div>
    </div>
    @empty
    <div class="col-span-4 py-16 text-center text-gray-400 dark:text-white/25">
        <p class="text-sm">There Are No Rooms Yet. <a href="{{ route('admin.rooms.create') }}" class="text-purple-500 hover:underline">Add Now</a></p>
    </div>
    @endforelse
</div>

@include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])

@endsection