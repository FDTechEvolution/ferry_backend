<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Slide;

class SlideController extends Controller
{
    public function getBlog() {
        $blog = Slide::where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->where('type', 'BLOG')
                        ->with('image')
                        ->orderBy('sort', 'ASC')
                        ->get();

        return response()->json(['data' => $blog, 'status' => 'success']);
    }

    public function getBlogBySlug(string $slug = null) {
        $blog = Slide::where('slug', $slug)
                        ->where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->where('type', 'BLOG')
                        ->with('image')
                        ->first();

        if(isset($blog)) return response()->json(['result' => true, 'data' => $blog, 'status' => 'success']);
        return response()->json(['result' => false, 'data' => '', 'status' => 'fail']);
    }
}
