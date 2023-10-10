<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RouteStationInfoLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'route_id',
        'station_infomation_id',
        'type'
    ];

    protected $hidden = [
        
    ];
}
