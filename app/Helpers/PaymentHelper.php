<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Payments;
use App\Models\PaymentLines;
use App\Models\Promotions;

class PaymentHelper
{
    public static function encodeRequest($payment, $payment_channel)
    {
        $merchantID = $payment_channel == 'CC' ? config('services.payment.merchant_id_credit') : config('services.payment.merchant_id_etc');
        $SECRETKEY = config('services.payment.secret_key');
        $backend_response = config('services.payment.backend_return');
        $fontend_return = config(('services.payment.frontend_return'));
        $currencyCode = 'THB';
        $nonceStr = time();

        $payload = array(
            //MANDATORY PARAMS
            "merchantID" => $merchantID,
            "invoiceNo" => $payment->paymentno,
            "description" => $payment_channel,
            "amount" => $payment->totalamt,
            "currencyCode" => $currencyCode,

            "paymentChannel" => [$payment_channel],
            "userDefined1" => $payment->id,
            "userDefined2" => $payment->booking_id,
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
        // Log::debug($decoded);
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

            // Route Addons
            if(!is_null($bRoute->bookingRouteAddons)) {
                foreach($bRoute->bookingRouteAddons as $key => $addon) {
                    $amount = $addon->isservice_charge == 'Y' ? $addon->price : 0;
                    PaymentLines::create([
                        'payment_id' => $payment->id,
                        'type' => 'ADDON',
                        'booking_id' => $booking->id,
                        'title' => sprintf('%s', $addon->name),
                        'amount' => $amount,
                        'booking_route_id' => $bookingRoute->id,
                    ]);
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

    public static function updatePayWithCreditCard($payment_id)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $feeeAmount = $payment->totalamt * 0.035;

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'FEE',
                'title' => 'Credit card fee 3.5%',
                'amount' => $feeeAmount,
            ]);

            if ($paymentLine) {
                $payment->payment_method = 'CREDIT';
                $payment->totalamt = $payment->totalamt + $feeeAmount;

                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePayWithCreditCardFree($payment_id, $payment_amount)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $creditAmount = -$payment_amount * 0.035;

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'FEE',
                'title' => 'Free Credit card fee',
                'amount' => $creditAmount,
            ]);

            if ($paymentLine) {
                $payment->payment_method = 'CREDIT';
                $payment->totalamt = $payment->totalamt + $creditAmount;

                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePremiumFlex($payment_id)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = $payment->totalamt * 0.1;

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'PREMIUM',
                'title' => 'Premium Flex 10%',
                'amount' => $premiumAmount,
            ]);

            if ($paymentLine) {
                $payment->totalamt = $payment->totalamt + $premiumAmount;

                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePremiumFlexFree($payment_id, $payment_amount)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = -$payment_amount * 0.1;

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'PREMIUM',
                'title' => 'Free Premium Flex',
                'amount' => $premiumAmount,
            ]);

            if ($paymentLine) {
                $payment->totalamt = $payment->totalamt + $premiumAmount;

                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePremiumFlexDiscount($payment_id, $discountamt)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = $payment->totalamt * 0.1;
            $premiumDiscountAmount = $discountamt * 0.1;
            $premiumDiscount = $premiumDiscountAmount - $premiumAmount;

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'PREMIUM',
                'title' => 'Premium Flex Discount',
                'amount' => $premiumDiscount,
            ]);

            if ($paymentLine) {
                $payment->totalamt = $payment->totalamt + $premiumDiscount;

                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePromoCodeDiscount($payment_id, $promotion_id, $discountamt) {
        $payment = Payments::where('id', $payment_id)->first();
        $promotion = Promotions::find($promotion_id);

        if (!is_null($payment)) {
            // $discountAmount = $payment->totalamt - $discountamt;
            $discount = number_format($promotion->discount);
            $discount_type = $promotion->discount_type == 'PERCENT' ? '%' : 'THB';

            //Make payment line
            $paymentLine = PaymentLines::create([
                'payment_id' => $payment->id,
                'type' => 'ROUTE',
                'title' => sprintf('PromoCode Discount %s %s [%s]', $discount, $discount_type, $promotion->code),
                'amount' => $discountamt,
            ]);

            if ($paymentLine) {
                $payment->totalamt = $payment->totalamt + $discountamt;

                $payment->save();
            }
        }

        return $payment;
    }
}
