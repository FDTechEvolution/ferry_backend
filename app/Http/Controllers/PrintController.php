<?php

namespace App\Http\Controllers;

use App\Helpers\TicketHelper;
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
        $booking = BookingHelper::getBookingInfoByBookingNo($bookingno);
        $term = Informations::where('position', 'TERM_TICKET')->first();
        $statusLabel = BookingHelper::status();
        $bookings[0] = $booking;
        //dd($booking);
        Pdf::setOption(['dpi' => 150, 'defaultMediaType' => 'a4', 'debugCss' => true]);
        $pdf = Pdf::loadView('print.ticket_v2', ['bookings' => $bookings, 'term' => $term,'statusLabel'=>$statusLabel]);

        /*
        if($booking->ispayment=='N'){
            //dd($booking);
            $pdf = Pdf::loadView('print.ticket_v2_nopayment', ['bookings' => $bookings, 'term' => $term]);
        }
            */

        return $pdf->stream();

    }

    public function multipleTicket(Request $request)
    {
        $bookingNos = $request->booking_nos;
        $bookings = [];

        foreach ($bookingNos as $bookingno) {
            $booking = BookingHelper::getBookingInfoByBookingNo($bookingno);
            if ($booking->ispayment == 'Y') {
                array_push($bookings, $booking);
            }

        }


        $term = Informations::where('position', 'TERM_TICKET')->first();

        Pdf::setOption(['dpi' => 150, 'defaultMediaType' => 'a4', 'debugCss' => true]);
        $pdf = Pdf::loadView('print.ticket', ['bookings' => $bookings, 'term' => $term]);

        return $pdf->stream();

    }
}
