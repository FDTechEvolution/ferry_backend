<?php
namespace App\Helpers;

use App\Models\ApiMerchants;
use App\Models\Sequencenumbers;


//https://medium.com/@icecslox/laravel-5-4-%E0%B8%AA%E0%B8%A3%E0%B9%89%E0%B8%B2%E0%B8%87-helper-%E0%B9%84%E0%B8%A7%E0%B9%89%E0%B9%83%E0%B8%8A%E0%B9%89%E0%B8%87%E0%B8%B2%E0%B8%99-52f93ee1805a

function newSequenceNumber($type,$apiMerchantId=null)
{
    $sequence = Sequencenumbers::where("type", $type)->first();
    $newSequenceNumber = '0000000000';
    if ($sequence) {
        $today = date('Y-m-d');
        $dataDate = $sequence->updated_at->format('Y-m-d');

        if($type != 'BOOKING'){
            if($today !=$dataDate){
                $sequence->running = 0;
                $sequence->save();
                $sequence = Sequencenumbers::where("type", $type)->first();
            }
        }


        $prefix = $sequence->prefix;

        //change ticket prefix when book from api agent
        if($type == 'TICKET' && !empty($apiMerchantId)){
            $apiMerchant = ApiMerchants::find($apiMerchantId);
            if(!empty($apiMerchant)){
                $prefix = $apiMerchant->prefix;
            }
        }

        $dateformat = $sequence->dateformat;
        $currentNumber = $sequence->running;
        $runningDigit = $sequence->running_digit;

        if (!is_null($dateformat) && $dateformat != '') {
            $prefix .= date($dateformat);
        }
        $nextNumber = $currentNumber + 1;

        $newSequenceNumber = $prefix . str_pad($nextNumber, $runningDigit, "0", STR_PAD_LEFT);

        //update table
        $sequence->running = $nextNumber;
        $sequence->save();
    }

    return $newSequenceNumber;
}
