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
        'ticketno'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }



    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }

    public function bookingCustomers() {
        return $this->belongsToMany(Customers::class, 'booking_customers', 'booking_id', 'customer_id');
    }

    public function bookingExtraAddons() {
        return $this->belongsToMany(Addon::class, 'booking_extras', 'booking_id', 'addon_id');
    }

    public function bookingExtraActivities() {
        return $this->belongsToMany(Activity::class, 'booking_extras', 'booking_id', 'activity_id');
    }

    
}
