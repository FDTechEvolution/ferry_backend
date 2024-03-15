<?php

namespace App\Http\Controllers;

use App\Models\ApiMerchants;
use App\Models\ApiRoutes;
use App\Models\RouteCalendars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class RouteCalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $api_route_id = request()->api_route_id;
        $date = request()->date;

        if(empty($api_route_id) || empty($date)){
            abort(404);
        }
        $apiRoute = ApiRoutes::where('id',$api_route_id)->with('api_merchant')->first();

        $routeCalendar = RouteCalendars::updateOrCreate([
            'date'=>$date,'api_route_id'=>$api_route_id,
        ],[
            'date'=>$date,
            'api_route_id'=>$api_route_id,
            'seat'=>$apiRoute->seat,
            'created_by'=>Auth::id()
        ]);

        return view('pages.route_calendars.modal.edit',['routeCalendar'=>$routeCalendar]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $routeCalendar = RouteCalendars::where('id',$id)->first();

        return view('pages.route_calendars.modal.edit',['routeCalendar'=>$routeCalendar]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request);
        $routeCalendar = RouteCalendars::where('id',$id)->first();

        $routeCalendar->seat = $request->seat;
        $routeCalendar->description = $request->description;
        $routeCalendar->updated_by = Auth::id();

        $routeCalendar->save();

        $date = Carbon::createFromFormat('Y-m-d', $routeCalendar->date);
        $month = $date->format('m');
        $year = $date->format('Y');

        return redirect()->route('apiroute.calendar', ['id'=> $routeCalendar->api_route_id,'api_route_id' => $routeCalendar->api_route_id,'month'=>$month,'year'=>$year])->withSuccess('');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
