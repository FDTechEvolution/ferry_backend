<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StationInfoLine extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'station_id',
        'station_infomation_id',
        'type'
    ];

    protected $hidden = [
        
    ];
}
