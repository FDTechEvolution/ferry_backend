@extends('layouts.default')
@php

$ticket = sizeof($booking['tickets']) > 0 ? $booking['tickets'][0] : [];
$user = $booking['user'];
$extras = $booking['bookingExtraAddons'];
$bookingRoutes = $booking['bookingRoutes'];
$bookingCustomers = $booking['bookingCustomers'];
$bookingRoutesX = $booking['bookingRoutesX'];
//$payment = sizeof($booking['payments']) > 0 ? $booking['payments'][0] : null;
$payments = $booking->payments;
//dd($payments);
@endphp

@section('page-title')
<h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">Booking Detail, Invoice No.</span>
    {{ $booking['bookingno'] }}</h1>

@stop

@section('content')
<div class="row g-3">
    <div class="col-12 col-lg-3">
        <a href="{{ route('booking-index') }}" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Back to
            Booking</a>
    </div>
    <div class="col-12 col-lg-9 text-end">
        <div class="btn-group" role="group">
            @if ($booking['ispayment'] == 'Y')
            <a href="{{ route('print-ticket', ['bookingno' => $booking['bookingno']]) }}" class="btn btn-primary"
                rel="noopener" target="_blank"><i class="fa-solid fa-print"></i> Print Ticket</a>
            <form action="{{ route('booking.sendConfirmEmail') }}" method="POST">
                @csrf
                @method('POST')
                <input type="hidden" value="{{ $booking['bookingno'] }}" id="book_{{ $booking['id'] }}"
                    name="booking_nos[]">

                <button type="submit" href="{{ route('print-ticket', ['bookingno' => $booking['bookingno']]) }}"
                    class="btn btn-dark" rel="noopener"><i class="fa-solid fa-envelope"></i> Send Ticket Email</button>
            </form>

            @endif

            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Action <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    @foreach ($bookingStatus as $key=> $item)
                    <li>
                        <a class="dropdown-item rounded js-ajax-modal {{$item['class']}}" href="#"
                            data-href="{{ route('booking.changeStatus', ['id' => $booking['id'], 'status' => $key]) }}"
                            data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                            data-ajax-modal-backdrop="static">
                            {!!$item['icon']!!}
                            <span>Change to {{$item['title']}}</span>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>

    </div>

</div>
<hr>

