<?php
namespace App\Helpers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AgentHelper
{
    public static function getMonthSoldByAgent($apiMerchantId,$yearMonth='',$routeId=''){
        $sql = 'select br.traveldate,sum(b.adult_passenger) as sold_seat
from
	booking_routes br
    join bookings b on br.booking_id = b.id
where
    DATE_FORMAT(br.traveldate,"%Y-%m") = :year_month
    and b.api_merchant_id = :api_merchant_id :conditions
group by br.traveldate';

        if(empty($yearMonth)){
            $yearMonth = Carbon::today()->format('Y-m');
        }


        if(!empty($routeId)){
            $sql = str_replace(':conditions', 'and br.route_id = "'.$routeId.'"', $sql);
        }
        //dd($sql);

        $solds = DB::select($sql, ['year_month'=>$yearMonth,'api_merchant_id'=>$apiMerchantId]);
        $data = [];
        foreach($solds as $sold){
            $data[$sold->traveldate] = [
                'traveldate'=>$sold->traveldate,
                'sold_seat'=>$sold->sold_seat
            ];
        }

        return $data;
    }


    public static function getDateSoldByAgent($apiMerchantId,$date,$routeId){
        $sql = 'select br.traveldate,sum(b.adult_passenger) as sold_seat
from
	booking_routes br
    join bookings b on br.booking_id = b.id
where
    br.traveldate = :date
    and b.api_merchant_id = :api_merchant_id and br.route_id = :route_id
group by br.traveldate';

        $solds = DB::select($sql, ['date'=>$date,'api_merchant_id'=>$apiMerchantId,'route_id'=>$routeId]);
        if(empty($solds) || sizeof($solds) ==0){
            return [
                'traveldate'=>$date,
                'sold_seat'=>0
            ];
        }
        foreach($solds as $sold){
             return [
                'traveldate'=>$sold->traveldate,
                'sold_seat'=>(int)$sold->sold_seat
            ];
        }


    }
}
