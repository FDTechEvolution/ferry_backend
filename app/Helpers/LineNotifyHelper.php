<?php
namespace App\Helpers;

use App\Models\Bookings;
use Phattarachai\LineNotify\Facade\Line;

class LineNotifyHelper
{
    public static function newBooking($bookingId){
        if(env('LINE_ACCESS_TOKEN_NEW_BOOKING') == '' || empty(env('LINE_ACCESS_TOKEN_NEW_BOOKING'))){
            return false;
        }

        $booking = Bookings::with('bookingRoutes','payments')->where('id',$bookingId)->first();

        //Send Line
        $str = "New booking!\n";
        $str .= sprintf('Invoice No.: %s',$booking->bookingno)."\n";
        foreach($booking->bookingRoutes as $index => $bookingRoute){
            $str .= sprintf('Route: %s->%s',$bookingRoute->station_from->name,$bookingRoute->station_to->name)."\n";
            $str .= sprintf('Route Time: %s/%s',date('H:i', strtotime($bookingRoute->depart_time)),date('H:i', strtotime($bookingRoute->arrive_time)))."\n";
            $str .= sprintf('Travel Date: %s',$bookingRoute->pivot->traveldate)."\n";
        }
        $str .= "\n";
        if(sizeof($booking->payments)>0){
            $str .= sprintf('Payment Amount: %sTHB',number_format($booking->payments[0]->totalamt))."\n";
        }

        $str .= sprintf('Ticket: %s/print/ticket/%s',env('SITE_URL'),$booking->bookingno);
        Line::setToken(env('LINE_ACCESS_TOKEN_NEW_BOOKING'))->send($str);
    }
}
