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
        'image_id'
    ];

    protected $hidden = [
        'section_id'
    ];

    public function section() {
        return $this->hasOne(Section::class, 'id', 'section_id');
    }

    public function image(){
        return $this->hasOne(Image::class,'id','image_id');
    }

    public function info_line() {
        return $this->belongsToMany(StationInfomation::class, 'station_info_lines', 'station_id', 'station_infomation_id')
                    ->withPivot('type');
    }
}
