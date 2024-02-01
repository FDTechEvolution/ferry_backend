<?php
namespace App\Helpers;

use App\Models\Route;
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
        

        $sql = 'select r.id 
        from 
            routes r 
            join stations s_from on r.station_from_id = s_from.id and s_from.isactive = "Y" 
            join stations s_to on r.station_to_id = s_to.id and s_to.isactive = "Y" 
        where 
        r.isactive = "Y"  
        and (r.station_from_id = ? and r.station_to_id = ?) 
        and r.id not in (
            select route_id from route_schedules where isactive = "Y" and api_merchant_id IS NULL and type = "CLOSE" and start_datetime <= ? and end_datetime >= ? and :dayCondition
        )';
        $conditionStr = '';

        $dayOfWeek = Carbon::parse($departDate)->dayOfWeek;
        if ($dayOfWeek == 1) {
            $conditionStr = 'mon = "Y" ';
        } elseif ($dayOfWeek == 2) {
            $conditionStr = 'tru = "Y" ';
        } elseif ($dayOfWeek == 3) {
            $conditionStr = 'wed = "Y" ';
        } elseif ($dayOfWeek == 4) {
            $conditionStr = 'thu = "Y" ';
        } elseif ($dayOfWeek == 5) {
            $conditionStr = 'fri = "Y" ';
        } elseif ($dayOfWeek == 6) {
            $conditionStr = 'sat = "Y" ';
        } else {
            $conditionStr = 'sun = "Y" ';
        }

        $sql = str_replace(':dayCondition', $conditionStr, $sql);

        $avaliableRouteIds = DB::select($sql, [$stationFromId, $stationToId, $departDate, $departDate]);

        //check has open route schedule
        $sql = 'select rs.* from route_schedules rs join routes r on rs.route_id = r.id where rs.type="OPEN" and rs.api_merchant_id is null and r.station_from_id = ? and r.station_to_id = ? and rs.isactive = "Y"';
        $avaliableOpenRoutes = DB::select($sql, [$stationFromId, $stationToId]);
        $avaliableRouteIds = json_decode(json_encode($avaliableRouteIds),true);
        //Log::debug($avaliableOpenRoutes);

        $avaliableOpenRouteIds = [];
        foreach($avaliableOpenRoutes as $avaliableOpenRoute){
            $_departDate = Carbon::createFromFormat('Y-m-d',  $departDate);
            $start = Carbon::createFromFormat('Y-m-d',  $avaliableOpenRoute->start_datetime);
            $end = Carbon::createFromFormat('Y-m-d',  $avaliableOpenRoute->end_datetime);
            //Log::debug(array_search($avaliableOpenRoute->route_id, $avaliableRouteIds));

            if(!$_departDate->between($start, $end)){

                $_avaliableRouteIds = $avaliableRouteIds;
                foreach($_avaliableRouteIds as $index => $avaliableRouteId){
                    if($avaliableRouteId['id'] == $avaliableOpenRoute->route_id){
                        unset($avaliableRouteIds[$index]);
                    }
                }

            }
        }

        //end
        

        $routes = Route::with('station_from', 'station_to', 'icons', 'activity_lines', 'meal_lines', 'partner', 'station_lines', 'routeAddons')
            ->whereIn('id',$avaliableRouteIds)
            ->get();
        //dd($routes);

        return ($routes);
    }

    public static function getStationFrom()
    {
        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->join('stations', 'routes.station_from_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y')
            ->groupBy('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->Get();

        return $stations;
    }

    public static function getStationTo($stationFromId = NULL)
    {

        $stations = DB::table('routes')
            ->select('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->join('stations', 'routes.station_to_id', '=', 'stations.id')
            ->where('routes.isactive', 'Y')
            ->where('routes.station_from_id', $stationFromId)
            ->groupBy('stations.id', 'stations.name', 'stations.piername', 'stations.nickname')
            ->Get();

        return $stations;
    }

    public static function getRoutes($stationFromId, $stationToId)
    {
        $routes = Route::where('isactive', 'Y')
            ->with(['station_from', 'station_to'])
            ->where('station_from_id', $stationFromId)
            ->where('station_to_id', $stationToId)
            ->orderBy('station_from_id', 'ASC')
            ->orderBy('depart_time', 'ASC')
            ->get();

        return $routes;
    }
}