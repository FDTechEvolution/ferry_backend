<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class BookingCustomers extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'booking_id',
        'customer_id',
        'isdefault'
    ];

    protected $hidden = [

    ];

    /*
    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->id = (string) HasUuids::newUniqueId();
        });
    }
    */
}
