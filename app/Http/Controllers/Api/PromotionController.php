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

    public function promotionCode($promo_code, $trip_type) {
        $promo = Promotions::where('code', $promo_code)->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promo)) {
            $_trip_type = $this->promoTripType($promo, $trip_type);
        }
        else return response()->json(['result' => false, 'data' => 'No promotion code or promotion code ran out.'], 200);
    }

    private function promoTripType($promo, $trip_type) {
        $result = null;

        if($promo->trip_type == NULL) return array('result' => true, 'data' => $promo);
        else {
            switch ($trip_type) {
                case 'one-trip':
                    $result = $this->oneTripPromoCode($promo);
                    break;
                case 'round-trip':
                    $result = $this->roundTripPromocode($promo);
                    break;
                case 'multi-trip':
                    $result = $this->multiTripPromocode($promo);
                    break;
                default:
                    $result = false;
            }
        }

        return $result;
    }

    private function oneTripPromoCode() {
        
    }
}