<div class="row">
    <div class="col-12 col-lg-8 border-end">
        <div class="row">
            <div class="col-12">
                <h4 class="text-main-color-2">Routes</h4>
            </div>
            <div class="col-12 mb-2">
                <table class="table table-align-middle">
                    <tbody>
                        @foreach ($bookingRoutes as $index => $route)
                        <tr>
                            <td colspan="7" class="align-text-bottom">
                                <h5 class="pb-0 mb-0">{{ date('l d M Y', strtotime($route->pivot->traveldate)) }}
                                </h5>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="text-center">
                                <h3>
                                    {{ $route->pivot->type }}

                                </h3>
                                @if ($route->pivot->ischange == 'Y')
                                <span class="text-danger">Changed route</span>
                                @endif
                            </td>
                            <td class="align-middle p-3" style="width: 15%;">
                                @if (isset($route['partner']['image']['path']))
                                <img src="{{ asset('/' . $route->partner->image->path) }}"
                                    class="img-fluid rounded-circle">
                                @endif
                            </td>
                            <td class="text-center">
                                <h4>{{ date('H:i', strtotime($route['depart_time'])) }}</h4>
                                {{ $route->station_from->name }}
                                <x-booking-view-addon :booking_route="$bookingRoutesX[$index]['bookingRouteAddons']"
                                    :subtype="_('from')" />
                            </td>
                            <td class="align-middle text-center">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z">
                                    </path>
                                    <path fill-rule="evenodd"
                                        d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z">
                                    </path>
                                </svg>
                            </td>
                            <td class="text-center">
                                <h4>{{ date('H:i', strtotime($route['arrive_time'])) }}</h4>
                                {{ $route->station_to->name }}
                                <x-booking-view-addon :booking_route="$bookingRoutesX[$index]['bookingRouteAddons']"
                                    :subtype="_('to')" />
                            </td>
                            <td class="text-end align-middle">
                                <h5>{{ number_format($route->regular_price) }}THB</h5>
                            </td>
                            <td>
                                @if ($booking->ispremiumflex == 'Y')
                                <a href="{{ route('bookingRoute.edit', ['bookingRoute' => $route->pivot->id, 'booking_id' => $booking->id]) }}"
                                    class="btn btn-secondary btn-sm "><i
                                        class="fa-regular fa-pen-to-square me-0"></i></a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-12">
                <h4 class="text-main-color-2">
                    {{ $booking->adult_passenger + $booking->child_passenger + $booking->infant_passenger }}
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
                                @endif {{ $customer->fullname }} @if ($customer->email != null)
                                <span class="badge bg-primary">Lead passenger</span>
                                @endif
                            </td>
                            <td>{{ $customer->passportno }}</td>
                            <td class="text-end">
                                <a href="" href="#"
                                    data-href="{{ route('customer.edit', ['customer' => $customer, 'booking_id' => $booking->id]) }}"
                                    data-ajax-modal-size="modal-lg" data-ajax-modal-centered="true"
                                    data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                    class="btn btn-secondary btn-sm js-ajax-modal"><i
                                        class="fa-regular fa-pen-to-square me-0"></i></a>
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
                <h4 class="text-main-color-2">Booking Details</h4>
            </div>
            <div class="col-12">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Status</td>
                            <td class="{{ $status[$booking->status]['class'] }}">
                                {{ $status[$booking->status]['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Premium Flex</td>
                            <td>
                                @if ($booking->ispremiumflex == 'Y')
                                <span class="text-success">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" class="bi bi-shield-fill-check" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.777 11.777 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7.159 7.159 0 0 0 1.048-.625 11.775 11.775 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.541 1.541 0 0 0-1.044-1.263 62.467 62.467 0 0 0-2.887-.87C9.843.266 8.69 0 8 0zm2.146 5.146a.5.5 0 0 1 .708.708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 7.793l2.646-2.647z">
                                        </path>
                                    </svg>
                                </span>
                                @else
                                <span class="text-mute">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" class="bi bi-shield-x" viewBox="0 0 16 16">
                                        <path
                                            d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z">
                                        </path>
                                        <path
                                            d="M6.146 5.146a.5.5 0 0 1 .708 0L8 6.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 7l1.147 1.146a.5.5 0 0 1-.708.708L8 7.707 6.854 8.854a.5.5 0 1 1-.708-.708L7.293 7 6.146 5.854a.5.5 0 0 1 0-.708z">
                                        </path>
                                    </svg>
                                </span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Invoice No.</td>
                            <td>{{ isset($booking->bookingno) ? $booking->bookingno : '' }}</td>
                        </tr>
                        <tr>
                            <td>Ticket No.</td>
                            <td>{{ isset($ticket->ticketno) ? $ticket->ticketno : '' }}</td>
                        </tr>
                        <tr>
                            <td>Issue Date</td>
                            <td>{{ date('d-m-Y H:i', strtotime($booking->created_at)) }}</td>
                        </tr>
                        <tr>
                            <td>Trip Type</td>
                            <td>{{ $tripType[$booking->trip_type] }}</td>
                        </tr>
                        <tr>
                            <td>Agent</td>
                            <td>{{ $booking->book_channel }}</td>
                        </tr>
                        <tr>
                            <td>Approved By</td>
                            <td>{{ is_null($user) ? 'System' : $user->firstname }}</td>
                        </tr>
                        <tr>
                            <td>Amend</td>
                            <td>{{ $booking->amend }} times</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <h4 class="text-main-color-2">Payment Details</h4>
    </div>
    <div class="col-12">
        @if (is_null($payments))
        <p class="text-center"><span class="text-danger">-- no payment --</span></p>
        @else
        @foreach ($payments as $index => $payment)
        <div class="row">
            <div class="col-12">
                <span>Payment method: <span class="badge bg-primary">{{ $payment->payment_method }}</span></span>
                <span> Payment date: <span class="badge bg-primary">{{ date('d-m-Y', strtotime($payment->payment_date))
                        }}</span></span>

            </div>
            <div class="col-12">
                <table class="table table-sm">
                    @foreach ($payment->paymentLines as $i => $line)
                    <tr>
                        <td>
                            #{{ $line->title }}
                        </td>
                        <td class="text-end">
                            {{ number_format($line->amount) }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="fw-bold">Total</td>
                        <td class="text-end">{{ number_format($payment->totalamt) }}</td>
                    </tr>
                </table>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12">
        <h4>Transaction History</h4>
        <table class="table table-sm table-hover">
            <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>User</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($booking->transactionLogs as $index => $tran)
                <tr>
                    <td>{{ $tran->created_at }}</td>
                    <td>{{ $tran->title }}</td>
                    <td>{{ $tran->description }}</td>
                    <td>{{ isset($tran->user->username) ? $tran->user->username : '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop



@section('script')
<script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop