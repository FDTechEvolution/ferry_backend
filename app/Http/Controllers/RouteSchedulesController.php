<?php

namespace App\Http\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\RouteHelper;
use App\Helpers\CalendarHelper;
use App\Models\ApiMerchants;
use App\Models\BookingRoutes;
use App\Models\Partners;
use App\Models\Route;
use App\Models\RouteDailyStatus;
use App\Models\RouteSchedules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RouteSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merchant_id = request()->merchant_id ?: null;
        $stationFromId = request()->station_from;
        $stationToId = request()->station_to;
        $partnerId = request()->partner_id;
        $title = empty($merchant_id) ? 'Route' : 'API Route';

        $stationFroms = RouteHelper::getSectionStationFrom(true);
        $stationTos = RouteHelper::getSectionStationTo(true, $stationFromId);
        $partners = Partners::where('isactive', 'Y')->orderBy('name', 'ASC')->get(['id', 'name']);
        $countBooking = RouteSchedules::where('isconflict', 'Y')->count();
        $routes = $this->getScheduleIndexRoutes($merchant_id, $stationFromId, $stationToId, $partnerId);

        return view('pages.route_schedules.index', [
            'routeSchedules' => [],
            'merchant_id' => $merchant_id,
            'title' => $title,
            'stationFroms' => $stationFroms,
            'stationTos' => $stationTos,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'apiMerchant' => null,
            'countBooking' => $countBooking,
            'routes' => $routes,
            'partners' => $partners,
            'partnerId' => $partnerId,
        ]);
    }

    private function getScheduleIndexRoutes($merchant_id, $stationFromId, $stationToId, $partnerId)
    {
        $latestSchedules = DB::table('route_schedules')
            ->select('route_id', DB::raw('MAX(updated_at) as max_updated'))
            ->when($merchant_id, fn ($query) => $query->where('api_merchant_id', $merchant_id), fn ($query) => $query->whereNull('api_merchant_id'))
            ->groupBy('route_id');

        $routes = DB::table('routes')
            ->select(
                'routes.id',
                'routes.depart_time',
                'routes.arrive_time',
                'sfrom.name as station_from_name',
                'sfrom.nickname as station_from_nickname',
                'sfrom.piername as station_from_piername',
                'sto.name as station_to_name',
                'sto.nickname as station_to_nickname',
                'sto.piername as station_to_piername',
                'partners.name as partner_name',
                'images.path as partner_image_path',
                'route_schedules.type as schedule_type',
                'route_schedules.start_datetime',
                'route_schedules.end_datetime',
                'route_schedules.created_at as schedule_created_at',
                'route_schedules.updated_at as schedule_updated_at',
                'updatedby.firstname as updated_name'
            )
            ->join('route_schedules', function ($join) use ($merchant_id) {
                $join->on('routes.id', '=', 'route_schedules.route_id');
                if ($merchant_id) {
                    $join->where('route_schedules.api_merchant_id', $merchant_id);
                } else {
                    $join->whereNull('route_schedules.api_merchant_id');
                }
            })
            ->joinSub($latestSchedules, 'latest_schedule', function ($join) {
                $join->on('route_schedules.route_id', '=', 'latest_schedule.route_id')
                    ->on('route_schedules.updated_at', '=', 'latest_schedule.max_updated');
            })
            ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
            ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
            ->leftJoin('partners', 'routes.partner_id', '=', 'partners.id')
            ->leftJoin('images', 'partners.image_id', '=', 'images.id')
            ->leftJoin('users as updatedby', 'route_schedules.updated_by', '=', 'updatedby.id');

        if (! empty($stationFromId) && $stationFromId != 'all') {
            $routes->where('routes.station_from_id', $stationFromId);
        }

        if (! empty($stationToId) && $stationToId != 'all') {
            $routes->where('routes.station_to_id', $stationToId);
        }

        if (! empty($partnerId) && $partnerId != 'all') {
            $routes->where('routes.partner_id', $partnerId);
        }

        return $routes
            ->orderBy('sfrom.name')
            ->orderBy('routes.depart_time')
            ->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $merchant_id = request()->merchant_id;
        $routes = [];
        $stationFromId = request()->station_from;
        $stationToId = request()->station_to;

        $stationFroms = RouteHelper::getSectionStationFrom();

        if (is_null($stationFromId) && sizeof($stationFroms) > 0) {
            //$stationFromId = $stationFroms[0]->id;
            foreach($stationFroms as $seaction){
                if(sizeof($seaction->stations) !=0){
                    $stationFromId = $seaction->stations[0]->id;
                    break;
                }
            }
        }

        $apiMerchant = NULL;
        if (!is_null($merchant_id) || $merchant_id != '') {
            $apiMerchant = ApiMerchants::where('id', $merchant_id)->first();
        }


        $stationTos = RouteHelper::getSectionStationTo(true,$stationFromId);


        $routes = RouteHelper::getRoutes($stationFromId, $stationToId);

        //dd($stationFrom);
        return view('pages.route_schedules.create', [
            'stationFroms' => $stationFroms,
            'stationTos' => $stationTos,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'routes' => $routes,
            'merchant_id' => $merchant_id,
            'apiMerchant' => $apiMerchant,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'daterange' => 'required|string',
        ]);
        //dd($request->all());

        $dates = explode('-', $request->daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $merchant_id = NULL;
        if (isset($request->merchant_id) && $request->merchant_id != '') {
            $merchant_id = $request->merchant_id;
        }

        $route_ids = [];
        if ($request->station_from_id == 'all' && $request->station_to_id == 'all') {
            $routes = Route::where('isactive', 'Y')->get();
            foreach ($routes as $route) {
                array_push($route_ids, $route->id);
            }
        } elseif (!isset($request->route_id)) {
            return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id]);
        } else {
            $route_ids = $request->route_id;
        }

        //Check bookingAffected
        $isHasEffectBookingMaster = false;

        foreach ($route_ids as $index => $route_id) {
            $isHasEffectBooking = false;

            if ($request->type == 'CLOSE') {
                $isHasEffectBooking = $this->isHasEffectBooking($route_id, $startDateSql, $endDateSql);
            }

            if ($isHasEffectBookingMaster == false && $isHasEffectBooking == true) {
                $isHasEffectBookingMaster = true;
            }

            $routeSchedule = RouteSchedules::create([
                'route_id' => $route_id,
                'type' => $request->type,
                'start_datetime' => $startDateSql,
                'end_datetime' => $endDateSql,
                'isactive' => $isHasEffectBooking ? 'N' : 'Y',
                'isconflict' => $isHasEffectBooking ? 'Y' : 'N',
                'description' => $request->description,
                'mon' => isset($request->mon) ? 'Y' : 'N',
                'tru' => isset($request->tru) ? 'Y' : 'N',
                'wed' => isset($request->wed) ? 'Y' : 'N',
                'thu' => isset($request->thu) ? 'Y' : 'N',
                'fri' => isset($request->fri) ? 'Y' : 'N',
                'sat' => isset($request->sat) ? 'Y' : 'N',
                'sun' => isset($request->sun) ? 'Y' : 'N',
                'api_merchant_id' => $merchant_id,
                'created_by' => Auth::id(),
            ]);

        }
        if ($isHasEffectBookingMaster) {
            //return redirect()->route('routeSchedules.bookingAffected', ['merchant_id' => $merchant_id]);
        }

        return redirect()->route('routeSchedules.jobProcess', ['haseff' => $isHasEffectBookingMaster])->withSuccess('');
        //return redirect()->route('routeSchedules.index', ['merchant_id' => null])->withSuccess('');
    }

    public function jobProcess()
    {
        $isHasEffectBookingMaster = request()->haseff;

        $routeSchedules = DB::table('route_schedules')
            ->select(
                'route_schedules.id',
                'route_schedules.start_datetime',
                'route_schedules.end_datetime',
                'sfrom.name as station_from_name',
                'sto.name as station_to_name'
            )
            ->join('routes', 'route_schedules.route_id', '=', 'routes.id')
            ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
            ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
            ->where('route_schedules.isjobsuccess', 'N')
            ->orderBy('route_schedules.created_at')
            ->get();

        return view('pages.route_schedules.job_process', [
            'routeSchedules' => $routeSchedules,
            'isHasEffectBookingMaster' => $isHasEffectBookingMaster,
            'title' => 'Make Calendar process...',
        ]);
    }

    public function jobRunAll()
    {
        set_time_limit(0);

        $routeSchedules = RouteSchedules::where('isjobsuccess', 'N')
            ->orderBy('created_at')
            ->get();

        $processed = 0;
        foreach ($routeSchedules as $routeSchedule) {
            DB::transaction(function () use ($routeSchedule) {
                $this->processRouteSchedule($routeSchedule);
            });
            $processed++;
        }

        return response()->json([
            'result' => true,
            'processed' => $processed,
        ], 200);
    }

    public function jobRun($id)
    {
        $routeSchedule = RouteSchedules::where('id', $id)->where('isjobsuccess', 'N')->first();

        if (! empty($routeSchedule)) {
            DB::transaction(function () use ($routeSchedule) {
                $this->processRouteSchedule($routeSchedule);
            });
        }

        return response()->json(['result' => true, 'data' => ''], 200);
    }

    private function processRouteSchedule(RouteSchedules $routeSchedule): void
    {
        $routeId = $routeSchedule->route_id;
        $isOpen = $routeSchedule->type === 'OPEN' ? 'Y' : 'N';
        $startDay = Carbon::parse($routeSchedule->start_datetime)->startOfDay();
        $endDay = Carbon::parse($routeSchedule->end_datetime)->startOfDay();
        $startDate = $startDay->format('Y-m-d');
        $endDate = $endDay->format('Y-m-d');

        RouteDailyStatus::where('route_id', $routeId)
            ->whereBetween('date', [$startDate, $endDate])
            ->delete();

        $rows = [];
        $timestamp = now();
        foreach ($startDay->range($endDay, 1, 'day') as $date) {
            $rows[] = [
                'id' => (string) Str::uuid(),
                'route_id' => $routeId,
                'date' => $date->format('Y-m-d'),
                'isopen' => $isOpen,
                'created_at' => $timestamp,
                'updated_at' => $timestamp,
            ];
        }

        foreach (array_chunk($rows, 500) as $chunk) {
            RouteDailyStatus::insert($chunk);
        }

        $routeSchedule->isjobsuccess = 'Y';
        $routeSchedule->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $startYear = request()->start_year;
        $endYear = request()->end_year;

        $sql = 'select a.*
from (
select date_format(start_datetime,"%Y") as y from route_schedules
union
select date_format(end_datetime,"%Y") as y from route_schedules
) as a group by a.y order by a.y asc';
        $years = DB::select($sql);


        $routeId = $id;
        $route = Route::where('id', $routeId)->with('station_from', 'station_to', 'routeDailyStatuses')->first();

        $routeDailyMaps = [];
        if (!empty($route->routeDailyStatuses)) {
            foreach ($route->routeDailyStatuses as $routeDailyStatus) {
                $routeDailyMaps[$routeDailyStatus->date] = $routeDailyStatus->isopen;
            }
        }

        $dt = Carbon::now();
        if(empty($startYear)){
            $startYear = $dt->year;
        }

        if(empty($endYear)){
            $endYear = $dt->year;
        }

        $yearCalendar = CalendarHelper::getYearRangCalendar($startYear,$endYear);
        return view('pages.route_schedules.show', ['yearCalendar' => $yearCalendar, 'route' => $route, 'routeDailyMaps' => $routeDailyMaps,'years'=>$years,'routeId'=>$routeId,'startYear'=>$startYear,'endYear'=>$endYear]);

    }

    public function bookingEffect()
    {
        $merchant_id = request()->merchant_id;

        $todayDateSql = Carbon::now()->format('Y-m-d');
        $bookingIds = [];

        $routeSchedules = RouteSchedules::where('isconflict', 'Y')->get();
        foreach ($routeSchedules as $index => $routeSchedule) {
            $startDateSql = $routeSchedule->start_datetime;
            $endDateSql = $routeSchedule->end_datetime;

            if ($startDateSql < $todayDateSql) {
                $startDateSql = $todayDateSql;
            }

            $sql = 'select br.id from booking_routes br join bookings b on br.booking_id = b.id where br.route_id = ? and (br.traveldate >= ? and br.traveldate <= ?) and b.status = "CO"';

            $datas = (DB::select($sql, [$routeSchedule->route_id, $startDateSql, $endDateSql]));

            //Log::debug($datas);
            foreach ($datas as $item) {
                /*
                $booking = Bookings::find($item->id);
                $booking->isconflict = 'Y';
                $booking->save();
                */
                array_push($bookingIds, $item->id);
            }

            if (sizeof($datas) == 0) {
                $routeSchedule->isconflict = 'N';
                $routeSchedule->isactive = 'Y';
                $routeSchedule->save();
            }
        }

        $bookingIds = json_decode(json_encode($bookingIds), true);

        $sql = 'select b.id,br.id as booking_route_id,b.created_at,b.bookingno,b.adult_passenger,b.child_passenger,b.infant_passenger,b.trip_type,concat(sf.nickname,"-",st.nickname) as route,br.traveldate,b.ispayment,b.book_channel,u.firstname,r.depart_time,r.arrive_time,b.totalamt from bookings b join booking_routes br on b.id = br.booking_id join routes r on br.route_id = r.id join stations sf on r.station_from_id = sf.id join stations st on r.station_to_id = st.id left join users u on b.user_id = u.id where br.id IN ("' . implode('","', $bookingIds) . '") and b.status = "CO" order by br.traveldate ASC,b.created_at ASC  ';

        $bookings = DB::select($sql);
        $bookings = json_decode(json_encode($bookings), true);

        if (sizeof($bookings) == 0) {
            return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
        }

        return view('pages.route_schedules.booking_effect', ['merchant_id' => $merchant_id, 'bookings' => $bookings]);
    }

    public function sendVoidBooking(Request $request)
    {
        $message = $request->message;
        $booking_route_ids = $request->booking_route_id;
        $merchant_id = $request->merchant_id;

        foreach ($booking_route_ids as $booking_route_id) {
            EmailHelper::voidBoking($booking_route_id, $message);
            $bookingRoute = BookingRoutes::where('id', $booking_route_id)->with('booking')->first();
            $booking = $bookingRoute->booking;

            $booking->status = 'VO';
            $booking->save();
        }

        return redirect()->route('routeSchedules.bookingAffected', ['merchant_id' => $merchant_id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $routeSchedule = RouteSchedules::where('id', $id)->with(['route', 'route.partner.image'])->first();
        $route_id = $routeSchedule->route_id;

        $apiMerchant = NULL;
        if (!is_null($routeSchedule->api_merchant_id) || $routeSchedule->api_merchant_id != '') {
            $apiMerchant = ApiMerchants::where('id', $routeSchedule->api_merchant_id)->first();
        }


        $routeScheduleInRoutes = RouteSchedules::where('route_id', $route_id)
            ->where('api_merchant_id', $routeSchedule->api_merchant_id)
            ->orderBy('updated_at', 'DESC')->get();

        return view('pages.route_schedules.edit', [
            'routeSchedule' => $routeSchedule,
            'routeScheduleInRoutes' => $routeScheduleInRoutes,
            'apiMerchant' => $apiMerchant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request);
        $request->validate([
            'type' => 'required|string',
            'daterange' => 'required|string',
        ]);



        $routeSchedule = RouteSchedules::where('id', $id)->first();

        $dates = explode('-', $request->daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $updateDatas = [
            'start_datetime' => $startDateSql,
            'end_datetime' => $endDateSql,
            'description' => $request->description,
            'type' => $request->type,
            'mon' => isset($request->mon) ? 'Y' : 'N',
            'tru' => isset($request->tru) ? 'Y' : 'N',
            'wed' => isset($request->wed) ? 'Y' : 'N',
            'thu' => isset($request->thu) ? 'Y' : 'N',
            'fri' => isset($request->fri) ? 'Y' : 'N',
            'sat' => isset($request->sat) ? 'Y' : 'N',
            'sun' => isset($request->sun) ? 'Y' : 'N',
            'updated_by' => Auth::id(),
        ];

        $routeSchedule->update($updateDatas);
        return redirect()->route('routeSchedules.index', ['merchant_id' => $routeSchedule->api_merchant_id])->withSuccess('');
    }

    /**
     * Remove the specified resource from storage.
     */
    /*
    public function destroy(string $id)
    {
        $routeSchedule = RouteSchedules::where('id', $id)->first();
        $merchant_id = $routeSchedule->api_merchant_id;
        $routeSchedule->delete();
        return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
    }
        */

    private function isHasEffectBooking($routeId, $startDateSql, $endDateSql)
    {
        $todayDateSql = Carbon::now()->format('Y-m-d');
        //$startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        //$endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        if ($startDateSql < $todayDateSql) {
            $startDateSql = $todayDateSql;
        }

        $sql = 'select b.id from booking_routes br join bookings b on br.booking_id = b.id where br.route_id = ? and (br.traveldate >= ? and br.traveldate <= ?) ';

        $datas = (DB::select($sql, [$routeId, $startDateSql, $endDateSql]));


        /*
        foreach ($datas as $item) {
            $booking = Bookings::find($item->id);
            $booking->isconflict = 'Y';
            $booking->save();
        }
        */
        //dd($count);
        if (sizeof($datas) > 0) {
            return true;
        }

        return false;

    }


}
