<?php

namespace App\Helpers;

use App\Models\Addon;
use App\Models\ApiMerchants;
use App\Models\BookingRoutes;
use App\Models\BookingExtras;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Tickets;
use App\Models\BookingRelated;
use Ramsey\Uuid\Uuid;
use App\Models\Promotions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookingHelper
{

    public static function status()
    {
        $status = [
            'DR' => ['title' => 'Non Approved', 'icon' => '<i class="fi fi-circle-spin"></i>', 'class' => '', 'action' => ''],
            'UNP' => ['title' => 'On Hold', 'icon' => '<i class="fa-solid fa-clock-rotate-left"></i>', 'class' => 'text-warning', 'action' => 'Unpaid'],
            'CO' => ['title' => 'Approved', 'icon' => '<i class="fa-solid fa-check-double"></i>', 'class' => 'text-success', 'action' => 'Paid'],
            'void' => ['title' => 'Cancelled', 'icon' => '<i class="fa-solid fa-xmark"></i>', 'class' => 'text-danger', 'action' => 'Cancel'],
            'VO' => ['title' => 'Cancelled', 'icon' => '<i class="fa-solid fa-xmark"></i>', 'class' => 'text-danger', 'action' => 'Cancel'],
            //'VO' => ['title' => 'CANX', 'icon' => '', 'class' => 'text-mute','action'=>'Cancel'],
            'amended' => ['title' => 'Amended', 'icon' => '<i class="fa-solid fa-list-check"></i>', 'class' => 'text-blue-900', 'action' => ''],
            'delete' => ['title' => 'Deleted', 'icon' => '<i class="fa-solid fa-trash"></i>', 'class' => 'text-danger', 'action' => 'Delete'],

        ];

        return $status;
    }

    public static function tripType()
    {
        return [
            'one-way' => 'One Way',
            'round-trip' => 'Round Trip',
            'multi-trip' => 'Multi Island',
        ];
    }

    public static function bookChannels()
    {
        $bookChannels = DB::table('bookings')
            ->select('book_channel', 'book_channel as title')
            ->groupBy('book_channel')
            ->get();
        $channels = [];
        foreach ($bookChannels as $item) {
            $channels[$item->book_channel] = $item->title;
        }

        return $channels;
    }

    public static function getBookingInfoByBookingNo($bookingno)
    {
        $booking = Bookings::where(['bookingno' => $bookingno])
            ->with('bookingCustomers', 'user', 'bookingRoutes', 'bookingRoutesX.tickets', 'bookingRoutesX.bookingExtraAddons', 'bookingRoutes.station_from', 'bookingRoutes.station_to', 'payments')
            ->first();

        //dd($booking);

        return $booking;
    }

    public static function getBookingInfoByBookingId($booking_id)
    {
        $booking = Bookings::where(['id' => $booking_id])
            ->with(
                'bookingCustomers',
                'tickets.customer',
                'user',
                'bookingRoutes',
                'bookingRoutesX.bookingExtraAddons',
                'bookingRoutes.station_from',
                'bookingRoutes.station_to',
                'bookingRoutes.station_lines',
                'payments',
            )
            ->first();

        //dd($booking);

        return $booking;
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
                'trip_type'=> ENUM('one-way', 'return','multiple')
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


        //dd($data);

        $amount = 0;
        $extraAmount = 0;
        $totalAmount = 0;

        //Create booking
        $_b = $data['booking'];
        $apiMerchantId = isset($_b['api_merchant_id']) ? $_b['api_merchant_id'] : NULL;
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
            'bookingno' => newSequenceNumber('BOOKING', $apiMerchantId),
            'book_channel' => isset($_b['book_channel']) ? $_b['book_channel'] : 'ONLINE',
            'ispremiumflex' => isset($_b['ispremiumflex']) ? $_b['ispremiumflex'] : 'N',
            'promotion_id' => isset($_b['promotion_id']) ? $_b['promotion_id'] : NULL,
            'api_merchant_id' => $apiMerchantId,
        ]);

        $amount += $_b['amount'];

        if (!$booking) {
            return false;
        }

        //Create customers
        //$totalPassenger = ($booking->adult_passenger+$booking->child_passenger+$booking->infant_passenger);

        $_c = $data['customers'];
        $mobileno = '';
        foreach ($_c as $key => $customerData) {
            if ($customerData['mobile'] != '') $mobileno = $customerData['mobile'];
            $customer = Customers::create([
                'fullname' => $customerData['fullname'],
                'type' => $customerData['type'],
                'passportno' => $customerData['passportno'],
                'email' => $customerData['email'],
                'mobile' => $customerData['mobile'],
                'fulladdress' => $customerData['fulladdress'],
                'mobile_code' => isset($customerData['mobile_code']) ? $customerData['mobile_code'] : null,
                'mobile_th' => isset($customerData['mobile_th']) ? $customerData['mobile_th'] : null,
                'title' => isset($customerData['title']) ? $customerData['title'] : null,
                'country' => isset($customerData['country']) ? $customerData['country'] : null,
                'birth_day' => isset($customerData['birthday']) ? $customerData['birthday'] : null
            ]);
            $isdefault = $key == 0 ? 'Y' : 'N';

            $booking->bookingCustomers()->attach($customer, ["id" => (string) Uuid::uuid4(), 'isdefault' => $isdefault]);
        }

        //Routes
        $_routes = $data['routes'];
        $routeType = [
            'one-way' => ['O', 'O'],
            'round-trip' => ['R1', 'R2'],
            'multiple' => ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'M7', 'M8', 'M9'],
        ];
        foreach ($_routes as $key => $routeData) {
            $bookingRoute = BookingRoutes::create([
                'route_id' => $routeData['route_id'],
                'traveldate' => $routeData['traveldate'],
                'amount' => $routeData['amount'],
                'type' => isset($routeType[$_b['trip_type']][$key]) ? $routeType[$_b['trip_type']][$key] : '',
                'booking_id' => $booking->id,
            ]);

            if (isset($routeData["extras"])) {
                $_extra = $routeData['extras'];
                foreach ($_extra as $index => $extra) {
                    $addon = Addon::where('id', $extra['addon_id'])->first();

                    $bookingExtra = BookingExtras::create([
                        'addon_id' => $addon->id,
                        'amount' => $extra['amount'],
                        'booking_route_id' => $bookingRoute->id,
                    ]);
                }
            }

            if (isset($routeData['route_addons'])) {
                foreach ($routeData['route_addons'] as $addon) {
                    BookingExtras::create([
                        'booking_route_id' => $bookingRoute->id,
                        'route_addon_id' => $addon['route_addon_id'],
                        'amount' => $addon['amount'],
                        'description' => $addon['description'],
                    ]);
                }
            }
        }


        TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Create booking', 'description' => '', 'booking_id' => $booking->id]);

        //$booking->mobileno = $mobileno;
        return $booking;
    }

    public static function completeBooking($bookingId = null, $referenceNo = null)
    {
        if (is_null($bookingId)) {
            return null;
        }

        $booking = Bookings::with(['bookingRoutes.station_from', 'bookingRoutes.station_to', 'bookingCustomers'])
            ->where('id', $bookingId)
            ->where('status', '!=', 'CO')
            ->first();

        //dd($booking);
        if (is_null($booking)) {
            return null;
        }


        $booking->status = 'CO';
        $booking->ispayment = 'Y';
        $booking->referenceno = $referenceNo;
        $booking->save();

        if ($booking->promotion_id != NULL) {
            $promotion = Promotions::find($booking->promotion_id);
            $promotion->times_used = $promotion->times_used + 1;
            $promotion->save();
        }

        //Create ticket

        $customers = $booking->bookingCustomers;
        $routes = $booking->bookingRoutes;
        $mobileno = '';
        $ticketType = 'TICKET';

        foreach ($customers as $c) {
            if ($c->mobile != '') $mobileno = $c->mobile;
        }

        $isCreateTicket = false;
        $countTicket = 0;
        foreach ($routes as $key => $route) {
            //foreach ($customers as $index => $customer) {
            if (isset($booking->api_merchant_id) && !empty($booking->api_merchant_id)) {
                $apiMerchant = ApiMerchants::find($booking->api_merchant_id);
                //Log::debug($apiMerchant);
                if (!is_null($apiMerchant)) {
                    $ticketType = 'TICKET_' . $apiMerchant->code;
                }
                //Log::debug($ticketType);
            }
            $ticketNo = newSequenceNumber($ticketType, $booking->api_merchant_id);

            if ($booking['trip_type'] == 'multiple') {
                $ticketNo .= '#' . ($key + 1);
            }
            $ticket = Tickets::updateOrCreate(
                [
                    'booking_route_id' => $route->pivot->id,
                ],
                [
                    'ticketno' => $ticketNo,
                    'station_from_id' => $route['station_from']['id'],
                    'station_to_id' => $route['station_to']['id'],
                    'status' => 'CO',
                    //'customer_id' => $customer['id'],
                    'booking_id' => $booking['id'],
                    'booking_route_id' => $route->pivot->id,
                    //'isdefault' => $customer->pivot->isdefault,
                ],
            );

            if ($ticket) {
                $isCreateTicket = true;
                $countTicket++;
            }
            //}

        }
        if ($isCreateTicket) {
            TransactionLogHelper::tranLog(['type' => 'ticket', 'title' => sprintf('Created ticket (%s)', $countTicket), 'description' => '', 'booking_id' => $booking->id]);
        }


        $booking = Bookings::with(['bookingRoutes.station_from', 'bookingRoutes.station_to', 'bookingCustomers'])->where('id', $bookingId)->first();

        TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Complated booking', 'description' => '', 'booking_id' => $booking->id]);
        EmailHelper::ticket($bookingId);
        //$booking->mobileno = $mobileno;
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

        TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Void booking', 'description' => '', 'booking_id' => $booking->id]);

        //Create ticket
        return $booking;
    }

    public static function moveBooking($oldBookingno, $newBookingno)
    {
        $oldBooking = Bookings::where('bookingno', $oldBookingno)->with()->first();
        $newBooking = Bookings::where('bookingno', $newBookingno)->first();

        $bookingRelated = BookingRelated::create([
            'booking_id' => $newBooking->id,
            'related_booking_id' => $oldBooking->id,
        ]);

        $oldBooking->status = 'RELATED';
        $oldBooking->save();

        return $newBooking;
    }
}
