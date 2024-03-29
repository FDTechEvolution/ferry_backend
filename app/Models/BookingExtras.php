<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingExtras extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'amount',
        'addon_id',
        'booking_route_id',
        'route_addon_id',
        'description'
    ];

    public function addon() {
        return $this->hasOne(Addon::class, 'id', 'addon_id');
    }

    public function route_addon() {
        return $this->hasMany(RouteAddons::class, 'id', 'route_addon_id');
    }

}
