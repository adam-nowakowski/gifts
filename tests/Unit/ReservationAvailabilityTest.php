<?php

namespace Tests\Unit;

use App\Models\Booking;
use App\Models\BookingDay;
use App\Models\Room;
use App\Models\User;
use App\Services\ReservationAvailability;
use Carbon\CarbonPeriod;
use Tests\TestCase;

class ReservationAvailabilityTest extends TestCase
{
    public function testGetPeriodDaysMethod()
    {
        $date = now();

        $randInt = random_int(1, 5);

        $period = ReservationAvailability::getPeriodDays($date->format('d M y'), $date->addDays($randInt)->format('d M y'));

        self::assertIsArray($period);
        self::assertCount($randInt+1, $period);
    }

    public function testGetRoomUnavailableDaysInGivenPeriodMethod()
    {
        $date = now();
        $dateFormatted = $date->format('Y-m-d');

        $user = User::factory()->create();
        $room = Room::factory()->create();

        $bookingData = [
            'user_id' => $user->id,
            'room_id' => $room->id,
            'from' => $dateFormatted,
            'to' => $dateFormatted,
            'days' => $date->diffInDays($date) + 1
        ];

        Booking::createReservation($bookingData);

        $unavailableDays = ReservationAvailability::getRoomUnavailableDaysInGivenPeriod($room->id, $dateFormatted, $dateFormatted);

        self::assertSame($date->format('d F y'), $unavailableDays[0]);
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
