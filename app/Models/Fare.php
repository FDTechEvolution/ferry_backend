<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Fare extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'standard_thb',
        'standard_percent',
        'online_thb',
        'online_percent',
        'seq',
        'isfixed',
        'fixed_thb'
    ];

    protected $hidden = [

    ];
}
