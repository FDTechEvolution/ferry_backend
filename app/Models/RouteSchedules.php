<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RouteSchedules extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'route_id',
        'type',
        'start_datetime',
        'end_datetime',
        'description',
        'isactive',
        'mon',
        'tru',
        'wed',
        'thu',
        'fri',
        'sat',
        'sun'
    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id')->with('station_from','station_to');
    }
}
