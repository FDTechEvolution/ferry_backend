<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\Payments;
use App\Models\PaymentLines;
use App\Models\Promotions;
use App\Models\FeeSetting;
use Phattarachai\LineNotify\Facade\Line;

class PaymentHelper
{
    public static function encodeRequest($payment, $payment_method, $fee)
    {
        $payment_channel = [
            'CC' => 'CC',
            'GCARD' => 'CC',
            'DPAY' => 'EWALLET',
            'THQR' => 'PPQR',
            'GQR' => 'CSQR'
        ];

        $merchantID = $payment_method == 'CC' ? config('services.payment.merchant_id_credit') : config('services.payment.merchant_id_etc');
        $SECRETKEY = config('services.payment.secret_key');
        $backend_response = config('services.payment.backend_return');
        $fontend_return = config(('services.payment.frontend_return'));
        $currencyCode = 'THB';
        $nonceStr = time();

        $payload = array(
            //MANDATORY PARAMS
            "merchantID" => $merchantID,
            "invoiceNo" => $payment->paymentno,
            "description" => $payment_channel[$payment_method],
            "amount" => round($payment->totalamt + $fee, 2),
            "currencyCode" => $currencyCode,

            "paymentChannel" => [$payment_channel[$payment_method]],
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

    // send to counter service
    public static function postTo_ctsv($payload) {
        $BASEURL = config('services.payment.ctsv_base_url');
        $MERCHANTID = config('services.payment.ctsv_merchant_id');
        $SECRETKEY = config('services.payment.ctsv_secret_key');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $BASEURL);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'merchantId:' . $MERCHANTID,
            'secretKey:' . $SECRETKEY,
        ));

        $result = curl_exec($ch); //execute post
        curl_close($ch); //close connection

        // Log::debug($result);
        $decoded = json_decode($result, true);
        // Log::debug($decoded);
        $payloadResponse = $decoded['encryptedPaymentData'];

