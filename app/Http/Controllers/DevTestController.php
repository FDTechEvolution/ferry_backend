<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Mail\TestMail;
use App\Models\Bookings;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Log;

class DevTestController extends Controller
{
    public function index(){
        //$log = Mail::to('athiwat.wir@gmail.com')->send(new TestMail());
        //$log= EmailHelper::ticket('9b63a3d2-ac4d-424f-ac80-b9826cfee4f3');
        //dd($log);

        //$x = RouteHelper::getAvaliableRoutes('9ad24fd5-754a-495d-8447-c629897e0ab2','9ad24dfa-d068-4aa2-8131-8c1c87b7b79d','2024-07-01');
        //dd($x);

        /*
        $bookings = Bookings::with('bookingRoutes','tickets')->where('ispayment','Y')->get();

        foreach($bookings as $booking){
            foreach($booking->bookingRoutes as $bookingRoute){
                foreach($booking->tickets as $ticket){
                    if(($bookingRoute->station_from->id == $ticket->station_from_id) && ($bookingRoute->station_to->id == $ticket->station_to_id)){
                        Log::debug('true');
                        $ticket->booking_route_id = $bookingRoute->pivot->id;
                        $ticket->save();
                    }
                }
            }
        }
            */

        $payments = Payments::get();

        foreach($payments as $payment){
            if(!empty($payment->description) && !is_null($payment->description)){
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
    }
}
