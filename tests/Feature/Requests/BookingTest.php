<?php

namespace Tests\Feature\Requests;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use App\Rules\CheckRoomAvailability;
use App\Services\ReservationAvailability;
use Tests\TestCase;

class BookingTest extends TestCase
{
    public function testOnlyLoggedUserCanStoreReservation()
    {
        $room = Room::factory()->create();
        $user = User::factory()->create();
        $booking = Booking::factory()->make([
            'user_id' => $user->id,
            'room_id' => $room->id
        ]);

        $this->json('post', route('bookings.store'), $booking->toArray())
            ->assertUnauthorized();

        $this->signIn();

        $this->json('post', route('bookings.store'), $booking->toArray())
            ->assertCreated();
    }

    public function testValidationWithEmptyData()
    {
        $this->signIn();

        $this->json('post', route('bookings.store'), [])
            ->assertSessionMissing([
                'room_id',
                'from',
                'to',
            ]);
    }

    public function testValidationWithReservedDate()
    {
        $this->signIn();

        $room = Room::factory()->create();
        $user = User::factory()->create();
        $booking = Booking::factory()->make([
            'user_id' => $user->id,
            'room_id' => $room->id
        ]);

        $this->json('post', route('bookings.store'), $booking->toArray());

        $response = $this->json('post', route('bookings.store'), $booking->toArray());

        $unavailableDays = ReservationAvailability::getRoomUnavailableDaysInGivenPeriod(
            $booking->room_id,
            $booking->from,
            $booking->to
        );

        self::assertEquals(
            CheckRoomAvailability::BASE_ERROR_MESSAGE . implode(', ', $unavailableDays),
            $response->getOriginalContent()['errors']['room_id'][0]
        );
    }
}
