<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Slide;

class BillboardController extends Controller
{
    public function getBillboard() {
        $billboard = Slide::where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->where('type', 'BOARD')
                        ->orderBy('sort', 'ASC')
                        ->get();

        return response()->json(['data' => $billboard, 'status' => 'success']);
    }
}
