<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Models\ApiMerchants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

use App\Models\Section;
use App\Models\Station;
use App\Models\BookingRoutes;
use App\Models\Route;
use App\Models\BookingExtras;
use App\Models\Bookings;
use App\Models\Partners;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        //$sections = $this->getSection();
        //$sections = RouteHelper::getSectionStationFrom(true);
        $partners = Partners::orderBy('name','ASC')->get();

        $stationFromId = request()->station_from;
        $stationToId = request()->station_to;
        $daterange = request()->daterange;
        $partnerId = request()->partner;

        $stationFroms = RouteHelper::getSectionStationFrom(true);

        $routes = Route::where('status', 'CO')
            ->with('station_from', 'station_from.section', 'station_to', 'icons', 'routeAddons', 'activity_lines', 'meal_lines', 'partner');
            if($stationFromId != 'all'){
                $routes = $routes->where('station_from_id',$stationFromId);
            }

        if(empty($stationToId) || $stationToId == ''){
            $stationToId = '';
        }else{
            $routes = $routes->where('station_to_id',$stationToId);
        }
        $routes = $routes->orderBy('depart_time', 'ASC')->get();

        $stationTos = RouteHelper::getSectionStationTo(true,$stationFromId);
        //Log::debug(sizeof($routes));

        $apiMerchants = ApiMerchants::orderBy('name','ASC')->get();

        return view('pages.reports.index', [
            'stationFroms' => $stationFroms,
            'stationTos'=>$stationTos,
            'partners' => $partners,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'daterange' => $daterange,
            'partnerId' => $partnerId,
            'routes'=>$routes,
            'apiMerchants'=>$apiMerchants
        ]);
    }

    public function paymentReport() {
        //$sections = $this->getSection();
        //$sections = RouteHelper::getSectionStationFrom(true);
        $partners = Partners::orderBy('name','ASC')->get();

        $stationFromId = request()->station_from;
        $stationToId = request()->station_to;
        $daterange = request()->daterange;
        $partnerId = request()->partner;

        $stationFroms = RouteHelper::getSectionStationFrom(true);

        $routes = Route::where('status', 'CO')
            ->with('station_from', 'station_from.section', 'station_to', 'icons', 'routeAddons', 'activity_lines', 'meal_lines', 'partner');
            if($stationFromId != 'all'){
                $routes = $routes->where('station_from_id',$stationFromId);
            }

        if(empty($stationToId) || $stationToId == ''){
            $stationToId = '';
        }else{
            $routes = $routes->where('station_to_id',$stationToId);
        }
        $routes = $routes->orderBy('depart_time', 'ASC')->get();

        $stationTos = RouteHelper::getSectionStationTo(true,$stationFromId);
        //Log::debug(sizeof($routes));

        $apiMerchants = ApiMerchants::orderBy('name','ASC')->get();

        return view('pages.reports.payment_report', [
            'stationFroms' => $stationFroms,
            'stationTos'=>$stationTos,
            'partners' => $partners,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'daterange' => $daterange,
            'partnerId' => $partnerId,
            'routes'=>$routes,
            'apiMerchants'=>$apiMerchants
        ]);
    }

    public function result(Request $request){
        //dd($request->all());
        $daterange = $request->date_range;
        $daterangeSplit = explode('-',$daterange);
        $description = '';

        $sql = 'select br.traveldate,b.ispremiumflex, b.bookingno,b.status,b.adult_passenger,b.child_passenger,b.infant_passenger,
 c.fullname,c.title,concat(c.mobile_code,c.mobile) as mobileno,c.mobile_th,c.email,
 sf.nickname as station_from_name,st.nickname as station_to_name,DATE_FORMAT(r.depart_time,"%H:%i") as depart_time,DATE_FORMAT(r.arrive_time,"%H:%i") as arrive_time,
ra.name as addon_name, bx.description ,b.id,p.paymentno,p.status as payment_status,b.book_channel,pa.name as partner_name
from
	bookings b
    join payments p on b.id = p.booking_id
    join booking_customers bc on (b.id = bc.booking_id and bc.isdefault="Y")
    join customers c on bc.customer_id = c.id
    join booking_routes br on b.id = br.booking_id
    join routes r on br.route_id = r.id
    join stations sf on r.station_from_id = sf.id
    join stations st on r.station_to_id = st.id
    left join booking_extras bx on br.id = bx.booking_route_id
    left join route_addons ra on bx.route_addon_id = ra.id
    left join partners pa on r.partner_id = pa.id
where b.status = "CO" and :conditions
order by br.traveldate ASC,b.bookingno ASC
';
        //$conditionStr = '(br.traveldate >= "2024-10-01" and br.traveldate <= "2024-10-30")';
        $startDateSql = Carbon::createFromFormat('d/m/Y', trim($daterangeSplit[0]))->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', trim($daterangeSplit[1]))->format('Y-m-d');
        $conditionStr = '(br.traveldate >="' . $startDateSql . '" and br.traveldate <="' . $endDateSql . '") ';

        $description .= sprintf('%s to %s | ',$startDateSql,$endDateSql);

        if(!empty($request->route_id) && $request->route_id !='all'){
            $conditionStr .= ' and r.id ="'.$request->route_id.'"';
            $_route = Route::where('id',$request->route_id)->with(['station_from','station_to'])->first();
            $description .= sprintf('%s - %s time %s/%s | ',$_route->station_from->name,$_route->station_to->name, date('H:i', strtotime($_route->depart_time)),date('H:i', strtotime($_route->arrive_time)));
        }else{
            if(!empty($request->station_from_id) && $request->station_from_id !='all'){
                $conditionStr .= ' and r.station_from_id = "'.$request->station_from_id.'"';
                $_station = Station::where('id',$request->station_from_id)->first();
                $description .= sprintf('From:%s | ',$_station->name);
            }

            if(!empty($request->station_to_id) && $request->station_to_id !='all'){
                $conditionStr .= ' and r.station_to_id = "'.$request->station_to_id.'"';
                $_station = Station::where('id',$request->station_to_id)->first();
                $description .= sprintf('To:%s | ',$_station->name);
            }
        }

        if(!empty($request->partner_id) && $request->partner_id !='all'){
            $conditionStr .= ' and r.partner_id = "'.$request->partner_id.'"';
        }

        if(!empty($request->api_merchant_id) && $request->api_merchant_id !='all'){
            if($request->api_merchant_id == 'admin' || $request->api_merchant_id == 'online'){
                $conditionStr .= ' and b.book_channel = "'.$request->api_merchant_id.'"';
            }else{
                $conditionStr .= ' and b.api_merchant_id = "'.$request->api_merchant_id.'"';
            }

        }

        $sql = str_replace(':conditions', $conditionStr, $sql);

        $bookings = DB::select($sql);

        return view('pages.reports.result',[
            'bookings'=>$bookings,'title'=>'Route Report','description'=>$description
        ]);
    }


    public function paymentResult(Request $request){
        //dd($request->all());
        $daterange = $request->date_range;
        $daterangeSplit = explode('-',$daterange);
        $description = '';
        //dd($daterangeSplit);

        $sql = 'select br.traveldate, b.bookingno,b.status,DATE_FORMAT(p.docdate,"%d-%m-%Y") as docdate,
 c.fullname,c.title,concat(c.mobile_code,c.mobile) as mobileno,c.mobile_th,c.email,
 sf.name as station_from_name,st.name as station_to_name,t.ticketno,p.amount,p.totalamt,pfee.amount as fee,ppremium.amount as pflex,
ra.name as addon_name, p.discount,bx.description ,b.id,p.paymentno,p.status as payment_status,b.book_channel,pa.name as partner_name
from
	bookings b
    join payments p on b.id = p.booking_id
    join booking_customers bc on (b.id = bc.booking_id and bc.isdefault="Y")
    join customers c on bc.customer_id = c.id
    join booking_routes br on b.id = br.booking_id
    join tickets t on br.id = t.booking_route_id
    join routes r on br.route_id = r.id
    join stations sf on r.station_from_id = sf.id
    join stations st on r.station_to_id = st.id
    left join booking_extras bx on br.id = bx.booking_route_id
    left join route_addons ra on bx.route_addon_id = ra.id
    left join partners pa on r.partner_id = pa.id
    left join (
		select payment_id,amount from payment_lines where type = "FEE"
    ) as pfee on p.id = pfee.payment_id
     left join (
		select payment_id,amount from payment_lines where type = "PREMIUM"
    ) as ppremium on p.id = ppremium.payment_id
where b.status = "CO" and :conditions
order by p.docdate ASC,b.bookingno ASC
';
        //$conditionStr = '(br.traveldate >= "2024-10-01" and br.traveldate <= "2024-10-30")';
        $startDateSql = Carbon::createFromFormat('d/m/Y', trim($daterangeSplit[0]))->format('Y-m-d');
        $endDateSql = Carbon::createFromFormat('d/m/Y', trim($daterangeSplit[1]))->format('Y-m-d');
        $conditionStr = '(DATE_FORMAT(p.docdate,"%Y-%m-%d") >="' . $startDateSql . '" and DATE_FORMAT(p.docdate,"%Y-%m-%d") <="' . $endDateSql . '") ';

        $description .= sprintf('%s to %s | ',$startDateSql,$endDateSql);

        if(!empty($request->route_id) && $request->route_id !='all'){
            $conditionStr .= ' and r.id ="'.$request->route_id.'"';
            $_route = Route::where('id',$request->route_id)->with(['station_from','station_to'])->first();
            $description .= sprintf('%s - %s time %s/%s | ',$_route->station_from->name,$_route->station_to->name, date('H:i', strtotime($_route->depart_time)),date('H:i', strtotime($_route->arrive_time)));
        }else{
            if(!empty($request->station_from_id) && $request->station_from_id !='all'){
                $conditionStr .= ' and r.station_from_id = "'.$request->station_from_id.'"';
                $_station = Station::where('id',$request->station_from_id)->first();
                $description .= sprintf('From:%s | ',$_station->name);
            }

            if(!empty($request->station_to_id) && $request->station_to_id !='all'){
                $conditionStr .= ' and r.station_to_id = "'.$request->station_to_id.'"';

                $_station = Station::where('id',$request->station_to_id)->first();
                $description .= sprintf('To:%s | ',$_station->name);
            }
        }

        if(!empty($request->partner_id) && $request->partner_id !='all'){
            $conditionStr .= ' and r.partner_id = "'.$request->partner_id.'"';
        }

        if(!empty($request->api_merchant_id) && $request->api_merchant_id !='all'){
            if($request->api_merchant_id == 'admin' || $request->api_merchant_id == 'online'){
                $conditionStr .= ' and b.book_channel = "'.$request->api_merchant_id.'"';
            }else{
                $conditionStr .= ' and b.api_merchant_id = "'.$request->api_merchant_id.'"';
            }

        }

        $sql = str_replace(':conditions', $conditionStr, $sql);

        $bookings = DB::select($sql);

        return view('pages.reports.payment',[
            'bookings'=>$bookings,'title'=>'Payment Report','description'=>$description
        ]);


        //$bookings = Bookings::with(['bookingCustomers'])
    }

}
