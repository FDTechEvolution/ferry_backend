<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingRelated extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'booking_id',
        'related_booking_id'
    ];

    public function booking() {
        return $this->hasOne(Bookings::class, 'id', 'booking_id');
    }

    public function relatedBooking() {
        return $this->hasOne(Bookings::class, 'id', 'related_booking_id');
    }
}
