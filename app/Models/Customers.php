<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Customers extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'fullname',
        'type',
        'passportno',
        'email',
        'mobile',
        'fulladdress'
    ];

    public function bookings() {
        return $this->belongsToMany(Bookings::class, 'booking_customers');
    }

}
