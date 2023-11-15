<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Bookings;
use App\Helpers\BookingHelper;

class BookingController extends Controller
{
    public function store(Request $request) {
        if($this->checkRoute($request->route_id)) {
            $data = [
                'booking' => [
                    'departdate' => $request->departdate,
                    'adult_passenger' => $request->passenger,
                    'child_passenger' => 0,
                    'infant_passenger' => 0,
                    'totalamt' => ($request->totalamount*$request->passenger),
                    'extraamt' => 0,
                    'amount' => $request->totalamount,
                    'ispayment' => 'N',
                    'user_id' => NULL,
                    'trip_type' => NULL,
                    'status' => 'DR'
                ],
                'customers' => [
                    [
                        'fullname' => $request->fullname,
                        'type' => 'ADULT',
                        'passportno' => NULL,
                        'email' => NULL,
                        'mobile' => $request->mobile,
                        'fulladdress' => NULL
                    ]
                ],
                'routes' => [
                    [
                        'route_id' => $request->route_id,
                        'traveldate' => $request->departdate,
                        'amount' => $request->totalamount,
                        'type' => NULL
                    ]
                ]
            ];

            $booking = BookingHelper::createBooking($data);

            return response()->json(['result' => true, 'data' => $booking], 200);
        }

        return response()->json(['result' => false, 'data' => 'No Route.'], 200);
    }

    private function checkRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? true : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::find($booking_id);
        return isset($booking) ? true : false;
    }

    public function complete(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            return response()->json(['result' => true, 'data' => 'completed.']);
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
