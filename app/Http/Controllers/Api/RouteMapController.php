<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\RouteMap;

class RouteMapController extends Controller
{
    public function getRouteMap() {
        $rm = RouteMap::where('isactive', 'Y')->with('image')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => $rm], 200);
    }
}
