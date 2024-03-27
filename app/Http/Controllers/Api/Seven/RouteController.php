<?php

namespace App\Http\Controllers\Api\Seven;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\RouteResource;
use App\Models\Route;
use App\Models\ApiRoutes;
use App\Models\ApiMerchants;

use App\Helpers\RouteHelper;

class RouteController extends Controller
{
    protected $SEVEN;

    public function __construct() {
        $this->SEVEN = ApiMerchants::where('code', 'SEVEN')->where('isactive', 'Y')->first();
    }

    public function getRouteByStation(string $from_id = null, string $to_id = null) {
        if(isset($this->SEVEN)) {
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

        return $this->returnUnauthorized();
    }

    private function whereApiActive($routes) {
        $result = [];

        if(!empty($routes)) {
            foreach($routes as $route) {
                if(!is_null($route->api_route)) {
                    if($route->api_route->isactive == 'Y') {
                        array_push($result, $route);
                    }
                }
            }
        }

        return $result;
    }

    private function returnUnauthorized() {
        return response()->json(['data' => 'Unauthorized'], 401);
    }
}
