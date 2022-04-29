<?php

namespace Tests\Unit;

use App\Models\BookingDay;
use Tests\TestCase;

class BookingDayTest extends TestCase
{
    public function testDateAttributeIsMutated()
    {
        $date = now();

        $bookingDay = BookingDay::factory()->create([
            'date' => $date
        ]);

        self::assertNotSame($bookingDay->getAttributes()['date'], $bookingDay->date);
        self::assertSame($date->format('d F Y'), $bookingDay->date);
    }
}
