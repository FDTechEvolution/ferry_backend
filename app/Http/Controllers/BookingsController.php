<?php

namespace App\Http\Controllers;

use App\Helpers\PaymentHelper;
use App\Models\Addon;
use App\Models\BookingCustomers;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Station;
use App\Models\Route;
use Ramsey\Uuid\Uuid;
use App\Helpers\BookingHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\ImageHelper;
use Illuminate\Support\Carbon;


use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $this->clearUnpayBooking();

        $station_from = request()->station_from;
        $station_to = request()->station_to;
        $departdate = request()->departdate;
        $ticketno = request()->ticketno;
        $bookingno = request()->bookingno;
        $daterange = request()->daterange;

        $sql = 'select b.id,b.created_at,b.bookingno,b.adult_passenger,b.child_passenger,b.infant_passenger,t.ticketno,b.trip_type,concat(sf.nickname,"-",st.nickname) as route,br.traveldate,b.ispayment,b.book_channel,u.firstname,r.depart_time,r.arrive_time,b.totalamt from bookings b join booking_routes br on b.id = br.booking_id join routes r on br.route_id = r.id join stations sf on r.station_from_id = sf.id join stations st on r.station_to_id = st.id left join users u on b.user_id = u.id left join tickets t on b.id= t.booking_id where :conditions order by br.traveldate ASC,b.created_at ASC  ';

        $startDate = date('d/m/Y');
        $endDate = date('d/m/Y', strtotime('+30 day', time()));

        $conditionStr = '1=1';

        if (!is_null($daterange) && $daterange != '') {
            $dates = explode('-', $daterange);
            $startDate = trim($dates[0]);
            $endDate = trim($dates[1]);

        }

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $conditionStr .= ' and (b.departdate >="' . $startDateSql . '" and b.departdate <="' . $endDateSql . '") ';

        if (!is_null($station_from) && $station_from != '') {
            $conditionStr .= ' and sf.id = "' . $station_from . '"';
        }
        if (!is_null($station_to) && $station_to != '') {
            $conditionStr .= ' and st.id = "' . $station_to . '"';
        }
        if (!is_null($departdate) && $departdate != '') {
            $conditionStr .= ' and br.traveldate = "' . $departdate . '"';
        }
        if (!is_null($ticketno) && $ticketno != '') {
            $conditionStr .= ' and t.ticketno = "' . $ticketno . '"';
        }
        if (!is_null($bookingno) && $bookingno != '') {
            $conditionStr .= ' and b.bookingno = "' . $bookingno . '"';
        }

        $sql = str_replace(':conditions', $conditionStr, $sql);

        $bookings = DB::select($sql);
        $bookings = json_decode(json_encode($bookings), true);

        /*
        $bookings = Bookings::with('bookingRoutes.station_from', 'bookingRoutes.station_to', 'bookingCustomers', 'user', 'tickets')
            ->orderBy('departdate', 'ASC')
            ->get();
        */

        $station = StationsController::avaliableStation();

        //dd($bookings);
        return view('pages.bookings.index', [
            'bookings' => $bookings,
            'station' => $station,
            'station_from' => $station_from,
            'station_to' => $station_to,
            'bookingno' => $bookingno,
            'ticketno' => $ticketno,
            'startDate' => $startDate,'endDate' => $endDate,
        ]);
    }

    public function route()
    {
        $station_from = request()->station_from;
        $station_to = request()->station_to;
        $departdate = request()->departdate;

        $routes = [];

        if (!is_null($station_from) && !is_null($station_to)) {
            $routes = Route::where('station_from_id', $station_from)
                ->where('station_to_id', $station_to)
                ->where('isactive', 'Y')
                ->with('station_from', 'station_to', 'icons')
                ->orderBy('depart_time', 'ASC')
                ->get();
        }

        //dd($routes);

        $station = StationsController::avaliableStation();
        return view('pages.bookings.route', ['routes' => $routes, 'stations' => $station, 'station_from' => $station_from, 'station_to' => $station_to, 'departdate' => $departdate]);
    }

    public function create()
    {
        $departdate = request()->departdate;
        $route_id = request()->route_id;

        $route = Route::where('id', $route_id)->with('station_from', 'station_to', 'icons')->first();
        $extras = Addon::where('isactive', 'Y')
            //->whereIn('type', ['ACTV','MEAL'])
            ->with('image')
            ->orderBy('type', 'ASC')
            ->get();




        return view('pages.bookings.create', ['route' => $route, 'departdate' => $departdate, 'extras' => $extras]);
    }

    public function view($booking_id)
    {
        $booking = BookingHelper::getBookingInfoByBookingId($booking_id);
        return view('pages.bookings.view', ['booking' => $booking]);
    }

    public function store(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'departdate' => 'required|string',
            'adult_passenger' => 'required|numeric',
            'child_passenger' => 'required|numeric',
            'infant_passenger' => 'required|numeric',
            'fullname' => 'required|string',
            'price' => 'required|numeric',
            'extra_price' => 'required|numeric',
            'total_price' => 'required|numeric',
            'ispayment' => 'required|string',
        ]);

        $extras = [];
        if (isset($request->addon_id)) {
            $extraPrices = $request->addon_price;

            foreach ($request->addon_id as $index => $addon_id) {
                array_push($extras, [
                    'addon_id' => $addon_id,
                    'amount' => $extraPrices[$index],
                ]);
            }
        }

        //$date = strtotime($request->departdate);
        //$departdate = date('Y-m-d', $this->convertDate($request->departdate));
        $departdate = $this->convertDate($request->departdate);
        $totalPassenger = ($request->adult_passenger + $request->child_passenger + $request->infant_passenger);

        $_customers = [];
        for ($i = 0; $i < 1; $i++) {
            $fullname = $request->fullname;
            if ($i != 0) {
                $fullname = sprintf('%s [%d]', $fullname, ($i));
            }
            $_c = [
                'fullname' => $fullname,
                'type' => 'ADULT',
                'passportno' => null,
                'email' => null,
                'mobile' => null,
                'fulladdress' => null,
            ];
            array_push($_customers, $_c);
        }

        $data = [
            'booking' => [
                'route_id' => $request->route_id,
                'departdate' => $departdate,
                'adult_passenger' => $request->adult_passenger,
                'child_passenger' => $request->child_passenger,
                'infant_passenger' => $request->infant_passenger,
                'totalamt' => $request->total_price,
                'extraamt' => $request->extra_price,
                'amount' => $request->price,
                'ispayment' => $request->ispayment,
                'user_id' => $request->user_id,
                'trip_type' => 'one-way',
                'book_channel' => 'ADMIN',
            ],
            'customers' => $_customers,
            'routes' => [
                [
                    'route_id' => $request->route_id,
                    'traveldate' => $departdate,
                    'amount' => $request->price,
                    'type' => 'departure',
                    'extras' => $extras,
                ],
            ],


        ];

        $booking = BookingHelper::createBooking($data);
        $payment = PaymentHelper::createPaymentFromBooking($booking->id);

        //Check has Payment
        if ($request->ispayment == 'Y') {
            $paymentData = [
                'payment_method' => $request->payment_method,
                'user_id' => $request->user_id,
            ];

            if ($request->hasFile('image_file')) {
                $imageHelper = new ImageHelper();
                $image = $imageHelper->upload($request->image_file, 'payment_slip');
                $paymentData['image_id'] = $image->id;
            }

            $payment = PaymentHelper::completePayment($payment->id, $paymentData);
            $booking = BookingHelper::completeBooking($booking['id']);
        }


        return redirect()->route('booking-index')->withSuccess('Save New Booking');
    }


    public function convertDate($date = null)
    {
        if (is_null($date) || $date == '') {
            return null;
        }

        $ext = explode('/', $date);
        if (sizeof($ext) < 3) {
            return $date;
        }

        $converted = ($ext[2]) . '-' . $ext[1] . '-' . $ext[0];
        return $converted;
    }


    private function clearUnpayBooking()
    {
        $now = Carbon::now();
        $yesterday = $now->add(-1, 'day');

        $bookings = Bookings::where('ispayment', 'N')
            ->where('created_at', '<', $yesterday)
            ->where('book_channel', 'ONLINE')
            ->get();

        foreach ($bookings as $booking) {
            foreach ($booking->bookingCustomers as $item) {
                $item->delete();
            }

            foreach ($booking->bookingRoutes as $item) {
                $item->delete();
            }

            foreach ($booking->payments as $item) {
                $item->delete();
            }

            $booking->delete();
        }
    }
}
