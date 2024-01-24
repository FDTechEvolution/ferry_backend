<?php

namespace App\Http\Controllers\Api\Seven;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;
use App\Models\Route;

class StationController extends Controller
{
    public function getStationFromRoute() {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')
                ->with('station_from', 'station_to')
                ->get();

        $stations['from'] = $this->stationCollection($routes, 'station_from');
        $stations['to'] = $this->stationCollection($routes, 'station_to');
        return response()->json(['data' => $stations], 200);
    }

    public function stationDepart() {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')
                        ->with('station_from')
                        ->get();

        $stations = $this->stationCollection($routes, 'station_from');
        return response()->json(['data' => $stations], 200);
    }

    public function stationArrive(string $from_id = null) {
        $routes = Route::where('station_from_id', $from_id)
                            ->where('isactive', 'Y')->where('status', 'CO')
                            ->with('station_to')
                            ->get();

        $stations = $this->stationCollection($routes, 'station_to');
        return response()->json(['data' => $stations], 200);
    }

    private function stationCollection($routes, $station) {
        $stations = [];

        foreach($routes as $route) {
            if($route[$station]['section']['isactive'] == 'Y') {
                $_station = [
                    'id' => $route[$station]['id'],
                    'name' => $route[$station]['name'],
                    'name_th' => $route[$station]['thai_name'],
                    'piername' => $route[$station]['piername'],
                    'piername_th' => $route[$station]['thai_piername'],
                    'nickname' => $route[$station]['nickname']
                ];
                if(!in_array($_station, $stations)) array_push($stations, $_station);
            }
        }

        return $stations;
    }
}
