@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="activity-page-title">Activity manage</h1>
    <x-a-href-green :text="_('Add')" :href="route('activity-create')" :target="_('_self')" class="ms-3 btn-sm" />
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
                        @foreach($activities as $index => $activity)
                            <tr class="text-center">
                                <td>{{ $index +1 }}</td>
                                <td class="text-start">{{ $activity['name'] }}</td>
                                <td>{{ number_format($activity['price']) }}</td>
                                <td></td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="route('activity-edit', ['id' => $activity['id']])"
                                        id="btn-station-edit"
                                    />
                                    <x-action-delete 
                                        :url="route('activity-delete', ['id' => $activity['id']])"
                                        :message="_('Are you sure? Delete '. $activity['name'] .'?')"
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

@section('script')
<script src="{{ asset('assets/js/app/activity.js') }}"></script>
@stop