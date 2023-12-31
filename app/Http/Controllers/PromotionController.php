<?php

namespace App\Http\Controllers;

use App\Models\Promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Route;
use App\Helpers\ImageHelper;
use App\Helpers\BookingHelper;
use Carbon\Carbon;

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

        return view('pages.promotion.create', ['stations' => $stations, 'routes' => $routes, 'tirpTypes' => $tirpTypes]);
    }

    public function edit($id)
    {
        $promotion = Promotions::where('id', $id)->first();
        $tripTypes = BookingHelper::tripType();
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->with('station_from', 'station_to')->get();

        return view('pages.promotion.edit', ['promotion' => $promotion, 'stations' => $stations, 'routes' => $routes, 'tripTypes' => $tripTypes]);

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
        ]);

        //Date custom
        $daterange = $request->daterange;
        $dates = explode('-', $daterange);
        $startDate = trim($dates[0]);
        $endDate = trim($dates[1]);
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');


        $promotion = Promotions::create([
            'code' => $request->code,
            'discount' => $request->discount,
            'discount_type' => $request->discount_type,
            'times_use_max' => $request->times_use_max,
            'title' => $request->title,
            'isactive' => 'Y',
            'depart_date_start' => $startDate,
            'depart_date_end' => $endDate,
            'description' => $request->description,
            'isfreecreditcharge' => isset($request->isfreecreditcharge) ? 'Y' : 'N',
            'isfreepremiumflex' => isset($request->isfreepremiumflex) ? 'Y' : 'N'
        ]);




        if (!$promotion) {
            return redirect()->route('promotion-index')->withFail('Something is wrong. Please try again.');
        }
        if (!isset($request->isactive)) {
            $promotion->isactive = 'N';
        }
        //Save conditions
        if ($request->trip_type != 'all') {
            $promotion->trip_type = $request->trip_type;
        }
        if ($request->station_from_id != null && $request->station_from_id != '') {
            $promotion->station_from_id = $request->station_from_id;
        }
        if ($request->station_to_id != null && $request->station_to_id != '') {
            $promotion->station_to_id = $request->station_to_id;
        }
        if ($request->route_id != null && $request->route_id != '') {
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
            'discount' => 'numeric|required',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|integer',
            'title' => 'required|string',
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
        $startDate = Carbon::createFromFormat('d/m/Y', $startDate)->format('Y-m-d');
        $endDate = Carbon::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');


        $promotion->title = $request->title;
        $promotion->code = $request->code;
        $promotion->discount = $request->discount;
        $promotion->discount_type = $request->discount_type;
        $promotion->times_use_max = $request->times_use_max;
        $promotion->isactive = $request->isactive;
        $promotion->description = $request->description;
        $promotion->depart_date_start =  $startDate;
        $promotion->depart_date_end = $endDate;
        $promotion->trip_type =  $request->trip_type;
        $promotion->isfreecreditcharge = isset($request->isfreecreditcharge) ? 'Y' : 'N';
        $promotion->isfreepremiumflex = isset($request->isfreepremiumflex) ? 'Y' : 'N';



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
}
