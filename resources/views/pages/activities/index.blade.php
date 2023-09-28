@extends('layouts.default')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

@section('page-title')
    <h1 class="ms-2 mb-0" id="activity-page-title">Activity manage</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-activity-create" />
@stop

@section('content')
<div class="row mt-4">

    <div class="col-12">
        <div id="to-activity-list">
            <div class="card-body w--90 mx-auto">
                <table class="table-datatable table table-datatable-custom" id="activity-datatable" 
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
                            <th class="text-center w--10">#</th>
                            <th>NameActivity</th>
                            <th class="text-center">Price (THB)</th>
                            <th class="text-center">View</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-activity-create" class="m-auto d-none">
            @include('pages.activities.create')
        </div>
        <div id="to-activity-edit" class="m-auto d-none">
            
        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/activity.js') }}"></script>
@stop