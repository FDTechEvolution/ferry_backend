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

    public static function promoTripType($promo_trip, $trip_type) {
        if($promo_trip == NULL || $promo_trip == 'all') return true;
        else {
            if($promo_trip == $trip_type) return true;
            else return false;
        }
    }

    public static function promoDepartDate($promo, $date) {
        if($promo->depart_date_start == NULL && $promo->depart_date_end == NULL) return true;
        else {
            $_date = explode('/', $date);
            $depart_start = date('Y-m-d', strtotime($_date[2].'-'.$_date[1].'-'.$_date[0]));
            $promo_start = date('Y-m-d', strtotime($promo->depart_date_start));
            $promo_end = date('Y-m-d', strtotime($promo->depart_date_end));

            $_promoHelper = new PromotionHelper;

            $depart_result = $promo->depart_date_start != NULL ? $_promoHelper->dateBetween($depart_start, $promo_start, $promo_end) : true;

            return $depart_result;
        }

        return false;
    }

    function dateBetween($date, $start, $end) {
        if(($date >= $start) && ($date <= $end)) return true;
        return false;
    }

    public static function promoBookingDate($promo) {
        $booking_date = date('Y-m-d');
        $booking_date = date('Y-m-d', strtotime($booking_date));
        $result = true;

        $_promoHelper = new PromotionHelper;

        if($promo->booking_start_date != NULL && $promo->booking_end_date != NULL) {
            $result = $_promoHelper->dateBetween($booking_date, $promo->booking_start_date, $promo->booking_end_date);
        }

        return $result;
    }

    public static function promoStation($promo, $station_from, $station_to) {
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
