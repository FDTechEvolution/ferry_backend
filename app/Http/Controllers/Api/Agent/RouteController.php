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

    public function getRouteByStation(Request $request, string $from_id = null, string $to_id = null) {
        $merchant = $request->attributes->get('merchant');
        $_merchant = ApiMerchants::find($merchant);
        $routes = ApiRoutes::where('api_merchant_id', $merchant)->with('route')->get();

        $_routes = $this->routeFromAndToCondition($routes, $from_id, $to_id);

        if(sizeof($_routes) > 0) {
            $data = $this->setupRoute($_routes, $_merchant);
            return response()->json(['data' => $data], 200);
        }
        else
            return response()->json(['data' => NULL], 200);
    }

    private function setupRoute($route, $merchant) {
        $route = $this->discount($route);
        $route = $this->onTop($route);
        return $this->routeCollection($route, $merchant);
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

    private function routeCollection($route, $merchant) {
        $result = [];
        foreach($route as $item) {
            $_route = [
                'id' => $item->id,
                'station_from' => [
                    'id' => $item->route->station_from_id,
                    'name' => $item->route->station_from->name,
                    'piername' => $item->route->station_from->piername,
                    'nickname' => $item->route->station_from->nickname,
                ],
                'station_to' => [
                    'id' => $item->route->station_to_id,
                    'name' => $item->route->station_to->name,
                    'piername' => $item->route->station_to->piername,
                    'nickname' => $item->route->station_to->nickname,
                ],
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

    private function routeFromAndToCondition($routes, $from_id, $to_id) {
        $route = [];
        foreach($routes as $item) {
            if($item->route->station_from_id == $from_id && $item->route->station_to_id == $to_id) {
                array_push($route, $item);
            }
        }

        return $route;
    }
}
