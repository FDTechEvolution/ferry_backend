@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Booking</h1> 
    <x-a-href-green :text="_('New Booking')" :href="route('booking-route')" class="ms-3 btn-sm w--10" /> 
@stop

@section('content')
<div class="section mb-3">
    <div class="row">
        <div class="col-12">
            <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice</th>
                            <th>Ticket No.</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Depart</th>
                            <th>Arrive</th>
                            <th></th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Child</th>
                            <th class="text-end">infant</th>
                            <th></th>
                        </tr>
                    </thead>
                <tbody id="">

                </tbody>
            </table>
        </div>
    </div>
</div>
@stop