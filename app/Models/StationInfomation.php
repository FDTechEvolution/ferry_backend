<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class StationInfomation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'text',
        'status',
        'type'
    ];

    protected $hidden = [
        
    ];

    public function info_from() {
        return $this->belongsTo(Station::class, 'id', 'station_infomation_from_id');
    }

    public function info_to() {
        return $this->belongsTo(Station::class, 'id', 'station_infomation_to_id');
    }
}
