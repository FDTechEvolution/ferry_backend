<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Station;
use App\Models\Route;
use App\Models\RouteIcon;
use App\Models\RouteStationInfoLine;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    protected $Type = 'route';
    protected $_Status = [
        'Y' => '<span class="text-success">On</span>',
        'N' => '<span class="text-danger">Off</span>'
    ];

    public function index() {
        $routes = Route::where('status', 'CO')->with('station_from', 'station_to', 'icons')->get();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();

        $status = $this->_Status;
        return view('pages.route_control.index', 
                    ['routes' => $routes, 'stations' => $stations, 'route_status' => $status, 'icons' => $icons]
                );
    }

    public function create() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->with('info_line')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();

        return view('pages.route_control.create', 
                    ['stations' => $stations, 'icons' => $icons]
                );
    }

    public function edit(string $id = null) {
        $route = Route::find($id);
        $route->station_lines;

        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->with('info_line')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();

        return view('pages.route_control.edit', ['route' => $route, 'icons' => $icons, 'stations' => $stations]);
    }

    public function store(Request $request) {
        $request->validate([
            'station_from' => 'required|string|min:36|max:36',
            'station_to' => 'required|string|min:36|max:36',
            'regular_price' => 'integer|nullable',
            'child_price' => 'integer|nullable'
        ]);

        $route = Route::create([
            'station_from_id' => $request->station_from,
            'station_to_id' => $request->station_to,
            'depart_time' => $request->depart_time,
            'arrive_time' => $request->arrive_time,
            'regular_price' => $request->regular_price,
            'child_price' => $request->child_price,
            'isactive' => isset($request->status) ? 'Y' : 'N'
        ]);

        if($route) {
            $result = $this->routeIconStore($request->icons, $route->id);

            if($result) {
                if(isset($request->master_from)) $this->storeRouteStationInfoLine($route->id, $request->master_from, 'from');
                if(isset($request->master_to)) $this->storeRouteStationInfoLine($route->id, $request->master_to, 'to');
                return redirect()->route('route-index')->withSuccess('Route created...');
            }
            else return redirect()->back()->withFail('Something is wrong. Please try again.');
        }

        return redirect()->back()->withFail('Something is wrong. Please try again.');
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

    private function storeRouteStationInfoLine(string $route_id = null, array $info_lines = [], string $type = null) {
        foreach($info_lines as $info) {
            RouteStationInfoLine::create([
                'route_id' => $route_id,
                'station_infomation_id' => $info,
                'type' => $type
            ]);
        }
    }

    public function update(Request $request) {
        $request->validate([
            'station_from' => 'required|string|min:36|max:36',
            'station_to' => 'required|string|min:36|max:36',
            'regular_price' => 'integer|nullable',
            'child_price' => 'integer|nullable'
        ]);

        $route = Route::find($request->route_id);
            $route->station_from_id = $request->station_from;
            $route->station_to_id = $request->station_to;
            $route->depart_time = $request->depart_time;
            $route->arrive_time = $request->arrive_time;
            $route->regular_price = $request->regular_price;
            $route->child_price = $request->child_price;
            $route->isactive = isset($request->status) ? 'Y' : 'N';
        if($route->save()) {
            $this->routeIconDestroy($request->route_id);
            $result = $this->routeIconStore($request->icons, $request->route_id);

            if($result) {
                $this->clearAllRouteStationInfoLine($request->route_id);
                if(isset($request->master_from)) $this->storeRouteStationInfoLine($route->id, $request->master_from, 'from');
                if(isset($request->master_to)) $this->storeRouteStationInfoLine($route->id, $request->master_to, 'to');
                return redirect()->route('route-index')->withSuccess('Route updated...');
            }
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
        $route->status = 'VO';
        if($route->save()) return redirect()->route('route-index')->withSuccess('Route deleted...');
        else return redirect()->route('route-index')->withFail('Something is wrong. Please try again.');
    }
}
