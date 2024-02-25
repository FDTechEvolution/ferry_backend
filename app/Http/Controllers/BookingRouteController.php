<?php

namespace App\Http\Controllers;

use App\Models\BookingRoutes;
use App\Models\Bookings;
use App\Models\Route;
use Illuminate\Http\Request;
use App\Helpers\RouteHelper;
use Illuminate\Support\Carbon;
use App\Helpers\TransactionLogHelper;
use Illuminate\Support\Facades\Log;

class BookingRouteController extends Controller
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
        //
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
        $booking_id = request()->booking_id;
        $bookingRoute = BookingRoutes::with(['Route'])->where('id',$id)->first();

        $departdate = request()->departdate;
        $routes = [];
        $stationFromId = request()->station_from_id;
        $stationToId = request()->station_to_id;

        if(is_null($departdate)){
            $departdate = date('d/m/Y');
        }
        $stationFroms = RouteHelper::getStationFrom();
        if (is_null($stationFromId) && sizeof($stationFroms) > 0) {
            $stationFromId = $stationFroms[0]->id;
        }
        $stationTos = RouteHelper::getStationTo($stationFromId);
        if (is_null($stationToId) && sizeof($stationTos) > 0) {
            $stationToId = $stationTos[0]->id;
        }

        if (!is_null($stationFromId) && !is_null($stationToId)) {
            $departdateSql = Carbon::createFromFormat('d/m/Y', $departdate)->format('Y-m-d');
            $routes = RouteHelper::getAvaliableRoutes($stationFromId, $stationToId,$departdateSql);
        }


        return view('pages.booking_route.edit',[
            'bookingRoute'=>$bookingRoute,'booking_id'=>$booking_id,
            'stationFroms'=>$stationFroms,'stationTos'=>$stationTos,
            'routes'=>$routes,'stationFromId'=>$stationFromId,'stationToId'=>$stationToId,
            'departdate'=>$departdate
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking_id = request()->booking_id;
        $traveldate = Carbon::createFromFormat('d/m/Y', $request->departdate)->format('Y-m-d');

        $bookingRoute = BookingRoutes::with(['route'])->where('id',$id)->first();

        $oldRoute = clone $bookingRoute->route;
        $newRoute = Route::with(['station_from','station_to'])->where('id',$request->route_id)->first();

        $bookingRoute->route_id = $request->route_id;
        $bookingRoute->traveldate = $traveldate;
        $bookingRoute->ischange = 'Y';
        $bookingRoute->save();

        //update booking
        $booking = Bookings::where('id',$booking_id)->first();
        $booking->amend = $booking->amend+1;
        $booking->save();
        //Log::debug($request);
        //Log::debug($oldRoute);
        //Log::debug($newRoute);

        $logDes = sprintf('Change from %s->%s %s to %s-%s %s',$oldRoute->station_from->name,$oldRoute->station_to->name,date('H:i', strtotime($oldRoute->depart_time)),$newRoute->station_from->name,$newRoute->station_to->name,date('H:i', strtotime($newRoute->depart_time)));
        TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Change route '.$bookingRoute->type, 'description' => $logDes, 'booking_id' => $booking_id]);

        return redirect()->route('booking-view',['id'=>$booking_id])->withSuccess('Changed route.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
