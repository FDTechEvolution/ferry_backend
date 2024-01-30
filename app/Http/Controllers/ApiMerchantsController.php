<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ApiMerchants;
use App\Models\ApiRoutes;

class ApiMerchantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $api_merchant = ApiMerchants::get();
        return view('pages.api_merchants.index', ['merchant' => $api_merchant]);
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
    public function update(Request $request, string $id)
    {
        $api_merchant = ApiMerchants::find($id);
        $api_merchant->commission = $request->commission;
        $api_merchant->vat = $request->vat;
        $api_merchant->save();

        $api_route = $this->updateCommissionVat($api_merchant->id, $api_merchant->commission, $api_merchant->vat);
        if($api_route) return redirect()->route('api.index')->withSuccess('Commission and Vat updated.');
        return redirect()->route('api.index')->withFail('Something is wrong. Please try again.');
    }

    private function updateCommissionVat($api_merchant_id, $_comm, $_vat) {
        $api_route = ApiRoutes::where('api_merchant_id', $api_merchant_id)->get();
        foreach($api_route as $index => $route) {
            $net_price = intval($route->regular_price) - intval($route->discount);
            $commission = (($net_price * (intval($_comm) + 100)) / 100 ) - $net_price;
            $commission = $commission > 50 ? $commission : 50;
            $vat = (($commission * (intval($_vat) + 100)) / 100) - $commission;

            $route->commission = $commission;
            $route->vat = $vat;
            $route->totalamt = ($route->regular_price - $route->discount) + $commission + $vat;
            $api_route[$index]->save();
        }

        return true;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
