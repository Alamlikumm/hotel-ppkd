<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('booking')
            ->latest()->paginate(15);

        $avgRating = Review::where('is_published', true)->avg('rating');

        return view('admin.reviews.index', compact('reviews', 'avgRating'));
    }

    public function reply(Request $request, Review $review)
    {
        $request->validate([
            'admin_reply' => 'required|string|max:1000',
        ]);

        $review->update([
            'admin_reply' => $request->admin_reply,
            'replied_by' => auth()->id(),
            'replied_at' => now(),
        ]);

        Alert::success('Success', 'Reply Saved Successfully.');

        return back()->with('success', 'Reply Saved Successfully.');
    }

    public function togglePublish(Review $review)
    {
        $review->update(['is_published' => ! $review->is_published]);

        Alert::success('Success', 'Review Status Changed Successfully.');

        return back()->with('success', 'Review Status Changed Successfully.');
    }
}
