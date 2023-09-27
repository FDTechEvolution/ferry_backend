<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Image extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'path',
        'name'
    ];

    protected $hidden = [

    ];

    public function addon() {
        return $this->belongsTo(Addon::class);
    }
}
