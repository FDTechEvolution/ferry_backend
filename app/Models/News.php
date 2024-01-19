<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class News extends Model
{
    use HasFactory, HasUuids;

    public $fillable = [
        'title',
        'slug',
        'body',
        'isactive',
        'view'
    ];

    public $hidden = [
        'view'
    ];
}
