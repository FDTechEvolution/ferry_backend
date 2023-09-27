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
        'description',
        'image_id',
        'image_icon_id'
    ];

    protected $hidden = [
        'image_id',
        'image_icon_id'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function icon() {
        return $this->hasOne(Image::class, 'id', 'image_icon_id');
    }
}
