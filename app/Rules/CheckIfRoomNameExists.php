<?php

namespace App\Rules;

use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;

class CheckIfRoomNameExists implements Rule
{
    public const ERROR_MESSAGE = 'This room already exists.';

    public function passes($attribute, $value): bool
    {
        return !Room::where('name', $value)->exists();
    }

    public function message(): string
    {
        return self::ERROR_MESSAGE;
    }
}
