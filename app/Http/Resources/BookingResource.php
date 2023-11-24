<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'depart_date' => $this->departdate,
            'adult' => $this->adult_passenger,
            'child' => $this->child_passenger,
            'infant' => $this->infant_passenger,
            'amount' => $this->amount,
            'amount_extra' => $this->extraamt,
            'trip_type' => $this->trip_type,
            'booking_number' => $this->bookingno,
            'status' => $this->status,
            'route' => $this->bookingRoutes->map(function($route) {
                return [
                    'station_from' => $route->station_from->name,
                    'station_to' => $route->station_to->name,
                    'depart_time' => $route->depart_time,
                    'arrive_time' => $route->arrive_time,
                    'adult_price' => $route->regular_price,
                    'child_price' => $route->child_price,
                    'infant_price' => $route->infant_price
                ];
            }),
            'customer' => $this->bookingCustomers->map(function($customer) {
                return [
                    'name' => $customer->fullname,
                    'mobile' => $customer->mobile,
                    'email' => $customer->email,
                    'address' => $customer->fulladdress,
                    'type' => $customer->type,
                    'passport' => $customer->passportno
                ];
            })
        ];
    }
}
