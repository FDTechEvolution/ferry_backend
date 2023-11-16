<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Addon;
use App\Models\Activity;
use App\Models\Bookings;
use App\Helpers\BookingHelper;

class BookingController extends Controller
{
    public function store(Request $request) {
        $route = $this->checkRoute($request->route_id);
        if($route) {
            $book_channel = $request->book_channel ?: 'SEVEN';
            $child = $request->child_passenger ?: 0;
            $infant = $request->infant_passenger ?: 0;
            $_amount = $request->totalamount ? ($request->totalamount*$request->passenger) : $this->routeAmount($route, $request->passenger, $child, $infant);
            $_extrameal = isset($request->meal_id) ? $this->extraMeal($request->meal_id, $request->meal_qty) : 0;
            $_extraactivity = isset($request->activity_id) ? $this->extraActivity($request->activity_id, $request->activity_qty) : 0;
            $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type, $request->passportno, $request->email, $request->address);
            $_totalamount = $_amount + $_extrameal + $_extraactivity;

            $data = [
                'booking' => [
                    'departdate' => $request->departdate,
                    'adult_passenger' => $request->passenger,
                    'child_passenger' => $child,
                    'infant_passenger' => $infant,
                    'totalamt' => $_totalamount,
                    'extraamt' => ($_extrameal + $_extraactivity),
                    'amount' => $_amount,
                    'ispayment' => 'N',
                    'user_id' => NULL,
                    'trip_type' => NULL,
                    'status' => 'DR',
                    'book_channel' => $book_channel
                ],
                'customers' => $_customer,
                'routes' => [
                    [
                        'route_id' => $request->route_id,
                        'traveldate' => $request->departdate,
                        'amount' => $_amount,
                        'type' => NULL
                    ]
                ]
            ];

            $booking = BookingHelper::createBooking($data);

            return response()->json(['result' => true, 'data' => $booking->id], 200);
        }
        // Log::debug($request);

        return response()->json(['result' => false, 'data' => 'No Route.'], 200);
    }

    private function checkRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::find($booking_id);
        return isset($booking) ?: false;
    }

    private function routeAmount($route, $adult, $child, $infant) {
        $amount = 0;
        $amount += $route->regular_price*$adult;
        $amount += $route->child_price*$child;
        $amount += $route->infant_price*$infant;

        return $amount;
    }

    private function extraMeal($meal_id, $meal_qty) {
        $meal_amount = 0;
        foreach($meal_qty as $key => $qty) {
            if($qty != 0) {
                $meal = Addon::find($meal_id[$key]);
                $meal_amount += $meal->amount*$qty;
            }
        }

        return $meal_amount;
    }

    private function extraActivity($activity_id, $activity_qty) {
        $acctivity_amount = 0;
        foreach($activity_qty as $key => $qty) {
            if($qty != 0) {
                $activity = Activity::find($activity_id[$key]);
                $acctivity_amount += $activity->price*$qty;
            }
        }

        return $acctivity_amount;
    }

    private function setPassenger($fullname, $mobile, $type = NULL, $passport = NULL, $email = NULL, $address = NULL) {
        $customer = [];

        if(is_array($fullname)) {
            foreach($fullname as $key => $name) {
                if($key == 0) {
                    array_push($customer, [
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => $passport,
                        'email' => $email,
                        'mobile' => $mobile,
                        'fulladdress' => $address
                    ]);
                }
                else {
                    array_push($customer, [
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => NULL,
                        'email' => NULL,
                        'mobile' => NULL,
                        'fulladdress' => NULL
                    ]);
                }
            }
        }
        else {
            array_push($customer, [
                'fullname' => $fullname,
                'type' => 'ADULT',
                'passportno' => $passport,
                'email' => $email,
                'mobile' => $mobile,
                'fulladdress' => $address
            ]);
        }

        return $customer;
    }

    public function complete(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $c = new BookingHelper;
            $complete = $c->completeBooking($request->booking_id);
            return response()->json(['result' => true, 'data' => $complete]);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function destroy(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            return response()->json(['result' => true, 'data' => 'canceled.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function update(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            return response()->json(['result' => true, 'data' => 'updated.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function getBookingById(string $id = null) {
        $booking = Bookings::find($id);
        if(isset($booking)) return response()->json(['result' => true, 'data' => $booking]);
        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }
    
}
