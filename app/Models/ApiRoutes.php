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
        'commission',
        'vat',
        'totalamt',
        'api_merchant_id',
        'child_price',
        'infant_price',
        'seat',
        'ontop'
    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id')->with('station_from', 'station_to');
    }

    public function api_merchant() {
        return $this->hasOne(ApiMerchants::class, 'id', 'api_merchant_id');
    }
}
