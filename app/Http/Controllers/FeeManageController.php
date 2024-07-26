<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\FeeSetting;

class FeeManageController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $fee = FeeSetting::get();
        return view('pages.fee_manage.index', ['fee' => $fee]);
    }

    public function update(Request $request) {
        $result = true;
        foreach($request['is_fee'] as $id) {
            $fee = FeeSetting::find($id);
            $type = $fee->type;
            $fee->regular_pf = $request['regular_pf_'.$type];
            $fee->child_pf = $request['child_pf_'.$type];
            $fee->infant_pf = $request['infant_pf_'.$type];
            $fee->percent_pf = $request['percent_pf_'.$type];
            $fee->is_pf_perperson = $request['is_pf_perperson_'.$type];
            $fee->regular_sc = $request['regular_sc_'.$type];
            $fee->child_sc = $request['child_sc_'.$type];
            $fee->infant_sc = $request['infant_sc_'.$type];
            $fee->percent_sc = $request['percent_sc_'.$type];
            $fee->is_sc_perperson = $request['is_sc_perperson_'.$type];
            $fee->isuse_pf = isset($request['isuse_pf_'.$type]) ? $request['isuse_pf_'.$type] : 'N';
            $fee->isuse_sc = isset($request['isuse_sc_'.$type]) ? $request['isuse_sc_'.$type] : 'N';

            if($fee->save()) $result = true;
            else {
                $result = false;
                return;
            }

        }
        if($result) return redirect()->route('fee.index')->withSuccess('Fee Updated.');
        else return redirect()->route('fee.index')->withFail('Something is wrong. Please try again.');
    }
}
