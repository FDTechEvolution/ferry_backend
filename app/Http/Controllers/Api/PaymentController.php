<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Bookings;

class PaymentController extends Controller
{
    public function paymentResponse(Request $request) {
        Log::debug($request);
    }
}
