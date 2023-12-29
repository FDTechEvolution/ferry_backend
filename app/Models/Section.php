<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Section extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'sectionscol'
    ];

    protected $hidden = [

    ];

    public function station() {
        return $this->belongsTo(Station::class, 'id', 'section_id');
    }
}
