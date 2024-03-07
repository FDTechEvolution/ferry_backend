<?php

namespace App\Http\Controllers;

use App\Models\ApiMerchants;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ApiRoutes;
use App\Models\Route;

class ApiRoutesController extends Controller
{
    public function index($merchant_id)
    {
        $api_merchant = $this->getApiMerchantById($merchant_id);
        $api_routes = ApiRoutes::where('api_merchant_id', $merchant_id)->with('route', 'api_merchant')->get();
        // Log::debug($api_routes->toArray());

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
        $commission = (($net_price * (100 + intval($api_merchant->commission))) / 100 ) - $net_price;
        $commission = $commission > 50 ? $commission : 50;
        $vat = (($commission * (100 + intval($api_merchant->vat))) / 100) - $commission;

        $api_route->regular_price = $request->regular;
        $api_route->discount = $request->discount;
        $api_route->commission = $commission;
        $api_route->vat = $vat;
        $api_route->totalamt = $net_price + $commission + $vat;

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

        return view('pages.api_routes.calendar');
    }
}
