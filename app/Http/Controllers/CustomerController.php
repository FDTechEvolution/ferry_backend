<?php

namespace App\Http\Controllers;

use App\Models\Bookings;
use App\Models\Customers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Helpers\TransactionLogHelper;

class CustomerController extends Controller
{
    protected $CodeCountry;
    protected $CountryList;

    public function __construct()
    {
        $this->middleware('auth');
        $this->CodeCountry = config('services.code_country');
        $this->CountryList = config('services.country_list');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bookingId = request()->booking_id;
        $customer = Customers::where('id',$id)->first();
        return view('pages.customer.modal.edit',[
            'customer'=>$customer,
            'country_list' => $this->CountryList, 'code_country' => $this->CodeCountry,'bookingId'=>$bookingId
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request);
        $customer = Customers::where('id',$id)->first();

        //$birth_day = Carbon::createFromFormat('d/m/Y', $request->birth_day)->format('Y-m-d');
       // $request->birth_day = $birth_day;

        $customer->update($request->all());
        $bookingId = $request->booking_id;
        $booking = Bookings::where('id',$bookingId)->first();
        $booking->amend = $booking->amend+1;
        $booking->save();

        TransactionLogHelper::tranLog(['type' => 'booking', 'title' => 'Update customer detail ('.$customer->fullname.')', 'description' => '', 'booking_id' => $bookingId]);

        return redirect()->route('booking-view',['id'=>$request->booking_id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
