<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Promotions;
use App\Helpers\PromotionHelper;
use App\Http\Resources\PromotionResource;

class PromotionController extends Controller
{
    public function getPromotion() {
        $promotions = Promotions::where('isactive', 'Y')->with('image')->orderBy('created_at', 'DESC')->get();

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
        $promo = Promotions::where('code', $request->promo_code)->where('isactive', 'Y')->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promo)) {
            $_depart_date = false;
            $_booking_date = false;
            $_station = false;

            $depart_date = null;
            if($request->trip_type == 'one-way') $depart_date = $request->depart_date;
            if($request->trip_type == 'multi-trip') $depart_date = $request->depart_date;
            else if($request->trip_type == 'round-trip') {
                $ex = explode(' - ', $request->depart_date);
                $depart_date = $ex[0];
            }

            $_trip_type = PromotionHelper::promoTripType($promo->trip_type, $request->trip_type);
            $_depart_date = PromotionHelper::promoDepartDate($promo, $depart_date);
            $_booking_date = PromotionHelper::promoBookingDate($promo);
            $_station = PromotionHelper::promoStation($promo, $request->station_from_id, $request->station_to_id);

            if($_trip_type && $_depart_date && $_booking_date && $_station) {
                return response()->json(['result' => true, 'data' => $promo]);
            }
        }

        return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

}
