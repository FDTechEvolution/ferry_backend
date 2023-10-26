@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Promotion code discount</h1> 
    <x-a-href-green :text="_('Add')" :href="route('promotion-create')" :target="_('_self')" class="ms-3 btn-sm w--10" /> 
@stop

@section('content')
<div class="row mt-4"> 
    <div class="col-12 col-md-11 col-lg-10 mx-auto">
    <div id="to-station-info-list">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="station-info-datatable" 
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
                            <th class="text-center">Choose</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Discount</th>
                            <th class="text-center">Start</th>
                            <th class="text-center">End</th>
                            <th class="text-center">Maximum</th>
                            <th class="text-center">Spent</th>
                            <th class="text-center">Total</th>
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