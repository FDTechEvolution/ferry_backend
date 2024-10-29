<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Bookings;
use App\Helpers\BookingHelper;
use App\Models\ApiMerchants;

class BookingController extends Controller
{
    public function store(Request $request) {
        $merchant = $request->attributes->get('merchant');
        $_merchant = ApiMerchants::find($merchant);

        if(isset($_merchant)) {
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
                        'amount' => ($request->totalamount*$request->passenger),
                        'ispayment' => 'N',
                        'user_id' => NULL,
                        'trip_type' => 'one-way',
                        'status' => 'DR',
                        'book_channel' => $_merchant->name,
                        'api_merchant_id'=>$_merchant->id,
                    ],
                    'customers' => [
                        [
                            'fullname' => $request->fullname,
                            'type' => 'ADULT',
                            'passportno' => isset($request->passportno)?$request->passportno:NULL,,
                            'email' => isset($request->email)?$request->email:NULL,
                            'mobile' => $request->mobile,
                            'fulladdress' => isset($request->fulladdress)?$request->fulladdress:NULL,
                        ]
                    ],
                    'routes' => [
                        [
                            'route_id' => $request->route_id,
                            'traveldate' => $request->departdate,
                            'amount' => $request->totalamount,
                            'type' => 'O'
                        ]
                    ]
                ];

                $booking = BookingHelper::createBooking($data);

                return response()->json(['result' => true, 'data' => $booking], 200);
            }

            return response()->json(['result' => false, 'data' => 'No Route.'], 200);
        }
    }

    private function getRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::where('id', $booking_id)->first();
        return isset($booking) ?: false;
    }

    public function complete(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            if($booking->status == 'DR') {
                $c = new BookingHelper;
                $booking = $c->completeBooking($request->booking_id);
            }

            return response()->json(['result' => true, 'data' => $booking]);

        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function destroy(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $booking = Bookings::find($request->booking_id);
            $booking->status = 'VO';
            if($booking->save())
                return response()->json(['result' => true, 'data' => 'Booking canceled.']);
            else
                return response()->json(['result' => false, 'data' => 'error.']);
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
        $booking = Bookings::find($id);
        if(isset($booking)) return response()->json(['result' => true, 'data' => $booking]);
        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }
}
