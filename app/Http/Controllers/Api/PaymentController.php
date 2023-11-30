<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Helpers\PaymentHelper;
use App\Helpers\BookingHelper;

use App\Models\Bookings;

class PaymentController extends Controller
{
    public function paymentResponse(Request $request) {
        $data = '{"payload":"' . $request['payload'] . '"}';
        $result = PaymentHelper::decodeResponse($data);
        
        if($result['respCode'] == '0000') $this->updateBookingpayment($result); // payment successs
        else if($result['respCode'] == '4005') $this->paymentFail(); // payment fail
    }

    private function updateBookingpayment($result) {
        $cardType = $result['cardType'] != '' ? $result['cardType'] : 'CREDIT';
        $description = json_encode($result);
        $payment_data = ['payment_method' => $cardType, 'totalamt' => $result['amount'], 'description' => $description];
        $res = (new BookingHelper)->completeBooking($result['userDefined1'], $payment_data);
    }

    private function paymentFail() {
        // do somting...
    }

    public function paymentRequest(Request $request) {
        $booking = Bookings::where('bookingno', $request->bookingno)->first();

        $payload = PaymentHelper::encodeRequest($booking);
        $response = PaymentHelper::postTo_2c2p($payload);
        $result = PaymentHelper::decodeResponse($response);

        return response()->json(['result' => true, 'data' => $result, 'booking' => $booking->bookingno], 200);
    }
}
