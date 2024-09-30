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
        @endif

        @if ($countBooking > 0)
        <a href="{{ route('routeSchedules.bookingAffected', ['routeSchedules' => $merchant_id]) }}?merchant_id={{ $merchant_id }}"
            class="btn btn-outline-danger"><span class="animate-blink text-danger"><i
                    class="fa-regular fa-circle-dot"></i></span> Check Affecting Booking</a>
        @endif
    </div>
</div>
<hr>
<form action="{{ route('routeSchedules.index') }}" method="GET" id="frm-search">
    @if (!is_null($merchant_id))
    <input type="hidden" value="{{ $merchant_id }}" name="merchant_id" />
    @endif
    <div class="row">
        <div class="col-12">
            <h5 class="text-main-color"><i class="fa-solid fa-magnifying-glass"></i> Search Route Schedule</h5>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-floating mb-3">
                <x-element.dropdown-station label="Station From" name="station_from" :data=$stationFroms
                    selected="{{ $stationFromId }}" />
            </div>
        </div>

        <div class="col-12 col-lg-4">
            <div class="form-floating mb-3">
                <x-element.dropdown-station label="Station To" name="station_to" :data=$stationTos
                    selected="{{ $stationToId }}" />
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="form-floating mb-3">
                <select class="form-select" id="partner_id" name="partner_id" aria-label="">
                    <option value="all" selected>-- All --</option>
                    @foreach ($partners as $partner)
                    <option value="{{ $partner->id }}" @selected($partnerId==$partner->id)>{{ $partner->name }}</option>
                    @endforeach
                </select>
                <label for="partner_id">Partner</label>
            </div>
        </div>
    </div>
</form>
<hr>

<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <table class="table-datatable table table-bordered table-striped"
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
                data-export='["pdf", "xls"]' data-main-search="false" data-column-search="false" data-custom-config='{

                }'>

                <thead class="bg-light">
                    <tr>
                        <th>Partner</th>
                        <th>Route</th>
                        <th>Time</th>
                        <th>Last action</th>
                        <th>Timestamp</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $routeIdTxt = '';
                    @endphp
                    @foreach ($routes as $index => $route)
                    @if (!empty($route->lastSchedule))
                    <tr>
                        <td class="text-center p-0 align-middle">
                            @if (!is_null($route->partner))
                            <img src="{{ asset($route->partner->image->path) }}" width="25" class="rounded-circle"
                                alt="{{ $route->partner->name }}" />
                            @endif
                        </td>
                        <td>
                            <x-view-route-detail :stationfrom="$route['station_from']" :stationto="$route['station_to']"
                                :icons="$route['icons']" />
                        </td>

                        <td class="align-middle">
                            <span class="">{{ date('H:i', strtotime($route->depart_time)) }}<i
                                    class="fa-solid fa-angles-right px-2 fa-1x"></i>{{ date('H:i',
                                strtotime($route->arrive_time)) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <span
                                class=" @if ($route->lastSchedule->type == 'CLOSE') text-danger @else text-success @endif">{{
                                $route->lastSchedule->type }}
                                {{ date('d M Y', strtotime($route->lastSchedule->start_datetime)) }} -
                                {{ date('d M Y', strtotime($route->lastSchedule->end_datetime)) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            <small class="d-flex">{{ date('D,d M Y H:i', strtotime($route->lastSchedule->created_at))
                                }}</small>
                            @if (!is_null($route->lastSchedule->updated_name) && $route->lastSchedule->updated_name !=
                            '')
                            <small>Updated By {{ $route->lastSchedule->updated_name }}:
                                {{ date('D,d M Y H:i', strtotime($route->lastSchedule->updated_at)) }}</small>
                            @endif
                        </td>
                        <td class="text-end align-middle">
                            <a href="{{ route('routeSchedules.show', ['routeSchedule' => $route->id]) }}"
                                class="me-2 text-primary" target="_blank">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-week" viewBox="0 0 16 16">
                                    <path
                                        d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z">
                                    </path>
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z">
                                    </path>
                                </svg>
                            </a>
                        </td>
                    </tr>

                    @php
                    $routeIdTxt = ($route->station_from->id . $route->station_to->id);
                    @endphp
                    @endif
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
            $('#station_from').on('change', function() {
                $('#page-loader').show();
                $('#station_to').empty();
                $('#frm-search').submit();
            });

            $('#station_to').on('change', function() {
                $('#page-loader').show();
                $('#frm-search').submit();
            });

            $('#partner_id').on('change', function() {
                $('#page-loader').show();
                $('#frm-search').submit();
            });
        });
</script>
@stop