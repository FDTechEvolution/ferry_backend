<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Route;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('pages.promotion.index');
    }

    public function create() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->with('station_from', 'station_to')->get();

        return view('pages.promotion.create', ['stations' => $stations, 'routes' => $routes]);
    }
}
