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
        'promotion_id',
        'isconflict',
        'amend',
        'api_merchant_id',
        'isemailsent',
        'referenceno'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function apiMerchant()
    {
        return $this->hasOne(ApiMerchants::class, 'id', 'api_merchant_id');
    }

    public function bookingCustomers()
    {
        return $this->belongsToMany(Customers::class, 'booking_customers', 'booking_id', 'customer_id')->orderByPivot('isdefault', 'ASC')->OrderBy('type', 'ASC')->withPivot('isdefault');
    }


    public function bookingRoutes()
    {
        return $this->belongsToMany(Route::class, 'booking_routes', 'booking_id', 'route_id')->withPivot('type', 'traveldate', 'amount', 'id', 'ischange')->with('station_from', 'station_to', 'routeAddons');
    }

    public function bookingRoutesX()
    {
        return $this->hasMany(BookingRoutes::class, 'booking_id', 'id')->with('bookingExtraAddons', 'bookingRouteAddons', 'tickets');
    }

    public function tickets()
    {
        return $this->hasMany(Tickets::class, 'booking_id', 'id')->with('station_from', 'station_to');
    }

    public function payments()
    {
        return $this->hasMany(Payments::class, 'booking_id', 'id')->with('paymentLines');
    }

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLogs::class, 'booking_id', 'id')->with('user')->orderBy('created_at', 'DESC');
    }

    public function promotion()
    {
        return $this->hasOne(Promotions::class, 'id', 'promotion_id');
    }

    public function route()
    {
        return $this->belongsToMany(Route::class, 'booking_routes', 'booking_id', 'route_id');
    }
}
