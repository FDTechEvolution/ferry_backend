<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Informations;

class InfomationController extends Controller
{
    public function getInfomation($type) {
        $info = Informations::where('position', $type)->select(['title', 'body'])->first();

        if(isset($info))
            return response()->json(['result' => true, 'data' => $info], 200);
        else
            return response()->json(['result' => false, 'data' => ''], 200);
    }
}
