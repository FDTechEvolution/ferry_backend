@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Booking</h1>
    <x-a-href-green :text="_('New')" :href="route('booking-route')" class="ms-3 btn-sm w--10" />
@stop

@section('content')
    <div class="section mb-3">
        <div class="row">
            <div class="col-12">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Booking No</th>
                            <th>Ticket No</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Adult</th>

                            <th>Depart</th>
                            <th>Arrive</th>
                            <th>Date</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Status</th>
                            <th>Admin</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="">
                       
                        @foreach ($bookings as $index => $item)
                            <tr>
                                <td>{{$item['bookingno']}}</td>
                                <td><strong>{{isset($item['tickets'][0])?$item['tickets'][0]['ticketno']:''}}</strong></td>
                                <td>{{ $item['bookingRoutes'][0]['station_from']['name'] }}</td>
                                <td>{{ $item['bookingRoutes'][0]['station_to']['name'] }}</td>
                                <td>{{ $item['adult_passenger'] }}</td>
                                <td>{{ date('H:i', strtotime($item['bookingRoutes'][0]['depart_time'])) }}</td>
                                <td>{{ date('H:i', strtotime($item['bookingRoutes'][0]['arrive_time'])) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item['departdate']))}}</td>
                                <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                <td class="text-center">
                                    @if ($item['ispayment'] == 'Y')
                                        <span class="text-success">Pay</span>
                                    @else
                                        <span class="text-danger">Unpay</span>
                                    @endif

                                </td>
                                <td>
                                    @if (isset($item['user']['id']))
                                        {{$item['user']['firstname']}}
                                    @endif
                                </td>
                                <td class="text-center"></td>
                            <tr>
                        @endforeach
                    </tbody>
                </table>

                
            </div>
        </div>
    </div>
@stop
