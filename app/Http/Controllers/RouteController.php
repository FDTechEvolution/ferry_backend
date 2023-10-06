<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Models\Station;
use App\Models\Route;

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
        $routes = Route::with('station_from', 'station_to')->get();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();

        // Log::debug($icons);

        $status = $this->_Status;
        return view('pages.route_control.index', 
                    ['routes' => $routes, 'stations' => $stations, 'route_status' => $status, 'icons' => $icons]
                );
    }

    public function create() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $icons = DB::table('icons')->where('type', $this->Type)->get();

        return view('pages.route_control.create', 
                    ['stations' => $stations, 'icons' => $icons]
                );
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

        if($route) return redirect()->route('route-index')->withSuccess('Route created...');
        else return redirect()->route('route-index')->withFail('Something is wrong. Please try again.');
    }

    public function destroy(string $id = null) {
        return redirect()->route('route-index')->withSuccess('Route deleted...');
    }
}
