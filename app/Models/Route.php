<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Route extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'station_from_id',
        'station_to_id',
        'depart_time',
        'arrive_time',
        'regular_price',
        'child_price',
        'isactive',
        'status'
    ];

    protected $hidden = [
        
    ];

    public function station_from() {
        return $this->hasOne(Station::class, 'id', 'station_from_id');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'id', 'station_to_id');
    }

    public function icons() {
        return $this->belongsToMany(Icon::class, 'route_icons', 'route_id', 'icon_id');
    }
}
