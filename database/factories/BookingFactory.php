<?php

namespace Database\Factories;

use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    public function definition(): array
    {
        $from = $this->faker->date;
        $to = Carbon::parse($from)->addDays(random_int(1, 10));

        return [
            'user_id' => User::inRandomOrder()->value('id') ?: $this->faker->numberBetween(),
            'room_id' => Room::inRandomOrder()->value('id') ?: $this->faker->numberBetween(),
            'from' => $from,
            'to' => $to,
            'nights' => $to->diffInDays($from)
        ];
    }
}
