<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Station;
use App\Models\Route;

use Illuminate\Http\Request;

class BookingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $routes = [];
        return view('pages.bookings.index', ['routes' => $routes]);
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

        return view('pages.bookings.create', ['route' => $route, 'departdate' => $departdate]);
    }

    public function store(Request $request)
    {

    }
}
