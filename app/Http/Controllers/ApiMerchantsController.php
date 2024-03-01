<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ApiMerchants;
use App\Models\ApiRoutes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ApiMerchantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $api_merchant = ApiMerchants::where('name','SEVEN')->first();
        $apiMerchants = ApiMerchants::where('name','!=','SEVEN')->get();
        return view('pages.api_merchants.index', ['merchant' => $api_merchant,'apiMerchants'=>$apiMerchants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $api_key = Str::random(30);
         return view('pages.api_merchants.modal.create',['api_key'=>$api_key]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'code'=>'required|string|unique:api_merchants,code'
        ]);

        $apiMerchant = ApiMerchants::create($request->all());
        return redirect()->route('api.edit',['id'=>$apiMerchant->id])->withSuccess('saved.');
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
        $apiMerchant = ApiMerchants::with(['apiRoutes','apiRoutes.partner','apiRoutes.partner.image','apiRoutes.station_from','apiRoutes.station_to'])->where('id',$id)->first();

        return view('pages.api_merchants.edit',['apiMerchant'=>$apiMerchant]);
    }

    public function addRoute(String $id){

        $sql = 'select
        r.id as route_id,p.name,img.path,concat(sf.name," [",sf.nickname,"] - ",st.name," [",st.nickname,"]") as route_name,
        r.depart_time,r.arrive_time,apir.isactive
        from
            routes r
            left join partners p on r.partner_id = p.id
            left join images img on p.image_id = img.id
            join stations sf on (r.station_from_id = sf.id and sf.isactive="Y")
            join stations st on (r.station_to_id = st.id and st.isactive="Y")
            left join api_routes apir on (apir.route_id = r.id and apir.api_merchant_id = ?)
        where r.status="CO" and r.isactive="Y" and (apir.isactive is null or apir.isactive = "N") order by apir.isactive desc,sf.name ASC,st.name ASC,r.depart_time ASC';

        $routes = DB::select($sql, [$id]);

        return view('pages.api_merchants.modal.add_route',['id'=>$id,'routes'=>$routes]);
    }

    public function storeRoute(Request $request){
        $apiMerchantId = $request->api_merchant_id;
        $routes = $request->routes;

        //ApiRoutes::where('api_merchant_id',$apiMerchantId)->where('isactive','Y')->update(['isactive'=>'N']);

        foreach($routes as $routeId){
            $apiRoute = ApiRoutes::updateOrCreate(
                ['api_merchant_id'=>$apiMerchantId,'route_id'=>$routeId],
                [
                    'route_id'=>$routeId,
                    'isactive'=>'Y',
                    'api_merchant_id'=>$apiMerchantId
                ]
            );
        }

        return redirect()->route('api.edit',['id'=>$apiMerchantId])->withSuccess('saved.');
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
        ApiRoutes::where('api_merchant_id',$id)->delete();
        ApiMerchants::where('id',$id)->delete();

        return redirect()->route('api.index')->withSuccess('deleted.');
    }
}
