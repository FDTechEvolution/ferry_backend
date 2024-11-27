@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">
    Edit Route</h1>
@stop

@section('content')
@php
$route = $bookingRoute->route;
@endphp
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('booking-view', ['id' => $booking_id]) }}" class="btn btn-secondary"><i
                class="fa-solid fa-circle-left"></i> Back to Booking</a>
    </div>
    <div class="col-12">
        <h5 class="text-main-color-2">Current Route {{ date('l d M Y', strtotime($bookingRoute->traveldate)) }}</h5>
        <div class="row">
            <div class="col-12 col-lg-8">
                <table class="table table-align-middle">
                    <tbody>


                        <tr class="">
                            <td class="">
                                <h3>{{ $bookingRoute->type }}</h3>
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

                            </td>
                            <td class="text-end align-middle">
                                <h5>{{ number_format($route->regular_price) }}THB</h5>
                            </td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <hr>
    <div class="col-12">
        <form novalidate class="bs-validate" id="frm-search" method="GET"
            action="{{ route('bookingRoute.edit', ['bookingRoute' => $bookingRoute]) }}">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $bookingRoute->id }}">
            <input type="hidden" name="booking_id" value="{{ $booking_id }}">

            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-floating mb-3">
                        <x-element.dropdown-station label="Station From" name="station_from_id" :data=$sections
                            selected="{{ $stationFromId }}" />
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-floating mb-3">
                        <x-element.dropdown-station label="Station To" name="station_to_id" :data=$sections
                            selected="{{ $stationToId }}" />
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="form-floating mb-3">
                        <input type="text" name="departdate" id="departdate"
                            class="form-control form-control-sm datepicker" data-show-weeks="true"
                            data-today-highlight="true" data-today-btn="true" data-clear-btn="false"
                            data-autoclose="true" data-format="DD/MM/YYYY" value="{{ $departdate }}">
                        <label for="departdate">Depart Date</label>
                    </div>
                </div>
            </div>

        </form>
    </div>

</div>
<hr>

<form novalidate class="bs-validate" id="frm" method="POST"
    action="{{ route('bookingRoute.update', ['bookingRoute' => $bookingRoute]) }}">
    @csrf
    @method('PATCH')
    <input type="hidden" name="id" value="{{ $bookingRoute->id }}">
    <input type="hidden" name="booking_id" value="{{ $booking_id }}">
    <input type="hidden" name="route_id" id="route_id">
    <input type="hidden" name="departdate" value="{{ $departdate }}">

    @if (sizeof($routes) != 0)
    <div class="section mb-3">
        <div class="row">
            <div class="col-12">
                <strong class="text-main-color-2">Avaliable routes on {{ $departdate }}</strong>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>From</th>
                                <th>To</th>
                                <th>Depart</th>
                                <th>Arrive</th>
                                <th></th>
                                <th class="text-end">Regular Price</th>
                                <th class="text-end">Child</th>
                                <th class="text-end">infant</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="">
                            @foreach ($routes as $index => $route)
                            <tr class="">

                                <td class="text-start lh--1-2">
                                    {{ $route['station_from']['name'] }}
                                    @if ($route['station_from']['piername'] != '')
                                    <small class="text-secondary fs-d-80">({{ $route['station_from']['piername']
                                        }})</small>
                                    @endif
                                </td>
                                <td class="text-start lh--1-2">
                                    {{ $route['station_to']['name'] }}
                                    @if ($route['station_to']['piername'] != '')
                                    <small class="text-secondary fs-d-80">({{ $route['station_to']['piername']
                                        }})</small>
                                    @endif
                                </td>
                                <td>{{ date('H:i', strtotime($route['depart_time'])) }}</td>
                                <td>{{ date('H:i', strtotime($route['arrive_time'])) }}</td>
                                <td>
                                    <div class="row mx-auto justify-center-custom">
                                        @foreach ($route['icons'] as $icon)
                                        <div class="col-sm-4 px-0" style="max-width: 35px;">
                                            <img src="{{ $icon['path'] }}" class="w-100">
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="text-end">{{ number_format($route['regular_price']) }}</td>
                                <td class="text-end">{{ number_format($route['child_price']) }}</td>
                                <td class="text-end">{{ number_format($route['infant_price']) }}</td>
                                <td class="text-end">

                                    <a href="#" data-href="{{ route('booking-index') }}"
                                        class="js-ajax-confirm btn btn-primary" data-id="{{$route->id}}"
                                        data-ajax-confirm-mode="ajax" data-ajax-confirm-type="warning"
                                        data-ajax-confirm-title="Please Confirm"
                                        data-ajax-confirm-body="Are you sure you want to change this route?"
                                        data-ajax-confirm-btn-yes-class="btn-sm btn-primary"
                                        data-ajax-confirm-btn-yes-text="Confirm"
                                        data-ajax-confirm-btn-yes-icon="fi fi-check"
                                        data-ajax-confirm-btn-no-class="btn-sm btn-light"
                                        data-ajax-confirm-btn-no-text="Cancel"
                                        data-ajax-confirm-btn-no-icon="fi fi-close"
                                        data-ajax-confirm-callback-function="cf_call">
                                        Select
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @endif
</form>

@stop


@section('script')
<script>
    var cf_call = function(el, data) {

            // el = confirm modal element
            // data = data sent by the server (html content)
            //alert('I am a callback!');
            let id = (el.attr('data-id'));
            $('#route_id').val(id);
            $('#frm').submit();
        }

        $(document).ready(function() {
            $('#station_from_id').on('change', function() {
                $('#page-loader').show();
                $('#station_to_id').empty();
                $('#frm-search').submit();
            });

            $('#station_to_id').on('change', function() {
                $('#page-loader').show();
                $('#frm-search').submit();
            });

            //departdate
            $('#departdate').on('change', function() {
                $('#page-loader').show();
                $('#frm-search').submit();
            });
        });
</script>
@stop