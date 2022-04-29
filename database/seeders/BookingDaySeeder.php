<?php

namespace Database\Seeders;

use App\Models\BookingDay;
use Illuminate\Database\Seeder;

class BookingDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BookingDay::factory()->create();
    }
}
