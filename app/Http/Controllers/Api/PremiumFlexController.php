<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PremiumFlex;

class PremiumFlexController extends Controller
{
    public function index() {
        $pmf = PremiumFlex::orderBy('seq', 'ASC')->get();

        return response()->json(['data' => $pmf], 200);
    }
}
