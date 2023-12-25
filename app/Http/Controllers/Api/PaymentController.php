<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Helpers\PaymentHelper;
use App\Helpers\BookingHelper;

use App\Models\Bookings;
use App\Models\Payments;

class PaymentController extends Controller
{
    protected $PaymentMethod = [
        'CC' => 'CC',
        'TM' => 'TRUEMONEY',
        'QR' => 'THQR'
    ];

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

        $payment = PaymentHelper::completePayment($result['userDefined1'], $payment_data);
        $booking = BookingHelper::completeBooking($result['userDefined2']);
    }

    private function paymentFail() {
        // do somting...
    }

    public function paymentRequest(Request $request) {
        $payment = Payments::find($request->payment_id);
        $booking = Bookings::find($payment->booking_id);
        $payment_channel = $this->PaymentMethod[$request->payment_method];

        // Log::debug($booking->bookingCustomers);
        // $customer_email = $booking->bookingCustomers->customer[0]->email;
        // Log::debug($customer_email);

        $payload = PaymentHelper::encodeRequest($payment, $payment_channel);
        $response = PaymentHelper::postTo_2c2p($payload);
        $result = PaymentHelper::decodeResponse($response);

        return response()->json(['result' => true, 'data' => $result, 'booking' => $booking->bookingno], 200);
    }
}
