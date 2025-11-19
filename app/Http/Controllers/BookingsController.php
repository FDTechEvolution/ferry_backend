<?php

namespace App\Http\Controllers;

use App\Helpers\LineNotifyHelper;
use App\Helpers\PaymentHelper;
use App\Models\Addon;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Payments;
use App\Models\Route;
use App\Helpers\BookingHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\ImageHelper;
use Illuminate\Support\Carbon;
use App\Helpers\RouteHelper;
use App\Helpers\EmailHelper;
use App\Helpers\TransactionLogHelper;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class BookingsController extends Controller
{
    protected $CodeCountry;
    protected $CountryList;

    public function __construct()
    {
        $this->middleware('auth');
        $this->CodeCountry = config('services.code_country');
        $this->CountryList = config('services.country_list');
    }

    public function index()
    {

        //$this->clearUnpayBooking();

        $station_from = request()->station_from;
        $station_to = request()->station_to;
        $departdate = request()->departdate;
        $ticketno = request()->ticketno;
        $bookingno = request()->bookingno;
        $daterange = request()->daterange;
        $date_type = request()->date_type;
        $status = request()->status;

        $paymentno = request()->paymentno;
        $customername = request()->customername;
        $email = request()->email;
        $bookChannel = request()->book_channel;
        $tripType = request()->trip_type;


        $sql = 'select
        b.id,b.created_at,b.bookingno,t.ticketno,b.adult_passenger,b.child_passenger,b.infant_passenger,
        (b.adult_passenger+b.child_passenger+b.infant_passenger) as total_passenger,
        b.trip_type,br.type,b.amend,concat(sf.nickname,"-",st.nickname) as route,br.traveldate,b.ispayment,
        b.book_channel,c.fullname as customer_name,c.email,r.depart_time,r.arrive_time,b.totalamt,p.totalamt as payment_totalamt,
        b.status,b.ispremiumflex,p.c_tranref,p.paymentno,p.discount,b.isemailsent,b.referenceno
    from
        bookings b
        join booking_routes br on b.id = br.booking_id
        join routes r on br.route_id = r.id
        left join tickets t on br.id = t.booking_route_id
        join stations sf on r.station_from_id = sf.id
        join stations st on r.station_to_id = st.id
        join booking_customers bc on (b.id = bc.booking_id and bc.isdefault = "Y")
        join customers c on bc.customer_id = c.id
        left join payments p on b.id = p.booking_id
    where :conditions order by b.created_at DESC';

        //$startDate = date_format(date_create('2024-01-01'), 'd/m/Y');
        //$startDate = Carbon::today()->subDays(7)->format('d/m/Y');
        $startDate = date('d/m/Y');
        $endDate = date('d/m/Y');
        $startTravelDate = Carbon::today()->subDays(7)->format('Y-m-d');

        $conditionStr = '1=1';
        $dateFillter = true;

        if (!is_null($daterange) && $daterange != '') {
            $dates = explode('-', $daterange);
            $startDate = trim($dates[0]);
            $endDate = trim($dates[1]);
        }

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d 00:00:00');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d 23:59:59');

        // $conditionStr .= ' and (b.departdate >="' . $startDateSql . '" and b.departdate <="' . $endDateSql . '") ';




        if (!is_null($station_from) && $station_from != '') {
            $dateFillter = false;
            $conditionStr .= ' and sf.id = "' . $station_from . '"';
        }
        if (!is_null($station_to) && $station_to != '') {
            $dateFillter = false;
            $conditionStr .= ' and st.id = "' . $station_to . '"';
        }
        if (!is_null($departdate) && $departdate != '') {
            $dateFillter = false;
            $conditionStr .= ' and br.traveldate = "' . $departdate . '"';
        }
        if (!is_null($ticketno) && $ticketno != '') {
            $dateFillter = false;
            $conditionStr .= ' and t.ticketno = "' . $ticketno . '"';
        }
        if (!is_null($bookingno) && $bookingno != '') {
            $dateFillter = false;
            $conditionStr .= ' and b.bookingno = "' . $bookingno . '"';
        }

        if (!empty($paymentno)) {
            $dateFillter = false;
            $conditionStr .= ' and p.paymentno = "' . $paymentno . '"';
        }
        if (!empty($customername)) {
            $dateFillter = false;
            $conditionStr .= ' and c.fullname like "' . $customername . '%"';
        }
        if (!empty($email)) {
            $dateFillter = false;
            $conditionStr .= ' and c.email = "' . $email . '"';
        }
        if (!empty($bookChannel)) {
            $conditionStr .= ' and b.book_channel = "' . $bookChannel . '"';
        }
        if (!empty($tripType)) {
            $dateFillter = false;
            $conditionStr .= ' and b.trip_type = "' . $tripType . '"';
        }

        if (!is_null($status) && $status != '') {
            $dateFillter = false;
            $conditionStr .= ' and b.status = "' . $status . '"';
        } else {
            if ($dateFillter) {
                $conditionStr .= ' and b.status not in ("delete","void")';
            }
        }

        if ($dateFillter) {
            if ($date_type == 'booking_date' || empty($date_type)) {
                $conditionStr .= ' and (b.created_at >="' . $startDateSql . '" and b.created_at <="' . $endDateSql . '") ';
            } else {
                $conditionStr .= ' and (br.traveldate >="' . $startDateSql . '" and br.traveldate <="' . $endDateSql . '") ';
            }
        }



        $sql = str_replace(':conditions', $conditionStr, $sql);

        $bookings = DB::select($sql);
        $bookings = json_decode(json_encode($bookings), true);


        $sections = RouteHelper::getSectionStationFrom(true);
        $bookingStatus = BookingHelper::status();
        $tripTypes = BookingHelper::tripType();
        $bookChannels = BookingHelper::bookChannels();

        //dd($bookings);
        return view('pages.bookings.index', [
            'bookings' => $bookings,
            'sections' => $sections,
            'station_from' => $station_from,
            'station_to' => $station_to,
            'bookingno' => $bookingno,
            'ticketno' => $ticketno,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'bookingStatus' => $bookingStatus,
            'tripTypes' => $tripTypes,
            'bookChannels' => $bookChannels,
            'customername' => $customername,
            'paymentno' => $paymentno,
            'email' => $email,
            'bookChannel' => $bookChannel,
            'tripType' => $tripType,
            'date_type' => $date_type
        ]);
    }

    public function route()
    {

        $departdate = request()->departdate;
        $routes = [];
        $stationFromId = request()->station_from_id;
        $stationToId = request()->station_to_id;

        if (is_null($departdate)) {
            $departdate = date('d/m/Y');
        }
        $stationFroms = RouteHelper::getSectionStationFrom(true);
        if (is_null($stationFromId) && sizeof($stationFroms) > 0) {
            foreach ($stationFroms as $seaction) {
                if (sizeof($seaction->stations) != 0) {
                    $stationFromId = $seaction->stations[0]->id;
                    break;
                }
            }
        }
        $stationTos = RouteHelper::getSectionStationTo(true, $stationFromId);
        if (is_null($stationToId) && sizeof($stationTos) > 0) {
            foreach ($stationTos as $seaction) {
                if (sizeof($seaction->stations) != 0) {
                    $stationToId = $seaction->stations[0]->id;
                    break;
                }
            }
        }

        if (!is_null($stationFromId) && !is_null($stationToId)) {
            $departdateSql = Carbon::createFromFormat('d/m/Y', $departdate)->format('Y-m-d');
            $routes = RouteHelper::getAvaliableRoutes($stationFromId, $stationToId, $departdateSql);
        }
        //dd($stationFroms);

        return view('pages.bookings.route', [
            'stationFroms' => $stationFroms,
            'stationTos' => $stationTos,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'routes' => $routes,
            'departdate' => $departdate,
        ]);
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
        $booking = Bookings::where(['id' => $booking_id])
            ->with(
                'bookingCustomers',
                'user',
                'bookingRoutes',
                'bookingRoutesX.bookingExtraAddons',
                'bookingRoutesX.bookingRouteAddons',
                'bookingRoutes.station_from',
                'bookingRoutes.station_to',
                'bookingRoutes.station_lines',
                'payments',
                'payments.paymentLines',
                'transactionLogs',
            )
            ->first();

        $bookingStatus = BookingHelper::status();

        return view('pages.bookings.view', [
            'booking' => $booking,
            'status' => BookingHelper::status(),
            'tripType' => BookingHelper::tripType(),
            'bookingStatus' => $bookingStatus,
        ]);
    }

    public function modalView($booking_id)
    {
        $booking = Bookings::where(['id' => $booking_id])
            ->with(
                'bookingCustomers',
                'user',
                'bookingRoutes',
                'bookingRoutesX.bookingExtraAddons',
                'bookingRoutesX.bookingRouteAddons',
                'bookingRoutes.station_from',
                'bookingRoutes.station_to',
                'bookingRoutes.station_lines',
                'payments',
                'payments.paymentLines',
                'transactionLogs',
            )
            ->first();
        return view('pages.bookings.mview', [
            'booking' => $booking,
            'status' => BookingHelper::status(),
            'tripType' => BookingHelper::tripType(),

        ]);
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

    public function updateCustomer(Request $request)
    {
        $b_day = explode('/', $request->birth_day);
        $customer = Customers::find($request->customer_id);
        $customer->title = strtoupper($request->title);
        $customer->fullname = $request->full_name;
        $customer->birth_day = $b_day[2] . '-' . $b_day[1] . '-' . $b_day[0];

        if ($customer->email != NULL) {
            $customer->email = $request->email;
            $customer->mobile_code = $request->mobile_code;
            $customer->mobile = $request->mobile;
            $customer->mobile_th = $request->th_mobile;
            $customer->country = $request->country;
            $customer->passportno = $request->passport_number;
            $customer->fulladdress = $request->address;
        }

        if ($customer->save()) {
            return redirect()->back()->withSuccess('Customer updated.');
        }
        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    public function sendConfirmEmail(Request $request)
    {
        $bookingNos = $request->booking_nos;

        foreach ($bookingNos as $bookingno) {

            $booking = Bookings::where('bookingno', $bookingno)->first();

            EmailHelper::ticket($booking->id);
        }
        return redirect()->back()->withSuccess('sent email.');
        //return redirect()->route('booking-index')->withSuccess('sent email.');
    }

    public function changeStatus($id)
    {
        $booking = Bookings::find($id);
        $status = request()->status;
        $booking->ispayment = $status == 'CO' ? 'Y' : 'N';
        $booking->save();
        $statusLabel = BookingHelper::status();
        return view('pages.bookings.modal.change_status', ['booking_id' => $id, 'status' => $status, 'statusLabel' => $statusLabel]);
    }

    public function updateStatus(Request $request)
    {
        $booking_id = $request->booking_id;
        $booking = Bookings::where('id', $booking_id)->first();
        $status = $request->status;
        $description = $request->description;
        $statusLabel = BookingHelper::status();


        if (isset($statusLabel[$status])) {


            if ($status == 'CO') {
                BookingHelper::completeBooking($booking_id, []);

                $payments = Payments::where('booking_id', $booking_id)->get();
                if (sizeof($payments) == 0) {
                    $payment = PaymentHelper::createPaymentFromBooking($booking_id);
                    PaymentHelper::completePayment($payment->id);
                }

                $booking->ispayment = 'Y';
            }

            $booking->status = $status;
            $booking->amend = $booking->amend + 1;
            $booking->save();

            //Log
            TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Change booking status to ' . $statusLabel[$status]['title'], 'description' => $description, 'booking_id' => $booking_id]);

            return redirect()->route('booking-view', ['id' => $booking_id])->withSuccess('Saved.');
        }

        return redirect()->route('booking-view', ['id' => $booking_id])->withFail('Something is wrong. Please try again.');
    }
}
