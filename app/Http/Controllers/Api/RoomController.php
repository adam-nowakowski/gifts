<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoomRequest;
use App\Http\Resources\RoomResource;
use App\Models\Room;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RoomController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return RoomResource::collection(Room::get());
    }

    public function store(RoomRequest $request): RoomResource
    {
        $room = Room::create($request->validated());

        return new RoomResource($room);
    }
}
