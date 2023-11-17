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
        $route = $this->getRoute($request->route_id[0]);
        if($route) {
            $_amount = $this->routeAmount($request->route_id, $request->passenger, $request->child_passenger, $request->infant_passenger);
            $_extrameal = isset($request->meal_id) ? $this->extraMeal($request->meal_id, $request->meal_qty) : 0;
            $_extraactivity = isset($request->activity_id) ? $this->extraActivity($request->activity_id, $request->activity_qty) : 0;

            $_booking = $this->setBooking($request->departdate, $request->passenger, $request->child_passenger, 
                                            $request->infant_passenger, $request->trip_type, $request->book_channel, 
                                            $_amount, $_extrameal, $_extraactivity);
            $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type, 
                                                $request->passportno, $request->email, $request->address);
            $_route = $this->setRoutes($request->route_id, $request->departdate, $request->returndate, 
                                        $request->passenger, $request->child_passenger, $request->infant_passenger);

            $data = [
                'booking' => $_booking,
                'customers' => $_customer,
                'routes' => $_route
            ];

            $booking = BookingHelper::createBooking($data);

            return response()->json(['result' => true, 'data' => $booking], 200);
        }
        // Log::debug($request);

        return response()->json(['result' => false, 'data' => 'No Route.'], 200);
    }

    private function setBooking($departdate, $adult, $child, $infant, $trip_type, $book_channel, $amount, $extrameal, $extraactivity) {       
        $booking = [
            'departdate' => $departdate,
            'adult_passenger' => $adult,
            'child_passenger' => $child,
            'infant_passenger' => $infant,
            'totalamt' => ($amount + $extrameal + $extraactivity),
            'extraamt' => ($extrameal + $extraactivity),
            'amount' => $amount,
            'ispayment' => 'N',
            'user_id' => NULL,
            'trip_type' => $trip_type,
            'status' => 'DR',
            'book_channel' => $book_channel
        ];

        return $booking;
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

    private function setRoutes($route_id, $departdate, $returndate = null, $adult, $child, $infant) {
        $route = [];
        $traveldate = $returndate != null ? [$departdate, $returndate] : $departdate;

        if(is_array($traveldate)) {
            foreach($route_id as $key => $_route) {
                $amount = 0;
                $r = $this->getRoute($_route);
                $amount += $r->regular_price*$adult;
                $amount += $r->child_price*$child;
                $amount += $r->infant_price*$infant;
                
                array_push($route, [
                    'route_id' => $_route,
                    'traveldate' => $traveldate[$key],
                    'amount' => $amount,
                    'type' => NULL
                ]);
            }
        }
        else {
            $amount = 0;
            $r = $this->getRoute($route_id[0]);
            $amount += $r->regular_price*$adult;
            $amount += $r->child_price*$child;
            $amount += $r->infant_price*$infant;

            array_push($route, [
                'route_id' => $route_id[0],
                'traveldate' => $traveldate,
                'amount' => $amount,
                'type' => NULL
            ]);
        }

        return $route;
    }

    private function getRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::find($booking_id);
        return isset($booking) ?: false;
    }

    private function routeAmount($route, $adult, $child, $infant) {
        $amount = 0;
        foreach($route as $_route) {
            $_r = $this->getRoute($_route);
            $amount += $_r->regular_price*$adult;
            $amount += $_r->child_price*$child;
            $amount += $_r->infant_price*$infant;
        }
        
        return $amount;
    }

    private function extraMeal($meal_id, $meal_qty) {
        $meal_amount = 0;
        foreach($meal_qty as $key => $meal) {
            foreach($meal as $key2 => $qty) {
                if($qty != 0) {
                    $_meal = Addon::find($meal_id[$key][$key2]);
                    $meal_amount += $_meal->amount*$qty;
                }
            }
        }

        return $meal_amount;
    }

    private function extraActivity($activity_id, $activity_qty) {
        $acctivity_amount = 0;
        foreach($activity_qty as $key => $activity) {
            foreach($activity as $key2 => $qty) {
                if($qty != 0) {
                    $_activity = Activity::find($activity_id[$key][$key2]);
                    $acctivity_amount += $_activity->price*$qty;
                }
            }
        }

        return $acctivity_amount;
    }


    // 7 Booking controller

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
