<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Reviews;

class ReviewController extends Controller
{
    public function index() {
        $reviews = Reviews::where('isactive', 'Y')->get();

        return response()->json(['data' => $reviews], 200);
    }
}
