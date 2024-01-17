<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingRoutes extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'route_id',
        'type',
        'traveldate',
        'amount',
        'booking_id'
    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }

    public function station_from() {
        return $this->hasOne(Station::class, 'route_id', 'station_from_id')->with('section');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'route_id', 'station_to_id')->with('section');
    }

    public function bookingExtraAddons() {
        return $this->belongsToMany(Addon::class, 'booking_extras','booking_route_id', 'addon_id');
    }

    public function bookingRouteAddons() {
        return $this->belongsToMany(RouteAddons::class, 'booking_extras','booking_route_id', 'route_addon_id')->withPivot('description');
    }
}
