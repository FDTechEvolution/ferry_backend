<?php

namespace App\Http\Controllers\Api\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Models\ApiMerchants;
use App\Models\ApiRoutes;

class RouteController extends Controller
{
    public function getRoutes(Request $request) {
        $merchant = $request->attributes->get('merchant');
        $data = [];
        $_merchant = ApiMerchants::find($merchant);
        $route = ApiRoutes::where('api_merchant_id', $merchant)->with(['route'])->get();

        $data = $this->setupRoute($route, $_merchant);

        return response()->json(['data' => $data], 200);
    }

    private function setupRoute($route, $merchant) {
        $route = $this->discount($route);
        $route = $this->onTop($route);
        return $this->isOpen($route, $merchant);
    }

    private function discount($route) {
        foreach($route as $item) {
            $item->regular_price = intval($item->route->regular_price) * (100 - intval($item->discount)) / 100;
            $item->child_price = intval($item->route->child_price) * (100 - intval($item->discount)) / 100;
            $item->infant_price = intval($item->route->infant_price) * (100 - intval($item->discount)) / 100;
        }

        return $route;
    }

    private function onTop($route) {
        foreach($route as $item) {
            $item->regular_price = number_format(intval($item->regular_price) * (100 - intval($item->ontop)) / 100);
            $item->child_price = number_format(intval($item->child_price) * (100 - intval($item->ontop)) / 100);
            $item->infant_price = number_format(intval($item->infant_price) * (100 - intval($item->ontop)) / 100);
        }

        return $route;
    }

    private function isOpen($route, $merchant) {
        $result = [];
        foreach($route as $item) {
            $_route = [
                'id' => $item->id,
                'station_from_id' => $item->route->station_from_id,
                'station_to_id' => $item->route->station_to_id,
                'station_from_name' => $item->route->station_from->name,
                'station_from_piername' => $item->route->station_from->piername,
                'station_from_nickname' => $item->route->station_from->nickname,
                'station_to_name' => $item->route->station_to->name,
                'station_to_piername' => $item->route->station_to->piername,
                'station_to_nickname' => $item->route->station_to->nickname,
                'depart_time' => $item->route->depart_time,
                'arrive_time' => $item->route->arrive_time,
                'seat' => $item->seat
            ];

            if($merchant->isopenregular == 'Y') $_route['regular_price'] = $item->regular_price;
            if($merchant->isopenchild == 'Y') $_route['cild_price'] = $item->child_price;
            if($merchant->isopeninfant == 'Y') $_route['infant_price'] = $item->infant_price;

            array_push($result, $_route);
        }

        return $result;
    }

    public function getRouteByStationFrom(Request $request, string $from_id = null) {
        $merchant = $request->attributes->get('merchant');
        $data = [];
        $_merchant = ApiMerchants::find($merchant);
        $routes = ApiRoutes::where('api_merchant_id', $merchant)->with(['route'])->get();

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
