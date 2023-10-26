@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Booking</h1> 
    <x-a-href-green :text="_('New Booking')" :href="route('booking-route')" class="ms-3 btn-sm w--10" /> 
@stop

@section('content')
@stop