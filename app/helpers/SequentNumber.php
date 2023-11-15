<?php
namespace App\Helpers;

use App\Models\Sequencenumbers;


//https://medium.com/@icecslox/laravel-5-4-%E0%B8%AA%E0%B8%A3%E0%B9%89%E0%B8%B2%E0%B8%87-helper-%E0%B9%84%E0%B8%A7%E0%B9%89%E0%B9%83%E0%B8%8A%E0%B9%89%E0%B8%87%E0%B8%B2%E0%B8%99-52f93ee1805a

function newSequenceNumber($type)
{
    $sequence = Sequencenumbers::where("type", $type)->first();
    $newSequenceNumber = '0000000000';
    if ($sequence) {
        $prefix = $sequence->prefix;
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
