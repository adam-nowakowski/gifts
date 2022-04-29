<?php

namespace App\Http\Requests;

use App\Rules\CheckIfRoomNameExists;
use Illuminate\Foundation\Http\FormRequest;

class RoomRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', new CheckIfRoomNameExists()],
        ];
    }
}
