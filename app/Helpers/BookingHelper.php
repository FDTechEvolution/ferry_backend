<?php
namespace App\Helpers;

use App\Models\BookingCustomers;
use App\Models\BookingRoutes;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Tickets;
use App\Models\Station;
use Ramsey\Uuid\Uuid;
use App\Helpers\SequentNumber;


class BookingHelper
{

    public static function status()
    {
        $status = [
            'DR' => 'Draft',
            'CO' => 'Completed',
            'VO' => 'Canceled',
        ];
    }

    public static function getBookingInfo($booking_id)
    {

    }

    /*
        data = [
            'booking'=>[
                'departdate'=> format Y-m-d,
                'adult_passenger'=> 0,
                'child_passenger'=>0,
                'infant_passenger'=> 0,
                'amount'=> price exclude extra,
                'ispayment'=>Y:N,
                'user_id'=> require only booking by admin on backend, null,
                'trip_type'=> ENUM('one-way', 'round-trip') 
            ],
            'routes'=>[
                [
                    route_id,
                    type: departure or return,
                    traveldate: Y-m-d format,
                    amount,
                    extras =>[
                        [
                            type : activity or addon,
                            amount,
                            activity_id,
                            addon_id
                        ],
                        [.....]
                    ]
                ],
                [......]
            ],
            'customers'=>[
                [
                    fullname,
                    type,
                    passportno,
                    email,
                    mobile,
                    fulladdress
                ],
                [.....],
            ],
           
        ]
    */
    public static function createBooking($data = [])
    {

        $amount = 0;
        $extraAmount = 0;
        $totalAmount = 0;

        //Create booking
        $_b = $data['booking'];
        $booking = Bookings::create([
            'departdate' => $_b['departdate'],
            'adult_passenger' => $_b['adult_passenger'],
            'child_passenger' => $_b['child_passenger'],
            'infant_passenger' => $_b['infant_passenger'],
            'totalamt' => $_b['totalamt'],
            'extraamt' => $_b['extraamt'],
            'amount' => $_b['amount'],
            'ispayment' => isset($_b['ispayment']) ? $_b['ispayment'] : 'N',
            'user_id' => isset($_b['user_id']) ? $_b['user_id'] : NULL,
            'trip_type' => $_b['trip_type'],
            'bookingno' => newSequenceNumber('BOOKING'),
            'book_channel' => isset($_b['book_channel']) ? $_b['book_channel'] : 'ONLINE',

        ]);

        $amount += $_b['amount'];

        if (!$booking) {
            return false;
        }

        //Create customers
        $_c = $data['customers'];
        foreach ($_c as $key => $customerData) {
            $customer = Customers::create([
                'fullname' => $customerData['fullname'],
                'type' => $customerData['type'],
                'passportno' => $customerData['passportno'],
                'email' => $customerData['email'],
                'mobile' => $customerData['mobile'],
                'fulladdress' => $customerData['fulladdress'],
            ]);
            $booking->bookingCustomers()->attach($customer, ["id" => (string) Uuid::uuid4()]);
        }

        //Create extra
        if (isset($data["extras"])) {
            $_extra = $data['extras'];
        }

        //Routes
        $_routes = $data['routes'];
        foreach ($_routes as $key => $routeData) {
            $bookingRoute = BookingRoutes::create([
                'route_id' => $routeData['route_id'],
                'traveldate' => $routeData['traveldate'],
                'amount' => $routeData['amount'],
                'type' => $routeData['type'],
                'booking_id' => $booking->id,
            ]);
        }

        if ($booking->ispayment == 'Y') {
            $b = new BookingHelper();
            $b->completeBooking($booking->id);

        }

        return $booking;
    }

    public function completeBooking($bookingId = null)
    {
        if (is_null($bookingId)) {
            return null;
        }

        $booking = Bookings::with('bookingRoutes.station_from', 'bookingRoutes.station_to', 'bookingCustomers')->where('id', $bookingId)->first();
        if (is_null($booking)) {
            return null;
        }

        $booking->status = 'CO';
        $booking->save();

        //Create ticket
        $customers = $booking->bookingCustomers;
        $routes = $booking->bookingRoutes;

        foreach ($routes as $key => $route) {
            foreach ($customers as $customer) {
                $ticket = Tickets::create(
                    [
                        'ticketno' => newSequenceNumber('TICKET'),
                        'station_from_id' => $route['station_from']['id'],
                        'station_to_id' => $route['station_to']['id'],
                        'status'=>'CO',
                        'customer_id'=>$customer['id'],
                        'booking_id'=>$booking['id']
                    ],
                );
            }
        }


        $booking = Bookings::with('bookingRoutes.station_from', 'bookingRoutes.station_to', 'bookingCustomers','tickets')->where('id', $bookingId)->first();
        return $booking;
    }

    public static function voidBooking($bookingId = null)
    {
        if (is_null($bookingId)) {
            return null;
        }

        $booking = Bookings::where('id', $bookingId)->first();
        if (is_null($booking)) {
            return null;
        }

        $booking->status = 'VO';
        $booking->save();

        //Create ticket
        return $booking;
    }
}