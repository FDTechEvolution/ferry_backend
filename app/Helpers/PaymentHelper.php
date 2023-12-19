<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Payments;
use App\Models\PaymentLines;

class PaymentHelper
{
    public static function encodeRequest($booking)
    {
        $merchantID = config('services.payment.merchant_id_etc');
        $SECRETKEY = config('services.payment.secret_key');
        // $merchantID = config('services.payment.merchant_id_credit');
        $backend_response = config('services.payment.backend_return');
        $fontend_return = config(('services.payment.frontend_return'));
        $currencyCode = 'THB';
        $nonceStr = time();

        $payload = array(
            //MANDATORY PARAMS
            "merchantID" => $merchantID,
            "invoiceNo" => $booking->bookingno,
            "description" => $booking->departdate,
            "amount" => $booking->totalamt,
            "currencyCode" => $currencyCode,

            "paymentChannel" => ["PPQR"],
            "userDefined1" => $booking->id,
            "backendReturnUrl" => $backend_response,

            //MANDATORY RANDOMIZER
            "nonceStr" => $nonceStr,
        );

        $jwt = JWT::encode($payload, $SECRETKEY, 'HS256');
        $data = '{"payload":"' . $jwt . '"}';

        return $data;
    }

    public static function postTo_2c2p($payload)
    {
        $BASEURL = config('services.payment.base_url');
        $APIURL = "paymentToken";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $BASEURL . $APIURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));

        $result = curl_exec($ch); //execute post
        curl_close($ch); //close connection
        return $result;
    }

    public static function decodeResponse($response)
    {
        $SECRETKEY = config('services.payment.secret_key');

        $decoded = json_decode($response, true);
        $payloadResponse = $decoded['payload'];
        $decodedPayload = JWT::decode($payloadResponse, new Key($SECRETKEY, 'HS256'));
        $decoded_array = (array) $decodedPayload;

        return $decoded_array;
    }

    //Make draf payment
    public static function createPaymentFromBooking($booking_id)
    {
        $booking = BookingHelper::getBookingInfoByBookingId($booking_id);
        $totalAmount = 0;

        //Make draft payment
        $payment = Payments::create([
            'payment_method' => 'NO',
            'totalamt' => $booking->totalamt,
            'docdate' => date('Y-m-d H:i:s'),
            'paymentno' => newSequenceNumber('PAYMENT'),
            'booking_id' => $booking->id,
        ]);

        //Customer
        if (!is_null($booking->bookingCustomers)) {
            $bookingCustomer = $booking->bookingCustomers[0];
            $payment->customer_id = $bookingCustomer->id;
        }

        foreach ($booking->bookingRoutes as $index => $bookingRoute) {
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'ROUTE',
                'booking_id' => $booking->id,
                'title' => sprintf('Booking No.%s, From %s to %s', $booking->bookingno, $bookingRoute->station_from->name, $bookingRoute->station_to->name),
                'amount' => $bookingRoute->pivot->amount,
                'booking_route_id' => $bookingRoute->id,
            ]);

            $totalAmount += $bookingRoute->pivot->amount;

            //Addons
            $bRoute = $booking->bookingRoutesX[$index];

            if (!is_null($bRoute->bookingExtraAddons)) {
                foreach ($bRoute->bookingExtraAddons as $key => $addon) {
                    //$_addon = Addon::where('id'=>$addon->)->first();

                    $paymentLine = PaymentLines::create([
                        'payment_id' => $payment->id,
                        'type' => 'ADDON',
                        'booking_id' => $booking->id,
                        'title' => sprintf('%s', $addon->name),
                        'amount' => $addon->amount,
                        'booking_route_id' => $bookingRoute->id,
                    ]);
                    $totalAmount += $addon->amount;
                }
            }

        }
        $payment->totalamt = $totalAmount;
        $payment->save();

        return $payment;
    }

    public static function completePayment($payment_id, $paymentData = [])
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $payment->status = 'CO';
            $payment->ispaid = 'Y';
            $payment->payment_date = date('Y-m-d H:i:s');
            $payment->payment_method = isset($paymentData['payment_method']) ? $paymentData['payment_method'] : 'NO';
            $payment->confirm_document = isset($paymentData['confirm_document']) ? $paymentData['confirm_document'] : NULL;
            $payment->description = isset($paymentData['description']) ? $paymentData['description'] : NULL;
            $payment->image_id = isset($paymentData['image_id']) ? $paymentData['image_id'] : null;
            $payment->user_id = isset($paymentData['user_id']) ? $paymentData['user_id'] : null;

            $payment->save();
        }

        return $payment;
    }
}