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
        'sectionscol',
        'sort',
        'isactive'
    ];

    protected $hidden = [

    ];

    public function stations() {
        return $this->hasMany(Station::class, 'section_id', 'id')->orderBy('sort','ASC');
    }
}
