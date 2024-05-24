<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Models\Station;

use App\Helpers\RouteHelper;

class RouteController extends Controller
{
    public function searchRoute(string $from = null, string $to = null, $date = null) {
        // $routes = Route::where('station_from_id', $from)
        //                 ->where('station_to_id', $to)
        //                 ->where('isactive', 'Y')
        //                 ->where('status', 'CO')
        //                 ->with('station_from', 'station_to', 'icons', 'activity_lines', 'meal_lines', 'partner', 'station_lines', 'routeAddons')
        //                 ->get();

        $routes = RouteHelper::getAvaliableRoutes($from, $to, $date);
        $_station = ['depart' => $this->getStation($from), 'arrive' => $this->getStation($to), 'date' => $date];

        return response()->json(['data' => $routes, 'station' => $_station, 'status' => 'success']);
    }

    private function getStation($id) {
        $station = Station::find($id);
        $name = $station['name'];
        $pier = $station['piername'] != '' ? '('.$station['piername'].')' : '';
        return $name.' '.$pier;
    }

    public function getAllRoute() {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')
                        ->with('station_from', 'station_to')
                        ->get();

        return response()->json(['data' => RouteResource::collection($routes)], 200);
    }

    public function getRouteById($id) {
        $route = Route::findOrFail($id);
        $route->station_from;
        $route->station_to;

        return response()->json(['data' => new RouteResource($route)], 200);
    }
}
