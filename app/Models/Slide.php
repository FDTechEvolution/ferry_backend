<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Slide extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'slug',
        'link',
        'sort',
        'type',
        'color',
        'image_id',
        'isactive',
        'status',
        'description',
        'icon',
        'isdefault'
    ];

    protected $hidden = [
        'status',
        'updated_at',
        'deleted_at'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
