<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\ApiRoutes;

class ApiRoutesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($merchant_id)
    {
        $api_routes = ApiRoutes::where('api_merchant_id', $merchant_id)->with('route')->get();
        // Log::debug($api_routes->toArray());

        return view('pages.api_routes.index', ['routes' => $api_routes]);
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
        $api_route->regular_price = $request->regular;
        $api_route->discount = $request->discount;
        $api_route->totalamt = $request->amount;

        if($api_route->save()) {
            return response()->json(['result' => true], 200);
        }
        return response()->json(['result' => false], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
