<?php

namespace App\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Eloquent
 * */
class BookingDay extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'date',
        'room_id',
        'booking_id',
    ];

    public function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d F Y'),
        );
    }
}
