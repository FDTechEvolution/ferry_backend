<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Helpers\PaymentHelper;
use App\Models\Route;
use App\Models\Bookings;
use App\Helpers\BookingHelper;
use App\Models\ApiMerchants;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $merchant = $request->attributes->get('merchant');
        $_merchant = ApiMerchants::find($merchant);

        if (isset($_merchant)) {
            $route = $this->getRoute($request->route_id);
            if ($route) {
                $totalamt = $request->totalamount;
                $data = [
                    'booking' => [
                        'departdate' => $request->departdate,
                        'adult_passenger' => $request->passenger,
                        'child_passenger' => 0,
                        'infant_passenger' => 0,
                        'totalamt' => $totalamt,
                        'extraamt' => 0,
                        'amount' => $totalamt,
                        'ispayment' => 'N',
                        'user_id' => NULL,
                        'trip_type' => 'one-way',
                        'status' => 'DR',
                        'book_channel' => $_merchant->name,
                        'api_merchant_id' => $_merchant->id,
                    ],
                    'customers' => [
                        [
                            'fullname' => $request->fullname,
                            'type' => 'ADULT',
                            'passportno' => isset($request->passportno) ? $request->passportno : NULL,
                            'email' => isset($request->email) ? $request->email : NULL,
                            'mobile' => $request->mobile,
                            'fulladdress' => isset($request->fulladdress) ? $request->fulladdress : NULL,
                        ]
                    ],
                    'routes' => [
                        [
                            'route_id' => $request->route_id,
                            'traveldate' => $request->departdate,
                            'amount' => $totalamt,
                            'type' => 'O'
                        ]
                    ]
                ];

                $booking = BookingHelper::createBooking($data);
                $payment = PaymentHelper::createPaymentFromBooking($booking->id);

                $_booking = Bookings::where(['id' => $booking->id])
                    ->with(
                        'bookingCustomers',
                        'bookingRoutes',
                    )
                    ->first();


                $customer = $_booking->bookingCustomers[0];
                $booking['customer'] = [
                    'fullname' => $customer->fullname,
                    'type' => $customer->type,
                    'mobile' => $customer->mobile,

                ];

                $route = $_booking->bookingRoutes[0];
                $booking['route'] = [
                    'depart_time' => $route->depart_time,
                    'arrive_time' => $route->arrive_time,
                    'station_from' => $route->station_from->name,
                    'station_to' => $route->station_to->name,
                ];


                return response()->json(['result' => true, 'data' => $booking], 200);
            }

            return response()->json(['result' => false, 'data' => 'route is incorrect ->' . $request->route_id], 200);
        }
    }

    private function getRoute($route_id)
    {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id)
    {
        $booking = Bookings::where('id', $booking_id)->first();
        return isset($booking) ?: false;
    }

    public function complete(Request $request)
    {
        $booking = Bookings::find($request->booking_id);
        $referenceNo = isset($request->reference_no) ? $request->reference_no : null;

        //Log::debug($request);
        if (!is_null($booking)) {


            if ($booking->status == 'DR') {
                $c = new BookingHelper;
                $c->completeBooking($request->booking_id, $referenceNo);
            } else {
                $status = BookingHelper::status();
                return response()->json(['result' => false, 'data' => 'this booking is ' . $status[$booking->status]['title']]);
            }

            return response()->json(['result' => true, 'data' => $booking]);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function destroy(Request $request)
    {
        if ($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            $booking->status = 'VO';
            if ($booking->save())
                return response()->json(['result' => true, 'data' => 'Booking canceled.']);
            else
                return response()->json(['result' => false, 'data' => 'error.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function update(Request $request)
    {
        if ($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            if (isset($request->departdate)) $booking->departdate = $request->departdate;
            if (isset($request->fullname)) $booking->bookingCustomers[0]->fullname = $request->fullname;
            if (isset($request->mobile)) $booking->bookingCustomers[0]->mobile = $request->mobile;
            if (isset($request->totalamount)) $booking->totalamt = $request->totalamount;
            if (isset($request->reference_no)) $booking->referenceno = $request->reference_no;

            if ($booking->push())
                return response()->json(['result' => true, 'data' => 'Booking updated.']);
            else
                return response()->json(['result' => false, 'data' => 'error.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function getBookingById(string $id = null)
    {

        $booking = Bookings::where('id', $id)
            ->with(
                'bookingCustomers',
                'bookingRoutes',
                'bookingRoutes.station_from',
                'bookingRoutes.station_to',
                'bookingRoutes.station_lines',
                'bookingRoutesX.tickets',
                'payments',
                'payments.paymentLines',
                'transactionLogs',
                'apiMerchant'
            )
            ->first();
        if (empty($booking)) {
            return response()->json(['result' => false, 'data' => 'No Booking.']);
        }

        $bookingStatus = BookingHelper::status();
        //Log::debug($booking);
        $customers = [];
        foreach ($booking->bookingCustomers as $c) {
            array_push($customers, [
                'fullname' => $c->fullname,
                'type' => $c->type,
                'mobile' => $c->mobile
            ]);
        }

        //ticket
        $ticketno = '';
        foreach ($booking->bookingRoutesX as $r) {
            if (!empty($r->tickets) && sizeof($r->tickets) > 0) {
                $ticketno = $r->tickets[0]->ticketno;
            }
        }

        $routes = [];
        foreach ($booking->bookingRoutes as $r) {

            array_push($routes, [
                'depart_time' => $r->depart_time,
                'arrive_time' => $r->arrive_time,
                'boat_type' => $r->boat_type,
                'station_from' => [
                    'id' => $r->station_from->id,
                    'name' => $r->station_from->name,
                    'piername' => $r->station_from->name,
                    'nickname' => $r->station_from->nickname,
                    'thai_name' => $r->station_from->thai_name,
                    'thai_piername' => $r->station_from->thai_piername,
                    'type' => $r->station_from->type,
                ],
                'station_to' => [
                    'id' => $r->station_to->id,
                    'name' => $r->station_to->name,
                    'piername' => $r->station_to->name,
                    'nickname' => $r->station_to->nickname,
                    'thai_name' => $r->station_to->thai_name,
                    'thai_piername' => $r->station_to->thai_piername,
                    'type' => $r->station_to->type,
                ]
            ]);
        }
        $data = [
            'id' => $booking->id,
            'departdate' => $booking->departdate,
            'adult_passenger' => $booking->adult_passenger,
            'child_passenger' => $booking->child_passenger,
            'infant_passenger' => $booking->infant_passenger,
            'totalamt' => (float)$booking->totalamt,
            'created_at' => $booking->created_at,
            'updated_at' => $booking->updated_at,
            'ispayment' => $booking->ispayment,
            'trip_type' => $booking->trip_type,
            'status' => $bookingStatus[$booking->status]['title'],
            'bookingno' => $booking->bookingno,
            'ticketno' => $ticketno,
            'book_channel' => $booking->book_channel,
            'merchant' => $booking->apiMerchant->name,
            'customers' => [
                $customers
            ],
            'route' => [
                $routes
            ]
        ];


        if (isset($booking)) return response()->json(['result' => true, 'data' => $data]);
        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    private function getBooking() {}
}
