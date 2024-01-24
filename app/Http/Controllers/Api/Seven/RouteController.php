<?php

namespace App\Http\Controllers\Api\Seven;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\RouteResource;
use App\Models\Route;

class RouteController extends Controller
{
    public function getRouteByStationFrom(string $from_id = null) {
        $routes = Route::where('station_from_id', $from_id)->where('isactive', 'Y')->where('status', 'CO')
                        ->with('station_to')
                        ->orderBy('regular_price', 'ASC')
                        ->get();

        if($routes)
            return response()->json(['data' => RouteResource::collection($routes)], 200);
        else
            return response()->json(['data' => NULL], 200);
    }

    public function getRouteByStationTo(string $to_id = null) {
        $routes = Route::where('station_to_id', $to_id)->where('isactive', 'Y')->where('status', 'CO')
                        ->with('station_to')
                        ->orderBy('regular_price', 'ASC')
                        ->get();

        if($routes)
            return response()->json(['data' => RouteResource::collection($routes)], 200);
        else
            return response()->json(['data' => NULL], 200);
    }

    public function getRouteByStation(string $from_id = null, string $to_id = null) {
        $routes = Route::where('station_from_id', $from_id)->where('station_to_id', $to_id)
                        ->where('isactive', 'Y')->where('status', 'CO')
                        ->with('station_from', 'station_to', 'api_route')
                        ->orderBy('regular_price', 'ASC')
                        ->get();

        $routes = $this->whereApiActive($routes);

        if(isset($routes))
            return response()->json(['data' => RouteResource::collection($routes)], 200);
        else
            return response()->json(['data' => NULL], 200);
    }

    private function whereApiActive($routes) {
        $result = [];

        if(!empty($routes)) {
            foreach($routes as $route) {
                if($route->api_route->isactive == 'Y') {
                    array_push($result, $route);
                }
            }
        }

        return $result;
    }
}
