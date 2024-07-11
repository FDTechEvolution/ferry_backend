<?php

namespace App\Http\Controllers;

use App\Helpers\EmailHelper;
use App\Helpers\RouteHelper;
use App\Mail\VoidBooking;
use App\Models\ApiMerchants;
use App\Models\BookingRoutes;
use App\Models\Bookings;
use App\Models\RouteSchedules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RouteSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $merchant_id = request()->merchant_id;
        $apiMerchant = null;
        $stationFromId = request()->station_from_id;
        $stationToId = request()->station_to_id;

        $routeSchedules = [];
        $title = 'Route';

        $stationFroms = RouteHelper::getStationFrom();

        $stationTos = RouteHelper::getStationTo($stationFromId);

        $countBooking = RouteSchedules::where('isconflict', 'Y')->count();

        //check normal ruote
        if (is_null($merchant_id) || $merchant_id == '') {
            //set inactive
            $date = date('Y-m-d');
            /*
            $routeSchedules = RouteSchedules::with('isactive', 'Y')
                ->where('end_datetime', '<', $date)
                ->whereNull('api_merchant_id')
                ->update(['isactive' => 'N']);
            */

            $routeSchedules = DB::table('routes')
                ->select('sfrom.name as station_from_name', 'sto.name as station_to_name', 'routes.*', 'route_schedules.*', 'createdby.firstname as created_name', 'updatedby.firstname as updated_name', 'images.path')
                ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
                ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
                ->join('route_schedules', 'routes.id', '=', 'route_schedules.route_id')
                ->leftJoin('users as createdby', 'route_schedules.created_by', 'createdby.id')
                ->leftJoin('users as updatedby', 'route_schedules.updated_by', 'updatedby.id')
                ->leftJoin('partners', 'routes.partner_id', 'partners.id')
                ->leftJoin('images', 'partners.image_id', 'images.id')
                ->whereNull('route_schedules.api_merchant_id');

            if (!is_null($stationFromId) && $stationFromId != 'all') {
                $routeSchedules = $routeSchedules->where('routes.station_from_id', $stationFromId);
            }

            if (!is_null($stationToId) && $stationToId != 'all') {
                $routeSchedules = $routeSchedules->where('routes.station_to_id', $stationToId);
            }

            $routeSchedules = $routeSchedules->orderBy('sfrom.name', 'ASC')
                ->orderBy('routes.depart_time', 'ASC')
                ->get();

        } else {
            $title = 'API Route';

            //set inactive
            $date = date('Y-m-d');

            /*
            $routeSchedules = RouteSchedules::with('isactive', 'Y')
                ->where('end_datetime', '<', $date)
                ->where('api_merchant_id', $merchant_id)
                ->update(['isactive' => 'N']);
            */


            $routeSchedules = DB::table('routes')
                ->select('sfrom.name as station_from_name', 'sto.name as station_to_name', 'routes.*', 'route_schedules.*', 'createdby.firstname as created_name', 'updatedby.firstname as updated_name', 'images.path')
                ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
                ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
                ->join('route_schedules', 'routes.id', '=', 'route_schedules.route_id')
                ->leftJoin('users as createdby', 'route_schedules.created_by', 'createdby.id')
                ->leftJoin('users as updatedby', 'route_schedules.updated_by', 'updatedby.id')
                ->leftJoin('partners', 'routes.partner_id', 'partners.id')
                ->leftJoin('images', 'partners.image_id', 'images.id')
                ->where('route_schedules.api_merchant_id', $merchant_id)
                ->orderBy('sfrom.name', 'ASC')
                ->orderBy('routes.depart_time', 'ASC')
                ->get();
        }

        //

        return view('pages.route_schedules.index', ['routeSchedules' => $routeSchedules, 'merchant_id' => $merchant_id, 'title' => $title, 'stationFroms' => $stationFroms, 'stationTos' => $stationTos, 'stationFromId' => $stationFromId, 'stationToId' => $stationToId, 'apiMerchant' => $apiMerchant, 'countBooking' => $countBooking]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $merchant_id = request()->merchant_id;
        $routes = [];
        $stationFromId = request()->station_from_id;
        $stationToId = request()->station_to_id;

        $stationFroms = RouteHelper::getStationFrom();
        if (is_null($stationFromId) && sizeof($stationFroms) > 0) {
            $stationFromId = $stationFroms[0]->id;
        }

        $apiMerchant = NULL;
        if (!is_null($merchant_id) || $merchant_id != '') {
            $apiMerchant = ApiMerchants::where('id', $merchant_id)->first();
        }


        $stationTos = RouteHelper::getStationTo($stationFromId);

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

        $dates = explode('-', $request->daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $merchant_id = NULL;
        if (isset($request->merchant_id) && $request->merchant_id != '') {
            $merchant_id = $request->merchant_id;
        }


        $route_ids = $request->route_id;
        if (!isset($route_ids) || sizeof($route_ids) == 0) {
            return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id]);
        }

        //Check bookingAffected
        $isHasEffectBookingMaster = false;


        $routeSchedule = null;
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
            return redirect()->route('routeSchedules.bookingAffected', ['merchant_id' => $merchant_id]);
        }

        return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
                array_push($bookingIds,$item->id);
            }

            if(sizeof($datas) ==0){
                $routeSchedule->isconflict ='N';
                $routeSchedule->isactive = 'Y';
                $routeSchedule->save();
            }
        }

        $bookingIds = json_decode(json_encode($bookingIds), true);

        $sql = 'select b.id,br.id as booking_route_id,b.created_at,b.bookingno,b.adult_passenger,b.child_passenger,b.infant_passenger,b.trip_type,concat(sf.nickname,"-",st.nickname) as route,br.traveldate,b.ispayment,b.book_channel,u.firstname,r.depart_time,r.arrive_time,b.totalamt from bookings b join booking_routes br on b.id = br.booking_id join routes r on br.route_id = r.id join stations sf on r.station_from_id = sf.id join stations st on r.station_to_id = st.id left join users u on b.user_id = u.id where br.id IN ("'.implode('","',$bookingIds).'") and b.status = "CO" order by br.traveldate ASC,b.created_at ASC  ';

        $bookings = DB::select($sql);
        $bookings = json_decode(json_encode($bookings), true);

        if (sizeof($bookings) == 0) {
            return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
        }

        return view('pages.route_schedules.booking_effect', ['merchant_id' => $merchant_id, 'bookings' => $bookings]);
    }

    public function sendVoidBooking(Request $request){
        $message = $request->message;
        $booking_route_ids = $request->booking_route_id;
        $merchant_id = $request->merchant_id;

        foreach($booking_route_ids as $booking_route_id){
            EmailHelper::voidBoking($booking_route_id,$message);
            $bookingRoute = BookingRoutes::where('id',$booking_route_id)->with('booking')->first();
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
