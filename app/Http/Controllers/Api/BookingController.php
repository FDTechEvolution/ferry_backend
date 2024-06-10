<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Route;
use App\Models\Addon;
use App\Models\Bookings;
use App\Models\BookingRoutes;
use App\Models\Promotions;
use App\Models\RouteAddons;
use App\Helpers\BookingHelper;
use App\Helpers\PaymentHelper;
use App\Helpers\PromotionHelper;
use App\Http\Resources\BookingResource;
use App\Models\PromotionLines;

class BookingController extends Controller
{
    protected $PaymentMethod = [
        'CC' => 'CC',
        'TM' => 'TRUEMONEY',
        'QR' => 'THQR'
    ];

    public function store(Request $request) {
        $route = $this->getRoute($request->route_id[0]);
        if($route) {
            $_promo = NULL;
            $_passenger = $request->passenger + $request->child_passenger + $request->infant_passenger;
            $_amount = $this->routeAmount($request->route_id, $request->passenger, $request->child_passenger, $request->infant_passenger);
            $_extra_meal = isset($request->meal_id) ? $this->extraAddon($request->meal_id, $request->meal_qty) : [0, []];
            $_extra_activity = isset($request->activity_id) ? $this->extraAddon($request->activity_id, $request->activity_qty) : [0, []];
            $_extra_shuttle_bus = isset($request->bus_id) ? $this->extraAddon($request->bus_id, $request->bus_qty) : [0, []];
            $_extra_longtail_boat = isset($request->boat_id) ? $this->extraAddon($request->boat_id, $request->boat_qty) : [0, []];
            $_extra_private_taxi = isset($request->taxi_id) ? $this->extraAddon($request->taxi_id, $request->taxi_qty) : [0, []];
            $_addons = isset($request->route_addon) ? $request->route_addon : [];
            $_addon_detail = isset($request->route_addon_detail) ? $request->route_addon_detail : [];
            $_promotion = $request->promocode != '' ? $this->promoCode($request->promocode, $request->route_id) : false;
            if($_promotion) $_promo = $this->setPromotionCode($_promotion, $request->trip_type, $request->departdate);

            $_booking = $this->setBooking($request->departdate, $request->passenger, $request->child_passenger,
                                            $request->infant_passenger, $request->trip_type, $request->book_channel,
                                            $_amount, $_extra_meal[0], $_extra_activity[0], $_extra_shuttle_bus[0],
                                            $_extra_longtail_boat[0], $_extra_private_taxi[0], $request->ispremiumflex, $_promo);
            $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type,
                                                $request->passportno, $request->email, $request->address, $request->mobile_code,
                                                $request->th_mobile, $request->country, $request->titlename, $request->birth_day);
            $_route = $this->setRoutes($request->route_id, $request->departdate, $request->returndate,
                                        $request->passenger, $request->child_passenger, $request->infant_passenger, $_addons, $_addon_detail);

            $_extra = array_merge($_extra_meal[1], $_extra_activity[1], $_extra_shuttle_bus[1], $_extra_longtail_boat[1]);

            if(!empty($_extra)) {
                foreach($_route as $index => $route) {
                    $_route[$index]['extras'] = $_extra[$index];
                }
            }

            $data = [
                'booking' => $_booking,
                'customers' => $_customer,
                'routes' => $_route
            ];

            // $payment_channel = $this->PaymentMethod[$request->payment_method];
            $isfreepremiumflex = isset($_promo) ? $_promo->isfreepremiumflex : 'N';
            $isfreecreditcharge = isset($_promo) ? $_promo->isfreecreditcharge : 'N';
            $isfreelongtailboat = isset($_promo) ? $_promo->isfreelongtailboat : 'N';
            $isfreeshuttlebus = isset($_promo) ? $_promo->isfreeshuttlebus : 'N';
            $isfreeprivatetaxi = isset($_promo) ? $_promo->isfreeprivatetaxi : 'N';

            $booking = BookingHelper::createBooking($data);
            $payment = PaymentHelper::createPaymentFromBooking($booking->id);
            $payment_id = $payment->id;

            // update promoCode
            // Log::debug($_promo);
            if(isset($_promo)) {
                $_discount_amount = 0;
                $p_line = $this->getPromotionLines($_promotion->id);
                foreach($request->route_id as $_route) {
                    $amount = 0;
                    $discount_amount = 0;
                    $_r = $this->getRoute($_route);
                    $pr = array_search($_route, $p_line['route']);
                    $fr = array_search($_r->station_from_id, $p_line['from']);
                    $tr = array_search($_r->station_to_id, $p_line['to']);
                    if($pr == '' && $fr == '' && $tr == '') {
                        if($_r->ispromocode == 'Y') {
                            $amount += $_r->regular_price*$request->passenger;
                            $amount += $_r->child_price*$request->child_passenger;
                            $amount += $_r->infant_price*$request->infant_passenger;
                            $discount_amount = PromotionHelper::promoDiscount($amount, $_promo);

                            $_discount_amount += $discount_amount - $amount;
                        }
                    }
                    else {
                        $p_line_route = !empty($p_line['route']) ? $p_line['route'][$pr] : '';
                        $p_line_from = !empty($p_line['from']) ? $p_line['from'][$fr] : '';
                        $p_line_to = !empty($p_line['to']) ? $p_line['to'][$tr] : '';
                        if($_r->ispromocode == 'Y' && $_r->id == $p_line_route ||
                            $_r->ispromocode == 'Y' && $_r->station_from_id == $p_line_from ||
                            $_r->ispromocode == 'Y' && $_r->station_to_id == $p_line_to
                        ){
                            $amount += $_r->regular_price*$request->passenger;
                            $amount += $_r->child_price*$request->child_passenger;
                            $amount += $_r->infant_price*$request->infant_passenger;
                            $discount_amount = PromotionHelper::promoDiscount($amount, $_promo);

                            $_discount_amount += $discount_amount - $amount;
                        }
                    }
                }

                $payment = PaymentHelper::updatePromoCodeDiscount($payment_id, $_promo->id, $_discount_amount);
            }
            $payment_amt = $_amount;

            // update PremiumFlex
            if($request->ispremiumflex == 'Y')
                $payment = PaymentHelper::updatePremiumFlex($payment_id, $payment_amt);
            if($request->ispremiumflex == 'Y' && $isfreepremiumflex == 'Y')
                $payment = PaymentHelper::updatePremiumFlexFree($payment_id, $payment_amt);

            // update Route Addon Promocode
            if($request->route_addon[0] != NULL) {
                foreach($request->route_addon as $route_addon) {
                    foreach($route_addon as $item) {
                        $r_addon = RouteAddons::find($item);
                        if($r_addon->type == 'longtail_boat' && $isfreelongtailboat == 'Y')
                            $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                        if($r_addon->type == 'shuttle_bus' && $isfreeshuttlebus == 'Y')
                            $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                        if($r_addon->type == 'private_taxi' && $isfreeprivatetaxi == 'Y')
                            $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                    }
                }
            }

            // $payment_amt = $_amount;

            // update CreditCard Free
            // if($payment_channel == 'CC')
            //     $payment = PaymentHelper::updatePayWithCreditCard($payment_id);
            // if($payment_channel == 'CC' && $isfreecreditcharge == 'Y')
            //     $payment = PaymentHelper::updatePayWithCreditCardFree($payment_id, $payment_amt);

            // $payment->totalamt = number_format($payment->totalamt, 2, '.', '');

            // $payload = PaymentHelper::encodeRequest($payment, $payment_channel);
            // $response = PaymentHelper::postTo_2c2p($payload);
            // $result = PaymentHelper::decodeResponse($response);

            return response()->json(['result' => true, 'booking' => $booking->bookingno, 'email' => $request->email], 200);
        }

