<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Route;

class RouteController extends Controller
{
    public function searchRoute(string $from = null, string $to = null) {
        $routes = Route::where('station_from_id', $from)
                        ->where('station_to_id', $to)
                        ->where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->with('station_from', 'station_to', 'icons')
                        ->get();

        return response()->json(['data' => $routes, 'status' => 'success']);
    }
}
