<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'nights' => $this->nights,
            'room_id' => $this->room_id,
            'room_name' => $this->room->name,
            'from' => $this->from,
            'to' => $this->to,
            'user_id' => $this->user_id,
            'user_name' => $this->user->name,
        ];
    }
}
