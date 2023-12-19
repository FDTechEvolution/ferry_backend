<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PaymentLines extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'payment_id',
        'type',
        'booking_id',
        'addon_id',
        'title',
        'amount',
        'description',
        'booking_route_id'
    ];

    public function addon() {
        return $this->hasOne(Addon::class, 'id', 'addon_id');
    }

    public function booking() {
        return $this->hasOne(Bookings::class, 'id', 'booking_id');
    }

    public function bookingRoute() {
        return $this->hasOne(BookingRoutes::class, 'id', 'booking_route_id');
    }

}
