<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class UserLog extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'user_id',
        'activity',
        'datetime',
        'description'
    ];

    protected $hidden = [
        'user_id'
    ];
}
