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
}
