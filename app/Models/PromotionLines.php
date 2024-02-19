<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PromotionLines extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'promotion_id',
        'route_id',
        'station_id',
        'isactive',
        'type'
    ];

    public function promotion(){
        return $this->hasOne(Promotions::class,'id','promotion_id');
    }

    public function route(){
        return $this->hasOne(Route::class,'id','route_id');
    }

    public function station(){
        return $this->hasOne(Station::class,'id','station_id');
    }
}
