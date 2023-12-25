<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Promotions;

use App\Http\Resources\PromotionResource;

class PromotionController extends Controller
{
    public function getPromotion() {
        $promotions = Promotions::where('isactive', 'Y')->orderBy('created_at', 'DESC')->get();

        return response()->json(['data' => PromotionResource::collection(($promotions))], 200);
    }

    public function getPromotionByCode($promocode) {
        $promotion = Promotions::where('code', $promocode)->where('isactive', 'Y')->first();

        if(isset($promotion))
            return response()->json(['data' => new PromotionResource($promotion)], 200);
        else
            return response()->json(['data' => false], 200);
    }

    public function promotionCode(Request $request) {
        $promo = Promotions::where('code', $request->promo_code)->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promo)) {
            $_trip_type = $this->promoTripType($promo->trip_type, $$request->trip_type);
            if($_trip_type) $this->promoDepartDateStart();
        }
        else return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

    private function promoTripType($promo_trip, $trip_type) {
        $result = null;

        if($promo_trip == NULL) return true;
        else {
            if($promo_trip == $trip_type) return true;
            else return false;
        }
    }

}
