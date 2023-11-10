<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\StationResource;
use App\Models\Station;

class StationsController extends Controller
{
    public function getStations() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => $stations, 'status' => 'success']);
    }

    // 7
    public function getAllStation() {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->orderBy('sort', 'ASC')->get();

        return response()->json(['data' => StationResource::collection($stations)], 200);
    }
}
