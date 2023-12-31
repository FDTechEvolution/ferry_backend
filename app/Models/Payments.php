<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Payments extends Model
{
    use HasFactory,HasUuids;

    protected $fillable = [
        'payment_method',
        'totalamt',
        'confirm_document',
        'description',
        'booking_id',
        'user_id',
        'docdate',
        'paymentno',
        'image_id',
        'status',
        'payment_date',
        'customer_id'
    ];

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function customer() {
        return $this->hasOne(Customers::class, 'id', 'customer_id');
    }

    public function image() {
        return $this->hasOne(Image::class, 'id', 'image_id');
    }
    public function booking() {
        return $this->hasOne(Bookings::class, 'id', 'booking_id');
    }

    public function paymentLines() {
        return $this->hasMany(PaymentLines::class, 'payment_id', 'id');
    }
}
