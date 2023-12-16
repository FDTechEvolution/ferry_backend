<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;

use App\Models\Promotions;

class PromotionHelper
{
    public static function promotionCode($promo_code) {
        $promo = Promotions::where('code', $promo_code)->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promo)) {
            if($promo->trip_type == NULL) return array('result' => true, 'data' => $promo);
        }
        else return array('result' => false, 'data' => 'No promotion code or promotion code ran out.');
    }
}