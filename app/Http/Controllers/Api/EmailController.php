<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

use App\Helpers\EmailHelper;
use App\Models\Bookings;

class EmailController extends Controller
{
    public function sendEmail($booking_id) {
        EmailHelper::ticket($booking_id);
        // $booking = Bookings::find('9b3aff15-6e1d-4f6c-87ba-96ba0704ea1e');
        // $customer = $booking->bookingCustomers;
        // $tickets = $booking->tickets;
        // $route = $booking->route;

        // $passenger = intval($booking->adult_passenger) + intval($booking->child_passenger) + intval($booking->infant_passenger);
        // $station_from = $tickets[0]->station_from->name;
        // $station_to = $tickets[0]->station_to->name;
        // $pier_from = $tickets[0]->station_from->piername != '' ? '('.$tickets[0]->station_from->name.')' : '';
        // $pier_to = $tickets[0]->station_to->piername != '' ? '('.$tickets[0]->station_to->name.')' : '';
        // $depart_time = date('H:i', strtotime($route[0]->depart_time));
        // $arrive_time = date('H:i', strtotime($route[0]->arrive_time));

        // // Log::debug($booking->tickets->station_to);

        // $mailData = [
        //     'bookingno' => $booking->bookingno,
        //     'ticketno' => $tickets[0]->ticketno,
        //     'passenger' => $passenger,
        //     'station_from' => $station_from.' '.$pier_from,
        //     'station_to' => $station_to.' '.$pier_to,
        //     'depart_time' => $depart_time,
        //     'arrive_time' => $arrive_time
        // ];

        return response()->json(['data' => 'sending...'], 200);
    }
}
