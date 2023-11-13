<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Models\Route;

class StationsController extends Controller
{
    public function getStations() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => $stations, 'status' => 'success']);
    }

    // 7
    public function getAllStation() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => StationResource::collection($stations)], 200);
    }

    public function getStationFromRoute() {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')
                ->with('station_from', 'station_to')
                ->get();

        $stations = $this->groupStation($routes);
        return response()->json(['data' => $stations], 200);
    }

    private function groupStation($routes) {
        $stations = [
            'from' => [],
            'to' => []
        ];

        foreach($routes as $route) {
            $_from = [
                'id' => $route['station_from']['id'],
                'name' => $route['station_from']['name'],
                'piername' => $route['station_from']['piername'],
                'nickname' => $route['station_from']['nickname']
            ];
            if(!in_array($_from, $stations['from'])) array_push($stations['from'], $_from);
            
            $_to = [
                'id' => $route['station_to']['id'],
                'name' => $route['station_to']['name'],
                'piername' => $route['station_to']['piername'],
                'nickname' => $route['station_to']['nickname']
            ];
            if(!in_array($_to, $stations['to'])) array_push($stations['to'], $_to);
        }

        return $stations;
    }
}
