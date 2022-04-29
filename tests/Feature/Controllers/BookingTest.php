<?php

namespace Tests\Feature\Controllers;

use App\Models\Booking;
use App\Models\BookingDay;
use App\Models\Room;
use App\Models\User;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function testOnlyLoggedUserCanUseBookingAPI()
    {
        $room = Room::factory()->create();
        $user = User::factory()->create();
        $booking = Booking::factory()->make([
            'user_id' => $user->id,
            'room_id' => $room->id
        ]);

        $this->json('get', route('bookings.index'))->assertUnauthorized();
        $this->json('post', route('bookings.store'), $booking->toArray())->assertUnauthorized();
        $this->json('delete', route('bookings.destroy', [
            'booking' => 1
        ]))->assertUnauthorized();

        $this->signIn();

        $this->json('get', route('bookings.index'))->assertOk();
        $this->json('post', route('bookings.store'), $booking->toArray())->assertCreated();
        $this->json('delete', route('bookings.destroy', [
            'booking' => Booking::first()
        ]))->assertNoContent();
    }

    public function testIndexMethodReturnsAllBookings()
    {
        $this->signIn();

        $room = Room::factory()->create();
        $user = User::factory()->create();
        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id
        ]);

        $bookingsCount = Booking::count();

        self::assertEquals($bookingsCount, $this->get(route('bookings.index'))->getOriginalContent()->count());

        Booking::factory()->create([
            'user_id' => $user->id,
            'room_id' => $room->id
        ]);

        $bookingsCount++;

        self::assertEquals($bookingsCount, $this->get(route('bookings.index'))->getOriginalContent()->count());
    }

    public function testStoreMethodStoresNewBooking()
    {
        $this->signIn();

        $room = Room::factory()->create();
        $from = $to = now();

        $bookingData = [
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'days' => $from->diffInDays($to) + 1
        ];

        $bookingDayData = [
            'room_id' => $bookingData['room_id'],
            'date' => $bookingData['from']
        ];

        $bookingTable = (new Booking())->getTable();
        $bookingDayTable = (new BookingDay())->getTable();

        unset($bookingData['days']);

        $this->assertDatabaseMissing($bookingTable, $bookingData);
        $this->assertDatabaseMissing($bookingDayTable, $bookingDayData);

        $this->post(route('bookings.store'), $bookingData);

        $this->assertDatabaseHas($bookingTable, $bookingData);
        $this->assertDatabaseHas($bookingDayTable, $bookingDayData);
    }

    public function testAdditionalAttributesAreAddedWhileStoringTheBooking()
    {
        $this->signIn();

        $room = Room::factory()->create();
        $from = $to = now();

        $bookingData = [
            'room_id' => $room->id,
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
        ];

        $this->post(route('bookings.store'), $bookingData);

        $addedBooking = Booking::orderBy('id', 'desc')->first();

        self::assertSame($this->user->id, $addedBooking->user_id);
        self::assertSame($from->diffInDays($to) + 1, $addedBooking->days);
    }

    public function testDestroyMethodDeletesBooking()
    {
        $this->signIn();

        $room = Room::factory()->create();
        $from = $to = now();

        $bookingData = [
            'user_id' => auth()->id(),
            'room_id' => $room->id,
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'days' => $from->diffInDays($to) + 1
        ];

        $booking =  Booking::factory()->create($bookingData);
        $bookingTable = $booking->getTable();

        $this->assertDatabaseHas($bookingTable, $bookingData);

        $this->delete(route('bookings.destroy', [
            'booking' => $booking
        ]), $bookingData);

        $this->assertDatabaseMissing($bookingTable, $bookingData);
    }
}
