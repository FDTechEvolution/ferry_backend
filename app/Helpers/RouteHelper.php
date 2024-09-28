<?php
namespace App\Helpers;

use App\Models\Route;
use App\Models\RouteDailyStatus;
use App\Models\RouteSchedules;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RouteHelper
{
    /*
     * $departDate with SQL format Y-m-d
     */
    public static function getAvaliableRoutes($stationFromId, $stationToId, $departDate)
    {

        $_departDate = Carbon::createFromFormat('Y-m-d', $departDate);
        $routeIds = [];

        $routeDailyStatuses = RouteDailyStatus::select('route_id')->where('date',$departDate)->where('isopen','Y')->get();
        foreach($routeDailyStatuses as $routeDailyStatus){
            array_push($routeIds,$routeDailyStatus->route_id);
        }

        //dd($routeDailyStatuses);

        $routes = Route::with('station_from', 'station_to', 'icons', 'activity_lines', 'meal_lines', 'partner', 'station_lines', 'routeAddons')
            ->whereIn('id', $routeIds)
            ->where('station_from_id', $stationFromId)
            ->where('status','CO')
            ->where('isactive','Y')
            ->where('station_to_id', $stationToId)
            ->orderBy('station_from_id', 'ASC')
            ->orderBy('depart_time', 'ASC')

            ->get();

        return ($routes);
    }

    public static function getStationFrom()
    {
        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->join('stations', 'routes.station_from_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y')
            ->groupBy('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->orderBy('stations.name','ASC')
            ->Get();

        return $stations;
    }

    public static function getStationTo($stationFromId = NULL)
    {

        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->join('stations', 'routes.station_to_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y');
        if ($stationFromId == null || $stationFromId == '' || $stationFromId == 'all') {

        } else {
            $stations = $stations->where('routes.station_from_id', $stationFromId);
        }

        $stations = $stations->groupBy('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
        ->orderBy('stations.name','ASC')->Get();

        return $stations;
    }

    public static function getRoutes($stationFromId, $stationToId)
    {
        $routes = Route::where('isactive', 'Y')
            ->with(['station_from', 'station_to','partner.image', 'icons']);
        if(!is_null($stationFromId) && $stationFromId !='' && $stationFromId !='all'){
            $routes = $routes->where('station_from_id', $stationFromId);
        }

        if(!is_null($stationToId) && $stationToId !='' && $stationToId !='all'){
            $routes = $routes->where('station_to_id', $stationToId);
        }

        $routes  = $routes->orderBy('station_from_id', 'ASC')
            ->orderBy('depart_time', 'ASC')
            ->get();
        //dd($routes);

        return $routes;
    }
}
