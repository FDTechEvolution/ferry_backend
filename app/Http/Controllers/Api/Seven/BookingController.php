<?php

namespace App\Http\Controllers\Api\Seven;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Addon;
use App\Models\Activity;
use App\Models\Bookings;
use App\Models\Customers;
use App\Helpers\BookingHelper;

class BookingController extends Controller
{
    public function store(Request $request) {
        $route = $this->getRoute($request->route_id);
        if($route) {
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
                    'trip_type' => 'one-way',
                    'status' => 'DR',
                    'book_channel' => 'SEVEN'
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

    public function checkBookingStatus(Request $request) {
        $booking = Bookings::find($request->id);
        $payload = ['id' => $request->id, 'expired_at' => NULL, 'amount' => NULL];
        if(isset($booking)) {
            $expired = $booking->created_at->addHours(1)->toDateTimeString();
            $_exprired = date('Y-m-d\TH:i:s.u\Z', strtotime($expired));
            $now = date('Y-m-d H:i:s');
            $payload = [
                'id' => $booking->id,
                'expired_at' => $_exprired,
                'amount' => $booking->totalamt,
                'booking_pdf' => '//'.$_SERVER['SERVER_NAME'].'/print/ticket/'.$booking->bookingno
            ];

            if($booking->status == 'DR') {
                if(strtotime($now) > strtotime($expired)) {
                    $payload['code'] = 'E003';
                    $payload['desc'] = 'Expired';
                }
                else {
                    $payload['code'] = '100';
                    $payload['desc'] = 'Success';
                }
            }
            if($booking->status == 'CO') {
                $payload['code'] = 'E002';
                $payload['desc'] = 'Duplicate';
            }
            return response()->json($payload, 200);
        }

        $payload['code'] = 'E001';
        $payload['desc'] = 'Not Found';
        return response()->json($payload, 200);

        // Error code
        // "code": "100", "desc": "Success"
        // "code": "E001", "desc": "Not Found"
        // "code": "E002", "desc": "Duplicate"
        // "code": "E003", "desc": "Expired"
    }

    private function getRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::where('id', $booking_id)->where('status', 'DR')->first();
        return isset($booking) ?: false;
    }

    public function complete(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $c = new BookingHelper;
            $complete = $c->completeBooking($request->booking_id);
            $complete['booking_pdf'] = '//'.$_SERVER['SERVER_NAME'].'/print/ticket/'.$complete['bookingno'];
            return response()->json(['result' => true, 'data' => $complete, 'code' => '100']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.', 'code' => 'E001']);
    }

    public function destroy(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            if($booking->status != 'CO') {
                $booking->status = 'VO';
                if($booking->save())
                    return response()->json(['result' => true, 'data' => 'Booking canceled.']);
                else
                    return response()->json(['result' => false, 'data' => 'error.']);
            }
            else return response()->json(['result' => false, 'data' => 'Booking is complete. Can not cancle.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function update(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            if(isset($request->departdate)) $booking->departdate = $request->departdate;
            if(isset($request->fullname)) $booking->bookingCustomers[0]->fullname = $request->fullname;
            if(isset($request->mobile)) $booking->bookingCustomers[0]->mobile = $request->mobile;
            if(isset($request->totalamount)) $booking->totalamt = $request->totalamount;

            if($booking->push())
                return response()->json(['result' => true, 'data' => 'Booking updated.']);
            else
                return response()->json(['result' => false, 'data' => 'error.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function getBookingById(string $id = null) {
        $booking = Bookings::with('bookingCustomers', 'bookingRoutes')->find($id);
        if(isset($booking)) return response()->json(['result' => true, 'data' => $booking]);
        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }
}
