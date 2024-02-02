<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Models\ApiMerchants;
use App\Models\RouteSchedules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
                ->select('sfrom.name as station_from_name', 'sto.name as station_to_name', 'routes.*', 'route_schedules.*','createdby.firstname as created_name','updatedby.firstname as updated_name',)
                ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
                ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
                ->join('route_schedules', 'routes.id', '=', 'route_schedules.route_id')
                ->leftJoin('users as createdby','route_schedules.created_by','createdby.id') 
                ->leftJoin('users as updatedby','route_schedules.updated_by','updatedby.id') 
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
            ->select('sfrom.name as station_from_name', 'sto.name as station_to_name', 'routes.*', 'route_schedules.*','createdby.firstname as created_name','updatedby.firstname as updated_name',)
                ->join('stations as sfrom', 'routes.station_from_id', '=', 'sfrom.id')
                ->join('stations as sto', 'routes.station_to_id', '=', 'sto.id')
                ->join('route_schedules', 'routes.id', '=', 'route_schedules.route_id')
                ->leftJoin('users as createdby','route_schedules.created_by','createdby.id') 
                ->leftJoin('users as updatedby','route_schedules.updated_by','updatedby.id') 
                ->where('route_schedules.api_merchant_id', $merchant_id)
                ->orderBy('sfrom.name', 'ASC')
                ->orderBy('routes.depart_time', 'ASC')
                ->get();
        }

        //

        return view('pages.route_schedules.index', ['routeSchedules' => $routeSchedules, 'merchant_id' => $merchant_id, 'title' => $title, 'stationFroms' => $stationFroms, 'stationTos' => $stationTos, 'stationFromId' => $stationFromId, 'stationToId' => $stationToId,'apiMerchant'=>$apiMerchant]);
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
            $apiMerchant = ApiMerchants::where('id',$merchant_id)->first();
        }

    
        $stationTos = RouteHelper::getStationTo($stationFromId);

        if (!is_null($stationFromId) && !is_null($stationToId)) {
            $routes = RouteHelper::getRoutes($stationFromId, $stationToId);
        }

        //dd($stationFrom);
        return view('pages.route_schedules.create', [
            'stationFroms' => $stationFroms,
            'stationTos' => $stationTos,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'routes' => $routes,
            'merchant_id' => $merchant_id,'apiMerchant'=>$apiMerchant
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


        foreach ($route_ids as $index => $route_id) {
            $routeSchedule = RouteSchedules::create([
                'route_id' => $route_id,
                'type' => $request->type,
                'start_datetime' => $startDateSql,
                'end_datetime' => $endDateSql,
                'isactive' => 'Y',
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

        return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $routeSchedule = RouteSchedules::where('id', $id)->with(['route'])->first();
        $route_id = $routeSchedule->route_id;

        $apiMerchant = NULL;
        if (!is_null($routeSchedule->api_merchant_id) || $routeSchedule->api_merchant_id != '') {
            $apiMerchant = ApiMerchants::where('id',$routeSchedule->api_merchant_id)->first();
        }


        $routeScheduleInRoutes = RouteSchedules::where('route_id', $route_id)
        ->where('api_merchant_id',$routeSchedule->api_merchant_id)
        ->orderBy('updated_at', 'DESC')->get();

        return view('pages.route_schedules.edit', [
            'routeSchedule' => $routeSchedule,
            'routeScheduleInRoutes' => $routeScheduleInRoutes,'apiMerchant'=>$apiMerchant
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
    public function destroy(string $id)
    {
        $routeSchedule = RouteSchedules::where('id', $id)->first();
        $merchant_id = $routeSchedule->api_merchant_id;
        $routeSchedule->delete();
        return redirect()->route('routeSchedules.index', ['merchant_id' => $merchant_id])->withSuccess('');
    }
}
