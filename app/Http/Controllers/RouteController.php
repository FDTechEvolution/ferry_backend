<?php

namespace App\Http\Controllers;

use App\Models\RouteAddons;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use App\Models\Station;
use App\Models\Route;
use App\Models\RouteIcon;
use App\Models\RouteStationInfoLine;
use App\Models\Activity;
use App\Models\Addon;
use App\Models\RouteActivity;
use App\Models\RouteMeal;
use App\Models\RouteShuttlebus;
use App\Models\RouteLongtailboat;
use App\Models\BookingRoutes;
use App\Models\Fare;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $Type = 'route';
    protected $Meal = 'MEAL';
    protected $Activity = 'ACTV';
    protected $LongtailBoat = 'LBOAT';
    protected $ShuttleBus = 'SBUS';
    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>'
    ];

    public static function getRouteAddons(){
        $infos = [
            [
                'title' => 'Shuttle Bus',
                'key' => 'shuttle_bus',
            ],
            [
                'title' => 'Private Taxi',
                'key' => 'private_taxi',
            ],
            [
                'title' => 'Longtail boat',
                'key' => 'longtail_boat',
            ],
        ];

        return $infos;
    }

    public function index() {
        $routes = Route::where('status', 'CO')->with('station_from', 'station_to', 'icons')->orderBy('created_at', 'DESC')->get();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();
        

        $status = $this->_Status;
        return view('pages.route_control.index',
                    ['routes' => $routes, 'stations' => $stations, 'route_status' => $status, 'icons' => $icons]
                );
    }

    public function create() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->orderBy('name', 'ASC')->get();
        $partners = PartnerController::listPartners();

        $meals = Addon::where('type', $this->Meal)->where('isactive', 'Y')->where('status', 'CO')->get();
        $activities = Addon::where('type', $this->Activity)->where('isactive', 'Y')->where('status', 'CO')->get();
        $fare_child = Fare::where('name', 'Child')->first();
        $fare_infant = Fare::where('name', 'Infant')->first();

        $infos = $this->getRouteAddons();
        $stationjsons = $stations->toJson();
        //dd($stationjsons);

        return view('pages.route_control.create',
                    ['partners'=>$partners,'stations' => $stations, 'icons' => $icons, 'activities' => $activities, 'meals' => $meals,
                        'fare_child' => $fare_child, 'fare_infant' => $fare_infant,
                        'infos'=>$infos,'stationJsons'=>$stationjsons
                    ]
                );
    }

    public function edit(string $id = null) {
        $route = Route::find($id);

        if(is_null($route) || $route->status != 'CO')
            return redirect()->route('route-index')->withFail('This route not exist.');

        $route->routeAddons;

        if(sizeof($route->routeAddons) ==0){
            $infos = $this->getRouteAddons();
            foreach($infos as $info){
                $routeAddon = RouteAddons::create([
                    'name'=>$info['title'].' from',
                    'type'=>$info['key'],
                    'subtype'=>'from',
                    'message'=>null,
                    'mouseover'=>null,
                    'price'=>0,
                    'isactive'=>'N',
                    'isservice_charge'=>'N',
                    'route_id'=>$route->id
                ]);
                $routeAddon = RouteAddons::create([
                    'name'=>$info['title'].' to',
                    'type'=>$info['key'],
                    'subtype'=>'to',
                    'message'=>null,
                    'mouseover'=>null,
                    'price'=>0,
                    'isactive'=>'N',
                    'isservice_charge'=>'N',
                    'route_id'=>$route->id
                ]);
            }
            $route = Route::find($id);
            $route->routeAddons;
        }

        $route->station_lines;
        $route->activity_lines;
        $route->meal_lines;
        $route->shuttle_bus;
        $route->longtail_boat;



        $partners = PartnerController::listPartners();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();
        $activities = Addon::where('type', $this->Activity)->where('status', 'CO')->with('icon')->get();
        $meals = Addon::where('type', $this->Meal)->where('status', 'CO')->get();
        $fare_child = Fare::where('name', 'Child')->first();
        $fare_infant = Fare::where('name', 'Infant')->first();
        $infos = $this->getRouteAddons();

        $stationjsons = $stations->toJson();
       

        return view('pages.route_control.edit', [
            'route' => $route, 'icons' => $icons, 'stations' => $stations, 'activities' => $activities,
            'partners'=>$partners,'meals' => $meals, 'fare_child' => $fare_child, 'fare_infant' => $fare_infant,'infos'=>$infos,
            'stationJsons'=>$stationjsons
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'station_from' => 'required|string|min:36|max:36',
            'station_to' => 'required|string|min:36|max:36',
            'regular_price' => 'integer|nullable',
            'child_price' => 'integer|nullable',
            'infant_price' => 'integer|nullable'
        ]);

        //dd($request);

        $route = Route::create([
            'station_from_id' => $request->station_from,
            'station_to_id' => $request->station_to,
            'depart_time' => $request->depart_time,
            'arrive_time' => $request->arrive_time,
            'regular_price' => $request->regular_price,
            'child_price' => $request->child_price,
            'infant_price' => $request->infant_price,
            'isactive' => isset($request->status) ? 'Y' : 'N',
            'partner_id'=>$request->partner_id,
            'text_1'=>$request->text_1,
            'text_2'=>$request->text_2,
            'master_from_info' => isset($request->master_from_on) ? 'Y' : 'N',
            'master_to_info' => isset($request->master_to_on) ? 'Y' : 'N',
            'ispromocode' => isset($request->promocode) ? 'Y' : 'N',
            'master_from'=>$request->master_from,
            'master_to'=>$request->master_to
        ]);

        if($route) {
            $result = $this->routeIconStore($request->icons, $route->id);

            //if(isset($request->shuttle_bus_name)) $this->shuttlebusStore($request->shuttle_bus_name, $request->shuttle_bus_price, $request->shuttle_bus_description, $route->id);
            //if(isset($request->longtail_boat_name)) $this->longtailStore($request->longtail_boat_name, $request->longtail_boat_price, $request->longtail_boat_description, $route->id);
            if(isset($request->activity_id)) $this->routeActivityStore($request->activity_id, $route->id);
            if(isset($request->meal_id)) $this->routeMealStore($request->meal_id, $route->id);

            /*
            if($result) {
                if(isset($request->master_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_from_selected, 'from', 'Y');
                if(isset($request->master_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_to_selected, 'to', 'Y');
                if(isset($request->info_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_from_selected, 'from', 'N');
                if(isset($request->info_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_to_selected, 'to', 'N');
                return redirect()->route('route-index')->withSuccess('Route created...');
            }
            
            else return redirect()->back()->withFail('Something is wrong. Please try again.');
            */

            //Make route addons From
            $routeAddons = $this->getRouteAddons();
            foreach($routeAddons as $index => $routeAddonType){
                $routeAddon = RouteAddons::create([
                    'name'=>$routeAddonType['title'],
                    'type'=>$routeAddonType['key'],
                    'subtype'=>'from',
                    'message'=>$request[$routeAddonType['key'].'_text_from'],
                    'mouseover'=>$request[$routeAddonType['key'].'_mouseover_from'],
                    'price'=>$request[$routeAddonType['key'].'_price_from'],
                    'isactive'=>isset($request[$routeAddonType['key'].'_isactive_from'])?'Y':'N',
                    'isservice_charge'=>isset($request[$routeAddonType['key'].'_isservice_charge_from'])?'Y':'N',
                    'route_id'=>$route->id
                ]);
            }

            foreach($routeAddons as $index => $routeAddonType){
                $routeAddon = RouteAddons::create([
                    'name'=>$routeAddonType['title'],
                    'type'=>$routeAddonType['key'],
                    'subtype'=>'to',
                    'message'=>$request[$routeAddonType['key'].'_text_to'],
                    'mouseover'=>$request[$routeAddonType['key'].'_mouseover_to'],
                    'price'=>$request[$routeAddonType['key'].'_price_to'],
                    'isactive'=>isset($request[$routeAddonType['key'].'_isactive_to'])?'Y':'N',
                    'isservice_charge'=>isset($request[$routeAddonType['key'].'_isservice_charge_to'])?'Y':'N',
                    'route_id'=>$route->id
                ]);
            }

            return redirect()->route('route-index')->withSuccess('Route created...');

        }

        // Log::debug($request);

        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    private function shuttlebusStore($name, $price, $description, $route_id) {
        foreach($name as $key => $n) {
            $addon = Addon::create([
                        'name' => $n,
                        'isactive' => 'Y',
                        'code' => Str::random(6),
                        'type' => $this->ShuttleBus,
                        'amount' => $price[$key],
                        'description' => $description[$key],
                        'status' => 'CO'
                    ]);

            if($addon) {
                RouteShuttlebus::create([
                    'route_id' => $route_id,
                    'addon_id' => $addon->id
                ]);
            }
        }
    }

    private function longtailStore($name, $price, $description, $route_id) {
        foreach($name as $key => $n) {
            $addon = Addon::create([
                        'name' => $n,
                        'isactive' => 'Y',
                        'code' => Str::random(6),
                        'type' => $this->LongtailBoat,
                        'amount' => $price[$key],
                        'description' => $description[$key],
                        'status' => 'CO'
                    ]);

            if($addon) {
                RouteLongtailboat::create([
                    'route_id' => $route_id,
                    'addon_id' => $addon->id
                ]);
            }
        }
    }

    private function routeIconStore(string $icons = null, string $route_id = null) {
        $_icons = preg_split('/\,/', $icons);

        foreach($_icons as $index => $icon) {
            RouteIcon::create([
                'route_id' => $route_id,
                'icon_id' => $icon,
                'seq' => $index
            ]);
        }

        return true;
    }

    private function routeActivityStore($activities, $route_id) {
        foreach($activities as $activity) {
            RouteActivity::create([
                'route_id' => $route_id,
                'addon_id' => $activity
            ]);
        }
    }

    private function routeMealStore($meals, $route_id) {
        foreach($meals as $meal) {
            RouteMeal::create([
                'route_id' => $route_id,
                'addon_id' => $meal
            ]);
        }
    }

    private function routeActivityDestroy($route_id) {
        RouteActivity::where('route_id', $route_id)->delete();
    }

    private function routeMealDestroy($route_id) {
        RouteMeal::where('route_id', $route_id)->delete();
    }

    private function routeShuttleBusDestroy($route_id) {
        $route_shuttlebus = RouteShuttlebus::where('route_id', $route_id)->get();
        foreach($route_shuttlebus as $shuttlebus) {
            Addon::find($shuttlebus->addon_id)->delete();
        }
        RouteShuttlebus::where('route_id', $route_id)->delete();
    }

    private function routeLongtailBoatDestroy($route_id) {
        $route_longtailboat = RouteLongtailboat::where('route_id', $route_id)->get();
        foreach($route_longtailboat as $longtailboat) {
            Addon::find($longtailboat->addon_id)->delete();
        }
        RouteLongtailboat::where('route_id', $route_id)->delete();
    }

    private function storeRouteStationInfoLine(string $route_id = null, string $info_lines = null, string $type = null, string $ismaster = null) {
        $infos = preg_split('/\,/', $info_lines);

        foreach($infos as $info) {
            RouteStationInfoLine::create([
                'route_id' => $route_id,
                'station_infomation_id' => $info,
                'type' => $type,
                'ismaster' => $ismaster
            ]);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'station_from' => 'required|string|min:36|max:36',
            'station_to' => 'required|string|min:36|max:36',
            'regular_price' => 'integer|nullable',
            'child_price' => 'integer|nullable',
            'infant_price' => 'integer|nullable',
        ]);

        //dd($request);

        $route = Route::find($request->route_id);
            $route->station_from_id = $request->station_from;
            $route->station_to_id = $request->station_to;
            $route->depart_time = $request->depart_time;
            $route->arrive_time = $request->arrive_time;
            $route->regular_price = $request->regular_price;
            $route->child_price = $request->child_price;
            $route->infant_price = $request->infant_price;
            $route->isactive = isset($request->status) ? 'Y' : 'N';
            $route->partner_id = $request->partner_id;
            $route->text_1 = $request->text_1;
            $route->text_2 = $request->text_2;
            //$route->master_from_info = isset($request->master_from_on) ? 'Y' : 'N';
            //$route->master_to_info = isset($request->master_to_on) ? 'Y' : 'N';
            $route->ispromocode = isset($request->promocode) ? 'Y' : 'N';
            $route->master_from = $request->master_from;
            $route->master_to = $request->master_to;

        if($route->save()) {
            $this->routeIconDestroy($request->route_id);
            $result = $this->routeIconStore($request->icons, $request->route_id);
            $this->routeActivityDestroy($request->route_id);
            if(isset($request->activity_id)) $this->routeActivityStore($request->activity_id, $request->route_id);
            $this->routeMealDestroy($request->route_id);
            if(isset($request->meal_id)) $this->routeMealStore($request->meal_id, $request->route_id);

            //$this->routeShuttleBusDestroy($request->route_id);
            //if(isset($request->shuttle_bus_name)) $this->shuttlebusStore($request->shuttle_bus_name, $request->shuttle_bus_price, $request->shuttle_bus_description, $request->route_id);

            //$this->routeLongtailBoatDestroy($request->route_id);
            //if(isset($request->longtail_boat_name)) $this->longtailStore($request->longtail_boat_name, $request->longtail_boat_price, $request->longtail_boat_description, $request->route_id);

            if($result) {
                $this->clearAllRouteStationInfoLine($request->route_id);
                //if(isset($request->master_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_from_selected, 'from', 'Y');
                //if(isset($request->master_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_to_selected, 'to', 'Y');
                //if(isset($request->info_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_from_selected, 'from', 'N');
                //if(isset($request->info_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_to_selected, 'to', 'N');
                //return redirect()->route('route-index')->withSuccess('Route updated...');
            }

            //dd($request);

            //update route addons
            foreach($request->route_addons as $item){
                $routeAddon = RouteAddons::find($item['id']);
                $routeAddon->isactive = isset($item['isactive'])?'Y':'N';
                $routeAddon->isservice_charge = isset($item['isservice_charge'])?'Y':'N';
                $routeAddon->price = $item['price'];
                $routeAddon->mouseover = $item['mouseover'];
                $routeAddon->message = $item['message'];
                $routeAddon->save();
            }

            return redirect()->route('route-index')->withSuccess('Route updated...');
        }
        else return redirect()->route('route-index')->withFail('Something is wrong. Please try again.');
    }

    private function clearAllRouteStationInfoLine(string $route_id = null) {
        RouteStationInfoLine::where('route_id', $route_id)->delete();
    }

    private function routeIconDestroy($route_id) {
        RouteIcon::where('route_id', $route_id)->delete();
    }

    public function destroy(string $id = null) {
        $route = Route::find($id);
        $route_used = BookingRoutes::where('route_id', $id)->first();

        if(is_null($route) || $route->status != 'CO')
            return redirect()->route('route-index')->withFail('This route not exist.');

        if(isset($route_used)) {
            $route->isactive = 'N';
            $route->status = 'VO';
            if($route->save()) return redirect()->route('route-index')->withSuccess('Route deleted...');
            else return redirect()->route('route-index')->withFail('Something is wrong. Please try again.');
        }
        else {
            RouteActivity::where('route_id', $id)->delete();
            RouteMeal::where('route_id', $id)->delete();
            RouteIcon::where('route_id', $id)->delete();
            RouteStationInfoLine::where('route_id', $id)->delete();

            $shuttle_bus = RouteShuttlebus::where('route_id', $id)->get();
            if(sizeof($shuttle_bus) > 0) {
                foreach($shuttle_bus as $bus) { Addon::find($bus->addon_id)->delete(); }
            }

            $longtail_boat = RouteLongtailboat::where('route_id', $id)->get();
            if(sizeof($longtail_boat) > 0) {
                foreach($longtail_boat as $boat) { Addon::find($boat->addon_id)->delete(); }
            }

            RouteShuttlebus::where('route_id', $id)->delete();
            RouteLongtailboat::where('route_id', $id)->delete();
            $route->delete();

            return redirect()->route('route-index')->withSuccess('Route deleted...');
        }
    }

    public function getRouteInfo(string $route_id = null, string $station_id = null, string $type = null) {
        $routes = null;
        if($type == 'from')
            $routes = Route::where('id', $route_id)->where('station_from_id', $station_id)->with('station_lines')->first();
        if($type == 'to')
            $routes = Route::where('id', $route_id)->where('station_to_id', $station_id)->with('station_lines')->first();

        return response()->json(['data' => $routes, 'status' => 'success']);
    }

    public function destroySelected(Request $request) {
        $routes = preg_split('/\,/', $request->route_selected);

        foreach($routes as $route) {
            $_route = Route::find($route);
            $_route->isactive = 'N';
            $_route->status = 'VO';
            $_route->save();
        }

        return redirect()->route('route-index')->withSuccess('Route updated...');
    }

    public function pdfSelected(Request $request) {
        if(!isset($request->route_selected) || $request->isMethod('get'))
            return redirect()->route('route-index')->withFail('No route selected.');

        $routes = preg_split('/\,/', $request->route_selected);
        $_routes = [];

        foreach($routes as $route) {
            $_route = Route::find($route);
            array_push($_routes, $_route);
        }

        return view('pages.route_control.pdf', ['routes' => $_routes]);
    }
}
