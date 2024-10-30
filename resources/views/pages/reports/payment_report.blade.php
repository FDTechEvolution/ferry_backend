@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2" id="report-page-title">Report</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('report-index') }}" class="btn btn-light"><i class="fa-solid fa-file"></i> Booking Route
            Report</a>
        <a href="{{ route('report.payment') }}" class="btn btn-primary"><i class="fa-solid fa-cash-register"></i>
            Payment Report</a>
    </div>
</div>
<hr>
<div class="row mb-4">
    <div class="col-12 text-center">
        <h3>Payment Report</h3>
    </div>
    <div class="col-12">
        <form class="bs-validate" id="frm" method="GET" action="{{ route('report.payment') }}">
            @csrf
            <fieldset id="report-create">
                <div class="row">
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <x-element.dropdown-station label="Station From" name="station_from" :data=$stationFroms
                                selected="{{ $stationFromId }}" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <x-element.dropdown-station label="Station To" name="station_to" :data=$stationTos
                                selected="{{ $stationToId }}" />
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <select name="time" id="time" class="form-select">
                                <option value="all">- ALL -</option>
                                @foreach ($routes as $route)
                                <option value="{{ $route->id }}">{{ date('H:i', strtotime($route->depart_time)) }}/{{
                                    date('H:i', strtotime($route->arrive_time)) }}
                                </option>
                                @endforeach
                            </select>
                            <label for="time">Route Time</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <input autocomplete="off" type="text" name="daterange" id="daterange"
                                class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                data-ranges="false" data-date-start="" data-date-end="" data-date-format="DD/MM/YYYY"
                                data-quick-locale='{
                                        "lang_apply"	: "Apply",
                                        "lang_cancel" : "Cancel",
                                        "lang_crange" : "Custom Range",
                                        "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                        "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                                    }'>
                            <label for="daterange">Payment Date</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select" name="partner" id="partner">
                                <option value="all" selected>- ALL -</option>
                                @foreach ($partners as $partner)
                                <option value="{{ $partner['id'] }}">{{ $partner['name'] }}</option>
                                @endforeach
                            </select>
                            <label for="partner">Partner</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select" name="agent" id="agent">
                                <option value="all" selected>- ALL -</option>
                                <option value="admin">Admin</option>
                                <option value="online">Online</option>
                                @foreach ($apiMerchants as $item)
                                <option value="{{ $item->id}}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <label for="agent">Agent</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-success" id="bt-paymentreport">Show Payment Report</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<form id="frm-submit" method="POST" action="{{ route('report.payment_result') }}" target="_blank">
    @csrf
    <input type="hidden" name="station_from_id" id="station_from_id">
    <input type="hidden" name="station_to_id" id="station_to_id">
    <input type="hidden" name="route_id" id="route_id">
    <input type="hidden" name="date_range" id="date_range">
    <input type="hidden" name="partner_id" id="partner_id">
    <input type="hidden" name="api_merchant_id" id="api_merchant_id">
    <input type="hidden" name="report_type" id="report_type">
</form>
@stop

@section('script')
<script>
    function applyFields(){
        $('#station_from_id').val($('#station_from').val());
        $('#station_to_id').val($('#station_to').val());
        $('#route_id').val($('#time').val());
        $('#date_range').val($('#daterange').val());
        $('#partner_id').val($('#partner').val());
        $('#api_merchant_id').val($('#agent').val());

    }

    $(document).ready(function(){
        $('#station_from,#station_to').on('change',function(){
            $('#frm').submit();
        });

        $('#bt-routereport').on('click',function(){
            $('#report_type').val('route');
            applyFields();
            $('#frm-submit').submit();
        });

        $('#bt-paymentreport').on('click',function(){
            $('#report_type').val('payment');
            applyFields();
            $('#frm-submit').submit();
        });
    });
</script>
@stop