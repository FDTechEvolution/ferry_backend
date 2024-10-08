<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Models\PromotionLines;
use App\Models\RouteAddons;
use App\Models\RouteSchedules;
use App\Models\Section;
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
use App\Models\ApiMerchants;
use App\Models\ApiRoutes;

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
        'Y' => '<i class="fa-solid fa-circle text-success"></i>',
        'N' => '<i class="fa-solid fa-circle text-secondary"></i>',
    ];

    public static function getRouteAddons()
    {
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

    public function index()
    {
        $stationFromId = request()->station_from;
        $stationToId = request()->station_to;

        $stationFroms = RouteHelper::getSectionStationFrom(true);

        $routes = Route::where('status', 'CO')
            ->with('station_from', 'station_from.section', 'station_to', 'icons', 'routeAddons', 'activity_lines', 'meal_lines', 'partner');
        if(empty($stationFromId) || $stationFromId == ''){
            foreach($stationFroms as $seaction){
                if(sizeof($seaction->stations) !=0){
                    $stationFromId = $seaction->stations[0]->id;
                    break;
                }
            }

            $routes = $routes->where('station_from_id',$stationFromId);
        }else{
            if($stationFromId != ''){
                $routes = $routes->where('station_from_id',$stationFromId);
            }
        }

        if(empty($stationToId) || $stationToId == ''){
            $stationToId = '';
        }else{
            $routes = $routes->where('station_to_id',$stationToId);
        }
        $stationTos = RouteHelper::getSectionStationTo(true,$stationFromId);

        $routes = $routes->orderBy('depart_time', 'ASC')->get();
        //dd($routes);

        $newRoutes = [];
        foreach($routes as $index => $route){
            $a = $route->station_from->section->sort.$route->station_from->sort;
            $b = $route->station_to->section->sort.$route->station_to->sort;
            $route['key'] = $a.$b.date('Hi', strtotime($route->depart_time));

            array_push($newRoutes,$route);
        }

        $key_values = array_column($newRoutes, 'key');
        array_multisort($key_values, SORT_ASC, $newRoutes);

        $icons = DB::table('icons')->where('type', $this->Type)->get();

        $status = $this->_Status;

        return view(
            'pages.route_control.index',[
                'routes' => $newRoutes,
                'route_status' => $status,
                'icons' => $icons,
                'stationFroms'=>$stationFroms,
                'stationTos'=>$stationTos,
                'stationFromId'=>$stationFromId,
                'stationToId'=>$stationToId
            ],
        );
    }

    public function create()
    {
        $stations = Station::get();
        $sections = RouteHelper::getSectionStationFrom();
        $icons = DB::table('icons')->where('type', $this->Type)->orderBy('name', 'ASC')->get();
        $partners = PartnerController::listPartners();
        $icons = $this->setRouteIconGroup($icons);

        $meals = Addon::where('type', $this->Meal)->where('isactive', 'Y')->where('status', 'CO')->get();
        $activities = Addon::where('type', $this->Activity)->where('isactive', 'Y')->where('status', 'CO')->get();
        $fare_child = Fare::where('name', 'Child')->first();
        $fare_infant = Fare::where('name', 'Infant')->first();

        $infos = $this->getRouteAddons();
        $stationjsons = $stations->toJson();
        //dd($stationjsons);

        return view(
            'pages.route_control.create',
            [
                'partners' => $partners,
                'stations' => $stations,
                'sections'=>$sections,
                'icons' => $icons,
                'activities' => $activities,
                'meals' => $meals,
                'fare_child' => $fare_child,
                'fare_infant' => $fare_infant,
                'infos' => $infos,
                'stationJsons' => $stationjsons,
            ],
        );
    }

    private function setRouteIconGroup($icons) {
        $group_1 = [];
        $group_2 = [];

        foreach($icons->toArray() as $ic) {
            if(strpos($ic->name, '(1)') != '') {
                array_push($group_2, $ic);
            }
            else array_push($group_1, $ic);
        }

        return array_merge($group_1, $group_2);
    }

    public function edit(string $id = null)
    {
        $route = Route::find($id);

        if (is_null($route) || $route->status != 'CO')
            return redirect()->route('route-index')->withFail('This route not exist.');

        $route->routeAddonEdit;

        if (sizeof($route->routeAddonEdit) == 0) {
            $_route = Route::where('id', $id)->with('station_from', 'station_to')->first();



            $infos = $this->getRouteAddons();
            $stationFrom = $route->station_from;
            $stationTo = $route->station_to;

            $route->master_from = $stationFrom->master_from;
            $route->master_to = $stationTo->master_to;
            $route->save();

            foreach ($infos as $info) {
                $isactive = 'N';
                if (!is_null($stationFrom[$info['key'] . '_text']) || !is_null($stationFrom[$info['key'] . '_mouseover'])) {
                    $isactive = 'Y';
                }
                $routeAddon = RouteAddons::create([
                    'name' => $info['title'] . ' from',
                    'type' => $info['key'],
                    'subtype' => 'from',
                    'message' => $stationFrom[$info['key'] . '_text'],
                    'mouseover' => $stationFrom[$info['key'] . '_mouseover'],
                    'price' => $stationFrom[$info['key'] . '_price'],
                    'isactive' => $isactive,
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);

                $isactive = 'N';
                if (!is_null($stationTo[$info['key'] . '_text']) || !is_null($stationTo[$info['key'] . '_mouseover'])) {
                    $isactive = 'Y';
                }
                $routeAddon = RouteAddons::create([
                    'name' => $info['title'] . ' to',
                    'type' => $info['key'],
                    'subtype' => 'to',
                    'message' => $stationTo[$info['key'] . '_text'],
                    'mouseover' => $stationTo[$info['key'] . '_mouseover'],
                    'price' => $stationTo[$info['key'] . '_price'],
                    'isactive' => $isactive,
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);
            }
            $route = Route::find($id);
            //$route->routeAddons;
        }

        $route->station_lines;
        $route->activity_lines;
        $route->meal_lines;
        $route->shuttle_bus;
        $route->longtail_boat;



        $partners = PartnerController::listPartners();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->orderBy('name', 'ASC')->get();
        $activities = Addon::where('type', $this->Activity)->where('status', 'CO')->with('icon')->get();
        $meals = Addon::where('type', $this->Meal)->where('status', 'CO')->get();
        $fare_child = Fare::where('name', 'Child')->first();
        $fare_infant = Fare::where('name', 'Infant')->first();
        $infos = $this->getRouteAddons();

        $stationjsons = $stations->toJson();
        $icons = $this->setRouteIconGroup($icons);

        return view('pages.route_control.edit', [
            'route' => $route,
            'icons' => $icons,
            'stations' => $stations,
            'activities' => $activities,
            'partners' => $partners,
            'meals' => $meals,
            'fare_child' => $fare_child,
            'fare_infant' => $fare_infant,
            'infos' => $infos,
            'stationJsons' => $stationjsons,
        ]);
    }

    //private function for dev only
    private function updateAddonManual()
    {
        //private_taxi
        $type = 'private_taxi';
        $routes = Route::where('isactive', 'Y')->with('routeAddonEdit', 'station_from', 'station_to')->get();

        foreach ($routes as $route) {
            //dd($route);
            $hasItem = false;
            foreach ($route->routeAddonEdit as $index => $item) {
                if ($item->type == $type) {
                    $hasItem = true;
                    break;
                }
            }

            if (!$hasItem) {
                $routeAddon = RouteAddons::create([
                    'name' => 'Private Taxi from',
                    'type' => $type,
                    'subtype' => 'from',
                    'message' => $route['station_from'][$type . '_text'],
                    'mouseover' => $route['station_from'][$type . '_mouseover'],
                    'price' => $route['station_from'][$type . '_price'],
                    'isactive' => 'N',
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);

                $routeAddon = RouteAddons::create([
                    'name' => 'Private Taxi to',
                    'type' => $type,
                    'subtype' => 'to',
                    'message' => $route['station_to'][$type . '_text'],
                    'mouseover' => $route['station_to'][$type . '_mouseover'],
                    'price' => $route['station_to'][$type . '_price'],
                    'isactive' => 'N',
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);

            }
        }
    }

    private function make($routes)
    {

        $count = 0;
        foreach ($routes as $route) {

            if (sizeof($route->routeAddons) > 0) {
                continue;
            }

            if ($count > 100) {
                return true;
            }

            $infos = $this->getRouteAddons();
            $stationFrom = $route->station_from;
            $stationTo = $route->station_to;

            $route->master_from = $stationFrom->master_from;
            $route->master_to = $stationTo->master_to;
            $route->save();

            foreach ($infos as $info) {
                $isactive = 'N';
                if (!is_null($stationFrom[$info['key'] . '_text']) || !is_null($stationFrom[$info['key'] . '_mouseover'])) {
                    $isactive = 'Y';
                }
                $routeAddon = RouteAddons::create([
                    'name' => $info['title'] . ' from',
                    'type' => $info['key'],
                    'subtype' => 'from',
                    'message' => $stationFrom[$info['key'] . '_text'],
                    'mouseover' => $stationFrom[$info['key'] . '_mouseover'],
                    'price' => $stationFrom[$info['key'] . '_price'],
                    'isactive' => $isactive,
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);

                $isactive = 'N';
                if (!is_null($stationTo[$info['key'] . '_text']) || !is_null($stationTo[$info['key'] . '_mouseover'])) {
                    $isactive = 'Y';
                }
                $routeAddon = RouteAddons::create([
                    'name' => $info['title'] . ' to',
                    'type' => $info['key'],
                    'subtype' => 'to',
                    'message' => $stationTo[$info['key'] . '_text'],
                    'mouseover' => $stationTo[$info['key'] . '_mouseover'],
                    'price' => $stationTo[$info['key'] . '_price'],
                    'isactive' => $isactive,
                    'isservice_charge' => 'N',
                    'route_id' => $route->id,
                ]);
            }
            $count++;
        }
    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'station_from' => 'required|string|min:36|max:36',
            'station_to' => 'required|string|min:36|max:36',
            'regular_price' => 'integer|nullable',
            'child_price' => 'integer|nullable',
            'infant_price' => 'integer|nullable',
        ]);



        $route = Route::create([
            'station_from_id' => $request->station_from,
            'station_to_id' => $request->station_to,
            'depart_time' => $request->depart_time,
            'arrive_time' => $request->arrive_time,
            'regular_price' => $request->regular_price,
            'child_price' => $request->child_price,
            'infant_price' => $request->infant_price,
            'isactive' => isset($request->status) ? 'Y' : 'N',
            'partner_id' => $request->partner_id,
            'text_1' => $request->text_1,
            'text_2' => $request->text_2,
            'master_from_info' => isset($request->master_from_info) ? 'Y' : 'N',
            'master_to_info' => isset($request->master_to_info) ? 'Y' : 'N',
            'ispromocode' => isset($request->promocode) ? 'Y' : 'N',
            'master_from' => $request->master_from,
            'master_to' => $request->master_to,
            'isinformation_from_active' => isset($request->isinformation_from_active) ? 'Y' : 'N',
            'isinformation_to_active' => isset($request->isinformation_to_active) ? 'Y' : 'N',
            'information_from' => $request->information_from,
            'information_to' => $request->information_to,
        ]);

        if ($route) {
            $result = $this->routeIconStore($request->icons, $route->id);

            //if(isset($request->shuttle_bus_name)) $this->shuttlebusStore($request->shuttle_bus_name, $request->shuttle_bus_price, $request->shuttle_bus_description, $route->id);
            //if(isset($request->longtail_boat_name)) $this->longtailStore($request->longtail_boat_name, $request->longtail_boat_price, $request->longtail_boat_description, $route->id);
            if (isset($request->activity_id))
                $this->routeActivityStore($request->activity_id, $route->id);
            if (isset($request->meal_id))
                $this->routeMealStore($request->meal_id, $route->id);

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
            foreach ($routeAddons as $index => $routeAddonType) {
                $routeAddon = RouteAddons::create([
                    'name' => $routeAddonType['title'] . ' from',
                    'type' => $routeAddonType['key'],
                    'subtype' => 'from',
                    'message' => $request[$routeAddonType['key'] . '_text_from'],
                    'mouseover' => $request[$routeAddonType['key'] . '_mouseover_from'],
                    'price' => $request[$routeAddonType['key'] . '_price_from'],
                    'isactive' => isset($request[$routeAddonType['key'] . '_isactive_from']) ? 'Y' : 'N',
                    'isservice_charge' => isset($request[$routeAddonType['key'] . '_isservice_charge_from']) ? 'Y' : 'N',
                    'route_id' => $route->id,
                ]);
            }

            foreach ($routeAddons as $index => $routeAddonType) {
                $routeAddon = RouteAddons::create([
                    'name' => $routeAddonType['title'] . ' to',
                    'type' => $routeAddonType['key'],
                    'subtype' => 'to',
                    'message' => $request[$routeAddonType['key'] . '_text_to'],
                    'mouseover' => $request[$routeAddonType['key'] . '_mouseover_to'],
                    'price' => $request[$routeAddonType['key'] . '_price_to'],
                    'isactive' => isset($request[$routeAddonType['key'] . '_isactive_to']) ? 'Y' : 'N',
                    'isservice_charge' => isset($request[$routeAddonType['key'] . '_isservice_charge_to']) ? 'Y' : 'N',
                    'route_id' => $route->id,
                ]);
            }

            $this->createApiRoute($route->id, $route->regular_price);

            return redirect()->route('route-index')->withSuccess('Route created...');

        }

        // Log::debug($request);

        return redirect()->back()->withFail('Something is wrong. Please try again.');
    }

    private function createApiRoute($route_id, $route_price)
    {
        $api_merchant = ApiMerchants::where('code', 'SEVEN')->get();
        foreach ($api_merchant as $merchant) {
            ApiRoutes::create([
                'route_id' => $route_id,
                'regular_price' => $route_price,
                'totalamt' => $route_price,
                'api_merchant_id' => $merchant->id,
            ]);
        }
    }

    private function shuttlebusStore($name, $price, $description, $route_id)
    {
        foreach ($name as $key => $n) {
            $addon = Addon::create([
                'name' => $n,
                'isactive' => 'Y',
                'code' => Str::random(6),
                'type' => $this->ShuttleBus,
                'amount' => $price[$key],
                'description' => $description[$key],
                'status' => 'CO',
            ]);

            if ($addon) {
                RouteShuttlebus::create([
                    'route_id' => $route_id,
                    'addon_id' => $addon->id,
                ]);
            }
        }
    }

    private function longtailStore($name, $price, $description, $route_id)
    {
        foreach ($name as $key => $n) {
            $addon = Addon::create([
                'name' => $n,
                'isactive' => 'Y',
                'code' => Str::random(6),
                'type' => $this->LongtailBoat,
                'amount' => $price[$key],
                'description' => $description[$key],
                'status' => 'CO',
            ]);

            if ($addon) {
                RouteLongtailboat::create([
                    'route_id' => $route_id,
                    'addon_id' => $addon->id,
                ]);
            }
        }
    }

    private function routeIconStore(string $icons = null, string $route_id = null)
    {
        $_icons = preg_split('/\,/', $icons);

        foreach ($_icons as $index => $icon) {
            RouteIcon::create([
                'route_id' => $route_id,
                'icon_id' => $icon,
                'seq' => $index,
            ]);
        }

        return true;
    }

    private function routeActivityStore($activities, $route_id)
    {
        foreach ($activities as $activity) {
            RouteActivity::create([
                'route_id' => $route_id,
                'addon_id' => $activity,
            ]);
        }
    }

    private function routeMealStore($meals, $route_id)
    {
        foreach ($meals as $meal) {
            RouteMeal::create([
                'route_id' => $route_id,
                'addon_id' => $meal,
            ]);
        }
    }

    private function routeActivityDestroy($route_id)
    {
        RouteActivity::where('route_id', $route_id)->delete();
    }

    private function routeMealDestroy($route_id)
    {
        RouteMeal::where('route_id', $route_id)->delete();
    }

    private function routeShuttleBusDestroy($route_id)
    {
        $route_shuttlebus = RouteShuttlebus::where('route_id', $route_id)->get();
        foreach ($route_shuttlebus as $shuttlebus) {
            Addon::find($shuttlebus->addon_id)->delete();
        }
        RouteShuttlebus::where('route_id', $route_id)->delete();
    }

    private function routeLongtailBoatDestroy($route_id)
    {
        $route_longtailboat = RouteLongtailboat::where('route_id', $route_id)->get();
        foreach ($route_longtailboat as $longtailboat) {
            Addon::find($longtailboat->addon_id)->delete();
        }
        RouteLongtailboat::where('route_id', $route_id)->delete();
    }

    private function storeRouteStationInfoLine(string $route_id = null, string $info_lines = null, string $type = null, string $ismaster = null)
    {
        $infos = preg_split('/\,/', $info_lines);

        foreach ($infos as $info) {
            RouteStationInfoLine::create([
                'route_id' => $route_id,
                'station_infomation_id' => $info,
                'type' => $type,
                'ismaster' => $ismaster,
            ]);
        }
    }

    public function update(Request $request)
    {
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
        $route->master_from_info = isset($request->master_from_info) ? 'Y' : 'N';
        $route->master_to_info = isset($request->master_to_info) ? 'Y' : 'N';
        $route->ispromocode = isset($request->promocode) ? 'Y' : 'N';
        $route->master_from = $request->master_from;
        $route->master_to = $request->master_to;

        $route->isinformation_from_active = isset($request->isinformation_from_active) ? 'Y' : 'N';
        $route->isinformation_to_active = isset($request->isinformation_to_active) ? 'Y' : 'N';
        $route->information_from = $request->information_from;
        $route->information_to = $request->information_to;

        if ($route->save()) {
            $this->routeIconDestroy($request->route_id);
            $result = $this->routeIconStore($request->icons, $request->route_id);
            $this->routeActivityDestroy($request->route_id);
            if (isset($request->activity_id))
                $this->routeActivityStore($request->activity_id, $request->route_id);
            $this->routeMealDestroy($request->route_id);
            if (isset($request->meal_id))
                $this->routeMealStore($request->meal_id, $request->route_id);

            //$this->routeShuttleBusDestroy($request->route_id);
            //if(isset($request->shuttle_bus_name)) $this->shuttlebusStore($request->shuttle_bus_name, $request->shuttle_bus_price, $request->shuttle_bus_description, $request->route_id);

            //$this->routeLongtailBoatDestroy($request->route_id);
            //if(isset($request->longtail_boat_name)) $this->longtailStore($request->longtail_boat_name, $request->longtail_boat_price, $request->longtail_boat_description, $request->route_id);

            if ($result) {
                $this->clearAllRouteStationInfoLine($request->route_id);
                //if(isset($request->master_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_from_selected, 'from', 'Y');
                //if(isset($request->master_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->master_to_selected, 'to', 'Y');
                //if(isset($request->info_from_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_from_selected, 'from', 'N');
                //if(isset($request->info_to_selected)) $this->storeRouteStationInfoLine($route->id, $request->info_to_selected, 'to', 'N');
                //return redirect()->route('route-index')->withSuccess('Route updated...');
            }

            //dd($request);

            //update route addons
            foreach ($request->route_addons as $item) {
                $routeAddon = RouteAddons::find($item['id']);
                $routeAddon->name = ucfirst(str_replace('_', ' ', ($item['type'] . ' ' . $item['subtype'])));
                $routeAddon->isactive = isset($item['isactive']) ? 'Y' : 'N';
                $routeAddon->isservice_charge = isset($item['isservice_charge']) ? 'Y' : 'N';
                $routeAddon->price = $item['price'];
                $routeAddon->mouseover = $item['mouseover'];
                $routeAddon->message = $item['message'];
                $routeAddon->save();
            }

            return redirect()->route('route-index')->withSuccess('Route updated...');
        } else
            return redirect()->route('route-index')->withFail('Something is wrong. Please try again.');
    }

    private function clearAllRouteStationInfoLine(string $route_id = null)
    {
        RouteStationInfoLine::where('route_id', $route_id)->delete();
    }

    private function routeIconDestroy($route_id)
    {
        RouteIcon::where('route_id', $route_id)->delete();
    }

    public function destroy(string $id = null)
    {
        $route = Route::find($id);
        $route_used = BookingRoutes::where('route_id', $id)->first();

        if (is_null($route) || $route->status != 'CO')
            return redirect()->route('route-index')->withFail('This route not exist.');

        if (isset($route_used)) {
            $route->isactive = 'N';
            $route->status = 'VO';
            $route->save();

        } else {
            RouteActivity::where('route_id', $id)->delete();
            RouteMeal::where('route_id', $id)->delete();
            RouteIcon::where('route_id', $id)->delete();
            RouteStationInfoLine::where('route_id', $id)->delete();


            $shuttle_bus = RouteShuttlebus::where('route_id', $id)->get();
            if (sizeof($shuttle_bus) > 0) {
                foreach ($shuttle_bus as $bus) {
                    Addon::find($bus->addon_id)->delete();
                }
            }

            $longtail_boat = RouteLongtailboat::where('route_id', $id)->get();
            if (sizeof($longtail_boat) > 0) {
                foreach ($longtail_boat as $boat) {
                    Addon::find($boat->addon_id)->delete();
                }
            }

            RouteShuttlebus::where('route_id', $id)->delete();
            RouteLongtailboat::where('route_id', $id)->delete();
            $route->delete();


        }

        ApiRoutes::where('route_id', $id)->forceDelete();
        RouteSchedules::where('route_id', $id)->forceDelete();
        PromotionLines::where('route_id', $id)->forceDelete();

        return redirect()->route('route-index')->withSuccess('Route deleted...');
    }

    public function getRouteInfo(string $route_id = null, string $station_id = null, string $type = null)
    {
        $routes = null;
        if ($type == 'from')
            $routes = Route::where('id', $route_id)->where('station_from_id', $station_id)->with('station_lines')->first();
        if ($type == 'to')
            $routes = Route::where('id', $route_id)->where('station_to_id', $station_id)->with('station_lines')->first();

        return response()->json(['data' => $routes, 'status' => 'success']);
    }

    public function destroySelected(Request $request)
    {
        $routes = preg_split('/\,/', $request->route_selected);

        foreach ($routes as $route) {
            $_route = Route::find($route);
            $_route->isactive = 'N';
            $_route->status = 'VO';
            $_route->save();

            ApiRoutes::where('route_id', $route)->forceDelete();
            RouteSchedules::where('route_id', $route)->forceDelete();
            PromotionLines::where('route_id', $route)->forceDelete();
        }

        return redirect()->route('route-index')->withSuccess('Route updated...');
    }

    public function pdfSelected(Request $request)
    {
        if (!isset($request->route_selected) || $request->isMethod('get'))
            return redirect()->route('route-index')->withFail('No route selected.');

        $routes = preg_split('/\,/', $request->route_selected);
        $_routes = [];

        foreach ($routes as $route) {
            $_route = Route::find($route);
            array_push($_routes, $_route);
        }

        return view('pages.route_control.pdf', ['routes' => $_routes]);
    }

    public function updateStatus(string $id = null)
    {
        $route = Route::find($id);
        if (isset($route)) {
            $route->isactive = $route->isactive == 'Y' ? 'N' : 'Y';
            if ($route->save())
                return response()->json(['result' => true], 200);
        }

        return response()->json(['result' => false], 200);
    }
}
