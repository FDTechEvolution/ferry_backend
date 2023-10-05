@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="meal-page-title"><span class="text-main-color-2">Route</span> control</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-route-create" />
    <div class="route-search">
        <div class="mb-3">
            <label for="station-from" class="form-label">Station From* </label>
            <input type="text" class="form-control" id="station-from">
        </div>
        <div class="mb-3">
            <label for="station-to" class="form-label">Station to </label>
            <input type="text" class="form-control" id="station-to">
        </div>
        <x-button-orange 
            :type="_('button')"
            :text="_('search')"
        />
    </div>
@stop

@section('content')
<div class="row mt-4">

    <div class="col-12">
        <div id="to-meal-list">
            <div class="card-body w--90 mx-auto">
                <h1>Route control</h1>
                <table class="table-datatable table table-datatable-custom" id="meals-datatable" 
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-enable-col-sorting="false"
                    data-items-per-page="15"

                    data-enable-column-visibility="false"
                    data-enable-export="true"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th class="text-center w--15">Choose</th>
                            <th class="text-center">Station From</th>
                            <th class="text-center">Station To</th>
                            <th class="text-center">Depart</th>
                            <th class="text-center">Arrive</th>
                            <th class="text-center">Icon</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">Station</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@stop