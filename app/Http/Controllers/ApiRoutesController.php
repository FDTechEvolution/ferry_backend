<?php

namespace App\Http\Controllers;

use App\Helpers\CalendarHelper;
use App\Models\ApiMerchants;
use App\Models\RouteCalendars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ApiRoutes;
use App\Models\Route;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiRoutesController extends Controller
{
    public function index($merchant_id)
    {
        $api_merchant = $this->getApiMerchantById($merchant_id);
        $api_routes = ApiRoutes::where('api_merchant_id', $merchant_id)->with('route', 'api_merchant')->get();

        return view('pages.api_routes.index', ['routes' => $api_routes, 'merchant_id' => $merchant_id,
                    'commission' => $api_merchant->commission, 'vat' => $api_merchant->vat,'api_merchant'=>$api_merchant]);
    }

    private function getApiMerchantById($id) {
        return ApiMerchants::find($id);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $api_route = ApiRoutes::find($request->id);
        $api_route->route;
        $api_route->api_merchant;

        $api_merchant = ApiMerchants::find($api_route->api_merchant_id);
        $net_price = intval($request->regular) - intval($request->discount);
        // $commission = (($net_price * (100 + intval($api_merchant->commission))) / 100 ) - $net_price;
        // $commission = $commission > 50 ? $commission : 50;
        // $vat = (($commission * (100 + intval($api_merchant->vat))) / 100) - $commission;

        $api_route->regular_price = $request->regular;
        $api_route->discount = $request->discount;
        $api_route->totalamt = $net_price;
        // $api_route->commission = $commission;
        // $api_route->vat = $vat;
        // $api_route->totalamt = $net_price + $commission + $vat;

        if($api_route->save()) return response()->json(['result' => true, 'data' => $api_route], 200);
        return response()->json(['result' => false], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function updateCommission() {
        $api_route = ApiRoutes::get();
        foreach($api_route as $index => $route) {
            $net_price = intval($route->regular_price) - intval($route->discount);
            $commission = (($net_price * 105 ) / 100 ) - $net_price;
            $commission = $commission > 50 ? $commission : 50;
            $vat = (($commission * 107) / 100) - $commission;

            $route->commission = $commission;
            $route->vat = $vat;
            $route->totalamt = ($route->regular_price - $route->discount) + $commission + $vat;
            $api_route[$index]->save();
        }

        return redirect()->back();
    }

    public function updateroute($merchant_id) {
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->select(['id', 'regular_price'])->get();
        foreach($routes as $route) {
            ApiRoutes::create([
                'route_id' => $route->id,
                'regular_price' => $route->regular_price,
                'api_merchant_id' => $merchant_id,
                'totalamt' => $route->regular_price
            ]);
        }

        return redirect()->back();
    }

    public function updateStatus($id) {
        $api_route = ApiRoutes::find($id);
        $api_route->route;
        $api_route->api_merchant;

        $api_route->isactive = $api_route->isactive == 'Y' ? 'N' : 'Y';

        if($api_route->save()) return response()->json(['result' => true, 'data' => $api_route], 200);
        return response()->json(['result' => false], 200);
    }


    public function calendar(string $apiRouteId){
        $apiRouteId = request()->query('api_route_id');
        $month = request()->query('month');
        $year = request()->query('year');

        //dd($apiRouteId);
        $apiRoute = ApiRoutes::where('id',$apiRouteId)->first();
        //dd($apiRoute);
        $apiMerchant = ApiMerchants::where('id',$apiRoute->api_merchant_id)->with('apiRoutes')->first();

        $date = Carbon::now();
        if(!is_null($month) && !is_null($year)){
            $date = Carbon::createFromFormat('Y-m-d',  sprintf('%s-%s-01',$year,$month));
        }
        $month = $date->format('m');
        $year = $date->format('Y');

        $monthCalendar =  CalendarHelper::getMonthCalendar($date);
        //dd($monthCalendar);
        $routeCalendars = RouteCalendars::where('api_route_id',$apiRouteId)
            ->whereMonth('date', '=', $month)
            ->whereYear('date','=',$year)
            ->orderBy('date','ASC')->get();


        $dateDatas = [];
        foreach($routeCalendars as $routeCalendar){
            $dateDatas[$routeCalendar->date] = [
                'id'=>$routeCalendar->id,
                'seat'=>$routeCalendar->seat
            ];
        }
        //dd($dateDatas);

        foreach($monthCalendar as $index=> $row){
            foreach($row as $i=> $col){

                if(isset($dateDatas[$col['date']])){
                    $monthCalendar[$index][$i]['seat'] =$dateDatas[$col['date']]['seat'];
                    $monthCalendar[$index][$i]['id'] = $dateDatas[$col['date']]['id'];
                }else{
                    $monthCalendar[$index][$i]['seat'] = $apiRoute->seat;
                    $monthCalendar[$index][$i]['id'] = null;
                }

            }
        }


        $monthOptions = [
            '01'=>'Janaury',
            '02'=>'February',
            '03'=>'March',
            '04'=>'April',
            '05'=>'May',
            '06'=>'June',
            '07'=>'July',
            '08'=>'August',
            '09'=>'September',
            '10'=>'October',
            '11'=>'November',
            '12'=>'December',

        ];

        $years = [
            '2024'=>'2024',
            '2025'=>'2025',
            '2026'=>'2026',
            '2027'=>'2027'
        ];

        return view('pages.api_routes.calendar',[
            'monthCalendar'=>$monthCalendar,
            'apiRouteId'=>$apiRouteId,
            'apiMerchant'=>$apiMerchant,
            'date'=>$date,
            'month'=>$month,
            'year'=>$year,
            'monthOptions'=>$monthOptions,
            'years'=>$years
        ]);
    }


    public function multipleDelete(Request $request){
        $apiRouteIds = $request->api_route_id;
        $api_merchant_id = $request->api_merchant_id;

        DB::table('api_routes')->whereIn('id', $apiRouteIds)->delete();

        return redirect()->route('api.edit',['id'=>$api_merchant_id])->withSuccess('deleted.');
    }
}
