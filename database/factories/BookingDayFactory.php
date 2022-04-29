<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingDayFactory extends Factory
{
    public function definition(): array
    {
        return [
            'date' => $this->faker->date,
            'room_id' => Room::inRandomOrder()->value('id') ?: $this->faker->numberBetween(),
            'booking_id' => Booking::inRandomOrder()->value('id') ?: $this->faker->numberBetween(),
        ];
    }
}
