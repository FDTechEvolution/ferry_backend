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
        'infant_price',
        'isactive',
        'status'
    ];

    protected $hidden = [
        
    ];

    public function station_from() {
        return $this->hasOne(Station::class, 'id', 'station_from_id')->with('section');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'id', 'station_to_id')->with('section');
    }

    public function icons() {
        return $this->belongsToMany(Icon::class, 'route_icons', 'route_id', 'icon_id')->orderBy('seq', 'ASC');
    }

    public function station_lines() {
        return $this->belongsToMany(StationInfomation::class, 'route_station_info_lines', 'route_id', 'station_infomation_id')
                    ->withPivot('type', 'ismaster');
    }

    public function activity_lines() {
        return $this->belongsToMany(Addon::class, 'route_activities', 'route_id', 'addon_id')->with('image', 'icon');
    }

    public function meal_lines() {
        return $this->belongsToMany(Addon::class, 'route_meals', 'route_id', 'addon_id');
    }

    public function shuttle_bus() {
        return $this->belongsToMany(Addon::class, 'route_shuttlebuses', 'route_id', 'addon_id');
    }

    public function longtail_boat() {
        return $this->belongsToMany(Addon::class, 'route_longtailboats', 'route_id', 'addon_id');
    }
}
