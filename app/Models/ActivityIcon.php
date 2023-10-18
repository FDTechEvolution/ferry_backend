<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class ActivityIcon extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'activity_id',
        'icon_id'
    ];

    protected $hidden = [
        
    ];
}
