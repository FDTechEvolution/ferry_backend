<?php
namespace App\Helpers;

use App\Mail\VoidBooking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\URL;
use App\Models\BookingRoutes;

use App\Models\Bookings;

class EmailHelper
{
    public static function ticket($booking_id)
    {
        $booking = Bookings::find($booking_id);
        $tickets = $booking->tickets;
        $route = $booking->route;
        $custoner = $booking->bookingCustomers;

        $passenger = intval($booking->adult_passenger) + intval($booking->child_passenger) + intval($booking->infant_passenger);
        $station_from = $tickets[0]->station_from->name;
        $station_to = $tickets[0]->station_to->name;
        $pier_from = $tickets[0]->station_from->piername != '' ? '(' . $tickets[0]->station_from->name . ')' : '';
        $pier_to = $tickets[0]->station_to->piername != '' ? '(' . $tickets[0]->station_to->name . ')' : '';
        $depart_time = date('H:i', strtotime($route[0]->depart_time));
        $arrive_time = date('H:i', strtotime($route[0]->arrive_time));
        $depart_date = date('l M d, Y', strtotime($booking->departdate));

        $mailData = [
            'bookingno' => $booking->bookingno,
            'ticketno' => $tickets[0]->ticketno,
            'passenger' => $passenger,
            'station_from' => $station_from . ' ' . $pier_from,
            'station_to' => $station_to . ' ' . $pier_to,
            'depart_time' => $depart_time,
            'arrive_time' => $arrive_time,
            'depart_date' => $depart_date,
            'link' => URL::previous(),
        ];

        Mail::to($custoner[0]->email)->send(new TicketMail($mailData));
    }

    public static function voidBoking($booking_route_id,$message)
    {
        $bookingRoute = BookingRoutes::where('id', $booking_route_id)->with('booking', 'route', 'route.station_from','route.station_to', 'booking.bookingCustomers')->first();

        $bookingCustomer = NULL;
        if (isset($bookingRoute->booking->bookingCustomers) && sizeof($bookingRoute->booking->bookingCustomers) > 0) {
            $bookingCustomer = $bookingRoute->booking->bookingCustomers[0];
            $booking = $bookingRoute->booking;
            $route = $bookingRoute->route;
            $station_from = $route->station_from;
            $station_to = $route->station_to;


            if (!is_null($bookingCustomer->email) && $bookingCustomer->email != '') {
                $depart_time = date('H:i', strtotime($route->depart_time));
                $arrive_time = date('H:i', strtotime($route->arrive_time));
                $depart_date = date('l M d, Y', strtotime($booking->departdate));
                $passenger = intval($booking->adult_passenger) + intval($booking->child_passenger) + intval($booking->infant_passenger);

                $station_from = $station_from->name;
                $station_to = $station_to->name;

                $mailData = [
                    'bookingno' => $booking->bookingno,
                    'passenger' => $passenger,
                    'station_from' => $station_from ,
                    'station_to' => $station_to,
                    'depart_time' => $depart_time,
                    'arrive_time' => $arrive_time,
                    'depart_date' => $depart_date,
                    'link' => URL::previous(),
                    'message'=>$message
                ];

                Mail::to($bookingCustomer->email)->send(new VoidBooking($mailData));
            }

        }
    }
}
