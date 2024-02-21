<?php

namespace App\Http\Controllers;

use App\Models\Informations;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Bookings;
use App\Helpers\BookingHelper;


//https://github.com/barryvdh/laravel-dompdf

//https://github.com/milon/barcode?source=post_page-----7d7d83334510--------------------------------


class PrintController extends Controller
{
    //

    public function ticket($bookingno = null)
    {
        $type = request()->type;
        if ($type == 'V') {
            $booking = BookingHelper::getBookingInfoByBookingNo($bookingno);
            $term = Informations::where('position','TERM_TICKET')->first();
            $bookings[0] = $booking;
            dd($booking->bookingCustomers);
            return view('print.ticket',['bookings'=>$bookings,'term'=>$term]);
        }else{
            $booking = BookingHelper::getBookingInfoByBookingNo($bookingno);
            $term = Informations::where('position','TERM_TICKET')->first();
            $bookings[0] = $booking;
            Pdf::setOption(['dpi' => 150, 'defaultMediaType' => 'a4','debugCss'=>true]);
            $pdf = Pdf::loadView('print.ticket', ['bookings'=>$bookings,'term'=>$term]);

            return $pdf->stream();
        }

    }
}
