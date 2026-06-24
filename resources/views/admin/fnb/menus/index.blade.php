@extends('layouts.admin')
@section('title', 'Menu F&B')
@section('subtitle', "Manage Food & Feverage Menu Dido's Hotel")

@section('topbar-actions')
    <button onclick="document.getElementById('modal-tambah').classList.remove('hidden')"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
        style="background: #121214">
        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Create Menu
    </button>
@endsection

@section('content')

    {{-- Filter --}}
    <div class="flex items-center gap-3 mb-5">
        <form method="GET" class="flex items-center gap-2">
            <select name="category" onchange="this.form.submit()" class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                           bg-white dark:bg-zinc-900 text-gray-700 dark:text-white/70
                           focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            <select name="status" onchange="this.form.submit()" class="text-sm px-3 py-2 rounded-xl border border-gray-200 dark:border-white/10
                           bg-white dark:bg-zinc-900 text-gray-700 dark:text-white/70
                           focus:outline-none focus:ring-2 focus:ring-blue-500/30">
                <option value="" class="bg-white dark:bg-zinc-900 text-blue-500 dark:text-blue-400">All Status</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Available</option>
                <option value="unavailable" {{ request('status') == 'unavailable' ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Out of stock</option>
            </select>
        </form>
    </div>

    {{-- Menu Grid --}}
    <div class="grid grid-cols-3 gap-4 mb-6">
        @forelse($menus as $menu)
            <div
                class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden hover:shadow-md transition-shadow duration-200 group">
                {{-- Image --}}
                <div
                    class="h-36 bg-blue-50/50 dark:bg-blue-900/10 relative overflow-hidden">
                    @if($menu->image)
                        <img src="{{ asset('storage/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <span class="text-4xl opacity-40">🍽️</span>
                        </div>
                    @endif
                    <span class="absolute top-3 right-3 text-xs px-2.5 py-1 rounded-full font-medium
                                 {{ $menu->status === 'available'
                 ? 'bg-green-500 text-white'
                 : 'bg-red-500 text-white' }}">
                        {{ $menu->status === 'available' ? 'Available' : 'Out of stock' }}
                    </span>
                </div>
                {{-- Content --}}
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-1">
                        <h3 class="text-sm font-semibold text-gray-800 dark:text-white leading-tight">{{ $menu->name }}</h3>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-white/30 mb-3">{{ $menu->category->name }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-bold text-blue-600 dark:text-blue-400">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </span>
                        <div class="flex items-center gap-1">
                            <button
                                onclick="openEditMenu({{ $menu->id }}, '{{ addslashes($menu->name) }}', {{ $menu->fnb_category_id }}, {{ $menu->price }}, '{{ $menu->status }}')"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-500/10 transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </button>
                            <a href="{{ route('admin.fnb-menus.destroy', $menu) }}"
                                data-confirm-delete="true"
                                class="p-1.5 rounded-lg text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-3 py-16 text-center text-gray-400 dark:text-white/25 text-sm">
                There Is No Menu Yet. Add First Menu!
            </div>
        @endforelse
    </div>

    {{ $menus->links() }}

    {{-- Modal Tambah --}}
    <div id="modal-tambah" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            onclick="document.getElementById('modal-tambah').classList.add('hidden')"></div>
        <div
            class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">Add New Menu</h3>
            <form method="POST" action="{{ route('admin.fnb-menus.store') }}" enctype="multipart/form-data"
                class="space-y-4">
                @csrf
                @include('admin.fnb.menus._form')
                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                        style="background: #1d4ed8">
                        Save
                    </button>
                    <button type="button" onclick="document.getElementById('modal-tambah').classList.add('hidden')" class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                                   border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div id="modal-edit" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
            onclick="document.getElementById('modal-edit').classList.add('hidden')"></div>
        <div
            class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
            <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">Edit Menu</h3>
            <form id="form-edit" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Name Menu</label>
                    <input type="text" id="edit-name" name="name" required class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Category</label>
                    <select id="edit-category" name="fnb_category_id" required class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                   bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                        <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Price (Rp)</label>
                    <input type="number" id="edit-price" name="price" required min="0" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                                  placeholder:text-gray-300 dark:placeholder:text-white/20
                                  focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Status</label>
                    <select id="edit-status" name="status" required class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                   bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                                   focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                        <option value="available" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Available</option>
                        <option value="unavailable" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Unavailable</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">
                        Menu photo <span class="normal-case font-normal text-gray-400">(Optional)</span>
                    </label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                                  bg-white dark:bg-white/5 text-gray-500 dark:text-white/50
                                  file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0
                                  file:text-xs file:font-medium file:bg-blue-50 file:text-blue-600
                                  dark:file:bg-blue-500/20 dark:file:text-blue-300
                                  focus:outline-none transition duration-200">
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit" class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity" style="background: #1d4ed8">
                        Update
                    </button>
                    <button type="button" onclick="document.getElementById('modal-edit').classList.add('hidden')" class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
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
        function openEditMenu(id, name, categoryId, price, status) {
            const modal = document.getElementById('modal-edit');
            const form = document.getElementById('form-edit');
            
            form.action = `/admin/fnb-menus/${id}`;
            
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-category').value = categoryId;
            document.getElementById('edit-price').value = price;
            document.getElementById('edit-status').value = status;
            
            modal.classList.remove('hidden');
        }
    </script>
@endpush
