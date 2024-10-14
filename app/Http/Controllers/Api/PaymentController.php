<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Helpers\PaymentHelper;
use App\Helpers\BookingHelper;
use App\Helpers\EmailHelper;
use App\Helpers\FeeHelper;

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

        if($result['respCode'] == '0000') $this->updateBookingpayment($result, '2C2P'); // payment successs
        else if($result['respCode'] == '4005') $this->paymentFail(); // payment fail
    }

    public function paymentCtsvResponse(Request $request) {
        $res = json_decode($request['paymentResult'], true);
        if($res['code'] == '100') {
            $ex = explode('-', $res['desc']);
            $payment = Payments::where('paymentno', $ex[1])->first();
            $booking = Bookings::where('bookingno', $ex[0])->first();

            $payload = [
                'userDefined1' => $payment->id, // payment_id
                'userDefined2' => $booking->id, // booking_no
                'cardType' => $res['paymentMethod'],
                'amount' => $res['amt'],
                'ctsv_description' => $res
            ];

            $this->updateBookingpayment($payload, 'PATALL');
        }
    }

    private function updateBookingpayment($result, $type) {
        $cardType = isset($result['cardType']) ? $result['cardType'] : $result['channelCode'];
        $description = isset($result['ctsv_description']) ? json_encode($result['ctsv_description']) : json_encode($result);
        $payment_data = ['payment_method' => $cardType, 'totalamt' => $result['amount'], 'description' => $description];

        // $result['userDefined1'] = $payment_id
        // $result['userDefined2'] = $booking_id
        $payment = PaymentHelper::completePayment($result['userDefined1'], $payment_data);
        $booking = BookingHelper::completeBooking($result['userDefined2']);

        // update payment line with fee
        $passengers = ['adult' => $booking->adult_passenger, 'child' => $booking->child_passenger, 'infant' => $booking->infant_passenger];
        $fee = FeeHelper::getFeeSetting($passengers, $payment->totalamt, $type);
        PaymentHelper::updateFeePaymentLine($result['userDefined1'], $fee, $type);

        // Send Email
        //EmailHelper::ticket($result['userDefined2']);
    }

    private function paymentFail() {
        // do somting...
    }

    public function paymentRequest(Request $request) {
        $payment = Payments::find($request->payment_id);
        $booking = Bookings::find($payment->booking_id);
        $payment_method = $request->payment_method;
        $passengers = ['adult' => $booking->adult_passenger, 'child' => $booking->child_passenger, 'infant' => $booking->infant_passenger];
        $fee = FeeHelper::getFeeSetting($passengers, $payment->totalamt, '2C2P');
        // Log::debug($fee);

        // Log::debug($booking->bookingCustomers);
        // $customer_email = $booking->bookingCustomers->customer[0]->email;
        // Log::debug($customer_email);

        $payload = PaymentHelper::encodeRequest($payment, $payment_method, $fee);
        $response = PaymentHelper::postTo_2c2p($payload);
        $result = PaymentHelper::decodeResponse($response);

        return response()->json(['result' => true, 'data' => $result, 'booking' => $booking->bookingno], 200);
    }

    public function paymentCounterService(Request $request) {
        $payment = Payments::find($request->payment_id);
        $booking = Bookings::with('bookingCustomers')->find($payment->booking_id);
        $customer = $this->getLeadCustomer($booking->bookingCustomers);
        $passengers = ['adult' => $booking->adult_passenger, 'child' => $booking->child_passenger, 'infant' => $booking->infant_passenger];
        $fee = FeeHelper::getFeeSetting($passengers, $payment->totalamt, 'PATALL');
        $inv = 'inv-'.time();

        $payload = array(
            'merchantId' => config('services.payment.ctsv_merchant_id'),
            'shopId' => config('services.payment.ctsv_shop_id'),
            'inv' => strval($inv),
            'desc' => $booking->bookingno.'-'.$payment->paymentno,
            'urlBack' => config('services.payment.ctsv_frontend_return'),
            'urlConfirm' => config('services.payment.ctsv_backend_return'),
            'paymentMethod' => $request->payment_method,
            'amt' => $payment->totalamt + $fee,
            'currency' => 'THB',
            'memberId' => isset($request->member_id) ? $request->memer_id : '',
            'name' => explode(' ', $customer->fullname)[0],
            'email' => $customer->email,
            'phone' => $customer->mobile,
            'ref1' => $payment->paymentno,
            'redirectResult' => 'Y'
        );

        // Log::debug($payload);
        $response = PaymentHelper::postTo_ctsv(json_encode($payload));
        return response()->json(['result' => true, 'data' => $response ?? [], 'booking' => $booking->bookingno], 200);
    }

    private function getLeadCustomer($customers) {
        foreach($customers as $cus) {
            if($cus['email'] != '') return $cus;
        }
    }
}
