<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingAddon extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'booking_addons';

    protected $fillable = [
        'booking_id',
        'addon_id',
    ];

    public function booking()
    {
        return $this->belongsTo(Bookings::class, 'booking_id', 'id');
    }

    public function addon()
    {
        return $this->hasOne(Addon::class, 'id', 'addon_id');
    }
}
