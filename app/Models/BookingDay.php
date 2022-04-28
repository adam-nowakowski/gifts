<?php

namespace App\Models;

use Eloquent;
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
        'reservations',
        'bookings_ids',
    ];

    protected $casts = [
        'bookings_ids' => 'array'
    ];
}
