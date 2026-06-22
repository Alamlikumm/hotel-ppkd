@extends('layouts.admin')
@section('title', 'Manajemen Users')
@section('subtitle', "Manage Accounts & Access Rights Dido's Hotel")

@section('topbar-actions')
<button onclick="document.getElementById('modal-user').classList.remove('hidden')"
        class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold text-white transition-all duration-200 hover:opacity-90 active:scale-95"
        style="background: #1d4ed8">
    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Add User
</button>
@endsection

@section('content')

{{-- Role Summary Cards --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    @php
    $roleColors = ['superadmin' => 'blue', 'resepsionis' => 'red', 'admin_fnb' => 'green'];
    $roleLabels = ['superadmin' => 'Super Admin', 'resepsionis' => 'Admin Hotel', 'admin_fnb' => 'Admin F&B'];
    $roleDesc   = ['superadmin' => 'Full Access to All Modules', 'resepsionis' => 'Rooms, Bookings, Reviews', 'admin_fnb' => 'Menu & Order F&B'];
    @endphp
    @foreach($roleColors as $slug => $color)
    <div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl p-5
                border-t-2 {{ $color === 'blue' ? 'border-t-blue-500' : 'border-t-green-500' }}">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-white text-xs font-bold
                        {{ $color === 'blue' ? 'bg-blue-500' : 'bg-green-500' }}">
                {{ strtoupper(substr($slug, 0, 2)) }}
            </div>
            <div>
                <p class="text-sm font-semibold text-gray-800 dark:text-white">{{ $roleLabels[$slug] }}</p>
                <p class="text-xs text-gray-400 dark:text-white/30">{{ $roleDesc[$slug] }}</p>
            </div>
        </div>
        <p class="text-2xl font-bold {{ $color === 'blue' ? 'text-blue-600 dark:text-blue-400' : 'text-green-600 dark:text-green-400' }}">
            {{ $users->where('role.slug', $slug)->count() }}
            <span class="text-sm font-normal text-gray-400 dark:text-white/30">User</span>
        </p>
    </div>
    @endforeach
</div>

{{-- Table --}}
<div class="bg-white dark:bg-white/4 border border-gray-100 dark:border-white/8 rounded-2xl overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="border-b border-gray-50 dark:border-white/5">
                <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">User</th>
                <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Email</th>
                <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Role</th>
                <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Status</th>
                <th class="px-5 py-3.5 text-left text-[11px] font-semibold text-gray-400 dark:text-white/30 uppercase tracking-wider">Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-50 dark:divide-white/5">
            @forelse($users as $user)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/2 transition-colors duration-100">
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-semibold flex-shrink-0"
                             style="background: #1e3a5f">
                            {{ strtoupper(substr($user->name, 0, 2)) }}
                        </div>
                        <span class="text-sm font-medium text-gray-800 dark:text-white">{{ $user->name }}</span>
                    </div>
                </td>
                <td class="px-5 py-3.5 text-sm text-gray-500 dark:text-white/40">{{ $user->email }}</td>
                <td class="px-5 py-3.5">
                    @php
                    $roleStyle = match($user->role->slug) {
                        'superadmin'  => 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300',
                        'resepsionis' => 'bg-blue-50 dark:bg-blue-500/15 text-blue-700 dark:text-blue-300',
                        'admin_fnb'   => 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300',
                        default       => 'bg-gray-100 text-gray-500',
                    };
                    @endphp
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium {{ $roleStyle }}">
                        {{ $user->role->name }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <span class="text-xs px-2.5 py-1 rounded-full font-medium
                                 {{ $user->is_active
                                    ? 'bg-green-50 dark:bg-green-500/15 text-green-700 dark:text-green-300'
                                    : 'bg-red-50 dark:bg-red-500/15 text-red-600 dark:text-red-400' }}">
                        {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </td>
                <td class="px-5 py-3.5">
                    <div class="flex items-center gap-2">
                        @if(!$user->isSuperAdmin())
                        <button type="button"
                                onclick="openEditUser({{ $user->id }}, '{{ addslashes($user->name) }}', '{{ addslashes($user->email) }}', {{ $user->role_id }}, {{ $user->is_active ? 1 : 0 }})"
                                class="text-xs px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-500/20
                                       text-blue-500 dark:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-500/10
                                       transition-colors duration-150">
                            Edit
                        </button>
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                              onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-500/20
                                           text-red-500 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-500/10
                                           transition-colors duration-150">
                                Delete
                            </button>
                        </form>
                        @else
                        <span class="text-xs text-gray-300 dark:text-white/20">—</span>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-5 py-16 text-center text-sm text-gray-400 dark:text-white/25">
            There Are No Users Yet
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- Modal Tambah User --}}
<div id="modal-user" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="document.getElementById('modal-user').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">Add New User</h3>
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              placeholder:text-gray-300 dark:placeholder:text-white/20
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="email@hotel.com"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              placeholder:text-gray-300 dark:placeholder:text-white/20
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Password</label>
                <input type="password" name="password" placeholder="Minimal 8 karakter"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              placeholder:text-gray-300 dark:placeholder:text-white/20
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              placeholder:text-gray-300 dark:placeholder:text-white/20
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Roles</label>
                <select name="role_id"
                        class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                    <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Select Roles</option>
                    @foreach(\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                        style="background: #0f172a">
                    Simpan
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-user').classList.add('hidden')"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                               border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Edit User --}}
<div id="modal-edit-user" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"
         onclick="document.getElementById('modal-edit-user').classList.add('hidden')"></div>
    <div class="relative bg-white dark:bg-[#1A1535] border border-gray-100 dark:border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl">
        <h3 class="text-sm font-semibold text-gray-800 dark:text-white mb-5">Edit User</h3>
        <form id="form-edit-user" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Name</label>
                <input type="text" id="edit-user-name" name="name" required
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Email</label>
                <input type="email" id="edit-user-email" name="email" required
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Password <span class="normal-case font-normal text-gray-400">(Optional)</span></label>
                <input type="password" name="password" placeholder="Leave blank to keep current password"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" placeholder="Confirm Password"
                       class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                              bg-white dark:bg-white/5 text-gray-800 dark:text-white
                              focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Roles</label>
                <select id="edit-user-role" name="role_id" required
                        class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                    <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Select Roles</option>
                    @foreach(\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">{{ $role->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Status</label>
                <input type="hidden" name="is_active" value="0">
                <select id="edit-user-status" name="is_active" required
                        class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                               bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                               focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
                    <option value="1" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Aktif</option>
                    <option value="0" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Nonaktif</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-2.5 rounded-xl text-sm font-semibold text-white hover:opacity-90 transition-opacity"
                        style="background: #1d4ed8">
                    Simpan Perubahan
                </button>
                <button type="button"
                        onclick="document.getElementById('modal-edit-user').classList.add('hidden')"
                        class="flex-1 py-2.5 rounded-xl text-sm font-medium text-gray-600 dark:text-white/60
                               border border-gray-200 dark:border-white/10 hover:bg-gray-50 dark:hover:bg-white/5">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openEditUser(id, name, email, roleId, isActive) {
        const modal = document.getElementById('modal-edit-user');
        const form = document.getElementById('form-edit-user');
        
        form.action = `/admin/users/${id}`;
        
        document.getElementById('edit-user-name').value = name;
        document.getElementById('edit-user-email').value = email;
        document.getElementById('edit-user-role').value = roleId;
        document.getElementById('edit-user-status').value = isActive;
        
        modal.classList.remove('hidden');
    }
</script>
@endpush
