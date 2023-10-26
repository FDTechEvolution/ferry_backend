@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Add Promotion code discount</h1> 
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="text-light">Promotion code</h2>
                    </div>
                </div>
                <form novalidate class="bs-validate" id="promotion-create-form" method="POST" action="">
                    @csrf
                    <fieldset id="promotion-create">
                        <div class="mb-4 row">
                            <div class="col-sm-12 col-lg-4 border-end">
                                <div class="mb-3 row">
                                    <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold">Code*</label>
                                    <div class="col-sm-12 col-lg-9">
                                        <input required type="text" class="form-control form-control-sm" name="code" value="">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold">Discount*</label>
                                    <div class="col-sm-6 col-lg-4">
                                        <input required type="number" class="form-control form-control-sm text-center" name="discount" value="">
                                    </div>
                                    <div class="col-sm-4 col-lg-5">
                                        <select required class="form-select form-select-sm text-center">
                                            <option value="" selected disabled>-- Select --</option>
                                            <option value="percent">%</option>
                                            <option value="thb">THB</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold">Usage*</label>
                                    <div class="col-sm-12 col-lg-9">
                                        <input required type="number" class="form-control form-control-sm" name="usage" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-8">
                                <div class="mb-3 row">
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-lg-5 col-form-label-sm text-light fw-bold text-lg-end">Depart Date Start</label>
                                            <div class="col-sm-12 col-lg-7">
                                                <input type="text" name="depart_start" class="form-control form-control-sm datepicker"
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
                                            <label class="col-sm-12 col-lg-5 col-form-label-sm text-light fw-bold text-lg-end">Booking Date Start</label>
                                            <div class="col-sm-12 col-lg-7">
                                                <input required type="text" name="booking_start" class="form-control form-control-sm datepicker"
                                                    data-show-weeks="true"
                                                    data-today-highlight="true"
                                                    data-today-btn="true"
                                                    data-clear-btn="false"
                                                    data-autoclose="true"
                                                    data-date-start="today"
                                                    data-format="DD/MM/YYYY">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-lg-5 col-form-label-sm text-light fw-bold text-lg-end">Depart Date End</label>
                                            <div class="col-sm-12 col-lg-7">
                                                <input type="text" name="depart_end" class="form-control form-control-sm datepicker"
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
                                            <label class="col-sm-12 col-lg-5 col-form-label-sm text-light fw-bold text-lg-end">Booking Date End</label>
                                            <div class="col-sm-12 col-lg-7">
                                                <input required type="text" name="booking_end" class="form-control form-control-sm datepicker"
                                                    data-show-weeks="true"
                                                    data-today-highlight="true"
                                                    data-today-btn="true"
                                                    data-clear-btn="false"
                                                    data-autoclose="true"
                                                    data-date-start="today"
                                                    data-format="DD/MM/YYYY">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-12 col-lg-5">
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Age</label>
                                            <div class="col-sm-12 col-lg-4">
                                                <input type="number" class="form-control form-control-sm text-center" name="age_min">
                                            </div>
                                            <label class="col-sm-12 col-lg-1 col-form-label-sm text-light fw-bold text-lg-center">-</label>
                                            <div class="col-sm-12 col-lg-4">
                                                <input type="number" class="form-control form-control-sm text-center" name="age_max">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Extra</label>
                                            <div class="col-sm-12 col-lg-9">
                                                <select class="form-select form-select-sm" name="extra">
                                                    <option value="">-- No Extra --</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-lg-7">
                                        <div class="row mb-2">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Station From</label>
                                            <div class="col-sm-12 col-lg-9">
                                                <select class="form-select form-select-sm" name="station_from">
                                                    <option value="">-- No Station --</option>
                                                    @foreach($stations as $station)
                                                        <option value="{{ $station->id }}">{{ $station->name }} @if($station->piername != null) ({{$station->piername}}) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Station To</label>
                                            <div class="col-sm-12 col-lg-9">
                                                <select class="form-select form-select-sm" name="station_to">
                                                    <option value="">-- No Station --</option>
                                                    @foreach($stations as $station)
                                                        <option value="{{ $station->id }}">{{ $station->name }} @if($station->piername != null) ({{$station->piername}}) @endif</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Route From</label>
                                            <div class="col-sm-12 col-lg-9">
                                                <select class="form-select form-select-sm" name="route_from">
                                                    <option value="">-- No Route --</option>
                                                    @foreach($routes as $route)
                                                        <option value="{{ $route->id }}">{{ $route->station_from->name }} -> {{ $route->station_to->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-2">
                                            <label class="col-sm-12 col-lg-3 col-form-label-sm text-light fw-bold text-end">Route To</label>
                                            <div class="col-sm-12 col-lg-9">
                                                <select class="form-select form-select-sm" name="route_to">
                                                    <option value="">-- No Route --</option>
                                                    @foreach($routes as $route)
                                                        <option value="{{ $route->id }}">{{ $route->station_from->name }} -> {{ $route->station_to->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop