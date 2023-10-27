@extends('layouts.default')
@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Create New Booking</h1> 
    
@stop

@section('content')
<div class="section bg-main-color mb-3">
    <div class="row">
        <div class="col-12">
           
            <h2 class="text-white">{{ $route['station_from']['name'] }} to  {{ $route['station_to']['name'] }}</h2>
        </div>
    </div>
    <hr>
    <div class="row text-white">
        <div class="col-2">
            <i class="fi fi-time"></i> Detart Time: {{date('H:i', strtotime($route['depart_time'])) }}
        </div>
        <div class="col-2">
        <i class="fi fi-time"></i> Arrive Time: {{date('H:i', strtotime($route['arrive_time'])) }}
        </div>

        <div class="col-2">
            Regular Price: {{number_format($route['regular_price'])}}THB
        </div>
        <div class="col-2">
            Child Price: {{number_format($route['child_price'])}}THB
        </div>
    </div>
</div>

<div class="section mb-3">
    <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{route('booking-route')}}">
        <fieldset id="booking-ceate">
            <input type="hidden" value="" name="route_id" id="route_id"/>
            <div class="row">
                <div class="col-12 col-md-10 offset-md-1">
                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm">Depart Date</label>
                        <div class="col-3">
                            <input required type="text" name="departdate" id="departdate" value="{{$departdate}}" class="form-control form-control-sm datepicker"
                            data-show-weeks="true"
                            data-today-highlight="true"
                            data-today-btn="true"
                            data-clear-btn="false"
                            data-autoclose="true"
                            data-date-start="today"
                            data-format="DD/MM/YYYY">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm">Reference</label>
                        <div class="col-3">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" />
                        </div>

                        <label class="col-1 col-form-label-sm text-end">A</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" />
                        </div>

                        <label class="col-1 col-form-label-sm text-end">C</label>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" />
                        </div>

                        <label class="col-1 col-form-label-sm text-end">I</label>
                        <div class="col-1">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm">Customer Name</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm">Extra</label>
                        <div class="col-4">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm">Price</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" required />
                        </div>

                        <label class="col-2 col-form-label-sm text-end">Extra Price</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" value="0" required/>
                        </div>

                        <label class="col-2 col-form-label-sm text-end">Total Price</label>
                        <div class="col-2">
                            <input type="text" class="form-control form-control-sm" name="reference" id="reference" value="0" required disabled/>
                        </div>
                    </div>
                    <hr>

                    <div class="row mb-3">
                        <label class="col-2 col-form-label-sm text-success">Pay</label>
                        <div class="col-3">
                            <div class="form-check mb-2">
                                <input class="form-check-input form-check-input-danger" type="radio" name="payment" value="" id="" required>
                                <label class="form-check-label" for="checkDanger">Unpay</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input form-check-input-success" type="radio" name="payment" value="" id="" required>
                                <label class="form-check-label" for="checkSuccess">Paid</label>
                            </div>
                        </div>

                        <label class="col-1 col-form-label-sm">Slip</label>
                        <div class="col-4">
                            <input class="form-control form-control-sm" id="formFileSm" type="file">
                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <x-button-submit-loading 
                                    class="btn-lg w--20 me-4 button-orange-bg"
                                    :form_id="_('booking-form')"
                                    :fieldset_id="_('booking-create')"
                                    :text="_('Save Booking')"
                                />
                        </div>
                    </div>

                </div>
            </div>
        </fieldset>
    </form>
</div>

@stop