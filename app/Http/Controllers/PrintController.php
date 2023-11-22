<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Bookings;


//https://github.com/barryvdh/laravel-dompdf


class PrintController extends Controller
{
    //

    public function ticket($bookingno = null)
    {
        $type = request()->type;
        if ($type == 'V') {
            return view('print.ticket');
        }else{
            $booking = Bookings::where(['bookingno'=>$bookingno])->first();
            Pdf::setOption(['dpi' => 150, 'defaultFont' => 'sans-serif', 'DOMPDF_ENABLE_CSS_FLOAT' => true]);
            $pdf = Pdf::loadView('print.ticket', ['booking'=>$booking]);
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
