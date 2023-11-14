@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Create New Booking</h1> 
    
@stop

@section('content')

<form novalidate class="bs-validate" id="frm" method="GET" action="{{route('booking-route')}}">

<div class="section bg-main-color mb-3">
    <fieldset id="">
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="mb-4 row">
                <label class="col-4 col-form-label-sm text-start fw-bold text-white">Station From * :</label>
                <div class="col-7">
                   
                    <select required class="form-select form-select-sm" id="station-from-selected" name="station_from">
                        <option value="" selected disabled>--- Choose ---</option>
                            @foreach($stations['station_from'] as $station)
                            
                                <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != '') [{{ $station['piername'] }}] @endif</option>
                            @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="mb-4 row">
                <label class="col-4 col-form-label-sm text-start fw-bold text-white">Station To * :</label>
                <div class="col-7">
                    <select required class="form-select form-select-sm" id="station-from-selected" name="station_to">
                        <option value="" selected disabled>--- Choose ---</option>
                            @foreach($stations['station_to'] as $station)
                                <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != '') [{{ $station['piername'] }}] @endif</option>
                            @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-md-6">
            <div class="mb-4 row">
                <label class="col-4 col-form-label-sm fw-bold text-white">Depart Date* :</label>
                <div class="col-7">
                <input type="text" name="departdate" id="departdate" class="form-control form-control-sm datepicker"
                    data-show-weeks="true"
                    data-today-highlight="true"
                    data-today-btn="true"
                    data-clear-btn="false"
                    data-autoclose="true"
                    data-date-start="today"
                    data-format="DD/MM/YYYY" value="{{date('d/m/Y')}}">
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 col-md-6 offset-md-2">
            
            <button type="submit" class="btn btn-light">Search <i class="fi fi-search"></i></button>
        </div>
    </div>
</fieldset>
</div>
</form>

@if (sizeof($routes) != 0)
<div class="section mb-3">
    <div class="row">
        <div class="col-12 col-md-10 offset-md-1">
            <h2 class="text-main-color-2">Route Table : {{$departdate}}</h2>
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
                        @foreach($routes as $index => $route)
                            <tr class="">
               
                                <td class="text-start lh--1-2">
                                    {{ $route['station_from']['name'] }}
                                    @if($route['station_from']['piername'] != '')
                                        <small class="text-secondary fs-d-80">({{$route['station_from']['piername']}})</small>
                                    @endif
                                </td>
                                <td class="text-start lh--1-2">
                                    {{ $route['station_to']['name'] }}
                                    @if($route['station_to']['piername'] != '')
                                        <small class="text-secondary fs-d-80">({{$route['station_to']['piername']}})</small>
                                    @endif
                                </td>
                                <td>{{ date('H:i', strtotime($route['depart_time'])) }}</td>
                                <td>{{ date('H:i', strtotime($route['arrive_time'])) }}</td>
                                <td>
                                    <div class="row mx-auto justify-center-custom">
                                        @foreach($route['icons'] as $icon)
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
                                    <a href="{{route('booking-create')}}?route_id={{$route->id}}&departdate={{$departdate}}" class="btn btn-outline-success">Select</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
            </table>
        </div>
    </div>
</div>
@endif
@stop