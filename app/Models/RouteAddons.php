<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RouteAddons extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'name',
        'type',
        'subtype',
        'message',
        'mouseover',
        'price',
        'isactive',
        'isservice_charge',
        'route_id'

    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id');
    }
}
