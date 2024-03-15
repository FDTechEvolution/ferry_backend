<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RouteCalendars extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'date',
        'api_route_id',
        'seat',
        'created_by',
        'updated_by',
        'description'

    ];

    public function apiRoute() {
        return $this->hasOne(ApiRoutes::class, 'id', 'api_route_id');
    }

    public function createdBy() {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    public function updatedBy() {
        return $this->hasOne(User::class, 'id', 'updated_by');
    }
}
