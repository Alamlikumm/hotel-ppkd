<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HousekeepingController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with('roomType')
            ->when($request->floor, fn ($q) => $q->byFloor($request->floor))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->get();

        $floors = Room::distinct()->pluck('floor')->sort();

        return view('admin.housekeeping.index', compact('rooms', 'floors'));
    }

    public function updateRoomStatus(Request $request, Room $room)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,occupied,maintenance',
            'notes' => 'nullable|string',
        ]);

        $room->update($validated);

        Alert::success('Success', 'Room status updated successfully.');

        return redirect()->route('admin.housekeeping.index')
            ->with('success', 'Room status updated successfully.');
    }
}
