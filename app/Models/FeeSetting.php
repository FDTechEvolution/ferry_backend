<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class FeeSetting extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'type',
        'regular_pf',
        'child_pf',
        'infant_pf',
        'percent_pf',
        'regular_sc',
        'child_sc',
        'infant_sc',
        'percent_sc',
        'isuse_pf',
        'isuse_sc',
        'is_pf_perperson',
        'is_sc_perperson'
    ];

    protected $hidden = [

    ];
}
