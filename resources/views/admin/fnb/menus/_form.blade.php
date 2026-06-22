<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Name
        Menu</label>
    <input type="text" name="name" value="{{ old('name') }}" placeholder="contoh: Special Fried Rice" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                  placeholder:text-gray-300 dark:placeholder:text-white/20
                  focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
    @error('name')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
</div>

<div>
    <label
        class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Category</label>
    <select name="fnb_category_id" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                   bg-white dark:bg-zinc-900 text-gray-800 dark:text-white
                   focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
        <option value="" class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">Select Category</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ old('fnb_category_id') == $cat->id ? 'selected' : '' }} class="bg-white dark:bg-zinc-900 text-gray-800 dark:text-white">
                {{ $cat->name }}
            </option>
        @endforeach
    </select>
</div>

<div>
    <label class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Price
        (Rp)</label>
    <input type="number" name="price" value="{{ old('price') }}" placeholder="40000" min="0" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
                  bg-white dark:bg-white/5 text-gray-800 dark:text-white
                  placeholder:text-gray-300 dark:placeholder:text-white/20
                  focus:outline-none focus:ring-2 focus:ring-blue-500/30 transition duration-200">
</div>

<div>
    <label
        class="block text-xs font-semibold text-gray-500 dark:text-white/40 uppercase tracking-wider mb-2">Status</label>
    <select name="status" class="w-full px-4 py-2.5 rounded-xl text-sm border border-gray-200 dark:border-white/10
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