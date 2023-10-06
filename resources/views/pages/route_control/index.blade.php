@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title"><span class="text-main-color-2">Route</span> control</h1>
    <a href="{{ route('route-create') }}" class="btn button-green-bg border-radius-10 ms-3 btn-sm w--10">Add</a>
    <div class="route-search d-none">
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
                            <th class="text-center" style="width: 60px;">Choose</th>
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
                        @foreach($routes as $index => $route)
                            <tr class="text-center">
                                <td>
                                    <input class="form-check-input form-check-input-primary" type="checkbox" value="" id="route-check-{{ $index }}">
                                </td>
                                <td style="line-height: 1.2rem;">
                                    {{ $route['station_from']['name'] }}
                                    @if($route['station_from']['piername'] != '')
                                        <small class="text-secondary fs-d-80">({{$route['station_from']['piername']}})</small>
                                    @endif
                                </td>
                                <td style="line-height: 1.2rem;">
                                    {{ $route['station_to']['name'] }}
                                    @if($route['station_to']['piername'] != '')
                                        <small class="text-secondary fs-d-80">({{$route['station_to']['piername']}})</small>
                                    @endif
                                </td>
                                <td>{{ $route['depart_time'] }}</td>
                                <td>{{ $route['arrive_time'] }}</td>
                                <td class="mx-auto">
                                    <div class="row">
                                        @foreach($route['icons'] as $icon)
                                        <div class="col-sm-4 px-0">
                                            <img src="{{ $icon['path'] }}" width="24" height="24">
                                        </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ $route['regular_price'] }}</td>
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
@stop

@section('script')
<script>
    const icons = {{ Js::from($icons) }}
</script>
<script src="{{ asset('assets/js/app/route_control.js') }}"></script>
@stop