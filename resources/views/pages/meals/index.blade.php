@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title">Meal manager</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-meal-create" />
@stop

@section('content')
<div class="row mt-4">

    <div class="col-12">
        <div id="to-station-list">
            <div class="card-body">
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
                            <th class="text-center">Picture</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meals as $meal)
                            <tr class="text-center">
                                <td>
                                    <div class="avatar avatar-md" style="background-image:url({{ asset('assets/images/meal/meal-no-picture.png') }})"></div>
                                </td>
                                <td>{{ $meal['name'] }}</td>
                                <td>{{ $meal['amount'] }}</td>
                                <td>
                                    <x-action-delete 
                                        :url="_('#')"
                                        :message="_('Are you sure? Delete this meal?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop