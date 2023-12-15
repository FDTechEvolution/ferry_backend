<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Partners extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'name',
        'image_id',
        'isactive'
    ];

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }

    public function routes() {
        return $this->belongsTo(Route::class, 'id', 'partner_id');
    }
}
