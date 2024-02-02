<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Section;
use App\Models\Station;
use App\Models\BookingRoutes;
use App\Models\Route;

class ReportsController extends Controller
{
    protected $CustomerType = [
        'ADULT' => '[A]',
        'CHILD' => '[C]',
        'INFANT' => '[I]'
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $sections = $this->getSection();

        return view('pages.reports.index', ['sections' => $sections, 'reports' => []]);
    }

    public function getRoute(Request $request) {
        $sections = $this->getSection();
        $depart_date = $this->setDepartDate($request->daterange);
        $start_date = Carbon::createFromFormat('Y-m-d', $depart_date[0])->startOfDay();
        $end_date = Carbon::createFromFormat('Y-m-d', $depart_date[1])->startOfDay();
        $station_from = 'ALL';
        $station_to = 'ALL';


        $from = $request->station_from != 'all' ? $request->station_from : '';
        $to = $request->station_to != 'all' ? $request->station_to : '';

        $routes = $this->routeGetReport($from, $to, $start_date, $end_date);

        $booking_route = $this->getOnlyBookingRoutes($routes);
        if($from != '') $station_from = $this->getStationById($request->station_from);
        if($to != '') $station_to = $this->getStationById($request->station_to);
        // Log::debug($routes->toArray());

        return view('pages.reports.index', ['sections' => $sections, 'reports' => $booking_route,
                'depart_date' => $request->daterange, 'from' => $station_from, 'to' => $station_to,
                'cus_type' => $this->CustomerType]);
    }

    public function reportPdfGenerate(Request $request) {
        $depart_date = $this->setDepartDate($request->daterange);
        $start_date = Carbon::createFromFormat('Y-m-d', $depart_date[0])->startOfDay();
        $end_date = Carbon::createFromFormat('Y-m-d', $depart_date[1])->startOfDay();

        $routes = $this->routeGetReport($request->station_from, $request->station_to, $start_date, $end_date);

        $booking_route = $this->getOnlyBookingRoutes($routes);
        $station_from = $this->getStationById($request->station_from);
        $station_to = $this->getStationById($request->station_to);

        return view('pages.reports.pdf', ['reports' => $booking_route, 'depart_date' => $request->daterange,
                    'from' => $station_from, 'to' => $station_to]);
    }

    private function routeGetReport($station_from, $station_to, $start_date, $end_date) {
        $_from = $station_from != '' ? $station_from : '';
        $_to = $station_to != '' ? $station_to : '';

        $routes = Route::where(function($f) use ($_from) {
                            if($_from != '') return $f->where('station_from_id', $_from);
                            else return $f->where('station_from_id', '!=', NULL);
                        })
                        ->where(function($t) use ($_to) {
                            if($_to != '') return $t->where('station_to_id', $_to);
                            else return $t->where('station_to_id', '!=', NULL);
                        })
                        ->with(['bookings' => function($br) use ($start_date, $end_date) {
                            return $br->whereDate('traveldate', '>=', $start_date)->whereDate('traveldate', '<=', $end_date);
                        }, 'booking_extra'])
                        ->get();

        return $routes;
    }

    private function getStationById($id) {
        return Station::find($id);
    }

    private function getOnlyBookingRoutes($routes) {
        $booking_routes = [];

        foreach($routes as $index => $route) {
            if(sizeof($route['bookings']) > 0) {
                foreach($route['bookings'] as $br) {
                    $br->traveldate = $br->pivot->traveldate;
                    $br->travel_date = date('d/m/Y', strtotime($br->pivot->traveldate));
                    $br->station_from = $this->setStationToBookingRoute($routes[$index]->station_from);
                    $br->station_to = $this->setStationToBookingRoute($routes[$index]->station_to);
                    array_push($booking_routes, $br->toArray());
                }
            }
        }

        usort($booking_routes, function ($a, $b) {
            return strtotime($a['traveldate']) - strtotime($b['traveldate']);
        });

        return $booking_routes;
    }

    private function setStationToBookingRoute($station) {
        return [
            'name' => $station->name,
            'nickname' => $station->nickname,
            'piername' => $station->piername
        ];
    }

    private function getSection() {
        return Section::with('stations')->orderBy('sort', 'ASC')->get();
    }

    private function setDepartDate($daterange) {
        $ex = explode(' - ', $daterange);
        $ex_start = explode('/', $ex[0]);
        $ex_end = explode('/', $ex[1]);

        $depart_start = $ex_start[2].'-'.$ex_start[1].'-'.$ex_start[0];
        $depart_end = $ex_end[2].'-'.$ex_end[1].'-'.$ex_end[0];

        return array($depart_start, $depart_end);
    }
}
