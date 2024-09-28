<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ApiMerchants;
use App\Models\ApiRoutes;
use App\Models\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Helpers\ImageHelper;
use App\Helpers\RouteHelper;


class ApiMerchantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        //$api_merchant = ApiMerchants::where('name','SEVEN')->first();
        $apiMerchants = ApiMerchants::with('image')->get();
        return view('pages.api_merchants.index', ['apiMerchants' => $apiMerchants]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $api_key = Str::random(50);
        return view('pages.api_merchants.modal.create', ['api_key' => $api_key]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'key' => 'required|string',
            'code' => 'required|string|unique:api_merchants,code',
        ]);

        $apiMerchant = ApiMerchants::create($request->all());

        //logo
        $this->uploadFile($request,$apiMerchant);

        return redirect()->route('api.edit', ['id' => $apiMerchant->id])->withSuccess('saved.');
    }

    private function uploadFile(Request $request, $apiMerchant)
    {
        //$file = $request->file('logofile');
        if ($request->hasFile('logofile')) {
            $imageHelper = new ImageHelper();
            $image = $imageHelper->upload($request->logofile, 'agent',true,$apiMerchant->code);

            ApiMerchants::where('id', $apiMerchant->id)->update(['image_id' => $image->id]);
        }
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
        $stationFromId = request()->sf;
        $stationToId = request()->st;
        $stationFroms = RouteHelper::getStationFrom();

        $stationTos = RouteHelper::getStationTo($stationFromId);

        $routes = [];
        if($stationFromId != 'all' || $stationToId !='all'){
            $routes = Route::select('id');
            if($stationFromId != 'all'){
                $routes = $routes->where('station_from_id',$stationFromId);
            }

            if($stationToId != 'all'){
                $routes = $routes->where('station_to_id',$stationToId);
            }

            $routes = $routes->get();
        }



        $apiMerchant = ApiMerchants::where('id', $id)->first();

        $apiRoutes = ApiRoutes::where('api_merchant_id',$id);
        if(sizeof($routes) >0){
            $apiRoutes = $apiRoutes->whereIn('route_id',$routes);
        }
        $apiRoutes =  $apiRoutes->with(['route'])->get();

        // Log::debug($apiMerchant->toArray());
        return view('pages.api_merchants.edit', [
            'apiMerchant' => $apiMerchant,
            'stationFroms' => $stationFroms,
            'stationTos' => $stationTos,
            'stationFromId' => $stationFromId,
            'stationToId' => $stationToId,
            'apiRoutes'=>$apiRoutes
        ]);
    }

    public function addRoute(string $id)
    {

        $sql = 'select
        r.id as route_id,p.name,img.path,concat(sf.name," [",sf.nickname,"] - ",st.name," [",st.nickname,"]") as route_name,
        r.depart_time,r.arrive_time,apir.isactive,concat(sf.name," [",sf.nickname,"]") as station_from,concat(st.name," [",st.nickname,"]") as station_to
        from
            routes r
            left join partners p on r.partner_id = p.id
            left join images img on p.image_id = img.id
            join stations sf on (r.station_from_id = sf.id and sf.isactive="Y")
            join stations st on (r.station_to_id = st.id and st.isactive="Y")
            left join api_routes apir on (apir.route_id = r.id and apir.api_merchant_id = ?)
        where r.status="CO" and r.isactive="Y" and (apir.isactive is null or apir.isactive = "N") order by apir.isactive desc,sf.name ASC,st.name ASC,r.depart_time ASC';

        $routes = DB::select($sql, [$id]);

        return view('pages.api_merchants.modal.add_route', ['id' => $id, 'routes' => $routes]);
    }

    public function storeRoute(Request $request)
    {
        $apiMerchantId = $request->api_merchant_id;
        $routes = $request->routes;
        //dd($request);
        //ApiRoutes::where('api_merchant_id',$apiMerchantId)->where('isactive','Y')->update(['isactive'=>'N']);

        if (!empty($request->routes)) {
            foreach ($routes as $routeId) {
                $apiRoute = ApiRoutes::updateOrCreate(
                    ['api_merchant_id' => $apiMerchantId, 'route_id' => $routeId],
                    [
                        'route_id' => $routeId,
                        'isactive' => 'Y',
                        'api_merchant_id' => $apiMerchantId,
                        'regular_price' => $request['adult_' . $routeId] ?? 0,
                        'child_price' => $request['child_' . $routeId] ?? 0,
                        'infant_price' => $request['infant_' . $routeId] ?? 0,
                        'seat' => $request['seat_' . $routeId] ?? 100,
                    ],
                );
            }

            return redirect()->route('api.edit', ['id' => $apiMerchantId])->withSuccess('Saved.');
        }

        return redirect()->route('api.edit', ['id' => $apiMerchantId])->withFail('Please Select Route.');
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
        if ($api_route)
            return redirect()->route('api.index')->withSuccess('Commission and Vat updated.');
        return redirect()->route('api.index')->withFail('Something is wrong. Please try again.');
    }

    private function updateCommissionVat($api_merchant_id, $_comm, $_vat)
    {
        $api_route = ApiRoutes::where('api_merchant_id', $api_merchant_id)->get();
        foreach ($api_route as $index => $route) {
            $net_price = intval($route->regular_price) - intval($route->discount);
            $commission = (($net_price * (intval($_comm) + 100)) / 100) - $net_price;
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
        ApiRoutes::where('api_merchant_id', $id)->delete();
        ApiMerchants::where('id', $id)->delete();

        return redirect()->route('api.index')->withSuccess('deleted.');
    }

    public function editMerchant(string $id)
    {

        $apiMerchant = ApiMerchants::where('id', $id)->first();

        return view('pages.api_merchants.modal.edit_merchant', [
            'apiMerchant' => $apiMerchant,
        ]);
    }

    public function updateMerchant(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
        ]);

        $apiMerchant = ApiMerchants::where('id', $request->id)->first();

        $apiMerchant->name = $request->name;
        $apiMerchant->isopenregular = isset($request->isopenregular) ? 'Y' : 'N';
        $apiMerchant->isopenchild = isset($request->isopenchild) ? 'Y' : 'N';
        $apiMerchant->isopeninfant = isset($request->isopeninfant) ? 'Y' : 'N';
        $apiMerchant->isopendiscount = isset($request->isopendiscount) ? 'Y' : 'N';

        $apiMerchant->save();

        $this->uploadFile($request,$apiMerchant);

        return redirect()->route('api.index')->withSuccess('deleted.');
    }
}
