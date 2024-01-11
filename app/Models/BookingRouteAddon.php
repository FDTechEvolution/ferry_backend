<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingRouteAddon extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'booking_route_id',
        'route_addon_id',
        'amount',
        'description'
    ];
}
