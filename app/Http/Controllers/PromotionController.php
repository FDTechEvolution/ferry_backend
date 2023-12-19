<?php

namespace App\Http\Controllers;

use App\Models\Promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Route;
use App\Helpers\ImageHelper;
use App\Helpers\BookingHelper;

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
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->with('station_from', 'station_to')->get();

        return view('pages.promotion.create', ['stations' => $stations, 'routes' => $routes,'tirpTypes'=>$tirpTypes]);
    }

    public function edit($id){
        $promotion = Promotions::where('id', $id)->first();
        $tripTypes = BookingHelper::tripType();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->with('station_from', 'station_to')->get();

        return view('pages.promotion.edit', ['promotion' => $promotion,'stations' => $stations, 'routes' => $routes,'tripTypes'=>$tripTypes]);

    }

    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'code' => 'required|string',
            'discount' => 'decimal:2|required',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|decimal:2',
            'title' => 'required|string',
        ]);

        $promotion = Promotions::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'times_use_max' => $request->times_use_max,
            'title' => $request->title,
            'isactive' => 'Y',
        ]);



        if (!$promotion) {
            return redirect()->route('promotion-index')->withFail('Something is wrong. Please try again.');
        }
        if(!isset($request->isactive)){
            $promotion->isactive = 'N';
        }
        //Save conditions
        if($request->trip_type !='all'){
            $promotion->trip_type = $request->trip_type;
        }
        if($request->station_from_id !=null && $request->station_from_id !=''){
            $promotion->station_from_id = $request->station_from_id;
        }
        if($request->station_to_id !=null && $request->station_to_id !=''){
            $promotion->station_to_id = $request->station_to_id;
        }
        if($request->route_id !=null && $request->route_id !=''){
            $promotion->route_id = $request->route_id;
        }

        //check has image
        if ($request->hasFile('image_file')) {
            $imageHelper = new ImageHelper();
            $image = $imageHelper->upload($request->image_file, 'promotion');
            $promotion->image_id = $image->id;
        }

        $promotion->save();


        return redirect()->route('promotion-index')->withSuccess('Promotion code saved.');
    }

    public function update(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'discount' => 'decimal:2|required',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|decimal:2',
            'title' => 'required|string',
        ]);

        $promotion = Promotions::where('id',$request->id)->first();

        if(is_null($promotion)){
            return redirect()->route('promotion-index');
        }

        if ($request->hasFile('image_file')) {
            $imageHelper = new ImageHelper();
            $image = $imageHelper->upload($request->image_file, 'promotion');
            $promotion->image_id = $image->id;
        }

        


    }

    public function destroy(string $id = null)
    {
        $promotion = Promotions::where('id', $id)->first();

        $promotion->forceDelete();
        return redirect()->route('promotion-index')->withSuccess('Promotion deleted...');

    }
}
