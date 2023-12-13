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

            return view('print.ticket',['booking'=>$booking,'term'=>$term]);
        }else{
            $booking = BookingHelper::getBookingInfoByBookingNo($bookingno);
            $term = Informations::where('position','TERM_TICKET')->first();
            //$booking = Bookings::where(['bookingno'=>$bookingno])->with('tickets')->first();
            Pdf::setOption(['dpi' => 150, 'defaultMediaType' => 'a4','debugCss'=>true]);
            $pdf = Pdf::loadView('print.ticket', ['booking'=>$booking,'term'=>$term]);
            //return $pdf->download('invoice.pdf');
            //$html = view('print.ticket')->render();
            //$pdf->loadHtml($html);
            //$pdf->loadHtml($content2);
            //$pdf->render();

            //return $pdf->download();
            return $pdf->stream();
        }

    }
}