        return response()->json(['result' => false, 'data' => 'No Route.'], 200);
    }

    public function storeMultiTrip(Request $request) {
        if(isset($request->route_id)) {

            $route = $this->getRoute($request->route_id[0]);
            if($route) {
                $_pro = NULL;
                $_passenger = $request->passenger + $request->child_passenger + $request->infant_passenger;
                $_promo = [];
                $_promotion = [];
                $_promo_id = '';
                $_promo_isfreepremiumflex = 'N';
                $_promo_isfreecreditcharge = 'N';
                $_promo_isfreelongtailboat = 'N';
                $_promo_isfreeshuttlebus = 'N';
                $_promo_isfreeprivatetaxi = 'N';
                $_amount = $this->routeAmount($request->route_id, $request->passenger, $request->child_passenger, $request->infant_passenger);
                $_extra_meal = isset($request->meal_id) ? $this->extraAddon($request->meal_id, $request->meal_qty) : [0, []];
                $_extra_activity = isset($request->activity_id) ? $this->extraAddon($request->activity_id, $request->activity_qty) : [0, []];
                $_extra_shuttle_bus = isset($request->bus_id) ? $this->extraAddon($request->bus_id, $request->bus_qty) : [0, []];
                $_extra_longtail_boat = isset($request->boat_id) ? $this->extraAddon($request->boat_id, $request->boat_qty) : [0, []];
                $_extra_private_taxi = isset($request->taxi_id) ? $this->extraAddon($request->taxi_id, $request->taxi_qty) : [0, []];
                $_addons = isset($request->route_addon) ? $request->route_addon : [];
                $_addon_detail = isset($request->route_addon_detail) ? $request->route_addon_detail : [];
                if($request->promocode != '') {
                    foreach($request->route_id as $index => $route_id) {
                        $has_promo = $this->promoCode($request->promocode, $request->route_id);
                        if($has_promo != NULL) {
                            $_pro = $has_promo;
                            array_push($_promotion, $has_promo);
                        }
                        else array_push($_promotion, []);
                    }
                }

                if(!empty($_promotion)) {
                    foreach($_promotion as $index => $_p) {
                        $is_promo = $this->setPromotionCode($_p, $request->trip_type, $request->departdate[$index]);
                        if($is_promo != NULL) {
                            $_promo_id = $is_promo->id;
                            if($is_promo->isfreepremiumflex == 'Y') $_promo_isfreepremiumflex = 'Y';
                            if($is_promo->isfreecreditcharge == 'Y') $_promo_isfreecreditcharge = 'Y';
                            if($is_promo->isfreelongtailboat == 'Y') $_promo_isfreelongtailboat = 'Y';
                            if($is_promo->isfreeshuttlebus == 'Y') $_promo_isfreeshuttlebus = 'Y';
                            if($is_promo->isfreeprivatetaxi == 'Y') $_promo_isfreeprivatetaxi = 'Y';
                            array_push($_promo, $is_promo);
                        }
                        else array_push($_promo, []);
                    }
                }

                $_booking = $this->setBooking($request->departdate[0], $request->passenger, $request->child_passenger,
                                                $request->infant_passenger, $request->trip_type, $request->book_channel,
                                                $_amount, $_extra_meal[0], $_extra_activity[0], $_extra_shuttle_bus[0],
                                                $_extra_longtail_boat[0], $_extra_private_taxi[0], $request->ispremiumflex, $_pro);
                $_customer = $this->setPassenger($request->fullname, $request->mobile, $request->passenger_type,
                                                    $request->passportno, $request->email, $request->address,
                                                    $request->mobile_code, $request->th_mobile, $request->country,
                                                    $request->titlename, $request->birth_day);
                $_route = $this->setRoutes($request->route_id, $request->departdate, $request->returndate,
                                            $request->passenger, $request->child_passenger, $request->infant_passenger, $_addons, $_addon_detail);

                $_extra = array_merge($_extra_meal[1], $_extra_activity[1], $_extra_shuttle_bus[1], $_extra_longtail_boat[1]);

                if(!empty($_extra)) {
                    foreach($_route as $index => $route) {
                        $_route[$index]['extras'] = $_extra[$index];
                    }
                }

                $data = [
                    'booking' => $_booking,
                    'customers' => $_customer,
                    'routes' => $_route
                ];

                // $payment_channel = $this->PaymentMethod[$request->payment_method];
                $isfreepremiumflex = !empty($_promo) ? $_promo_isfreepremiumflex : 'N';
                $isfreecreditcharge = !empty($_promo) ? $_promo_isfreecreditcharge : 'N';
                $isfreelongtailboat = !empty($_promo) ? $_promo_isfreelongtailboat : 'N';
                $isfreeshuttlebus = !empty($_promo) ? $_promo_isfreeshuttlebus : 'N';
                $isfreeprivatetaxi = !empty($_promo) ? $_promo_isfreeprivatetaxi : 'N';

                $booking = BookingHelper::createBooking($data);
                $payment = PaymentHelper::createPaymentFromBooking($booking->id);

                // update promoCode
                if(!empty($_promo)) {
                    $_discount_amount = 0;
                    $p_line = $this->getPromotionLines($_promo_id);
                    foreach($request->route_id as $index => $_route) {
                        $amount = 0;
                        $discount_amount = 0;
                        $_r = $this->getRoute($_route);
                        $pr = array_search($_route, $p_line['route']);
                        $fr = array_search($_r->station_from_id, $p_line['from']);
                        $tr = array_search($_r->station_to_id, $p_line['to']);
                        if($pr == '' && $fr == '' && $tr == '') {
                            if($_r->ispromocode == 'Y') {
                                $amount += $_r->regular_price*$request->passenger;
                                $amount += $_r->child_price*$request->child_passenger;
                                $amount += $_r->infant_price*$request->infant_passenger;
                                $discount_amount = PromotionHelper::promoDiscount($amount, $_promo[$index]);

                                $_discount_amount += $discount_amount - $amount;
                            }
                        }
                        else {
                            $p_line_route = !empty($p_line['route']) ? $p_line['route'][$pr] : '';
                            $p_line_from = !empty($p_line['from']) ? $p_line['from'][$fr] : '';
                            $p_line_to = !empty($p_line['to']) ? $p_line['to'][$tr] : '';
                            if($_r->ispromocode == 'Y' && $_r->id == $p_line_route ||
                                $_r->ispromocode == 'Y' && $_r->station_from_id == $p_line_from ||
                                $_r->ispromocode == 'Y' && $_r->station_to_id == $p_line_to
                            ){
                                $amount += $_r->regular_price*$request->passenger;
                                $amount += $_r->child_price*$request->child_passenger;
                                $amount += $_r->infant_price*$request->infant_passenger;
                                $discount_amount = PromotionHelper::promoDiscount($amount, $_promo[$index]);

                                $_discount_amount += $discount_amount - $amount;
                            }
                        }
                    }

                    $payment = PaymentHelper::updatePromoCodeDiscount($payment->id, $_promo_id, $_discount_amount);
                }

                $payment_amt = $payment->totalamt;
                $payment_id = $payment->id;
                if($request->ispremiumflex == 'Y')
                    $payment = PaymentHelper::updatePremiumFlex($payment->id, $payment_amt);
                if($request->ispremiumflex == 'Y' && $isfreepremiumflex == 'Y')
                    $payment = PaymentHelper::updatePremiumFlexFree($payment->id, $payment_amt);

                // update Route Addon Promocode
                if(!empty($request->route_addon)) {
                    foreach($request->route_addon as $route_addon) {
                        foreach($route_addon as $item) {
                            $r_addon = RouteAddons::find($item);
                            if($r_addon->type == 'longtail_boat' && $isfreelongtailboat == 'Y')
                                $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                            if($r_addon->type == 'shuttle_bus' && $isfreeshuttlebus == 'Y')
                                $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                            if($r_addon->type == 'private_taxi' && $isfreeprivatetaxi == 'Y')
                                $payment = PaymentHelper::updateRouteAddonFree($payment_id, $r_addon->name, $r_addon->price, $_passenger);
                        }
                    }
                }

                // $payment_amt = $payment->totalamt;
                // if($payment_channel == 'CC')
                //     $payment = PaymentHelper::updatePayWithCreditCard($payment->id);
                // if($payment_channel == 'CC' && $isfreecreditcharge == 'Y')
                //     $payment = PaymentHelper::updatePayWithCreditCardFree($payment->id, $payment_amt);

                // $payment->totalamt = number_format($payment->totalamt, 2, '.', '');

                // $payload = PaymentHelper::encodeRequest($payment, $payment_channel);
                // $response = PaymentHelper::postTo_2c2p($payload);
                // $result = PaymentHelper::decodeResponse($response);

                return response()->json(['result' => true, 'booking' => $booking->bookingno, 'email' => $request->email], 200);
            }
            return response()->json(['result' => false, 'data' => 'No Route.'], 200);
        }
        return response()->json(['result' => false, 'data' => 'No Data.'], 200);
    }

    private function promoCode($promocode, $route_id) {
        $promotion = Promotions::where('code', $promocode)->where('isactive', 'Y')->whereColumn('times_used', '<', 'times_use_max')->first();
        if(isset($promocode)) {
            $p_lines = $this->getPromotionLines($promotion->id);
            foreach($route_id as $r_id) {
                $route = Route::find($r_id);
                if(isset($route) && $route->ispromocode == 'Y') {
                    $r = array_search($route->id, $p_lines['route']);
                    $f = array_search($route->station_from_id, $p_lines['from']);
                    $t = array_search($route->station_to_id, $p_lines['to']);

                    if($r == '' && $f == '' && $t == '') {
                        if($route['ispromocode'] == 'Y') {
                            return $promotion;
                        }
                    }
                    else {
                        if($r != '' && $route['ispromocode'] == 'Y' ||
                            $f != '' && $route['ispromocode'] == 'Y' ||
                            $t != '' && $route['ispromocode'] == 'Y'
                        )
                        return $promotion;
                    }
                }
            }

            if($promotion->isfreecredircard == 'Y' || $promotion->isfreepremiumflex == 'Y') {
                return $promotion;
            }
        }
        return NULL;
    }

    private function getPromotionLines($promotion_id) {
        $promo_lines = PromotionLines::where('promotion_id', $promotion_id)->where('isactive', 'Y')->get();

        $inCondition = [
            'route' => [],
            'from' => [],
            'to' => []
        ];

        foreach($promo_lines as $line) {
            if($line->type == 'ROUTE') array_push($inCondition['route'], $line->route_id);
            if($line->type == 'STATION_FROM') array_push($inCondition['from'], $line->station_id);
            if($line->type == 'STATION_TO') array_push($inCondition['to'], $line->station_id);
        }

        return $inCondition;
    }

    private function setPromotionCode($promo, $trip_type, $depart_date) {
        $_trip_type = false;
        $_depart_date = false;
        $_booking_date = false;
        $_station = false;

        $_date = explode('-', $depart_date);
        $_departdate = $_date[2].'/'.$_date[1].'/'.$_date[0];

        $_trip_type = PromotionHelper::promoTripType($promo->trip_type, $trip_type);
        $_depart_date = PromotionHelper::promoDepartDate($promo, $_departdate);
        $_booking_date = PromotionHelper::promoBookingDate($promo);
        // $_station = PromotionHelper::promoStation($promo, $promo->station_from_id, $promo->station_to_id);

        if($_trip_type && $_depart_date && $_booking_date) {
            return $promo;
        }
        return NULL;
    }

    private function setBooking($departdate, $adult, $child, $infant, $trip_type, $book_channel, $amount, $meal, $activity, $bus, $boat, $taxi, $ispremiumflex, $promo) {
        $extra_amount = ($meal + $activity + $bus + $boat + $taxi);
        $booking = [
            'departdate' => $departdate,
            'adult_passenger' => $adult,
            'child_passenger' => $child,
            'infant_passenger' => $infant,
            'totalamt' => $amount + $extra_amount,
            'extraamt' => $extra_amount,
            'amount' => $amount,
            'ispayment' => 'N',
            'user_id' => NULL,
            'trip_type' => $trip_type,
            'status' => 'DR',
            'book_channel' => $book_channel,
            'ispremiumflex' => $ispremiumflex,
            'promotion_id' => $promo != NULL ? $promo->id : NULL
        ];

        return $booking;
    }

    private function setPassenger($fullname, $mobile, $type = NULL, $passport = NULL, $email = NULL, $address = NULL, $mobile_code = NULL, $th_mobile = NULL, $country = NULL, $titlename = NULL, $birth_day = NULL) {
        $customer = [];

        if(is_array($fullname)) {
            foreach($fullname as $key => $name) {
                if($key == 0) {
                    array_push($customer, [
                        'title' => strtoupper($titlename[$key]),
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => $passport,
                        'email' => $email,
                        'mobile_code' => $mobile_code,
                        'mobile' => $mobile,
                        'mobile_th' => $th_mobile,
                        'fulladdress' => $address,
                        'birthday' => $birth_day[$key],
                        'country' => $country
                    ]);
                }
                else {
                    array_push($customer, [
                        'title' => strtoupper($titlename[$key]),
                        'fullname' => $name,
                        'type' => strtoupper($type[$key]),
                        'passportno' => NULL,
                        'email' => NULL,
                        'mobile_code' => NULL,
                        'mobile' => NULL,
                        'mobile_th' => NULL,
                        'fulladdress' => NULL,
                        'birthday' => $birth_day[$key],
                        'country' => NULL
                    ]);
                }
            }
        }
        else {
            array_push($customer, [
                'fullname' => $fullname,
                'type' => 'ADULT',
                'passportno' => $passport,
                'email' => $email,
                'mobile' => $mobile,
                'fulladdress' => $address
            ]);
        }

        return $customer;
    }

    private function setRoutes($route_id, $departdate, $returndate = null, $adult, $child, $infant, $addons, $addon_detail) {
        $route = [];
        $traveldate = $returndate != null ? [$departdate, $returndate] : $departdate;
        $passenger = $adult + $child + $infant;

        if(is_array($traveldate)) {
            foreach($route_id as $key => $_route) {
                $route_addons = [];
                $amount = 0;
                $r = $this->getRoute($_route);
                $amount += $r->regular_price*$adult;
                $amount += $r->child_price*$child;
                $amount += $r->infant_price*$infant;

                // Log::debug($addons);
                if(!empty($addons[$key])) {
                    $route_addons = $this->setRouteAddon($addons[$key], $addon_detail[$key], $passenger);
                }

                array_push($route, [
                    'route_id' => $_route,
                    'traveldate' => $traveldate[$key],
                    'amount' => $amount,
                    'type' => NULL,
                    'route_addons' => $route_addons
                ]);
            }
        }
        else {
            $amount = 0;
            $route_addons = [];
            $r = $this->getRoute($route_id[0]);
            $amount += $r->regular_price*$adult;
            $amount += $r->child_price*$child;
            $amount += $r->infant_price*$infant;

            if(!empty($addons[0])) {
                $route_addons = $this->setRouteAddon($addons[0], $addon_detail[0], $passenger);
            }

            array_push($route, [
                'route_id' => $route_id[0],
                'traveldate' => $traveldate,
                'amount' => $amount,
                'type' => NULL,
                'route_addons' => $route_addons
            ]);
        }

        return $route;
    }

    private function setRouteAddon($addons, $addon_detail, $passenger) {
        $_addon = [];
        foreach($addons as $index => $addon) {
            $a = $this->getRouteAddonById($addon);
            if($a) {
                $amount = $a->isservice_charge == 'Y' ? $a->price : 0;
                array_push($_addon, [
                    'route_addon_id' => $a->id,
                    'amount' => $amount * $passenger,
                    'description' => $addon_detail[$index]
                ]);
            }
        }

        return $_addon;
    }

    private function getRouteAddonById($id) {
        $addon = RouteAddons::find($id);
        if(isset($addon)) return $addon;
        else return false;
    }

    private function getRoute($route_id) {
        $route = Route::find($route_id);
        return isset($route) ? $route : false;
    }

    private function checkBooking($booking_id) {
        $booking = Bookings::find($booking_id);
        return isset($booking) ?: false;
    }

    private function routeAmount($route, $adult, $child, $infant) {
        $amount = 0;
        foreach($route as $_route) {
            $_r = $this->getRoute($_route);
            $amount += $_r->regular_price*$adult;
            $amount += $_r->child_price*$child;
            $amount += $_r->infant_price*$infant;
        }

        return $amount;
    }

    private function extraAddon($addon_id, $addon_qty) {
        $addons = [];
        $addon_amount = 0;
        foreach($addon_qty as $key => $addon) {
            if($addon != NULL) {
                foreach($addon as $key2 => $qty) {
                    if($qty != 0) {
                        $_addon = Addon::find($addon_id[$key][$key2]);
                        $amount = $_addon->amount*$qty;
                        $addon_amount += $amount;
                        array_push($addons, ['addon_id' => $_addon->id, 'amount' => $amount]);
                    }
                }
            }
        }

        return array($addon_amount, $addons);
    }


    // 7 Booking controller

    public function complete(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            $c = new BookingHelper;
            $complete = $c->completeBooking($request->booking_id);
            return response()->json(['result' => true, 'data' => $complete]);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function destroy(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            return response()->json(['result' => true, 'data' => 'canceled.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function update(Request $request) {
        if($this->checkBooking($request->booking_id)) {
            return response()->json(['result' => true, 'data' => 'updated.']);
        }

        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    public function getBookingById(string $id = null) {
        $booking = Bookings::find($id);
        if(isset($booking)) return response()->json(['result' => true, 'data' => $booking]);
        return response()->json(['result' => false, 'data' => 'No Booking.']);
    }

    private function getBookingByBookingNumber($bookingno) {
        return Bookings::where('bookingno', $bookingno)->with('bookingCustomers', 'bookingRoutes', 'bookingRoutesX', 'payments')->first();
    }

    public function bookingRecord(string $bookingno = null, string $email = null) {
        $booking = $this->getBookingByBookingNumber($bookingno);
        if(isset($booking)) {
            $cus_email = '';
            foreach($booking->bookingCustomers as $lead) { if($lead->email != NULL) $cus_email = $lead->email; }
            if($cus_email == $email) {
                $addons = $this->getRouteAddon($booking);
                $booking_routes = $booking->bookingRoutes->toArray();
                $last_route = end($booking_routes);
                $m_route = $this->getRouteMultiple($last_route['station_to_id']);
                $m_from_route = $last_route['station_to'];

                return response()->json(['result' => true, 'data' => new BookingResource($booking), 'addon' => $addons, 'm_route' => $m_route, 'm_from_route' => $m_from_route], 200);
            }
        }

        return response()->json(['result' => false, 'data' => 'No booking record.'], 200);
    }

    private function getRouteAddon($booking) {
        $_booking = json_decode($booking, true);
        $addons = [
            'meals' => [],
            'activities' => []
        ];
        foreach($_booking['booking_routes_x'] as $route) {
            $route = Route::find($route['route_id']);
            $addons['meals'] = $route->meal_lines;
            $addons['activities'] = $route->activity_lines;
        }

        return $addons;
    }

    private function getRouteMultiple($station_id) {
        $route = Route::where('station_from_id', $station_id)
                        ->where('isactive', 'Y')
                        ->where('status', 'CO')
                        ->with('station_to')
                        ->get();

        return $route;
    }

    public function bookingCheckRoute(string $booking_current = null, string $booking_new = null) {
        if($booking_current != $booking_new) {
            $route_current = $this->getRouteByBookingNumber($booking_current);
            $route_new = $this->getRouteByBookingNumber($booking_new);

            if($route_current[0] == $route_new[0]) {
                $booking = $this->getBookingByBookingNumber($booking_new);
                if($route_current[1] == $route_new[1]) {
                    if($route_current[3] == $route_new[3]) {
                        return response()->json(['result' => true, 'status' => '', 'data' => $booking], 200);
                    }
                    else {
                        return response()->json(['result' => true, 'status' => 'not match', 'data' => $booking], 200);
                    }
                }
                else {
                    return response()->json(['result' => true, 'status' => 'unpay', 'data' => $booking], 200);
                }
            }
            else return response()->json(['result' => false, 'status' => 'uncurrect', 'data' => ''], 200);
        }

        return response()->json(['result' => false, 'status' => 'duplicate', 'data' => ''], 200);
    }

    private function getRouteByBookingNumber($bookingno) {
        $booking = Bookings::where('bookingno', $bookingno)->with('bookingRoutes')->first();
        return array($booking->bookingRoutes[0]['route_id'], $booking->ispayment, $booking->status, $booking->departdate);
    }

    public function bookingMerge(Request $request) {
        // $booking_current = $this->getBookingByBookingNumber($request->booking_number);
        // $booking_new = $this->getBookingByBookingNumber($request->booking_number_new);

        $booking = BookingHelper::moveBooking($request->booking_number, $request->booking_number_new);
        return response()->json(['result' => true, 'data' => $booking], 200);
    }

    public function addNewRoute(Request $request) {
        $booking = Bookings::find($request->booking_id);
        $route = Route::find($request->route_id);
        $amount = $booking->amount;
        $new_amount = $this->passengerAmount($booking, $route);
        if($booking->ispayment == 'N') {
            BookingRoutes::create([
                'route_id' => $route->id,
                'traveldate' => $this->dateFormat($request->depart),
                'booking_id' => $booking->id,
                'amount' => $amount
            ]);

            $booking->amount = $amount + $new_amount;
            $booking->totalamt = $booking->extraamt + $amount + $new_amount;
            $booking->save();
        }
    }

    private function dateFormat($date) {
        $ex = explode('/', $date);
        return $ex[2].'-'.$ex[1].'-'.$ex[0];
    }

    private function passengerAmount($booking, $route) {
        $adult = $booking->adult_passenger*$route->regular_price;
        $child = $booking->child_passenger*$route->child_price;
        $infant = $booking->infant_passenger*$route->infant_price;

        return $adult + $child + $infant;
    }
}
