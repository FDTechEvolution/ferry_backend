<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Helpers\EmailHelper;

class DevTestController extends Controller
{
    public function index(){
        //$log = Mail::to('athiwat.wir@gmail.com')->send(new TestMail());
        $log= EmailHelper::ticket('9b63a3d2-ac4d-424f-ac80-b9826cfee4f3');
        dd($log);
    }
}
