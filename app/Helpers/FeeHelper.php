<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use App\Models\FeeSetting;

class FeeHelper
{
    public static function getFeeSetting($passengers, $total, $type) {
        $f = FeeSetting::where('type', $type)->first();
        $_total = 0;

        if($f['isuse_pf'] == 'Y') {
            if($f['is_pf_perperson'] == 'Y') {
                $adult_fee = $passengers['adult'] * $f->regular_pf;
                $child_fee = $passengers['child'] * $f->child_pf;
                $infant_fee = $passengers['infant'] * $f->infant_pf;
                $_total += $adult_fee + $child_fee + $infant_fee;
            }
            else {
                $_fee = $total*($f->percent_pf/100);
                $_total += $_fee;
            }
        }

        if($f['isuse_sc'] == 'Y') {
            if($f['is_sc_perperson'] == 'Y') {
                $adult_fee = $passengers['adult'] * $f->regular_sc;
                $child_fee = $passengers['child'] * $f->child_sc;
                $infant_fee = $passengers['infant'] * $f->infant_sc;
                $_total += $adult_fee + $child_fee + $infant_fee;
            }
            else {
                $_fee = $total*($f['percent_sc']/100);
                $_total += $_fee;
            }
        }

        return $_total;
    }
}
