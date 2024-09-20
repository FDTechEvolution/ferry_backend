<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Models\Route;
use App\Models\ApiRoutes;

class StationController extends Controller
{
    public function getStationFromRoute(Request $request) {
        $merchant = $request->attributes->get('merchant');
        $routes = ApiRoutes::where('api_merchant_id', $merchant)->with(['route'])->get();

        $stations['from'] = $this->stationCollection($routes, 'station_from');
        $stations['to'] = $this->stationCollection($routes, 'station_to');
        return response()->json(['data' => $stations], 200);
    }

    public function stationDepart(Request $request) {
        $merchant = $request->attributes->get('merchant');
        $routes = ApiRoutes::where('api_merchant_id', $merchant)->with(['route'])->get();

        $stations = $this->stationCollection($routes, 'station_from');
        return response()->json(['data' => $stations], 200);
    }

    public function stationArrive(Request $request, string $from_id = null) {
        $merchant = $request->attributes->get('merchant');
        $_routes = ApiRoutes::where('api_merchant_id', $merchant)->with(['route'])->get();

        $routes = $this->stationArriveFrom($_routes, $from_id);

        $stations = $this->stationCollection($routes, 'station_to');
        return response()->json(['data' => $stations], 200);
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

    private function stationCollection($routes, $station) {
        $stations = [];

        foreach($routes as $item) {
            $route = $item->route;
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
