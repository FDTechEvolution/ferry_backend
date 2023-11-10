<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class RouteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'depart_time' => date('h:i', strtotime($this->depart_time)),
            'arrive_time' => date('h:i', strtotime($this->arrive_time)),
            'regular_price' => $this->regular_price - ($this->regular_price*0.2),
            'station_from' => [
                'name' => $this->station_from->name,
                'piername' => $this->station_from->piername,
                'nickname' => $this->station_from->nickname
            ],
            'station_to' => [
                'name' => $this->station_to->name,
                'piername' => $this->station_to->piername,
                'nickname' => $this->station_to->nickname
            ],
            'activities' => !$this->activity_lines ? '' : $this->activity_lines->map(function($activity) {
                if($activity->status == 'CO') {
                    return [
                        'id' => $activity->id,
                        'name' => $activity->name,
                        'amount' => $activity->price,
                        'detail' => $activity->detail
                    ];
                }
            }),
            'meals' => !$this->meal_lines ? '' : $this->meal_lines->map(function($meal) {
                if($meal->isactive == 'Y' && $meal->status == 'CO') {
                    return [
                        'id' => $meal->id,
                        'name' => $meal->name,
                        'amount' => $meal->amount,
                        'detail' => $meal->description
                    ];
                }
            }),
        ];
    }
}
