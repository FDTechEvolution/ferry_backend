<?php
namespace App\Helpers;

use App\Mail\BookingMail;
use App\Mail\VoidBooking;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\URL;
use App\Models\BookingRoutes;
use Exception;

use App\Models\Bookings;

class EmailHelper
{
    public static function ticket($booking_id)
    {

        $booking = Bookings::find($booking_id);
        $tickets = $booking->tickets;
        //$route = $booking->route;
        $customer = $booking->bookingCustomers[0];
        //dd($customer);
        if(is_null($customer->email) || $customer->email ==''){
            TransactionLogHelper::tranLog(['type' => 'email', 'title' => 'Can not send email', 'description' => $customer->email, 'booking_id' => $booking->id]);

            return false;
        }

        $ticketno = isset($tickets[0]->ticketno)?$tickets[0]->ticketno:'';

        $mailData = [
            'bookingno' => $booking->bookingno,
            'ticketno' => $ticketno,
            'customer_name' => sprintf('%s.%s',$customer->title,ucwords($customer->fullname)),
            'link' => URL::previous(),
        ];

        $cc = ['RSVN_Tigerline@outlook.com','tigerline8989@gmail.com'];

            try {
                Mail::to($customer->email)
                ->cc($cc)
                ->send(new TicketMail($mailData, $booking->bookingno,$ticketno));
                TransactionLogHelper::tranLog(['type' => 'email', 'title' => 'Sent ticket email successfully', 'description' => '', 'booking_id' => $booking->id]);
            } catch (Exception $e) {
                TransactionLogHelper::tranLog(['type' => 'email', 'title' => 'Sent ticket email failed', 'description' => $e->getMessage(), 'booking_id' => $booking->id]);

            }


        //LineNotifyHelper::devLog(sprintf('send email %s | %s ',$customer->email,$ticketno));
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
                Mail::to('win.tigerline@gmail.com')->send(new VoidBooking($mailData));
            }

        }
    }

    public static function emailBooking($booking_id) {
        $booking = Bookings::find($booking_id);
        $customer = $booking->bookingCustomers[0];
        $url = 'https://tigerlineferry.com/booking/payment/'.$booking->bookingno.'/'.$customer->email;

        $mailData = [
            'bookingno' => $booking->bookingno,
            'customer_name' => sprintf('%s.%s',$customer->title,ucwords($customer->fullname)),
            'payment' => $url,
        ];

        Mail::to($customer->email)
            ->send(new BookingMail($mailData));
    }

}
