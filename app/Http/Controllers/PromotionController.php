<?php

namespace App\Http\Controllers;

use App\Models\Promotions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Station;
use App\Models\Route;
use App\Helpers\ImageHelper;

class PromotionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $promotions = Promotions::with(['image'])
            ->orderBy('isactive', 'DESC')
            ->orderBy('created_at', 'DESC')->get();
        return view('pages.promotion.index', ['promotions' => $promotions]);
    }

    public function create()
    {
        $stations = Station::where('isactive', 'Y')->where('status', 'CO')->get();
        $routes = Route::where('isactive', 'Y')->where('status', 'CO')->with('station_from', 'station_to')->get();

        return view('pages.promotion.create', ['stations' => $stations, 'routes' => $routes]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'discount' => 'integer|nullable',
            'discount_type' => 'required|string',
            'times_use_max' => 'required|integer',
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

        //check has image
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
