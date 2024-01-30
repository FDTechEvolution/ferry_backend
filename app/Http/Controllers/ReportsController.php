<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        // Log::debug($depart_date);

        $routes = Route::where('station_from_id', $request->station_from)
                        ->where('station_to_id', $request->station_to)
                        ->with(['booking_route'])
                        ->whereHas('booking_route', function($br) use ($depart_date) {
                            $br->where('traveldate', '>=', '2024-01-20')->where('traveldate', '<=', '2024-01-25');
                        })
                        ->get();

        Log::debug($routes->toArray());

        return view('pages.reports.index', ['sections' => $sections, 'reports' => $routes]);
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
