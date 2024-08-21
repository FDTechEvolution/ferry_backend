<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Models\Route;
use App\Models\ApiRoutes;
use App\Models\ApiMerchants;

class StationController extends Controller
{
    protected $SEVEN;

    public function __construct() {
        //$this->SEVEN = ApiMerchants::where('code', 'SEVEN')->where('isactive', 'Y')->first();
    }

    public function getStationFromRoute() {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')
                ->with('station_from', 'station_to')
                ->get();
        //Log::debug($routes);

        $stations['from'] = $this->stationCollection($routes, 'station_from');
        $stations['to'] = $this->stationCollection($routes, 'station_to');
        return response()->json(['data' => $stations], 200);
    }

    public function stationDepart() {
        //if(isset($this->SEVEN)) {
            $routes = ApiRoutes::where('api_merchant_id', $this->SEVEN->id)->with(['route'])->get();
            $stations = $this->stationCollection($routes, 'station_from');
            return response()->json(['data' => $stations], 200);
        //}

        //$this->returnUnauthorized();
    }

    public function stationArrive(string $from_id = null) {
        //if(isset($this->SEVEN)) {
            $_routes = ApiRoutes::where('api_merchant_id', $this->SEVEN->id)->with(['route'])->get();
            $routes = $this->stationArriveFrom($_routes, $from_id);

            $stations = $this->stationCollection($routes, 'station_to');
            return response()->json(['data' => $stations], 200);
        //}

       // $this->returnUnauthorized();
    }

    private function stationArriveFrom($route, $from_id) {
        $_route = [];
        foreach($route as $item) {
            if($item->route->station_from_id == $from_id) {
                array_push($_route, $item);
            }
        }

        return $_route;
    }

    private function returnUnauthorized() {
        return response()->json(['data' => 'Unauthorized'], 401);
    }

    private function stationCollection($routes, $station) {
        $stations = [];

        foreach($routes as $item) {
            $route = $item;
            //Log::debug($item);
            if(!isset($route->$station->section)){
                continue;
                //Log::debug($item);
            }
            if($route->$station->section->isactive == 'Y') {
                $_station = [
                    'id' => $route->$station->id,
                    'name' => $route->$station->name,
                    'name_th' => $route->$station->thai_name,
                    'piername' => $route->$station->piername,
                    'piername_th' => $route->$station->thai_piername,
                    'nickname' => $route->$station->nickname
                ];
                if(!in_array($_station, $stations)) array_push($stations, $_station);
            }
        }

        return $stations;
    }
}