        return $payloadResponse;
    }

    //Make draf payment
    public static function createPaymentFromBooking($booking_id)
    {
        $booking = BookingHelper::getBookingInfoByBookingId($booking_id);
        $totalAmount = 0;
        $passenger = 1;

        //Make draft payment
        $payment = Payments::create([
            'payment_method' => 'NO',
            'totalamt' => 0,
            'docdate' => date('Y-m-d H:i:s'),
            'paymentno' => newSequenceNumber('PAYMENT'),
            'booking_id' => $booking->id,
        ]);

        //Customer
        if (!is_null($booking->bookingCustomers)) {
            $passenger = count($booking->bookingCustomers);
            $bookingCustomer = $booking->bookingCustomers[0];
            $payment->customer_id = $bookingCustomer->id;
            $payment->save();
        }

        foreach ($booking->bookingRoutes as $index => $bookingRoute) {
            $title = sprintf('Booking No.%s, From %s to %s', $booking->bookingno, $bookingRoute->station_from->name, $bookingRoute->station_to->name);

            PaymentHelper::createPaymentLine($payment->id,'ROUTE',$booking->id,$title,$bookingRoute->pivot->amount,$bookingRoute->id);

            //Addons
            $bRoute = $booking->bookingRoutesX[$index];
            if (!is_null($bRoute->bookingExtraAddons)) {
                foreach ($bRoute->bookingExtraAddons as $key => $addon) {
                    PaymentHelper::createPaymentLine($payment->id,'ADDON',$booking->id,sprintf('%s', $addon->name),$addon->amount,$bookingRoute->id);
                }
            }

            // Route Addons
            if(!is_null($bRoute->bookingRouteAddons)) {
                foreach($bRoute->bookingRouteAddons as $key => $addon) {
                    $amount = $addon->isservice_charge == 'Y' ? $addon->price : 0;
                    $amount = $amount * $passenger;
                    PaymentHelper::createPaymentLine($payment->id,'ADDON',$booking->id,sprintf('%s', $addon->name),$amount,$bookingRoute->id,$addon->pivot->description);
                }
            }

        }
        $payment = Payments::where('id',$payment->id)->first();

        $title = sprintf('Create payment document no. %s',$payment->paymentno);
        TransactionLogHelper::tranLog(['type' => 'PAYMENT', 'title' => $title, 'description' => '', 'booking_id' => $booking_id]);

        return $payment;
    }

    private static function createPaymentLine($paymentId,$type,$bookingId,$title,$amount,$bookingRouteId,$description=''){
        $payment = Payments::where('id', $paymentId)->first();

        $paymentLine = PaymentLines::create([
            'payment_id' => $paymentId,
            'type' => $type,
            'booking_id' => $bookingId,
            'title' => $title,
            'amount' => $amount,
            'booking_route_id' => $bookingRouteId,
            'description' => $description
        ]);

        if ($paymentLine) {
            //TransactionLogHelper::tranLog(['type' => 'booking', 'title' => $title, 'description' => $description, 'booking_id' => $bookingId]);

            $payment->totalamt = $payment->totalamt + $amount;
            $payment->save();
        }

        return $paymentLine;

    }

    public static function completePayment($payment_id, $paymentData = [])
    {
        $payment = Payments::with('booking')->where('id', $payment_id)->where('ispaid','N')->first();

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

            PaymentHelper::paymentAgentInfo($payment_id);

            $title = sprintf('Payment successfully with %s amount %s',$payment->payment_method,$payment->totalamt);
            TransactionLogHelper::tranLog(['type' => 'PAYMENT', 'title' => $title, 'description' => '', 'booking_id' => $payment->booking_id]);
            EmailHelper::ticket($payment->booking_id);

            LineNotifyHelper::newBooking($payment->booking_id);
        }

        return $payment;
    }

    public static function updatePayWithCreditCard($payment_id)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $feeeAmount = $payment->totalamt * 0.035;

            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'FEE',NULL,'Credit card fee 3.5%',$feeeAmount,NULL,'');

            if ($paymentLine) {
                $payment->payment_method = 'CREDIT';
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

            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'FEE',NULL,'Free Credit card fee',$creditAmount,NULL,'');

            if ($paymentLine) {
                $payment->payment_method = 'CREDIT';
                $payment->save();
            }
        }

        return $payment;
    }

    public static function updatePremiumFlex($payment_id, $payment_amount)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = $payment_amount * 0.1;
            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'PREMIUM',NULL,'Premium Flex 10%',$premiumAmount,NULL,'');
        }

        return $payment;
    }

    public static function updatePremiumFlexFree($payment_id, $payment_amount)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = -$payment_amount * 0.1;

            //Make payment line
            // $paymentLine = PaymentLines::create([
            //     'payment_id' => $payment->id,
            //     'type' => 'PREMIUM',
            //     'title' => 'Free Premium Flex',
            //     'amount' => $premiumAmount,
            // ]);

            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'PREMIUM',NULL,'Free Premium Flex',$premiumAmount,NULL,'');

        }

        return $payment;
    }

    public static function updateRouteAddonFree($payment_id, $addon_name, $addon_price, $passenger) {
        $title = 'Free '.$addon_name;
        $addon_price = $addon_price * $passenger;
        $price = -$addon_price;
        $paymentLine = PaymentHelper::createPaymentLine($payment_id,'ADDON',NULL,$title,$price,NULL,'');
    }

    public static function updatePremiumFlexDiscount($payment_id, $discountamt)
    {
        $payment = Payments::where('id', $payment_id)->first();

        if (!is_null($payment)) {
            $premiumAmount = $payment->totalamt * 0.1;
            $premiumDiscountAmount = $discountamt * 0.1;
            $premiumDiscount = $premiumDiscountAmount - $premiumAmount;

            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'PREMIUM',NULL,'Premium Flex Discount',$premiumDiscount,NULL,'');
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

            $title = sprintf('PromoCode Discount %s %s [%s]', $discount, $discount_type, $promotion->code);
            $paymentLine = PaymentHelper::createPaymentLine($payment_id,'ROUTE',NULL,$title,$discountamt,NULL,'');
        }

        return $payment;
    }

    public static function updateFeePaymentLine($payment_id, $_fee, $type) {
        $fee = FeeSetting::where('type', $type)->first();
        $title = '';
        if($fee->isuse_sc == 'Y') $title .= 'Service';
        if($fee->isuse_sc == 'Y' && $fee->isuse_pf == 'Y') $title .= ' + ';
        if($fee->isuse_pf == 'Y') $title .= 'Processing';
        $title .= ' fee ['. $type .']';

        $line = PaymentHelper::createPaymentLine($payment_id, 'FEE', NULL, $title, $_fee, NULL, '');
    }

    public static function paymentAgentInfo($paymentId){
        $payment = Payments::find($paymentId);

        $des = (array)json_decode($payment->description);
                //dd($des);
                if(isset($des['agentCode']) && $des['agentCode'] == 'SCB'){
                    $payment->c_accountno = $des['accountNo'];
                    $payment->c_paymentid = $des['paymentID'];
                    $payment->c_merchanid = $des['merchantID'];
                    $payment->c_invoiceno = $des['invoiceNo'];
                    $payment->c_amount = $des['amount'];
                    $payment->c_currencycode = $des['currencyCode'];
                    $payment->c_tranref = $des['tranRef'];
                    $payment->c_referenceno = $des['referenceNo'];
                    $payment->c_approvalcode = $des['approvalCode'];
                    //$payment->c_datetime = date('Y-m-d H:i:s', $des['transactionDateTime']);
                    $payment->c_agent = $des['agentCode'];
                    $payment->c_issuercountry = $des['issuerCountry'];
                    $payment->c_issuerbank = $des['issuerBank'];
                    $payment->c_cardtype = $des['cardType'];
                }

                $payment->save();
    }
}
