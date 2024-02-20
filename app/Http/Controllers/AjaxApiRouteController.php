<?php

namespace App\Http\Controllers;

use App\Models\ApiRoutes;
use Illuminate\Http\Request;

class AjaxApiRouteController extends Controller
{
    public function edit(string $id)
    {
        $type = request()->type;

        $apiRoute = ApiRoutes::where('id', $id)->first();
        return view('pages.api_merchants.modal.edit', ['apiRoute' => $apiRoute, 'type' => $type]);
    }

    public function update(Request $request)
    {
        $type = $request->type;
        $id = $request->id;
        $isApplyToAll = isset($request->isapply) ? 'Y' : 'N';

        $apiRoute = ApiRoutes::where('id', $id)->first();

        if ($type == 'seat') {
            if ($isApplyToAll == 'Y') {
                ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['seat'=>$request->seat]);
            }else{
                $apiRoute->seat = $request->seat;
                $apiRoute->save();
            }

        }

        if ($type == 'discount') {
            if ($isApplyToAll == 'Y') {
                ApiRoutes::where('api_merchant_id',$apiRoute->api_merchant_id)->update(['discount'=>$request->discount]);
            }else{
                $apiRoute->discount = $request->discount;
                $apiRoute->save();
            }
        }


        return redirect()->route('api.edit',['id'=>$apiRoute->api_merchant_id])->withSuccess('saved.');
    }
}
