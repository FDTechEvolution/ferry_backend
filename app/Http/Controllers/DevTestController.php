<?php

namespace App\Http\Controllers;

use App\Helpers\RouteHelper;
use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\EmailHelper;

class DevTestController extends Controller
{
    public function index(){
        //$log = Mail::to('athiwat.wir@gmail.com')->send(new TestMail());
        //$log= EmailHelper::ticket('9b63a3d2-ac4d-424f-ac80-b9826cfee4f3');
        //dd($log);

        $x = RouteHelper::getAvaliableRoutes('9ad24fd5-754a-495d-8447-c629897e0ab2','9ad24dfa-d068-4aa2-8131-8c1c87b7b79d','2024-07-01');
        dd($x);
    }
}
