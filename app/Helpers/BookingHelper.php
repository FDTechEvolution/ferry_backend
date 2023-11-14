<?php
namespace App\Helpers;

use App\Models\BookingCustomers;
use App\Models\BookingRoutes;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Station;
use Ramsey\Uuid\Uuid;


class BookingHelper
{

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
            'ispayment' => $_b['ispayment'],
            'user_id' => $_b['user_id'],
            'trip_type' => $_b['trip_type'],

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
                'booking_id'=>$booking->id
            ]);

        }



        return $booking;
    }
}