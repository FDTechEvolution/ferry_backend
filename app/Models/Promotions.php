<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Promotions extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'code',
        'discount',
        'discount_type',
        'trip_type',
        'depart_date_start',
        'depart_date_end',
        'booking_start_date',
        'booking_end_date',
        'station_from_id',
        'station_to_id',
        'route_id',
        'times_used',
        'times_use_max',
        'title',
        'isactive',
        'image_id',
        'created_at'
    ];

    public function image(){
        return $this->hasOne(Image::class,'id','image_id');
    }

    public function route(){
        return $this->hasOne(Route::class,'id','route_id');
    }

    public function station_from() {
        return $this->hasOne(Station::class, 'id', 'station_from_id')->with('section');
    }

    public function station_to() {
        return $this->hasOne(Station::class, 'id', 'station_to_id')->with('section');
    }

}
