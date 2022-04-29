<?php

namespace Tests\Feature\Requests;

use App\Models\Room;
use App\Rules\CheckIfRoomNameExists;
use Tests\TestCase;

class RoomTest extends TestCase
{
    public function testOnlyLoggedUserCanStoreRoom()
    {
        $room = Room::factory()->make();

        $this->json('post', route('rooms.store'), $room->toArray())
            ->assertUnauthorized();

        $this->signIn();

        $this->json('post', route('rooms.store'), $room->toArray())
            ->assertCreated();
    }

    public function testValidationWithEmptyData()
    {
        $this->signIn();

        $this->json('post', route('rooms.store'), [])
            ->assertSessionMissing([
                'name',
            ]);
    }

    public function testValidationWithUsedName()
    {
        $this->signIn();

        $room = Room::factory()->create();

        $response = $this->json('post', route('rooms.store'), $room->toArray());

        self::assertEquals(
            CheckIfRoomNameExists::ERROR_MESSAGE,
            $response->getOriginalContent()['errors']['name'][0]
        );
    }
}
