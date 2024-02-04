<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Section;
use App\Models\Station;
use App\Models\BookingRoutes;
use App\Models\Route;
use App\Models\BookingExtras;
use App\Models\Partners;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $sections = $this->getSection();
        $partners = $this->getPartner();

        return view('pages.reports.index', ['sections' => $sections, 'partners' => $partners, 'reports' => []]);
    }

    public function getRoute(Request $request) {
        $sections = $this->getSection();
        $partners = $this->getPartner();

        $depart_date = $this->setDepartDate($request->daterange);
        $start_date = Carbon::createFromFormat('Y-m-d', $depart_date[0])->startOfDay();
        $end_date = Carbon::createFromFormat('Y-m-d', $depart_date[1])->startOfDay();
        $station_from = 'ALL';
        $station_to = 'ALL';
        $partner = 'ALL';
        $depart_arrive = 'ALL';

        $from = $request->station_from != 'all' ? $request->station_from : '';
        $to = $request->station_to != 'all' ? $request->station_to : '';
        $_partner = $request->partner != 'all' ? $request->partner : '';
        $_depart_arrive = $request->depart_time != 'all' ? $request->depart_time : '';

        $routes = $this->routeGetReport($from, $to, $start_date, $end_date, $_partner, $_depart_arrive);

        $booking_route = $this->getOnlyBookingRoutes($routes);
        if($from != '') $station_from = $this->getStationById($request->station_from);
        if($to != '') $station_to = $this->getStationById($request->station_to);
        if($_partner != '') $partner = $this->getPassnerById($request->partner);
        if($_depart_arrive != '') $depart_arrive = $request->depart_time;
        // Log::debug($partner->toArray());

        return view('pages.reports.index', ['sections' => $sections, 'partners' => $partners, 'reports' => $booking_route,
                'depart_date' => $request->daterange, 'from' => $station_from, 'to' => $station_to, 'is_partner' => $partner,
                'depart_arrive' => $depart_arrive]);
    }

    public function reportPdfGenerate(Request $request) {
        $depart_date = $this->setDepartDate($request->daterange);
        $start_date = Carbon::createFromFormat('Y-m-d', $depart_date[0])->startOfDay();
        $end_date = Carbon::createFromFormat('Y-m-d', $depart_date[1])->startOfDay();
        $station_from = 'ALL';
        $station_to = 'ALL';
        $partner = 'ALL';
        $depart_arrive = 'ALL';

        $from = $request->station_from != 'all' ? $request->station_from : '';
        $to = $request->station_to != 'all' ? $request->station_to : '';
        $_partner = $request->partner != 'all' ? $request->partner : '';
        $_depart_arrive = $request->depart_time != 'all' ? $request->depart_time : '';

        $routes = $this->routeGetReport($from, $to, $start_date, $end_date, $_partner, $_depart_arrive);

        $booking_route = $this->getOnlyBookingRoutes($routes);
        if($from != '') $station_from = $this->getStationById($request->station_from);
        if($to != '') $station_to = $this->getStationById($request->station_to);
        if($_partner != '') $partner = $this->getPassnerById($request->partner);
        if($_depart_arrive != '') $depart_arrive = $request->depart_time;

        return view('pages.reports.pdf', ['reports' => $booking_route, 'depart_date' => $request->daterange,
                    'from' => $station_from, 'to' => $station_to, 'partner' => $partner, 'is_partner' => $partner,
                    'depart_arrive' => $depart_arrive]);
    }

    private function routeGetReport($station_from, $station_to, $start_date, $end_date, $partner, $depart_time) {
        $_from = $station_from != '' ? $station_from : '';
        $_to = $station_to != '' ? $station_to : '';
        $_partner = $partner != '' ? $partner : '';
        $depart = '';
        $arrive = '';
        if($depart_time != '') {
            $ex = explode('-', $depart_time);
            $depart = $ex[0];
            $arrive = $ex[1];
        }

        $routes = Route::where(function($f) use ($_from) {
                            if($_from != '') return $f->where('station_from_id', $_from);
                        })
                        ->where(function($t) use ($_to) {
                            if($_to != '') return $t->where('station_to_id', $_to);
                        })
                        ->where(function($p) use ($_partner) {
                            if($_partner != '') return $p->where('partner_id', $_partner);
                        })
                        ->where(function($d) use ($depart) {
                            if($depart != '') return $d->where('depart_time', $depart);
                        })
                        ->where(function($a) use ($arrive) {
                            if($arrive != '') return $a->where('arrive_time', $arrive);
                        })
                        ->with(['bookings' => function($br) use ($start_date, $end_date) {
                            return $br->whereDate('traveldate', '>=', $start_date)->whereDate('traveldate', '<=', $end_date);
                        }, 'partner'])
                        ->get();

        // Log::debug($routes->toArray());
        return $routes;
    }

    private function getStationById($id) {
        return Station::find($id);
    }

    private function getPassnerById($id) {
        return Partners::find($id);
    }

    private function getOnlyBookingRoutes($routes) {
        $booking_routes = [];

        foreach($routes as $index => $route) {
            if(sizeof($route['bookings']) > 0) {
                foreach($route['bookings'] as $br) {
                    $shuttle_bus = $this->getRouteExtra($br->pivot->id, 'shuttle_bus');
                    $longtail_boat = $this->getRouteExtra($br->pivot->id, 'longtail_boat');
                    $private_taxi = $this->getRouteExtra($br->pivot->id, 'private_taxi');

                    $br->traveldate = $br->pivot->traveldate;
                    $br->travel_date = date('d/m/Y', strtotime($br->pivot->traveldate));
                    $br->station_from = $this->setStationToBookingRoute($routes[$index]->station_from);
                    $br->station_to = $this->setStationToBookingRoute($routes[$index]->station_to);
                    $br->shuttle_bus_from = $shuttle_bus[0];
                    $br->shuttle_bus_to = $shuttle_bus[1];
                    $br->longtail_boat_from = $longtail_boat[0];
                    $br->longtail_boat_to = $longtail_boat[1];
                    $br->private_taxi_from = $private_taxi[0];
                    $br->private_taxi_to = $private_taxi[1];
                    $br->meal = $this->getAddonExtra($br->pivot->id, 'MEAL');
                    $br->activity = $this->getAddonExtra($br->pivot->id, 'ACTV');
                    array_push($booking_routes, $br->toArray());
                }
            }
        }

        usort($booking_routes, function ($a, $b) {
            return strtotime($a['traveldate']) - strtotime($b['traveldate']);
        });

        // Log::debug($booking_routes);
        return $booking_routes;
    }

    private function getAddonExtra($booking_route_id, $type) {
        $addon_extra = BookingExtras::where('booking_route_id', $booking_route_id)
                        ->with(['addon' => function($a) use ($type) {
                            return $a->where('type', $type);
                        }])
                        ->get();

        $addons = [];
        foreach($addon_extra as $extra) {
            if($extra->addon != NULL) {
                array_push($addons, $extra->addon->name);
            }

        }

        return $addons;
    }

    private function getRouteExtra($booking_route_id, $type) {
        $booking_extra = BookingExtras::where('booking_route_id', $booking_route_id)
                            ->with(['route_addon' => function($ra) use ($type) {
                                return $ra->where('type', $type);
                            }])
                            ->get();

        $from = '';
        $to = '';
        foreach($booking_extra as $extra) {
            if($extra->route_addon != NULL) {
                foreach($extra->route_addon as $addon) {
                    if($addon->subtype == 'from') $from = $extra->description;
                    if($addon->subtype == 'to') $to = $extra->description;
                }
            }
        }

        return array($from, $to);
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

    private function getPartner() {
        return Partners::where('isactive', 'Y')->orderBy('name', 'ASC')->get();
    }

    private function setDepartDate($daterange) {
        $ex = explode(' - ', $daterange);
        $ex_start = explode('/', $ex[0]);
        $ex_end = explode('/', $ex[1]);

        $depart_start = $ex_start[2].'-'.$ex_start[1].'-'.$ex_start[0];
        $depart_end = $ex_end[2].'-'.$ex_end[1].'-'.$ex_end[0];

        return array($depart_start, $depart_end);
    }

    public function routeDepartArriveTime(string $from_id = null, string $to_id = null) {
        $route = Route::where('station_from_id', $from_id)
                        ->where('station_to_id', $to_id)
                        ->where('isactive', 'Y')
                        ->orderBy('depart_time', 'ASC')
                        ->get();

        $times = [];
        foreach($route as $index => $item) {
            $depart = date('H:i', strtotime($item->depart_time));
            $arrive = date('H:i', strtotime($item->arrive_time));

            array_push($times, ['depart_time' => $depart, 'arrive_time' => $arrive]);
        }

        $_times = array_unique($times, SORT_REGULAR);
        return response()->json(['data' => $_times], 200);
    }
}
