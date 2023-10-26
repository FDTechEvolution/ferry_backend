<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Fare;

class FareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $fares = Fare::orderBy('seq', 'ASC')->get();
        $updated_at = $fares[0]->updated_at;

        return view('pages.fare.index', ['fares' => $fares, 'updated_at' => $updated_at]);
    }

    public function update(Request $request) {
        $result = true;
        foreach($request->fare_id as $index => $id) {
            $fare = Fare::find($id);
            $fare->standard_thb = $request->standard_thb[$index];
            $fare->standard_percent = $request->standard_percent[$index];
            $fare->online_thb = $request->online_thb[$index];
            $fare->online_percent = $request->online_percent[$index];
            if($fare->save()) $result = true;
            else {
                $result = false;
                return;
            }
        }

        if($result) return redirect()->route('fare-index')->withSuccess('Fare updated.');
        else return redirect()->route('meals-index')->withFail('Something is wrong. Please try again.');
    }
}
