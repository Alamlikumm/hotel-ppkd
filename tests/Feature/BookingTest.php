<?php

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\RoomSeeder;
use Database\Seeders\RoomTypeSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('receptionist can create booking with extra bed', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoomTypeSeeder::class);
    $this->seed(RoomSeeder::class);
    $this->seed(UserSeeder::class);

    $receptionist = User::where('email', 'admin@hotel.com')->first();
    $room = Room::where('status', 'available')->first();

    $response = $this->actingAs($receptionist)
        ->post(route('admin.bookings.store'), [
            'room_id' => $room->id,
            'guest_name' => 'John Doe',
            'guest_email' => 'john@example.com',
            'guest_phone' => '081234567890',
            'check_in' => now()->format('Y-m-d'),
            'check_out' => now()->addDays(2)->format('Y-m-d'),
            'extra_bed' => '1',
            'payment_method' => 'cash',
            'notes' => 'Some notes',
        ]);

    $response->assertRedirect();

    $booking = Booking::latest()->first();

    expect($booking->extra_bed)->toBeTrue();
    expect((float) $booking->extra_bed_price)->toBe(200000.0); // 2 nights * 100k

    $baseRoomPrice = $room->roomType->price_per_night * 2;
    expect((float) $booking->total_price)->toBe((float) ($baseRoomPrice + 200000.0));
});

test('receptionist can extend checkout date of a booking', function () {
    $this->seed(RoleSeeder::class);
    $this->seed(RoomTypeSeeder::class);
    $this->seed(RoomSeeder::class);
    $this->seed(UserSeeder::class);

    $receptionist = User::where('email', 'admin@hotel.com')->first();
    $room = Room::where('status', 'available')->first();

    // Create booking
    $booking = Booking::create([
        'booking_code' => Booking::generateCode(),
        'room_id' => $room->id,
        'guest_name' => 'Jane Doe',
        'guest_email' => 'jane@example.com',
        'guest_phone' => '081234567891',
        'check_in' => now(),
        'check_out' => now()->addDays(2),
        'total_nights' => 2,
        'total_price' => ($room->roomType->price_per_night * 2) + 200000.0,
        'extra_bed' => true,
        'extra_bed_price' => 200000.0,
        'status' => 'confirmed',
        'payment_status' => 'paid',
        'paid_at' => now(),
        'payment_method' => 'cash',
        'handled_by' => $receptionist->id,
    ]);

    $newCheckOut = now()->addDays(4)->format('Y-m-d');

    $response = $this->actingAs($receptionist)
        ->post(route('admin.bookings.extend', $booking), [
            'new_check_out' => $newCheckOut,
        ]);

    $response->assertRedirect();

    $booking->refresh();

    expect($booking->total_nights)->toBe(4);
    expect($booking->check_out->format('Y-m-d'))->toBe($newCheckOut);

    $expectedTotalPrice = ($room->roomType->price_per_night * 4) + 400000.0; // 4 nights room + 4 nights extra bed
    expect((float) $booking->total_price)->toBe((float) $expectedTotalPrice);
    expect((float) $booking->extra_bed_price)->toBe(400000.0);
});
