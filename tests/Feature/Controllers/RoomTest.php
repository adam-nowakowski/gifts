<?php

namespace Tests\Feature\Controllers;

use App\Models\Booking;
use App\Models\BookingDay;
use App\Models\Room;
use App\Models\User;
use Tests\TestCase;

class RoomTest extends TestCase
{
    public function testOnlyLoggedUserCanUseRoomAPI()
    {
        $room = Room::factory()->make();

        $this->json('get', route('rooms.index'))->assertUnauthorized();
        $this->json('post', route('rooms.store'), $room->toArray())->assertUnauthorized();

        $this->signIn();

        $this->json('get', route('rooms.index'))->assertOk();
        $this->json('post', route('rooms.store'), $room->toArray())->assertCreated();
    }

    public function testIndexMethodReturnsAllRooms()
    {
        $this->signIn();

        Room::factory()->create();

        $roomsCount = Room::count();

        self::assertEquals($roomsCount, $this->get(route('rooms.index'))->getOriginalContent()->count());

        Room::factory()->create();

        $roomsCount++;

        self::assertEquals($roomsCount, $this->get(route('rooms.index'))->getOriginalContent()->count());
    }

    public function testStoreMethodStoresNewRoom()
    {
        $this->signIn();

        $room = Room::factory()->make();

        $roomTable = $room->getTable();
        $roomData = $room->toArray();

        $this->assertDatabaseMissing($roomTable, $roomData);

        $this->post(route('rooms.store'), $roomData);

        $this->assertDatabaseHas($roomTable, $roomData);
    }
}
