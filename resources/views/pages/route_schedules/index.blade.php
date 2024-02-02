@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">{{ $title }}</span> Schedule</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">

            @if (is_null($merchant_id))
                <a href="{{ route('route-index') }}" class="btn btn-secondary"><i class="fi fi-arrow-left"></i> Back</a>
                <a href="{{ route('routeSchedules.create') }}" class="btn button-orange-bg">Create New</a>
            @else
                <a href="{{ route('api-route-index', ['merchant_id' => $merchant_id]) }}" class="btn btn-secondary"><i
                        class="fi fi-arrow-left"></i> Back</a>
                <a href="{{ route('routeSchedules.create') }}?merchant_id={{ $merchant_id }}"
                    class="btn button-orange-bg">Create New</a>

                <img src="{{ $apiMerchant->logo }}" width="200px" class="px-2" />
            @endif
        </div>
    </div>
    <hr>
    <form action="{{ route('routeSchedules.index') }}" method="GET" id="frm-search">
        @if (!is_null($merchant_id))
            <input type="hidden" value="{{ $merchant_id }}" name="merchant_id" />
        @endif
        <div class="row">
            <div class="col-12 col-lg-4">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_from_id" name="station_from_id" aria-label="">
                        <option value="all" selected>-- All --</option>
                        @foreach ($stationFroms as $station)
                            <option value="{{ $station->id }}" @selected($stationFromId == $station->id)>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    <label for="station_from_id">Station From</label>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_to_id" name="station_to_id" aria-label="">
                        <option value="all" selected>-- All --</option>
                        @foreach ($stationTos as $station)
                            <option value="{{ $station->id }}" @selected($stationToId == $station->id)>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    <label for="station_to_id">Station To</label>
                </div>
            </div>
        </div>
    </form>
    <hr>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-datatable  table-align-middle table-hover"
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                    data-lng-processing="Processing..." data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                    data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="false"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS"
                    data-lng-all="All" data-export-pdf-disable-mobile="true" data-responsive="false"
                    data-export='["pdf", "xls"]' data-main-search="false" data-column-search="false"
                    data-custom-config='{

                }'>

                    <thead class="bg-light">
                        <tr>
                            <th>Route</th>
                            <th>Time</th>
                            <th>Effective date</th>
                            <th>Timestamp</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $route_id = '';
                        @endphp
                        @foreach ($routeSchedules as $index => $routeSchedule)
                            <tr>
                                <td>
                                    @if ($route_id != $routeSchedule->route_id)
                                        <p class="pb-0 mb-0">
                                            {{ $routeSchedule->station_from_name }}
                                            <i class="fa-solid fa-angles-right px-2 fa-1x"></i>
                                            {{ $routeSchedule->station_to_name }}
                                        </p>
                                    @endif
                                </td>
                                <td>
                                    <span class="">{{ date('H:i', strtotime($routeSchedule->depart_time)) }}<i
                                            class="fa-solid fa-angles-right px-2 fa-1x"></i>{{ date('H:i', strtotime($routeSchedule->arrive_time)) }}
                                    </span>
                                </td>
                                <td>
                                    @if ($routeSchedule->isactive == 'Y')
                                        <p class="p-0 m-0">
                                            <span
                                                class="badge @if ($routeSchedule->type == 'CLOSE') bg-danger @else bg-success @endif">{{ $routeSchedule->type }}</span>
                                            {{ date('D,d M Y', strtotime($routeSchedule->start_datetime)) }} -
                                            {{ date('D,d M Y', strtotime($routeSchedule->end_datetime)) }}
                                        </p>
                                        <small>{{ $routeSchedule->description }}</small>
                                    @else
                                        <p class="p-0 m-0 text-gray-400">
                                            <span class="text-warning pe-2">Auto disable</span><span
                                                class="badge bg-secondary text-dark">{{ $routeSchedule->type }}</span>
                                            {{ date('D,d M Y', strtotime($routeSchedule->start_datetime)) }} -
                                            {{ date('D,d M Y', strtotime($routeSchedule->end_datetime)) }}
                                        </p>
                                        <small class="text-gray-400">{{ $routeSchedule->description }}</small>
                                    @endif
                                </td>

                                <td>
                                    <small class="d-flex">Created By {{$routeSchedule->created_name}}: {{ date('D,d M Y H:i', strtotime($routeSchedule->created_at)) }}</small>
                                    @if(!is_null($routeSchedule->updated_name) && $routeSchedule->updated_name !='')
                                    <small>Updated By {{$routeSchedule->updated_name}}: {{ date('D,d M Y H:i', strtotime($routeSchedule->updated_at)) }}</small>
                                    @endif
                                </td>
                                <td class="text-end">
                                    @if ($routeSchedule->isactive == 'Y')
                                        <x-action-edit class="me-2" :url="route('routeSchedules.edit', [
                                            'routeSchedule' => $routeSchedule->id,
                                        ])" id="btn-section-edit" />
                                        <x-delete-button :url="route('routeSchedules.destroy', [
                                            'routeSchedule' => $routeSchedule->id,
                                        ])" :id="$routeSchedule->id" />
                                    @else
                                        <x-delete-button :url="route('routeSchedules.destroy', [
                                            'routeSchedule' => $routeSchedule->id,
                                        ])" :id="$routeSchedule->id" />
                                    @endif
                                </td>
                            </tr>
                            @php
                                $route_id = $routeSchedule->route_id;
                            @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        var send_delete = function(el, data) {
            let url = (el.attr('data-href'));
            let id = (el.attr('data-id'));
            $('#frm-' + id).submit();
        }

        $(document).ready(function() {
            $('#station_from_id').on('change', function() {
                $('#page-loader').show();
                $('#station_to_id').empty();
                $('#frm-search').submit();
            });

            $('#station_to_id').on('change', function() {
                $('#page-loader').show();
                $('#frm-search').submit();
            });
        });
    </script>
@stop
