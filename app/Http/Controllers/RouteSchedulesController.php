<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Models\RouteSchedules;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RouteSchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //set inactive
        $date = date('Y-m-d');
        //RouteHelper::getAvaliableRoutes('9ad24c8e-47c4-4f2c-823d-32d7b2812711','9ad26407-81ce-4ad3-99ae-b4bcb47d16f6','2024-02-05');
        $routeSchedules = RouteSchedules::with('isactive','Y')
            ->where('end_datetime','<',$date)
            ->update(['isactive' => 'N']);


        $routeSchedules = RouteSchedules::with('route')
            ->orderBy('isactive', 'asc')
            ->orderBy('start_datetime', 'desc')->get();

        return view('pages.route_schedules.index',['routeSchedules'=>$routeSchedules]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = [];
        $stationFromId = request()->station_from_id;
        $stationToId = request()->station_to_id;

        $stationFroms = RouteHelper::getStationFrom();
        if (is_null($stationFromId) && sizeof($stationFroms) > 0) {
            $stationFromId = $stationFroms[0]->id;
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

        $route_ids = $request->route_id;
        if(!isset($route_ids) || sizeof($route_ids) ==0){
            return redirect()->route('routeSchedules.index');
        }
        foreach ($route_ids as $index => $route_id) {
            $routeSchedule = RouteSchedules::create([
                'route_id' => $route_id,
                'type' => $request->type,
                'start_datetime' => $startDateSql,
                'end_datetime' => $endDateSql,
                'isactive' => 'Y',
                'description' => $request->description,
                'mon'=>isset($request->mon)?'Y':'N',
                'tru'=>isset($request->tru)?'Y':'N',
                'wed'=>isset($request->wed)?'Y':'N',
                'thu'=>isset($request->thu)?'Y':'N',
                'fri'=>isset($request->fri)?'Y':'N',
                'sat'=>isset($request->sat)?'Y':'N',
                'sun'=>isset($request->sun)?'Y':'N',
            ]);
        }

        return redirect()->route('routeSchedules.index')->withSuccess('');
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
        $routeSchedule = RouteSchedules::where('id',$id)->with(['route'])->first();

        return view('pages.route_schedules.edit', [
            'routeSchedule' => $routeSchedule,
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

        

        $routeSchedule = RouteSchedules::where('id',$id)->first();

        $dates = explode('-', $request->daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $startDateSql = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');

        $updateDatas = [
            'start_datetime' => $startDateSql,
            'end_datetime' => $endDateSql,
            'description' => $request->description,
            'mon'=>isset($request->mon)?'Y':'N',
            'tru'=>isset($request->tru)?'Y':'N',
            'wed'=>isset($request->wed)?'Y':'N',
            'thu'=>isset($request->thu)?'Y':'N',
            'fri'=>isset($request->fri)?'Y':'N',
            'sat'=>isset($request->sat)?'Y':'N',
            'sun'=>isset($request->sun)?'Y':'N'
        ];

        $routeSchedule->update($updateDatas);
        return redirect()->route('routeSchedules.index')->withSuccess('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $routeSchedule = RouteSchedules::where('id',$id)->first();
        $routeSchedule->delete();
        return redirect()->route('routeSchedules.index')->withSuccess('');
    }
}
