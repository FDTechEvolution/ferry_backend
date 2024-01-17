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
    <div class="row g-3 align-items-center">
        <div class="col">
            <h4 class="mb-0">#{{ $booking['bookingno'] }}</h4>
            <ul class="list-unstyled m-0 p-0">
                <li class="list-item">
                    <span class="text-muted small">{{ $booking->created_at }}</span>
                </li>
                <li class="list-item">
                    @if ($booking['ispayment'] == 'Y')
                        <span class="badge bg-success-soft rounded-pill d-inline-flex align-items-center">
                            <span class="bull bull-lg bg-success me-2 animate-pulse-success"></span>
                            <span>Paid</span>
                        </span>
                    @else
                    @endif
                    <span class="badge bg-secondary-soft rounded-pill">
                        {{ $booking['trip_type'] }}
                    </span>
                </li>
            </ul>

        </div>
        <div class="col-md-6 text-md-end">
            @if ($booking['ispayment'] == 'Y')
                <a href="{{ route('print-ticket', ['bookingno' => $booking['bookingno']]) }}"
                    class="btn btn-primary transition-hover-top" rel="noopener" target="_blank"><i
                        class="fa-solid fa-print"></i> Print Ticket</a>
            @endif
        </div>
    </div>

    <div class="row g-2">

        <div class="col">
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-7 border-end">
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
                                        <h5>{{ number_format($route->regular_price) }}THB/Person</h5>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="col-12">
                    <h4>
                        <i class="fa-solid fa-users"></i> <span
                            class="text-main-color-2">{{ $booking->adult_passenger + $booking->child_passenger + $booking->infant_passenger }}</span>
                        Passengers
                    </h4>
                    <span class="badge rounded-pill bg-secondary-soft">Adult {{ $booking->adult_passenger }} </span>
                    <span class="badge rounded-pill bg-secondary-soft">Child {{ $booking->child_passenger }} </span>
                    <span class="badge rounded-pill bg-secondary-soft">Infant {{ $booking->infant_passenger }} </span>
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

                                        <button type="button" class="btn btn-sm mb-2" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop">
                                            <span class="fw-normal">edit</span><i class="fa-regular fa-pen-to-square"></i>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-5">
            <div class="row">
                <div class="col-12">
                    <h4 class="text-main-color-2">Payment Details</h4>
                </div>
                <div class="col-12">
                    @php
                        $payments = $booking->payments;
                    @endphp
                    @if (is_null($payments))
                        <p class="text-center"><span class="text-danger">-- no payment --</span></p>
                    @else
                        @foreach ($payments as $index => $payment)
                            <div class="row">
                                <div class="col">
                                    <ul class="list-unstyled m-0 p-0">
                                        <li class="list-item">
                                            Payment method: <span
                                                class="badge bg-primary">{{ $payment->payment_method }}</span>
                                        </li>
                                        <li class="list-item">
                                            Payment date: <span
                                                class="badge bg-primary">{{ $payment->payment_date }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-12">
                                    <table class="table table-sm">
                                        @foreach ($payment->paymentLines as $i=>$line)
                                            <tr>
                                                <td>
                                                    #{{$line->title}}
                                                </td>
                                                <td class="text-end">
                                                    {{$line->amount}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    @endif
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
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Passenger <span
                            class="text-main-color-2">XXX</span></h5>
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
