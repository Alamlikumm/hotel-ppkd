<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FnbCategory;
use App\Models\FnbMenu;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class FnbMenuController extends Controller
{
    public function index(Request $request)
    {
        $menus = FnbMenu::with('category')
            ->when($request->category, fn ($q) => $q->where('fnb_category_id', $request->category))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->latest()->paginate(12);

        $categories = FnbCategory::all();

        confirmDelete('Delete Menu!', 'Are you sure you want to delete this menu?');

        return view('admin.fnb.menus.index', compact('menus', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fnb_category_id' => 'required|exists:fnb_categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        FnbMenu::create([...$validated, 'created_by' => auth()->id()]);

        Alert::success('Success', 'Menu Added Successfully.');

        return back()->with('success', 'Menu Added Successfully.');
    }

    public function update(Request $request, FnbMenu $fnbMenu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'fnb_category_id' => 'required|exists:fnb_categories,id',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:available,unavailable',
        ]);

        if ($request->hasFile('image')) {
            $this->deleteImage($fnbMenu->image);
            $validated['image'] = $this->storeImage($request->file('image'));
        }

        $fnbMenu->update($validated);

        Alert::success('Success', 'Menu Updated Successfully.');

        return back()->with('success', 'Menu Updated Successfully.');
    }

    public function destroy(FnbMenu $fnbMenu)
    {
        $this->deleteImage($fnbMenu->image);
        $fnbMenu->delete();

        Alert::success('Success', 'The Menu Has Been Successfully Deleted.');

        return back()->with('success', 'The Menu Has Been Successfully Deleted.');
    }

    private function storeImage(UploadedFile $image): string
    {
        $filename = time().'_'.$image->getClientOriginalName();

        Storage::disk('images')->putFileAs('fnb', $image, $filename);

        return 'images/fnb/'.$filename;
    }

    private function deleteImage(?string $image): void
    {
        if (! $image) {
            return;
        }

        if (str_starts_with($image, 'images/')) {
            Storage::disk('images')->delete('fnb/'.basename($image));

            return;
        }

        Storage::disk('public')->delete($image);
    }
}
