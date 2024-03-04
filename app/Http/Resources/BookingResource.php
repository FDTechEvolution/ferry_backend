<?php

namespace App\Http\Resources;

use DateTime;
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
        $depart = new DateTime($this->departdate);
        $now = new DateTime('now');
        $do_update = $depart > $now ? true : false;

        return [
            'id' => $this->id,
            'depart_date' => $this->departdate,
            'do_update' => $do_update,
            'adult' => $this->adult_passenger,
            'child' => $this->child_passenger,
            'infant' => $this->infant_passenger,
            'amount' => $this->amount,
            'amount_extra' => $this->extraamt,
            'trip_type' => $this->trip_type,
            'booking_number' => $this->bookingno,
            'status' => $this->status,
            'ispayment' => $this->ispayment,
            'route' => $this->bookingRoutes->map(function($route) {
                return [
                    'station_from' => $route->station_from->name,
                    'station_from_pier' => $route->station_from->piername,
                    'station_from_nickname' => $route->station_from->nickname,
                    'station_to' => $route->station_to->name,
                    'station_to_pier' => $route->station_to->piername,
                    'station_to_nickname' => $route->station_to->nickname,
                    'depart_time' => $route->depart_time,
                    'arrive_time' => $route->arrive_time,
                    'adult_price' => $route->regular_price,
                    'child_price' => $route->child_price,
                    'infant_price' => $route->infant_price,
                    'amount' => $route->pivot->amount
                ];
            }),
            'customer' => $this->bookingCustomers->map(function($customer) {
                return [
                    'id' => $customer->id,
                    'title' => $customer->title,
                    'name' => $customer->fullname,
                    'mobile' => $customer->mobile,
                    'email' => $customer->email,
                    'address' => $customer->fulladdress,
                    'type' => $customer->type,
                    'passport' => $customer->passportno,
                    'birth_day' => $customer->birth_day
                ];
            }),
            'extra' => $this->bookingRoutesX->map(function($extra) {
                if($extra->status == 'CO' && $extra->isactive == 'Y') {
                    return [
                        'name' => $extra->name,
                        'type' => $extra->type,
                        'amount' => $extra->amount,
                        'image' => $extra->image,
                        'icon' => $extra->icon
                    ];
                }
            }),
            'payment' => $this->payments->map(function($payment) {
                return [
                    'payment_id' => $payment->id,
                    'payment_method' => $payment->payment_method,
                    'totalamt' => $payment->totalamt,
                    'paymentno' => $payment->paymentno,
                    'ispaid' => $payment->ispaid,
                    'status' => $payment->status,
                    'payment_lines' => $payment->paymentLines->map(function($line) {
                        return [
                            'type' => $line->type,
                            'title' => $line->title,
                            'amount' => $line->amount,
                            'description' => $line->description
                        ];
                    })
                ];
            }),

        ];
    }
}
