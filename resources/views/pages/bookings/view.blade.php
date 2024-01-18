@extends('layouts.default')
@php

    $tickets = $booking['tickets'];
    $user = $booking['user'];
    $extras = $booking['bookingExtraAddons'];
    $bookingRoutes = $booking['bookingRoutes'];
    $bookingCustomers = $booking['bookingCustomers'];
    $bookingRoutesX = $booking['bookingRoutesX'];
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
                            @foreach ($bookingRoutes as $index => $route)
                                <tr>
                                    <td class="align-middle p-3" style="width: 15%;">
                                        @if (isset($route['partner']['image']['path']))
                                            <img src="{{ asset('/' . $route->partner->image->path) }}"
                                                class="img-fluid rounded-circle">
                                        @endif
                                    </td>
                                    <td class="text-center align-top">
                                        <h4>{{ date('H:i', strtotime($route['depart_time'])) }}</h4>
                                        {{ $route->station_from->name }}
                                        <x-booking-view-addon
                                            :booking_route="$bookingRoutesX[$index]['bookingRouteAddons']"
                                            :subtype="_('from')"
                                        />
                                    </td>
                                    <td class="align-middle text-center">
                                        <i class="fa-solid fa-right-long fs-5"></i>
                                    </td>
                                    <td class="text-center align-top">
                                        <h4>{{ date('H:i', strtotime($route['arrive_time'])) }}</h4>
                                        {{ $route->station_to->name }}
                                        <x-booking-view-addon
                                            :booking_route="$bookingRoutesX[$index]['bookingRouteAddons']"
                                            :subtype="_('to')"
                                        />
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
                                        @endif {{ $customer->fullname }} @if($customer->email != NULL) <span class="badge bg-primary">Lead passenger</span> @endif
                                    </td>
                                    <td>{{ $customer->passportno }}</td>
                                    <td class="text-end">
                                        <button type="button" class="btn btn-sm mb-2 py-0 customer-btn-edit" data-bs-toggle="modal"
                                            data-bs-target="#staticBackdrop"
                                            data-customer_id="{{ $customer->id }}"
                                            data-title="{{ $customer->title }}"
                                            data-fullname="{{ $customer->fullname }}"
                                            data-email="{{ $customer->email }}"
                                            data-mobile="{{ $customer->mobile }}"
                                            data-th_mobile="{{ $customer->mobile_th }}"
                                            data-bday="{{ $customer->birth_day }}"
                                            data-address="{{ $customer->fulladdress }}"
                                            data-passport="{{ $customer->passportno }}"
                                            data-code_mobile="{{ $customer->mobile_code }}"
                                            data-country="{{ $customer->country }}">
                                            <i class="fa-regular fa-pen-to-square me-0"></i>
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
                                            <tr>
                                                <td class="fw-bold">Total</td>
                                                <td class="text-end">{{ $payment->totalamt }}</td>
                                            </tr>
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
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Edit Passenger <span
                            class="text-main-color-2"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form novalidate class="bs-validate" id="booking-customer-form" method="POST" action="{{ route('booking-update-customer') }}">
                        @csrf
                        <fieldset id="booking-customer-field">
                            <div class="row mt-2 mb-5 border-radius-10 border border-booking-passenger">
                                <div class="col-12 mt-3" id="lead-passenger">
                                    <div class="row">
                                        <div class="col-12 col-lg-2 form-floating mb-3">
                                            <select required class="form-select form-select-sm" name="title" id="passenger-title" aria-label="Floating label select example">
                                                <option value="" selected disabled>Select Title</option>
                                                <option value="mr">Mr.</option>
                                                <option value="mrs">Mrs.</option>
                                                <option value="ms">Ms.</option>
                                                <option value="other">Other</option>
                                            </select>
                                            <label for="passenger-title">Title<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-lg-5 form-floating mb-3">
                                            <input required type="text" class="form-control form-control-sm" name="full_name" id="passenger-full-name" placeholder="Full name" value="">
                                            <label for="passenger-first-name" class="ms-2">Full name<span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-12 col-lg-5 form-floating mb-3">
                                            <input required type="text" name="birth_day" class="form-control form-control-sm datepicker passenger-b-day"
                                                data-show-weeks="true"
                                                data-today-highlight="true"
                                                data-today-btn="false"
                                                data-clear-btn="false"
                                                data-autoclose="true"
                                                data-format="DD/MM/YYYY"
                                                data-date-start="1924-01-01"
                                                autocomplete="off"
                                                placeholder="Date of Birth">
                                            <label class="ms-2">Date of Birth<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" id="sub-passenger">
                                    <div class="row mb-3 mb-lg-0">
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-floating mb-3">
                                                        <input required type="email" name="email" class="form-control form-control-sm" id="passenger-email" placeholder="E-mail" autocomplete="true">
                                                        <label for="passenger-email" class="ms-2">E-mail<span class="text-danger">*</span></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 form-floating mb-3">
                                            <select required class="form-select form-select-sm" name="country" id="passenger-country" aria-label="Floating label select example" autocomplete="true">
                                                <option value="" selected disabled>Select Country</option>
                                                @foreach($country_list as $key => $country)
                                                    <option value="{{ $country }}">{{ $country }}</option>
                                                @endforeach
                                            </select>
                                            <label for="passenger-country">Country<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label class="form-label">Telephone number<span class="text-danger">*</span> ( <i class="fi fi-phone"></i> )</label>
                                                    <div class="row">
                                                        <div class="col-4">
                                                            <select required class="form-select" name="mobile_code" id="passenger-mobile-code">
                                                                <option value="" selected disabled></option>
                                                                @foreach($code_country as $code)
                                                                    <option id="code-{{ $code }}" value="{{ $code }}">+{{ $code }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-8">
                                                            <input required type="number" class="form-control" id="passenger-mobile" name="mobile">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <label class="form-label">Thai telephone number</label>
                                            <div class="row">
                                                <div class="col-4">
                                                    <input type="text" name="th_code" class="form-control" value="+66" readonly>
                                                </div>
                                                <div class="col-8">
                                                    <input type="number" name="th_mobile" id="passenger-mobile-th" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-lg-4 form-floating mb-3">
                                            <input type="text" name="passport_number" class="form-control form-control-sm" id="passenger-passport" placeholder="Passport Number">
                                            <label for="passenger-passport" class="ms-2">Passport Number</label>
                                        </div>
                                        <div class="col-12 col-lg-8 form-floating mb-3">
                                            <textarea class="form-control" placeholder="Address" id="passenger-address" name="address" style="height: 100px" autocomplete="true"></textarea>
                                            <label for="passenger-address" class="ms-2">Address</label>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="customer_id" id="customer-id" value="">
                            </div>
                        </fieldset>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="booking-customer-update">Update</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('script')
<script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop
