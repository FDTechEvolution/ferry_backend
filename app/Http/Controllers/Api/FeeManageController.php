<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\FeeSetting;

class FeeManageController extends Controller
{
    public function index() {
        $fee = FeeSetting::get();

        return response()->json(['data' => $fee], 200);
    }
}
