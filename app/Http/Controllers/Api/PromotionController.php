<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Promotions;
use App\Models\Route;
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

            // Log::debug($_station);

            if($_trip_type && $_depart_date && $_booking_date) {
                return response()->json(['result' => true, 'data' => $promo, 'promo_line' => $_station]);
            }
        }

        return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

    public function promotionCodeV2($promo_code, $departdate, $route, $trip_type) {
        $promo = Promotions::where('code', $promo_code)->where('isactive', 'Y')->whereColumn('times_used', '<', 'times_use_max')->first();
        if($promo) {
            $route = Route::find($route);
            $_depart_date = false;
            $_booking_date = false;
            $_station = false;

            $ex = explode('-', $departdate);
            $departdate = $ex[2].'/'.$ex[1].'/'.$ex[0];

            $depart_date = null;
            if($trip_type == 'one-way') $depart_date = $departdate;
            if($trip_type == 'multi-trip') $depart_date = $departdate;
            else if($trip_type == 'round-trip') {
                $ex = explode(' - ', $departdate);
                $depart_date = $ex[0];
            }

            $_trip_type = PromotionHelper::promoTripType($promo->trip_type, $trip_type);
            $_depart_date = PromotionHelper::promoDepartDate($promo, $depart_date);
            $_booking_date = PromotionHelper::promoBookingDate($promo);
            $_station = PromotionHelper::promoStation($promo, $route->station_from_id, $route->station_to_id);

            if($_trip_type && $_depart_date && $_booking_date) {
                return response()->json(['result' => true, 'data' => $promo, 'promo_line' => $_station]);
            }
        }

        return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

}
