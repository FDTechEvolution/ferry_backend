<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Mail\TestMail;
use App\Models\Bookings;
use App\Models\PaymentLines;
use App\Models\Payments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\EmailHelper;
use Illuminate\Support\Facades\Log;

class DevTestController extends Controller
{
    public function index(){
        $paymentLines = PaymentLines::where('type','DISCOUNT')->get();

        foreach($paymentLines as $item){
            Payments::where('id',$item->payment_id)->update(['discount'=>$item->amount]);
        }

        $bookings = Bookings::where('book_channel','ONLINE')->get();
        foreach($bookings as $item){
            $payment = Payments::where('booking_id',$item->id)->first();
            if(!empty($payment)){
                $payment->amount = $item->amount;
                $payment->save();
            }

        }
    }
}
