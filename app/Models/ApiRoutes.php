<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApiRoutes extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'route_id',
        'isactive',
        'regular_price',
        'discount',
        'totalamt',
        'api_merchant_id'
    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id')->with('station_from', 'station_to');
    }
}