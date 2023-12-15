<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Models\Customers;

class CustomerController extends Controller
{
    public function updateCustomer(Request $request) {
        foreach($request->cus_id as $index => $id) {
            $date_ex = explode('/', $request->date[$index]);
            $customer = Customers::find($id);
            $customer->fullname = $request->fullname[$index];
            $customer->birth_day = $date_ex[2].'-'.$date_ex[1].'-'.$date_ex[0];
            if(isset($request->email[$index])) {
                $customer->email = $request->email[$index];
            }

            $customer->save();
        }
    }
}
