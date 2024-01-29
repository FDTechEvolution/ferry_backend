<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\PremiumFlex;

class PremiumFlexController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        $pmf = PremiumFlex::orderBy('seq', 'ASC')->get();

        return view('pages.premium_flex.index', ['pmf' => $pmf]);
    }

    public function update(Request $request) {

        $this->updatePMF($request->ol_id, $request->ol_title, $request->ol_body);
        $this->updatePMF($request->pmf_id, $request->pmf_title, $request->pmf_body);

        return redirect()->route('pmf-index')->withSuccess('Premium Flex updated...');
    }

    private function updatePMF($id, $title, $body) {
        $pmf = PremiumFlex::find($id);
        $pmf->title = $title;
        $pmf->body = $body;

        $pmf->save();
    }
}
