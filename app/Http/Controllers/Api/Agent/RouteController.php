<?php

namespace App\Http\Controllers\Api\Agent;

use App\Helpers\RouteHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Helpers\AgentHelper;
use App\Models\ApiMerchants;
use App\Models\ApiRoutes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function getRouteByStation(Request $request, string $from_id = null, string $to_id = null,$depart='') {
        $merchant = $request->attributes->get('merchant');
        $_merchant = ApiMerchants::find($merchant);
        $routes = ApiRoutes::where('api_merchant_id', $merchant)->with('route')->get();

        if(empty($depart)){
            $depart = Carbon::now()->format('Y-m-d');
        }


        $activeRoutes = RouteHelper::getAvaliableRoutes($from_id,$to_id,$depart);

        $result = [];
        foreach($activeRoutes as $item) {
            //$apiRoute = ApiRoutes::where('api_merchant_id', $merchant)->where('route_id',$item->id)->with('route')->first();
            $sql = 'select
	rc.seat,apir.regular_price,apir.child_price,apir.infant_price,apir.seat as default_seat
from
	api_routes apir
    left join route_calendars rc on (apir.id = rc.api_route_id and rc.date = :date)
where
	apir.route_id = :route_id
    and apir.api_merchant_id = :api_merchant_id';

            $apiRoutes = DB::select($sql,['date'=>$depart,'route_id'=>$item->id,'api_merchant_id'=>$merchant]);

            if(sizeof($apiRoutes) ==0){
                continue;
            }
            $apiRoute = $apiRoutes[0];
            //Log::debug($_merchant);
            //get calendar setting
            $soldSeat = AgentHelper::getDateSoldByAgent($merchant,$depart,$item->id);

            $maxSeat = (int)empty($apiRoute->seat)?$apiRoute->default_seat:$apiRoute->seat;

            if(($maxSeat-$soldSeat['sold_seat'])<1 ){
                continue;
            }

            $_route = [
                'id' => $item->id,
                'depart_time' => $item->depart_time,
                'arrive_time' => $item->arrive_time,
                'boat_type'=>$item->boat_type,
                'date'=>$depart,
                'seat' => $maxSeat,
                'sold_seat'=> $soldSeat['sold_seat'],
                'avaliable_seat'=> $maxSeat-$soldSeat['sold_seat'],
                'regular_price'=>$_merchant->isopenregular=='Y'?(float)$apiRoute->regular_price:0,
                'child_price'=>$_merchant->isopenchild=='Y'?(float)$apiRoute->child_price:0,
                'infant_price'=>$_merchant->isopeninfant=='Y'?(float)$apiRoute->infant_price:0,
                'station_from' => [
                    'id' => $item->station_from_id,
                    'name' => $item->station_from->name,
                    'th_name'=>$item->station_from->thai_name,
                    'piername' => $item->station_from->piername,
                    'thai_piername' => $item->station_from->thai_piername,
                    'nickname' => $item->station_from->nickname,
                ],
                'station_to' => [
                    'id' => $item->station_to_id,
                    'name' => $item->station_to->name,
                    'th_name'=>$item->station_to->thai_name,
                    'piername' => $item->station_to->piername,
                    'thai_piername' => $item->station_to->thai_piername,
                    'nickname' => $item->station_to->nickname,
                ],

            ];

            array_push($result, $_route);
        }

        if(empty($result)){
            return response()->json(['data' => $result,'msg'=>'no route avaliable on '.$depart], 200);
        }
        return response()->json(['data' => $result], 200);
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
                'id' => $item->route->id,
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
                'seat' => $item->seat,
                'boat_type'=>$item->route->boat_type
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
