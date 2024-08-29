<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tickets extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'ticketno',
        'station_from_id',
        'station_to_id',
        'status',
        'customer_id',
        'booking_id',
        'isdefault',
        'booking_route_id'
    ];

    public function customer() {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function booking() {
        return $this->hasOne(Bookings::class, 'id', 'booking_id');
    }

    public function bookingRoute() {
        return $this->hasOne(BookingRoutes::class, 'id', 'booking_route_id');
    }

    public function station_from() {
        return $this->hasOne(Station::class, 'id', 'station_from_id');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'id', 'station_to_id');
    }
}
