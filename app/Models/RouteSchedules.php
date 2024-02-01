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
        'sun',
        'api_merchant_id',
        'created_by',
        'updated_by'
    ];

    public function route() {
        return $this->hasOne(Route::class, 'id', 'route_id')->with('station_from','station_to')->orderBy('depart_time','ASC');
    }

    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
