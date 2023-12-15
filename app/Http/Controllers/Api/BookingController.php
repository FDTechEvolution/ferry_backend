<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Addon;
use App\Models\Bookings;
use App\Models\BookingRoutes;
use App\Helpers\BookingHelper;
use App\Helpers\PaymentHelper;
use App\Http\Resources\BookingResource;

class BookingController extends Controller
{
    public function store(Request $request) {
        $route = $this->getRoute($request->route_id[0]);
        if($route) {
            $_amount = $this->routeAmount($request->route_id, $request->passenger, $request->child_passenger, $request->infant_passenger);
            $_extra_meal = isset($request->meal_id) ? $this->extraAddon($request->meal_id, $request->meal_qty, $request->route_id) : 0;
            $_extra_activity = isset($request->activity_id) ? $this->extraAddon($request->activity_id, $request->activity_qty, $request->route_id) : 0;
            $_extra_shuttle_bus = isset($request->bus_id) ? $this->extraAddon($request->bus_id, $request->bus_qty, $request->route_id) : 0;
            $_extra_longtail_boat = isset($request->boat_id) ? $this->extraAddon($request->boat_id, $request->boat_qty, $request->route_id) : 0;

            $_booking = $this->setBooking($request->departdate, $request->passenger, $request->child_passenger, 
                                            $request->infant_passenger, $request->trip_type, $request->book_channel, 
                                            $_amount, $_extra_meal[0], $_extra_activity[0], $_extra_shuttle_bus[0], $_extra_longtail_boat[0]);
            $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type, 
                                                $request->passportno, $request->email, $request->address, $request->mobile_code, $request->th_mobile, $request->country, $request->titlename, $request->birth_day);
            $_route = $this->setRoutes($request->route_id, $request->departdate, $request->returndate, 
                                        $request->passenger, $request->child_passenger, $request->infant_passenger);

            $_extra = array_merge($_extra_meal[1], $_extra_activity[1], $_extra_shuttle_bus[1], $_extra_longtail_boat[1]);

            $data = [
                'booking' => $_booking,
                'customers' => $_customer,
                'extras' => $_extra,
                'routes' => $_route
            ];

            $booking = BookingHelper::createBooking($data);
            $payload = PaymentHelper::encodeRequest($booking);
            $response = PaymentHelper::postTo_2c2p($payload);
            $result = PaymentHelper::decodeResponse($response);
            // Log::debug($result);

            return response()->json(['result' => true, 'data' => $result, 'booking' => $booking->bookingno], 200);
        }
        // Log::debug($request);

