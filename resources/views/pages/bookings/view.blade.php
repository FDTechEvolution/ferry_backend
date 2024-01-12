@extends('layouts.default')
@php

    $tickets = $booking['tickets'];
    $user = $booking['user'];
    $extras = $booking['bookingExtraAddons'];
    $bookingRoutes = $booking['bookingRoutes'];
    $bookingCustomers = $booking['bookingCustomers'];
    $payment = sizeof($booking['payments']) > 0 ? $booking['payments'][0] : null;
@endphp

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">Booking Detail, Invoice No.</span>
        {{ $booking['bookingno'] }}</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            @if ($booking['ispayment'] == 'Y')
                <a href="{{ route('print-ticket', ['bookingno' => $booking['bookingno']]) }}"
                    class="btn btn-primary transition-hover-top" rel="noopener" target="_blank"><i
                        class="fa-solid fa-print"></i> Print Ticket</a>
            @endif
            <a href="#" class="btn btn-success transition-hover-top" rel="noopener" target="_blank"><i
                    class="fa-brands fa-cc-visa"></i> Make Payment</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-lg-8 border-end">
            <div class="row">
                <div class="col-12 mb-2">
                    <table class="table">
                        <tbody>
                            @foreach ($bookingRoutes as $route)
                                <tr>
                                    <td class="align-middle p-3" style="width: 15%;">
                                        @if (isset($route['partner']['image']['path']))
                                            <img src="{{ asset('/' . $route->partner->image->path) }}"
                                                class="img-fluid rounded-circle">
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <h4>{{ date('H:i', strtotime($route['depart_time'])) }}</h4>
                                        {{ $route->station_from->name }}
                                    </td>
                                    <td class="align-middle text-center">
                                        <i class="fa-solid fa-right-long fs-5"></i>
                                    </td>
                                    <td class="text-center align-middle ">
                                        <h4>{{ date('H:i', strtotime($route['arrive_time'])) }}</h4>
                                        {{ $route->station_to->name }}
                                    </td>
                                    <td class="text-end align-middle">
                                        <h4>{{ number_format($route->regular_price) }}THB</h4>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h4><i class="fa-solid fa-users"></i> <span
                            class="text-main-color-2">{{ $booking->adult_passenger + $booking->child_passenger + $booking->infant_passenger }}</span>
                        Passengers</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Fullname</th>
                                <th>Passport No.</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookingCustomers as $index => $customer)
                                <tr class="align-middle">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $customer->type }}</td>
                                    <td>
                                        @if ($customer->title != '')
                                            {{ $customer->title }}.
                                        @endif {{ $customer->fullname }}
                                    </td>
                                    <td>{{ $customer->passportno }}</td>
                                    <td class="text-end">

                                        <button type="button" class="btn btn-sm rounded-circle btn-outline-secondary mb-2" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                            <i class="fa-solid fa-pen"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-4">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-main-color-2">Booking Sumary</h4>
                </div>
            </div>

        </div>
    </div>
@stop


@section('modal')
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Passenger <span class="text-main-color-2">XXX</span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Understood</button>
                </div>
            </div>
        </div>
    </div>

@stop
