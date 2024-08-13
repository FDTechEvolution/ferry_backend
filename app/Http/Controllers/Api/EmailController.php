<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

use App\Helpers\EmailHelper;
use App\Models\Bookings;

class EmailController extends Controller
{
    public function sendEmail($booking_id) {
        EmailHelper::ticket($booking_id);
        return response()->json(['data' => 'sending...'], 200);
    }

    public function sendBookingEmail($booking_id) {
        EmailHelper::emailBooking($booking_id);
        return response()->json(['data' => 'email booking sended...'], 200);
    }
}
