<?php

namespace App\Rules;

use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;

class CheckIfRoomNameExists implements Rule
{
    public function passes($attribute, $value): bool
    {
        return !Room::where('name', $value)->exists();
    }

    public function message(): string
    {
        return 'This room already exists.';
    }
}