        return response()->json(['result' => false, 'data' => 'No Route.'], 200);
    }

    public function storeMultiTrip(Request $request) {
        // Log::debug($request);
        if(isset($request->route_id)) {
            
            $route = $this->getRoute($request->route_id[0]);
            if($route) {
                $_amount = $this->routeAmount($request->route_id, $request->passenger, $request->child_passenger, $request->infant_passenger);
                $_extra_meal = isset($request->meal_id) ? $this->extraAddon($request->meal_id, $request->meal_qty, $request->route_id) : [0, []];
                $_extra_activity = isset($request->activity_id) ? $this->extraAddon($request->activity_id, $request->activity_qty, $request->route_id) : [0, []];
                $_extra_shuttle_bus = isset($request->bus_id) ? $this->extraAddon($request->bus_id, $request->bus_qty, $request->route_id) : [0, []];
                $_extra_longtail_boat = isset($request->boat_id) ? $this->extraAddon($request->boat_id, $request->boat_qty, $request->route_id) : [0, []];

                $_booking = $this->setBooking($request->departdate[0], $request->passenger, $request->child_passenger, 
                                                $request->infant_passenger, $request->trip_type, $request->book_channel, 
                                                $_amount, $_extra_meal[0], $_extra_activity[0], $_extra_shuttle_bus[0], $_extra_longtail_boat[0]);
                $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type, 
                                                    $request->passportno, $request->email, $request->address, $request->mobile_code, $request->th_mobile, $request->country, $request->titlename, $request->birth_day);
                $_route = $this->setRoutes($request->route_id, $request->departdate, $request->returndate, 
                                            $request->passenger, $request->child_passenger, $request->infant_passenger);

                $_extra = array_merge($_extra_meal[1], $_extra_activity[1], $_extra_shuttle_bus[1], $_extra_longtail_boat[1]);

                $data = [
                    'booking' => $_booking,
                    'customers' => $_customer,
                    'extras' => $_extra,
                    'routes' => $_route
                ];

                $booking = BookingHelper::createBooking($data);
                $payload = PaymentHelper::encodeRequest($booking);
                $response = PaymentHelper::postTo_2c2p($payload);
                $result = PaymentHelper::decodeResponse($response);

                return response()->json(['result' => true, 'data' => $result, 'booking' => $booking->bookingno], 200);
            }
            return response()->json(['result' => false, 'data' => 'No Route.'], 200);
        }
        return response()->json(['result' => false, 'data' => 'No Data.'], 200);
    }

    private function setBooking($departdate, $adult, $child, $infant, $trip_type, $book_channel, $amount, $meal, $activity, $bus, $boat) { 
        $extra_amount = ($meal + $activity + $bus + $boat);
        $booking = [
            'departdate' => $departdate,
            'adult_passenger' => $adult,
            'child_passenger' => $child,
            'infant_passenger' => $infant,
            'totalamt' => $amount + $extra_amount,
            'extraamt' => $extra_amount,
            'amount' => $amount,
            'ispayment' => 'N',
            'user_id' => NULL,
            'trip_type' => $trip_type,
            'status' => 'DR',
            'book_channel' => $book_channel
        ];

        return $booking;
    }

    private function setPassenger($fullname, $mobile, $type = NULL, $passport = NULL, $email = NULL, $address = NULL, $mobile_code = NULL, $th_mobile = NULL, $country = NULL, $titlename = NULL, $birth_day = NULL) {
        $customer = [];

        if(is_array($fullname)) {
            foreach($fullname as $key => $name) {
                if($key == 0) {
                    array_push($customer, [
                        'title' => strtoupper($titlename[$key]),
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => $passport,
                        'email' => $email,
                        'mobile_code' => $mobile_code,
                        'mobile' => $mobile,
                        'mobile_th' => $th_mobile,
                        'fulladdress' => $address,
                        'birthday' => $birth_day[$key],
                        'country' => $country
                    ]);
                }
                else {
                    array_push($customer, [
                        'title' => strtoupper($titlename[$key]),
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => NULL,
                        'email' => NULL,
                        'mobile_code' => NULL,
                        'mobile' => NULL,
                        'mobile_th' => NULL,
                        'fulladdress' => NULL,
                        'birthday' => $birth_day[$key],
                        'country' => NULL
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

    private function extraAddon($addon_id, $addon_qty, $route) {
        $addons = [];
        $addon_amount = 0;
        foreach($addon_qty as $key => $addon) {
            if($addon != NULL) {
                foreach($addon as $key2 => $qty) {
                    if($qty != 0) {
                        $_addon = Addon::find($addon_id[$key][$key2]);
                        $amount = $_addon->amount*$qty;
                        $addon_amount += $amount;
                        $route_id = $route[$key];
                        array_push($addons, ['addon_id' => $_addon->id, 'amount' => $amount, 'route_id' => $route_id]);
                    }
                }
            }
        }

        return array($addon_amount, $addons);
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

    private function getBookingByBookingNumber($bookingno) {
        return Bookings::where('bookingno', $bookingno)->with('bookingCustomers', 'bookingRoutes', 'bookingExtraAddons')->first();
    }

    public function bookingRecord(string $id = null) {
        $booking = $this->getBookingByBookingNumber($id);
        $addons = $this->getRouteAddon($booking);
        $booking_routes = $booking->bookingRoutes->toArray();
        $last_route = end($booking_routes);
        $m_route = $this->getRouteMultiple($last_route['station_to_id']);
        $m_from_route = $last_route['station_to'];
        if(isset($booking)) {
            return response()->json(['result' => true, 'data' => new BookingResource($booking), 'addon' => $addons, 'm_route' => $m_route, 'm_from_route' => $m_from_route], 200);
        }

        return response()->json(['result' => false, 'data' => 'No booking record.'], 200);
    }

    private function getRouteAddon($booking) {
        $_booking = json_decode($booking, true);
        $addons = [
            'meals' => [],
            'activities' => []
        ];
        foreach($_booking['booking_routes'] as $route) {
            $route = Route::find($route['id']);
            $addons['meals'] = $route->meal_lines;
            $addons['activities'] = $route->activity_lines;
        }

        return $addons;
    }

    private function getRouteMultiple($station_id) {
        $route = Route::where('station_from_id', $station_id)
                        ->where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->with('station_to')
                        ->get();

        return $route;
    }

    public function bookingCheckRoute(string $booking_current = null, string $booking_new = null) {
        if($booking_current != $booking_new) {
            $route_current = $this->getRouteByBookingNumber($booking_current);
            $route_new = $this->getRouteByBookingNumber($booking_new);

            if($route_current[0] == $route_new[0]) {
                $booking = $this->getBookingByBookingNumber($booking_new);
                if($route_current[1] == $route_new[1]) {
                    if($route_current[3] == $route_new[3]) {
                        return response()->json(['result' => true, 'status' => '', 'data' => $booking], 200);
                    }
                    else {
                        return response()->json(['result' => true, 'status' => 'not match', 'data' => $booking], 200);
                    }
                }
                else {
                    return response()->json(['result' => true, 'status' => 'unpay', 'data' => $booking], 200);
                }
            }
            else return response()->json(['result' => false, 'status' => 'uncurrect', 'data' => ''], 200);
        }

        return response()->json(['result' => false, 'status' => 'duplicate', 'data' => ''], 200);
    }

    private function getRouteByBookingNumber($bookingno) {
        $booking = Bookings::where('bookingno', $bookingno)->with('bookingRoutes')->first();
        return array($booking->bookingRoutes[0]['route_id'], $booking->ispayment, $booking->status, $booking->departdate);
    }

    public function bookingMerge(Request $request) {
        // $booking_current = $this->getBookingByBookingNumber($request->booking_number);
        // $booking_new = $this->getBookingByBookingNumber($request->booking_number_new);

        $booking = BookingHelper::moveBooking($request->booking_number, $request->booking_number_new);
        return response()->json(['result' => true, 'data' => $booking], 200);
    }

    public function addNewRoute(Request $request) {
        $booking = Bookings::find($request->booking_id);
        $route = Route::find($request->route_id);
        $amount = $booking->amount;
        $new_amount = $this->passengerAmount($booking, $route);
        if($booking->ispayment == 'N') {
            BookingRoutes::create([
                'route_id' => $route->id,
                'traveldate' => $this->dateFormat($request->depart),
                'booking_id' => $booking->id,
                'amount' => $amount
            ]);

            $booking->amount = $amount + $new_amount;
            $booking->totalamt = $booking->extraamt + $amount + $new_amount;
            $booking->save();
        }
    }

    private function dateFormat($date) {
        $ex = explode('/', $date);
        return $ex[2].'-'.$ex[1].'-'.$ex[0];
    }

    private function passengerAmount($booking, $route) {
        $adult = $booking->adult_passenger*$route->regular_price;
        $child = $booking->child_passenger*$route->child_price;
        $infant = $booking->infant_passenger*$route->infant_price;

        return $adult + $child + $infant;
    }
}
