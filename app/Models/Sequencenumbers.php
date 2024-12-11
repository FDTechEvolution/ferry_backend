<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sequencenumbers extends Model
{
    use HasFactory;

    protected $fillable = [
        'running',
        'name',
        'type',
        'dateformat',
        'prefix',
        'running_digit'
    ];
}
