<?php

namespace App\Http\Controllers;

use App\Mail\TestMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class DevTestController extends Controller
{
    public function index(){
        $log = Mail::to('athiwat.wir@gmail.com')->send(new TestMail());
        dd($log);
    }
}
