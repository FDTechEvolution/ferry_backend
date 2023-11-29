<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Helpers\PaymentHelper;
use App\Helpers\BookingHelper;

class PaymentController extends Controller
{
    public function paymentResponse(Request $request) {
        $data = '{"payload":"' . $request['payload'] . '"}';
        $result = PaymentHelper::decodeResponse($data);

        Log::debug($result);
        
        // payment successs
        if($result['respCode'] == '0000') $this->updateBookingpayment($result['userDefined1']);

        // payment fail
        if($result['respCode'] == '4005') $this->paymentFail();
    }

    private function updateBookingpayment($booking_id) {
        $result = (new BookingHelper)->completeBooking($booking_id);
    }

    private function paymentFail() {
        // do somting...
    }
}
