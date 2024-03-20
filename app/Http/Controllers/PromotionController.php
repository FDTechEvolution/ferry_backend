<?php

namespace App\Http\Controllers;

use App\Models\PromotionLines;
use App\Models\Promotions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Route;
use App\Helpers\ImageHelper;
use App\Helpers\BookingHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $promotions = Promotions::with(['image'])
            ->orderBy('isactive', 'ASC')
            ->orderBy('created_at', 'DESC')->get();
        return view('pages.promotion.index', ['promotions' => $promotions]);
    }

    public function create()
    {
        $tirpTypes = BookingHelper::tripType();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $routes = Route::where('isactive', 'Y')
            ->where('ispromocode','Y')
            ->with('station_from', 'station_to')->get();

        return view('pages.promotion.create', ['stations' => $stations, 'routes' => $routes, 'tirpTypes' => $tirpTypes]);
    }

    public function edit($id)
    {
        $promotion = Promotions::with(['promotionStationFroms','promotionStationTos'])->where('id', $id)->first();
        $tripTypes = BookingHelper::tripType();

        $sql = 'select r.id as route_id,pl.id as promotion_line_id,p.name,concat(sf.name," [",sf.nickname,"] - ",st.name," [",st.nickname,"]") as route_name,r.depart_time,r.arrive_time,pl.isactive,r.ispromocode from routes r left join partners p on r.partner_id = p.id join stations sf on (r.station_from_id = sf.id and sf.isactive="Y") join stations st on (r.station_to_id = st.id and st.isactive="Y") join promotion_lines pl on (r.id = pl.route_id and pl.type="ROUTE" and pl.promotion_id = ?) where r.status="CO" and r.isactive="Y" and pl.isactive="Y" order by sf.name ASC,st.name ASC,r.depart_time ASC';

        $promotionRoutes = DB::select($sql, [$promotion->id]);


        return view('pages.promotion.edit', ['promotion' => $promotion, 'tripTypes' => $tripTypes,'promotionRoutes'=>$promotionRoutes]);

    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'code' => 'required|string',
            'discount' => 'numeric|required',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|integer',
            'title' => 'required|string',
            'booking_daterange'=>'required|string',
            'daterange'=>'required|string',
        ]);

        //Date custom
        $daterange = $request->daterange;
        $dates = explode('-', $daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $booking_daterange = $request->booking_daterange;
        $dates = explode('-', $daterange);
        $booksStartDate = trim($dates[0]);
        $bookEndDate = trim($dates[1]);

        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
        $booksStartDate = Carbon::createFromFormat('d/m/Y', $booksStartDate)->format('Y-m-d');
        $bookEndDate = Carbon::createFromFormat('d/m/Y', $bookEndDate)->format('Y-m-d');


        $promotion = Promotions::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'times_use_max' => $request->times_use_max,
            'title' => $request->title,
            'isactive' => 'Y',
            'depart_date_start' => $startDate,
            'depart_date_end' => $endDate,
            'booking_start_date' => $startDate,
            'booking_end_date' => $endDate,
            'description' => $request->description,
            'isfreecreditcharge' => isset($request->isfreecreditcharge) ? 'Y' : 'N',
            'isfreepremiumflex' => isset($request->isfreepremiumflex) ? 'Y' : 'N',
            'isfreelongtailboat' => isset($request->isfreelongtailboat) ? 'Y' : 'N',
            'isfreeshuttlebus' => isset($request->isfreeshuttlebus) ? 'Y' : 'N',
            'isfreeprivatetaxi' => isset($request->isfreeprivatetaxi) ? 'Y' : 'N'
        ]);




        if (!$promotion) {
            return redirect()->route('promotion-index')->withFail('Something is wrong. Please try again.');
        }
        if (!isset($request->isactive)) {
            $promotion->isactive = 'N';
        }

        //check has image
        if ($request->hasFile('image_file')) {
            $imageHelper = new ImageHelper();
            $image = $imageHelper->upload($request->image_file, 'promotion');
            $promotion->image_id = $image->id;
        }

        $promotion->save();


        return redirect()->route('promotion-edit',['id'=>$promotion->id])->withSuccess('Promotion code saved.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'discount' => 'numeric|required',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|integer',
            'title' => 'required|string',
            'booking_daterange'=>'required|string',
            'daterange'=>'required|string',
        ]);

        $promotion = Promotions::where('id', $request->id)->first();

        if (is_null($promotion)) {
            return redirect()->route('promotion-index');
        }

        //Date custom
        $daterange = $request->daterange;
        $dates = explode('-', $daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);

        $booking_daterange = $request->booking_daterange;
        $dates = explode('-', $booking_daterange);
        $bookStartDate = trim($dates[0]);
        $bookEndDate = trim($dates[1]);


        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
        $bookStartDate = Carbon::createFromFormat('d/m/Y', $bookStartDate)->format('Y-m-d');
        $bookEndDate = Carbon::createFromFormat('d/m/Y', $bookEndDate)->format('Y-m-d');


        $promotion->title = $request->title;
        $promotion->code = $request->code;
        $promotion->discount = $request->discount;
        $promotion->discount_type = $request->discount_type;
        $promotion->times_use_max = $request->times_use_max;
        $promotion->isactive = $request->isactive;
        $promotion->description = $request->description;
        $promotion->depart_date_start = $startDate;
        $promotion->depart_date_end = $endDate;
        $promotion->booking_start_date = $bookStartDate;
        $promotion->booking_end_date = $bookEndDate;
        $promotion->trip_type = $request->trip_type;
        $promotion->isfreecreditcharge = isset($request->isfreecreditcharge) ? 'Y' : 'N';
        $promotion->isfreepremiumflex = isset($request->isfreepremiumflex) ? 'Y' : 'N';
        $promotion->isfreelongtailboat = isset($request->isfreelongtailboat) ? 'Y' : 'N';
        $promotion->isfreeshuttlebus = isset($request->isfreeshuttlebus) ? 'Y' : 'N';
        $promotion->isfreeprivatetaxi = isset($request->isfreeprivatetaxi) ? 'Y' : 'N';



        if ($request->hasFile('image_file')) {
            $imageHelper = new ImageHelper();
            $image = $imageHelper->upload($request->image_file, 'promotion');
            $promotion->image_id = $image->id;
        }

        $promotion->save();


        return redirect()->route('promotion-index')->withSuccess('Promotion code saved.');

    }

    public function destroy(string $id = null)
    {
        $promotion = Promotions::where('id', $id)->first();

        $promotion->forceDelete();
        return redirect()->route('promotion-index')->withSuccess('Promotion deleted...');

    }

    public function addStation(String $id){
        $type = request()->type;

        $sql = 'select s.id,s.name,s.nickname,pl.id as promotion_line_id,pl.isactive from stations s left join promotion_lines pl on (s.id = pl.station_id and pl.type=? and pl.promotion_id = ?) order by s.name ASC';

        $stations = DB::select($sql, [$type,$id]);
        return view('pages.promotion.modal.add_station',['stations'=>$stations,'type'=>$type,'id'=>$id]);
    }

    public function addRoute(String $id){
        $type = 'ROUTE';

        $sql = 'select r.id as route_id,pl.id as promotion_line_id,p.name,concat(sf.name," [",sf.nickname,"] - ",st.name," [",st.nickname,"]") as route_name,r.depart_time,r.arrive_time,pl.isactive,r.ispromocode from routes r left join partners p on r.partner_id = p.id join stations sf on (r.station_from_id = sf.id and sf.isactive="Y") join stations st on (r.station_to_id = st.id and st.isactive="Y") left join promotion_lines pl on (r.id = pl.route_id and pl.type="ROUTE" and pl.promotion_id = ?) where r.status="CO" and r.isactive="Y" order by sf.name ASC';

        $routes = DB::select($sql, [$id]);
        return view('pages.promotion.modal.add_route',['id'=>$id,'routes'=>$routes,'type'=>$type]);
    }

    public function storeStation(Request $request){
        $promotion_id = $request->promotion_id;
        $type = $request->type;
        $stationIds = $request->stations;

        if(is_null($stationIds)){
            $stationIds = [];
        }

        PromotionLines::where('promotion_id',$promotion_id)->where('isactive','Y')->where('type',$type)->update(['isactive'=>'N']);

        foreach($stationIds as $stationId){
            $promotionLine = PromotionLines::updateOrCreate(
                ['promotion_id'=>$promotion_id,'station_id'=>$stationId,'type'=>$type],
                [
                    'promotion_id'=>$promotion_id,
                    'station_id'=>$stationId,
                    'type'=>$type,
                    'isactive'=>'Y'
                ]
            );
        }

        return redirect()->route('promotion-edit',['id'=>$promotion_id])->withSuccess('Stations saved.');

    }

    public function storeRoute(Request $request){
        $promotion_id = $request->promotion_id;
        $type = $request->type;
        $routeIds = $request->routes;

        if(is_null($routeIds)){
            $routeIds = [];
        }

        PromotionLines::where('promotion_id',$promotion_id)->where('isactive','Y')->where('type','ROUTE')->update(['isactive'=>'N']);

        foreach($routeIds as $routeId){
            $promotionLine = PromotionLines::updateOrCreate(
                ['promotion_id'=>$promotion_id,'route_id'=>$routeId,'type'=>'ROUTE'],
                [
                    'promotion_id'=>$promotion_id,
                    'route_id'=>$routeId,
                    'type'=>'ROUTE',
                    'isactive'=>'Y'
                ]
            );

            Route::where('id',$routeId)->update(['ispromocode'=>'Y']);
        }

        return redirect()->route('promotion-edit',['id'=>$promotion_id])->withSuccess('Stations saved.');
    }
}
