<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Promotions;

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
        $promo = Promotions::where('code', $request->promo_code)->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promo)) {
            $_depart_date = false;
            $_booking_date = false;
            $_station = false;

            $_trip_type = $this->promoTripType($promo->trip_type, $request->trip_type);
            if($_trip_type) $_depart_date = $this->promoDepartDate($promo, $request->depart_date);
            if($_depart_date) $_booking_date = $this->promoBookingDate($promo);
            if($_booking_date) $_station = $this->promoStation($promo, $request->station_from_id, $request->station_to_id);

            if($_trip_type && $_depart_date && $_booking_date && $_station) {
                return response()->json(['result' => true, 'data' => $promo]);
            }
        }

        return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

    private function promoTripType($promo_trip, $trip_type) {
        if($promo_trip == NULL) return true;
        else {
            if($promo_trip == $trip_type) return true;
            else return false;
        }
    }

    private function promoDepartDate($promo, $date) {
        if($promo->depart_date_start == NULL && $promo->depart_date_end == NULL) return true;
        else {
            $_date = explode('/', $date);
            $depart_start = date('Y-m-d', strtotime($_date[2].'-'.$_date[1].'-'.$_date[0]));
            $promo_start = date('Y-m-d', strtotime($promo->depart_date_start));
            $promo_end = date('Y-m-d', strtotime($promo->depart_date_end));

            $depart_result = $promo->depart_date_start != NULL ? $this->dateBetween($depart_start, $promo_start, $promo_end) : true;

            return $depart_result;
        }

        return false;
    }

    private function dateBetween($date, $start, $end) {
        if(($date >= $start) && ($date <= $end)) return true;
        return false;
    }

    private function promoBookingDate($promo) {
        $booking_date = date('Y-m-d');
        $booking_date = date('Y-m-d', strtotime($booking_date));
        $result = true;

        if($promo->booking_start_date != NULL && $promo->booking_end_date != NULL) {
            $result = $this->dateBetween($booking_date, $promo->booking_start_date, $promo->booking_end_date);
        }

        return $result;
    }

    private function promoStation($promo, $station_from, $station_to) {
        $_from = true;
        $_to = true;

        if($promo->station_from_id != NULL && $promo->station_to_id != NULL) return true;
        else {
            if($promo->station_from_id != NULL) $_from = $promo->station_from_id == $station_from ? true : false;
            if($promo->station_to_id != NULL) $_to = $promo->station_to_id == $station_to ? true : false;
        }

        return ($_from && $_to) ? true : false;
    }

}
