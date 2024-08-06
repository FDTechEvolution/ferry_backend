<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $regular_price = floatval($this->api_route->regular_price) - floatval($this->api_route->discount);
        $discount = floatval($this->api_route->discount);
        $gross_fare = number_format($regular_price + $discount, 2);
        $totalamt = number_format($regular_price, 2);

        return [
            'id' => $this->id,
            'depart_time' => date('H:i', strtotime($this->depart_time)),
            'arrive_time' => date('H:i', strtotime($this->arrive_time)),
            'regular_price' => $regular_price,
            'gross_fare' => $gross_fare,
            'discount' => $discount,
            'totalamt' => $totalamt,
            'avaliable_seat' => 100,
            // 'master_from_info' => $this->master_from_info,
            // 'master_to_info' => $this->master_to_info,
            // 'ispromocode' => $this->ispromocode,
            'station_from' => [
                'name' => $this->station_from->name,
                'name_th' => $this->station_from->thai_name,
                'piername' => $this->station_from->piername,
                'piername_th' => $this->station_from->thai_piername,
                'nickname' => $this->station_from->nickname
            ],
            'station_to' => [
                'name' => $this->station_to->name,
                'name_th' => $this->station_to->thai_name,
                'piername' => $this->station_to->piername,
                'piername_th' => $this->station_to->thai_piername,
                'nickname' => $this->station_to->nickname
            ],
            // 'activities' => !$this->activity_lines ? '' : $this->activity_lines->map(function($activity) {
            //     if($activity->status == 'CO') {
            //         return [
            //             'id' => $activity->id,
            //             'name' => $activity->name,
            //             'amount' => $activity->price,
            //             'detail' => $activity->detail
            //         ];
            //     }
            // }),
            // 'meals' => !$this->meal_lines ? '' : $this->meal_lines->map(function($meal) {
            //     if($meal->isactive == 'Y' && $meal->status == 'CO') {
            //         return [
            //             'id' => $meal->id,
            //             'name' => $meal->name,
            //             'amount' => $meal->amount,
            //             'detail' => $meal->description
            //         ];
            //     }
            // }),
        ];
    }
}
