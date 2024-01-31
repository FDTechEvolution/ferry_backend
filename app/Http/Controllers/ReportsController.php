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

        $routes = Route::where('station_from_id', $request->station_from)
                        ->where('station_to_id', $request->station_to)
                        ->with(['booking_route' => function($br) use ($start_date, $end_date) {
                            return $br->whereDate('traveldate', '>=', $start_date)->whereDate('traveldate', '<=', $end_date);
                        }])
                        ->get();

        $booking_route = $this->getOnlyBookingRoutes($routes);
        // Log::debug($booking_route);

        return view('pages.reports.index', ['sections' => $sections, 'reports' => $booking_route]);
    }

    private function getOnlyBookingRoutes($routes) {
        $booking_routes = [];

        foreach($routes as $route) {
            if(sizeof($route['booking_route']) > 0) {
                foreach($route['booking_route'] as $br) {
                    $br->traveldate = $br->pivot->traveldate;
                    $br->travel_date = date('d/m/Y', strtotime($br->pivot->traveldate));
                    array_push($booking_routes, $br->toArray());
                }
            }
        }

        usort($booking_routes, function ($a, $b) {
            return strtotime($a['traveldate']) - strtotime($b['traveldate']);
        });

        return $booking_routes;
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
