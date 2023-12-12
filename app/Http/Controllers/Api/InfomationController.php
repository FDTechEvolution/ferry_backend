<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Informations;

class InfomationController extends Controller
{
    public function getTermAndCondition() {
        $info = Informations::where('position', 'TERM_TICKET')->select(['body'])->first();

        return response()->json(['data' => $info], 200);
    }
}
