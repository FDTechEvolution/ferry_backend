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
                            <th>From</th>
                            <th>To</th>
                            <th>Depart Date</th>
                            <th>Depart Time</th>
                            <th>Arrive Time</th>
                            <th></th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Child</th>
                            <th class="text-end">infant</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="">
                        @foreach ($bookings as $index => $item)
                            <tr>
                                <td>{{ $item['route']['station_from']['name'] }}</td>
                                <td>{{ $item['route']['station_to']['name'] }}</td>
                                <td>{{ $item['departdate'] }}</td>
                                <td>{{ date('H:i', strtotime($item['route']['depart_time'])) }}</td>
                                <td>{{ date('H:i', strtotime($item['route']['arrive_time'])) }}</td>
                                <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
