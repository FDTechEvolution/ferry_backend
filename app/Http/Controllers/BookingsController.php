<?php

namespace App\Http\Controllers;

use App\Models\BookingCustomers;
use App\Models\Bookings;
use App\Models\Customers;
use App\Models\Station;
use App\Models\Route;
use Ramsey\Uuid\Uuid;


use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $bookings = Bookings::with('route.station_from','route.station_to','user')->get();

        
        
        //dd($bookings);
        return view('pages.bookings.index', ['bookings' => $bookings]);
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

        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        return view('pages.bookings.route', ['routes' => $routes, 'stations' => $stations, 'station_from' => $station_from, 'station_to' => $station_to, 'departdate' => $departdate]);
    }

    public function create()
    {
        $departdate = request()->departdate;
        $route_id = request()->route_id;

        $route = Route::where('id', $route_id)->with('station_from', 'station_to', 'icons')->first();
        $meals = (new MealsController)->getMeals();

        return view('pages.bookings.create', ['route' => $route, 'departdate' => $departdate,'meals'=>$meals]);
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

        $date = strtotime($request->departdate);
        $departdate = date('Y-m-d', $date); 
        
        //dd($departdate);
        //save booking
        $booking = Bookings::create([
            'route_id'=> $request->route_id,
            'departdate'=> $departdate,
            'adult_passenger'=> $request->adult_passenger,
            'child_passenger'=> $request->child_passenger,
            'infant_passenger'=> $request->infant_passenger,
            'totalamt'=> $request->total_price,
            'extraamt'=> $request->extra_price,
            'amount'=> $request->price,
            'ispayment'=>$request->ispayment,
            'user_id'=>$request->user_id
        ]);

        if($booking) {

            //save customer
            $customer = Customers::create([
                'fullname'=>$request->fullname,
                'type'=>'ADULT'
            ]);

            $booking->bookingCustomers()->attach($customer,["id" => (string) Uuid::uuid4()]);


            return redirect()->route('booking-index')->withSuccess('Save New Booking');
        }

        //return redirect()->route('booking-index')->withSuccess('Save New Booking');
    }
}
