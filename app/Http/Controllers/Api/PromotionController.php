<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promotions;

use App\Http\Resources\PromotionResource;

class PromotionController extends Controller
{
    public function getPromotion() {
        $promotions = Promotions::where('isactive', 'Y')->get();

        return response()->json(['data' => PromotionResource::collection(($promotions))], 200);
    }
}
