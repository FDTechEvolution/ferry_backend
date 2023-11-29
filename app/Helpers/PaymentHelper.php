<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class PaymentHelper
{
    public static function encodeRequest($booking) {
        $SECRETKEY = config('services.payment.secret_key');
        $merchantID = config('services.payment.merchant_id');
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

            "userDefined1" => $booking->id,
            "frontendReturnUrl" => $fontend_return,
            "backendReturnUrl" => $backend_response,

            //MANDATORY RANDOMIZER
            "nonceStr" => $nonceStr
        );

        $jwt = JWT::encode($payload, $SECRETKEY, 'HS256');
        $data = '{"payload":"' . $jwt . '"}';

        return $data;
    }

    public static function postTo_2c2p($fields_string) {
        $BASEURL = config('services.payment.base_url');
        $APIURL = "paymentToken";
        
        $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $BASEURL.$APIURL); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',                 
				));
 
            //execute post
            $result = curl_exec($ch); //close connection
            curl_close($ch);
            return $result;
    }

    public static function decodeResponse($response) {
        $SECRETKEY = config('services.payment.secret_key');

        $decoded = json_decode($response, true);
        $payloadResponse = $decoded['payload'];
        $decodedPayload = JWT::decode($payloadResponse, new Key($SECRETKEY, 'HS256'));
        $decoded_array = (array) $decodedPayload;
        
        return $decoded_array;
    }
}