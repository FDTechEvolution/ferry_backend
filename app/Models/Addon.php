<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Addon extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'isactive',
        'code',
        'type',
        'amount',
        'description'
    ];

    protected $hidden = [

    ];
}
