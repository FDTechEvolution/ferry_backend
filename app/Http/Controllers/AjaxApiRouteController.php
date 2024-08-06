<?php

namespace App\Http\Controllers;

use App\Models\ApiRoutes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AjaxApiRouteController extends Controller
{
    public function edit(string $id)
    {
        // $type = request()->type;

        $apiRoute = ApiRoutes::where('id', $id)->with('api_merchant')->first();
        return view('pages.api_merchants.modal.edit', ['apiRoute' => $apiRoute]);
    }

    public function update(Request $request)
    {
        // $type = $request->type;
        $id = $request->id;
        // $isApplyToAll = isset($request->isapply) ? 'Y' : 'N';

        $apiRoute = ApiRoutes::where('id', $id)->first();

        $apiRoute->seat = $request->seat;
        $apiRoute->discount = $request->discount;
        $apiRoute->ontop = $request->ontop;
        $apiRoute->regular_price = $request->adult_price;
        $apiRoute->child_price = $request->child_price;
        $apiRoute->infant_price = $request->infant_price;

        if($apiRoute->save())
            return redirect()->route('api.edit',['id'=>$apiRoute->api_merchant_id])->withSuccess('saved.');

        // if ($type == 'seat') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['seat'=>$request->seat]);
        //     }else{
        //         $apiRoute->seat = $request->seat;
        //         $apiRoute->save();
        //     }

        // }

        // if ($type == 'discount') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['discount'=>$request->discount]);
        //     }else{
        //         $apiRoute->discount = $request->discount;
        //         $apiRoute->save();
        //     }
        // }

        // if ($type == 'ontop') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['ontop'=>$request->ontop]);
        //     }else{
        //         $apiRoute->ontop = $request->ontop;
        //         $apiRoute->save();
        //     }
        // }

        // if ($type == 'adult') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['regular_price'=>$request->adult]);
        //     }else{
        //         $apiRoute->regular_price = $request->adult_price;
        //         $apiRoute->save();
        //     }
        // }

        // if ($type == 'child') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['child_price'=>$request->child_price]);
        //     }else{
        //         $apiRoute->child_price = $request->child_price;
        //         $apiRoute->save();
        //     }
        // }

        // if ($type == 'infant') {
        //     if ($isApplyToAll == 'Y') {
        //         ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['infant_price'=>$request->infant_price]);
        //     }else{
        //         $apiRoute->infant_price = $request->infant_price;
        //         $apiRoute->save();
        //     }
        // }
    }
}
