<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\BookingDay;
use App\Models\Room;
use App\Models\User;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function testFromAttributeIsMutated()
    {
        $date = now();

        $booking = Booking::factory()->create([
            'from' => now()
        ]);

        self::assertNotSame($booking->getAttributes()['from'], $booking->from);
        self::assertSame($date->format('d F Y'), $booking->from);
    }

    public function testToAttributeIsMutated()
    {
        $date = now();

        $booking = Booking::factory()->create([
            'to' => $date
        ]);

        self::assertNotSame($booking->getAttributes()['to'], $booking->to);
        self::assertSame($date->format('d F Y'), $booking->to);
    }

    public function testHasUserRelation()
    {
        $user = User::factory()->create();
        $booking = Booking::factory()->create([
            'user_id' => $user->id
        ]);

        self::assertInstanceOf(User::class, $booking->user);
        self::assertSame($user->id, $booking->user->id);
    }

    public function testHasRoomRelation()
    {
        $room = Room::factory()->create();
        $booking = Booking::factory()->create([
            'room_id' => $room->id
        ]);

        self::assertInstanceOf(Room::class, $booking->room);
        self::assertSame($room->id, $booking->room->id);
    }

    public function testHasBookingDaysRelation()
    {
        $booking = Booking::factory()->create();
        $bookingDay = BookingDay::factory()->create([
            'booking_id' => $booking->id
        ]);

        self::assertContainsOnlyInstancesOf(BookingDay::class, $booking->bookingDays);
        self::assertSame($bookingDay->id, $booking->bookingDays[0]->id);
    }

    public function testCreateReservationMethodCreatesBookingAndBookingDays()
    {
        $user = User::factory()->create();
        $room = Room::factory()->create();
        $from = $to = now();

        $bookingData = [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'from' => $from->format('Y-m-d'),
            'to' => $to->format('Y-m-d'),
            'days' => $from->diffInDays($to) + 1
        ];

        $bookingDayData = [
            'room_id' => $bookingData['room_id'],
            'date' => $bookingData['from']
        ];

        $bookingTable = Booking::factory()->make()->getTable();
        $bookingDayTable = BookingDay::factory()->make()->getTable();

        $this->assertDatabaseMissing($bookingTable, $bookingData);
        $this->assertDatabaseMissing($bookingDayTable, $bookingDayData);

        $booking = Booking::createReservation($bookingData);

        self::assertInstanceOf(Booking::class, $booking);

        $this->assertDatabaseHas($bookingTable, $bookingData);
        $this->assertDatabaseHas($bookingDayTable, $bookingDayData);
    }
}
