<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ApiMerchants extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'key',
        'commission',
        'vat',
        'discount',
        'description',
        'isactive',
        'code',
        'isopenregular',
        'isopenchild',
        'isopeninfant',
        'isopendiscount',
        'image_id'
    ];

    public function apiRoutes() {
        return $this->belongsToMany(Route::class, 'api_routes', 'api_merchant_id', 'route_id')
        ->withPivot('isactive','seat','discount','id','ontop', 'regular_price', 'child_price', 'infant_price')
        ->wherePivot('isactive', 'Y');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
