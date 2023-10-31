<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Slide;

class SlideController extends Controller
{
    public function getSlide() {
        $slides = Slide::where('isactive', 'Y')->where('status', 'CO')->with('image')->orderBy('sort', 'ASC')->get();
        
        return response()->json(['data' => $slides, 'status' => 'success']);
    }
}
