<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Bookings extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'departdate',
        'adult_passenger',
        'child_passenger',
        'infant_passenger',
        'totalamt',
        'extraamt',
        'amount',
        'route_id',
        'ispayment',
        'user_id',
        'status',
        'bookingno',
        'book_channel',
        'trip_type',
        'ispremiumflex',
        'promotion_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function bookingCustomers() {
        return $this->belongsToMany(Customers::class, 'booking_customers', 'booking_id', 'customer_id')->OrderBy('type', 'ASC')->withPivot('isdefault');
    }

    public function bookingRoutes() {
        return $this->belongsToMany(Route::class, 'booking_routes', 'booking_id', 'route_id')->withPivot('type', 'traveldate','amount')->with('station_from', 'station_to', 'bookingRouteAddons');
    }

    public function bookingRoutesX(){
        return $this->hasMany(BookingRoutes::class,'booking_id','id')->with('bookingExtraAddons', 'bookingRouteAddons');
    }

    public function tickets() {
        return $this->hasMany(Tickets::class,'booking_id', 'id');
    }

    public function payments() {
        return $this->hasMany(Payments::class,'booking_id', 'id')->with('paymentLines');
    }

    public function promotion() {
        return $this->hasOne(Promotions::class, 'id', 'promotion_id');
    }
}
