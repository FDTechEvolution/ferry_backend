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
        'status',
        'partner_id',
        'text_1',
        'text_2',
        'master_from_info',
        'master_to_info',
        'ispromocode',
        'master_from',
        'master_to',
        'information_from',
        'information_to',
        'isinformation_from_active',
        'isinformation_to_active'
    ];

    protected $hidden = [

    ];

    public function schedules(){
        return $this->hasMany(RouteSchedules::class,'route_id','id')->orderBy('updated_at','DESC');
    }

    public function lastSchedule(){
        return $this->hasMany(RouteSchedules::class,'route_id','id')->latest();
    }

    public function partner() {
        return $this->hasOne(Partners::class, 'id', 'partner_id')->with('image');
    }

    public function station_from() {
        return $this->hasOne(Station::class, 'id', 'station_from_id')->where('isactive', 'Y')->orderBy('sort', 'ASC')->with('section', 'image');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'id', 'station_to_id')->where('isactive', 'Y')->orderBy('sort', 'ASC')->with('section', 'image');
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

    public function routeAddons() {
        return $this->hasMany(RouteAddons::class, 'route_id', 'id')->where('isactive', 'Y')->orderBy('type','ASC')->orderBy('subtype','ASC');
    }
    public function routeAddonEdit() {
        return $this->hasMany(RouteAddons::class, 'route_id', 'id')->orderBy('type','ASC')->orderBy('subtype','ASC');
    }

    public function api_route() {
        return $this->hasOne(ApiRoutes::class, 'route_id', 'id');
    }

    public function bookings() {
        return $this->belongsToMany(Bookings::class, 'booking_routes', 'route_id', 'booking_id')->withPivot('traveldate', 'id')
                    ->with('promotion', 'payments', 'bookingCustomers');
    }

    public function booking_extra() {
        return $this->belongsToMany(BookingExtras::class, 'booking_routes', 'route_id', 'id');
    }
}
