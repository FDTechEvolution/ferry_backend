<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Station extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'piername',
        'nickname',
        'isactive',
        'section_id',
        'station_infomation_from_id',
        'station_infomation_to_id',
        'sort',
        'address',
        'image_id',
        'google_map',
        'master_from',
        'master_to',
        'shuttle_bus_price',
        'shuttle_bus_text',
        'shuttle_bus_mouseover',
        'private_taxi_price',
        'private_taxi_text',
        'private_taxi_mouseover',
        'longtail_boat_price',
        'longtail_boat_text',
        'longtail_boat_mouseover',
        'thai_name',
        'thai_piername',
        'type'
    ];

    protected $hidden = [
        'section_id'
    ];

    public function section() {
        return $this->hasOne(Section::class, 'id', 'section_id')->orderBy('sort', 'ASC');
    }

    public function image(){
        return $this->hasOne(Image::class,'id','image_id');
    }

    public function info_line() {
        return $this->belongsToMany(StationInfomation::class, 'station_info_lines', 'station_id', 'station_infomation_id')
                    ->withPivot('type');
    }

    public function stationFrom(){
        return $this->hasMany(Route::class,'station_from_id','id');
    }

    public function stationTo(){
        return $this->hasMany(Route::class,'station_to_id','id');
    }

    public function stationInformations(){
        return $this->hasMany(StationInfomation::class,'station_id','id');
    }
}
