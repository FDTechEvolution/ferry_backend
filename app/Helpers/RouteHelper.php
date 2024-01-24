<?php
namespace App\Helpers;

use App\Models\Route;
use Illuminate\Support\Facades\DB;

class RouteHelper
{
    public static function getAvaliableRoutes(){
        $avaliableRouteIds = DB::table('routes')->where('routes.isactive','Y');
    }
    
    public static function getStationFrom()
    {
        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name')
            ->join('stations', 'routes.station_from_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y')
            ->groupBy('stations.id', 'stations.name')
            ->Get();

        return $stations;
    }

    public static function getStationTo($stationFromId = NULL)
    {

        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name')
            ->join('stations', 'routes.station_from_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y')
            ->where('routes.station_to_id', $stationFromId)
            ->groupBy('stations.id', 'stations.name')
            ->Get();

        return $stations;
    }

    public static function getRoutes($stationFromId, $stationToId)
    {
        $routes = Route::where('isactive', 'Y')
            ->with(['station_from','station_to'])
            ->where('station_from_id', $stationFromId)
            ->where('station_to_id', $stationToId)
            ->orderBy('station_from_id', 'ASC')
            ->orderBy('depart_time', 'ASC')
            ->get();

        return $routes;
    }
}