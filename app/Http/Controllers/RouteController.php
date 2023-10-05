<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;

class RouteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $station = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        return view('pages.route_control.index', ['station' => $station]);
    }
}
