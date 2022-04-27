<?php

namespace Database\Factories;

use App\Models\Booking;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingDayFactory extends Factory
{
    public function definition()
    {
        return [
            'date' => $this->faker->date,
            'reservations' => $this->faker->numberBetween(),
            'bookings_ids' => Booking::get()->toArray(),
        ];
    }
}
