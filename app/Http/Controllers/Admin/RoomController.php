<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $rooms = Room::with('roomType')
            ->when($request->floor, fn ($q) => $q->byFloor($request->floor))
            ->when($request->status, fn ($q) => $q->where('status', $request->status))
            ->get();

        $floors = Room::distinct()->pluck('floor')->sort();

        confirmDelete('Delete Room!', 'Are you sure you want to delete this room?');

        return view('admin.rooms.index', compact('rooms', 'floors'));
    }

    public function create()
    {
        $roomTypes = RoomType::all();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms',
            'floor' => 'required|integer',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'required|in:available,occupied,maintenance',
            'notes' => 'nullable|string',
        ]);

        Room::create($validated);

        Alert::success('Done', 'Room Has Been Created');

        return redirect()->route('admin.rooms.index')
            ->with('success', 'Room Added Successfully.');
    }

    public function edit(Room $room)
    {
        $roomTypes = RoomType::all();

        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'room_number' => 'required|unique:rooms,room_number,'.$room->id,
            'floor' => 'required|integer',
            'room_type_id' => 'required|exists:room_types,id',
            'status' => 'required|in:available,occupied,maintenance',
            'notes' => 'nullable|string',
        ]);

        $room->update($validated);

        Alert::success('Done', 'The Room Was Successfully Updated.');

        return redirect()->route('admin.rooms.index')
            ->with('success', 'The Room Was Successfully Updated.');
    }

    public function destroy(Room $room)
    {
        $room->delete();

        Alert::success('Done', 'The Room Was Successfully Deleted.');

        return redirect()->route('admin.rooms.index')
            ->with('success', 'The Room Was Successfully Deleted.');
    }
}
