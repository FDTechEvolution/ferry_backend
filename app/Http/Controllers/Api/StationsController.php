<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Models\Route;
use App\Models\Section;

class StationsController extends Controller
{
    public function getStations() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => $stations, 'status' => 'success']);
    }

    public function getStationByNickname(string $nickname) {
        $station = Station::where('nickname', $nickname)->with(['image'])->first();

        return response()->json(['data' => $station, 'status' => 'success']);
    }

    public function getToStation(string $from_id) {
        $station = Route::where('station_from_id', $from_id)->where('isactive', 'Y')->where('status', 'CO')->with('station_to')->get();
        $stations = $this->groupStation($station);
        return response()->json(['data' => $stations], 200);
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
        // Log::debug($stations);
        return response()->json(['data' => $stations], 200);
    }

    private function groupStation($routes) {
        $stations = [
            'from' => [],
            'to' => []
        ];

        foreach($routes as $route) {
            if($route['station_from']['section']['isactive'] == 'Y') {
                $_from = [
                    'id' => $route['station_from']['id'],
                    'name' => $route['station_from']['name'],
                    'piername' => $route['station_from']['piername'],
                    'nickname' => $route['station_from']['nickname'],
                    'section' => $route['station_from']['section']['name'],
                    'sort' => $route['station_from']['sort'],
                    's_sort' => $route['station_from']['section']['sort'],
                    'col' => $route['station_from']['section']['sectionscol']
                ];
                if(!in_array($_from, $stations['from'])) array_push($stations['from'], $_from);
            }

            if($route['station_to']['section']['isactive'] == 'Y') {
                $_to = [
                    'id' => $route['station_to']['id'],
                    'name' => $route['station_to']['name'],
                    'piername' => $route['station_to']['piername'],
                    'nickname' => $route['station_to']['nickname'],
                    'section' => $route['station_to']['section']['name'],
                    'sort' => $route['station_to']['sort'],
                    's_sort' => $route['station_to']['section']['sort'],
                    'col' => $route['station_to']['section']['sectionscol']
                ];
                if(!in_array($_to, $stations['to'])) array_push($stations['to'], $_to);
            }
        }

        return $stations;
    }
}
