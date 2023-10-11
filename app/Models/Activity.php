<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Activity extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'price',
        'detail',
        'image_id',
        'status'
    ];

    protected $hidden = [

    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
