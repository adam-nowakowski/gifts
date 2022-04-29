<?php

namespace App\Models;

use App\Services\ReservationAvailability;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

/**
 * @mixin Eloquent
 * */
class Booking extends Model
{
    use HasFactory;

    public static function boot() {
        parent::boot();

        static::deleting(function($booking) {
            $booking->bookingDays()->delete();
        });
    }

    protected $fillable = [
        'user_id',
        'room_id',
        'from',
        'to',
        'days',
    ];

    public function from(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d F Y'),
        );
    }

    public function to(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => Carbon::parse($value)->format('d F Y'),
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function bookingDays(): HasMany
    {
        return $this->hasMany(BookingDay::class);
    }

    public static function createReservation($bookingData): Booking|Model
    {
        DB::beginTransaction();

        $booking = self::create($bookingData);

        $period = ReservationAvailability::getPeriodDays($booking->from, $booking->to);

        foreach ($period as $date) {
            $booking->bookingDays()->create([
                'date' => $date,
                'room_id' => $booking->room_id
            ]);
        }

        DB::commit();

        return $booking;
    }
}
