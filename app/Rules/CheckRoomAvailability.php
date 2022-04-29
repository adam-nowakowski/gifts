<?php

namespace App\Rules;

use App\Services\ReservationAvailability;
use Illuminate\Contracts\Validation\Rule;

class CheckRoomAvailability implements Rule
{
    public const BASE_ERROR_MESSAGE = 'This room is unavailable in day(s): ';

    private array $unavailableDays;

    public function __construct(private string $from, private string $to)
    {
    }

    public function passes($attribute, $value): bool
    {
        $this->unavailableDays = ReservationAvailability::getRoomUnavailableDaysInGivenPeriod(
            $value,
            $this->from,
            $this->to
        );

        return empty($this->unavailableDays);
    }

    public function message(): string
    {
        return self::BASE_ERROR_MESSAGE . implode(', ', $this->unavailableDays);
    }
}
