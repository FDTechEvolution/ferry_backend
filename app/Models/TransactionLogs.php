<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class TransactionLogs extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'type',
        'title',
        'description',
        'user_id',
        'booking_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function book() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
