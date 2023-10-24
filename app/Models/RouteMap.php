<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RouteMap extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'detail',
        'image_id',
        'image_banner_id',
        'image_thumb_id',
        'sort',
        'isactive',
        'status'
    ];

    protected $hidden = [
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function banner() {
        return $this->hasOne(Image::class, 'id', 'image_banner_id');
    }

    public function thumb() {
        return $this->hasOne(Image::class, 'id', 'image_thumb_id');
    }
}
