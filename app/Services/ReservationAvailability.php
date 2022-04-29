<?php

namespace App\Services;

use App\Models\BookingDay;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReservationAvailability
{
    public static function getPeriodDays(string $from, string $to): array
    {
        if ($from !== $to) {
            $to = Carbon::parse($to)->addDay();
        }

        return CarbonPeriod::create($from, $to)->toArray();
    }

    public static function getRoomUnavailableDaysInGivenPeriod(int $roomId, string $from, string $to): array
    {
        $period = self::getPeriodDays($from, $to);
        $unavailableDays = [];

        foreach ($period as $date) {
            if (BookingDay::where([
                'date' => $date,
                'room_id' => $roomId
            ])->exists()) {
                $unavailableDays[] = Carbon::parse($date)->format('d F y');
            }
        }

        return $unavailableDays;
    }
}