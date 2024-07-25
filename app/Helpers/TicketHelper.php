<?php
namespace App\Helpers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Helpers\BookingHelper;
use App\Models\Informations;
use Illuminate\Support\Facades\Storage;

class TicketHelper
{
    public function makePdf($bookingNo)
    {
        $booking = BookingHelper::getBookingInfoByBookingNo($bookingNo);
        $term = Informations::where('position', 'TERM_TICKET')->first();
        $bookings[0] = $booking;
        Pdf::setOption(['dpi' => 150, 'defaultMediaType' => 'a4', 'debugCss' => true]);
        $pdf = Pdf::loadView('print.ticket_v2', ['bookings' => $bookings, 'term' => $term]);

        $filename = sprintf('%s.pdf',$booking->bookingno);
        Storage::disk('attachments')->put($filename, $pdf->output());
    }
}
