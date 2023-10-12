@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Create</span> Review</h1> <x-a-href-green
    :text="_('Add')" :href="route('review-create')" :target="_('_self')" class="ms-3 btn-sm w--10" /> 
@stop

@section('content') 
<div class="row mt-4"> 
    <div class="col-12">

    </div>
</div>
@stop