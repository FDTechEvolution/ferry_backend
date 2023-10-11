@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title"><span class="text-main-color-2">Route</span> control</h1>
    <a href="{{ route('route-create') }}" class="btn button-green-bg border-radius-10 ms-3 btn-sm w--15">Add</a>
@stop

@section('page-option')
<div class="route-search d-none">
    <div class="row pt-2">
        <div class="col-9">
            <div class="mb-1 row">
                    <label for="station-search-from" class="col-form-label form-label-sm col-sm-4 custom-padding">Station From* </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm" id="station-search-from">
                    </div>
            </div>
            <div class="mb-1 row">
                    <label for="station-search-to" class="col-form-label form-label-sm col-sm-4 custom-padding">Station to </label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control form-control-sm col-sm-10" id="station-search-to">
                    </div>
            </div>
        </div>
        <div class="col-3">
            <x-button-orange 
                :type="_('button')"
                :text="_('search')"
            />
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">
        
    </div>

    <div class="col-12">
        <div id="to-route-list">
            <div class="card-body w--90 mx-auto">
                <h1>Route control</h1>
                <table class="table-datatable table table-datatable-custom" id="route-datatable" 
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
                            <th class="text-center d-none" style="width: 60px;">Choose</th>
                            <th class="text-start">Station From</th>
                            <th class="text-start">Station To</th>
                            <th class="text-center">Depart</th>
                            <th class="text-center">Arrive</th>
                            <th class="text-center fix-width-120">Icon</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($routes as $index => $route)
                            <tr class="text-center">
                                <td class="d-none">
                                    <input class="form-check-input form-check-input-primary" type="checkbox" value="" id="route-check-{{ $index }}">
                                </td>
                                <td class="text-start" style="line-height: 1.2rem;">
                                    {{ $route['station_from']['name'] }}
                                    @if($route['station_from']['piername'] != '')
                                        <small class="text-secondary fs-d-80">({{$route['station_from']['piername']}})</small>
                                    @endif
                                </td>
                                <td class="text-start" style="line-height: 1.2rem;">
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
                                        <div class="col-sm-4 px-0" style="max-width: 40px;">
                                            <img src="{{ $icon['path'] }}" class="w-100">
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ number_format($route['regular_price']) }}</td>
                                <td>{!! $route_status[$route['isactive']] !!}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="route('route-edit', ['id' => $route['id']])"
                                        id="btn-route-edit"
                                    />
                                    <x-action-delete 
                                        :url="route('route-delete', ['id' => $route['id']])"
                                        :message="_('Are you sure? Delete this route ?')"
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

<style>
    .custom-padding {
        padding-top: 9px;
        padding-bottom: 8px;
    }
    .fix-width-120 {
        width: 120px;
    }
    
</style>
@stop

@section('script')
<script>
    const icons = {{ Js::from($icons) }}
</script>
<script src="{{ asset('assets/js/app/route_control.js') }}"></script>
@stop