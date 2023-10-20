<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TimeTable extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'detail',
        'image_id',
        'sort',
        'isactive',
        'status'
    ];

    protected $hidden = [
        'status'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
}
