<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FnbCategory;
use App\Models\FnbMenu;
use Illuminate\Http\Request;
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
            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/fnb'), $filename);
            $validated['image'] = 'images/fnb/'.$filename;
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
            if ($fnbMenu->image) {
                $oldPath = public_path($fnbMenu->image);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                } else {
                    Storage::disk('public')->delete($fnbMenu->image);
                }
            }
            $image = $request->file('image');
            $filename = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images/fnb'), $filename);
            $validated['image'] = 'images/fnb/'.$filename;
        }

        $fnbMenu->update($validated);

        Alert::success('Success', 'Menu Updated Successfully.');

        return back()->with('success', 'Menu Updated Successfully.');
    }

    public function destroy(FnbMenu $fnbMenu)
    {
        if ($fnbMenu->image) {
            $path = public_path($fnbMenu->image);
            if (file_exists($path) && is_file($path)) {
                @unlink($path);
            } else {
                Storage::disk('public')->delete($fnbMenu->image);
            }
        }
        $fnbMenu->delete();

        Alert::success('Success', 'The Menu Has Been Successfully Deleted.');

        return back()->with('success', 'The Menu Has Been Successfully Deleted.');
    }
}
