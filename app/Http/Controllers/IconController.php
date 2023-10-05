<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Icons;


class IconController extends Controller
{
    //
    static function getListIcon(){
        $icons = Icons::orderby('name','ASC')->get();
        return $icons;
    }
}
