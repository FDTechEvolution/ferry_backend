@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Create Route</span> Schedule</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('routeSchedules.index') }}?merchant_id={{ $merchant_id }}" class="btn btn-secondary"><i
                    class="fi fi-arrow-left"></i> Back</a>

            @if (!is_null($apiMerchant))
                <img src="{{ $apiMerchant->logo }}" width="200px" class="px-2" />
            @endif
        </div>
    </div>
    <hr>
    <form action="{{ route('routeSchedules.create') }}" method="GET" id="frm-search">
        @if (!is_null($merchant_id))
            <input type="hidden" value="{{ $merchant_id }}" name="merchant_id" />
        @endif

        <div class="row mb-3">
            <div class="col-12">
                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input-success" type="radio" name="type" id="type_open"
                        value="OPEN" checked>
                    <label class="form-check-label" for="type_open">Open Route</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input form-check-input-danger" type="radio" name="type" id="type_close"
                        value="CLOSE">
                    <label class="form-check-label" for="type_close">Close Route</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_from_id" name="station_from_id" aria-label="">
                        <option value="all">All Station</option>
                        @foreach ($stationFroms as $station)
                            <option value="{{ $station->id }}" @selected($stationFromId == $station->id)>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    <label for="station_from_id">Station From</label>
                </div>
            </div>

            <div class="col-12 col-lg-8">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_to_id" name="station_to_id" aria-label="">
                        <option value="all">All Station</option>
                        @foreach ($stationTos as $station)
                            <option value="{{ $station->id }}" @selected($stationToId == $station->id)>{{ $station->name }}</option>
                        @endforeach
                    </select>
                    <label for="station_to_id">Station To</label>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12 col-lg-8">
                <div class="form-floating mb-3">
                    <input autocomplete="off" type="text" name="daterange" id="daterange"
                        class="form-control form-control-sm rangepicker" data-bs-placement="left" data-ranges="false"
                        data-date-start="" data-date-end="" data-date-format="DD/MM/YYYY"
                        data-quick-locale='{
        "lang_apply"	: "Apply",
        "lang_cancel" : "Cancel",
        "lang_crange" : "Custom Range",
        "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
    }'>
                    <label for="departdate">Effective date</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Note/Description</label>
                </div>
            </div>
        </div>
    </form>
    <hr>
    @if (sizeof($routes) > 0)
        <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('routeSchedules.store') }}">
            @csrf
            @if (!is_null($merchant_id))
                <input type="hidden" value="{{ $merchant_id }}" name="merchant_id" />
            @endif
            <fieldset id="field-frm">
                <div class="row">
                    <div class="col-12 col-lg-8 border-end">
                        <div class="table-responsive">
                            <div class="btn-select-all">
                                <div class="form-check mb-2 ms-2">
                                    <input class="form-check-input form-check-input-success" type="checkbox" value=""
                                        id="check-all-route">
                                    <label class="form-check-label border-bottom cursor-pointer small"
                                        for="check-all-route">
                                        Select All Route
                                    </label>
                                </div>
                            </div>
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Route (Click to select)</th>
                                        <th class="text-center">Icon</th>
                                        <th class="text-center">Depart Time</th>
                                        <th class="text-center">Arrive Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($routes as $index => $route)
                                        <tr>
                                            <td>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input form-check-input-success check-route"
                                                        type="checkbox" value="{{ $route->id }}" name="route_id[]"
                                                        id="{{ $route->id }}">
                                                    <label class="form-check-label" for="{{ $route->id }}">
                                                        <img src="{{ asset($route->partner->image->path) }}"
                                                            width="25" class="rounded-circle" />
                                                        <strong>{{ $route->station_from->name }} -
                                                            {{ $route->station_to->name }}</strong>
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center">
                                                    @foreach ($route->icons as $icon)
                                                        <div class="col-sm-4 px-0 me-1" style="width: 25px;">
                                                            <img src="{{ $icon['path'] }}" class="w-100">
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td class="text-center">{{ date('H:i', strtotime($route['depart_time'])) }}
                                            </td>
                                            <td class="text-center">{{ date('H:i', strtotime($route['arrive_time'])) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">



                        <div class="row mb-3" style="display: none;">
                            <div class="col-12">
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="mon" name="mon" checked>
                                    <label class="form-check-label" for="mon">
                                        Monday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="tru" name="tru" checked>
                                    <label class="form-check-label" for="tru">
                                        Tuesday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="wed" name="wed" checked>
                                    <label class="form-check-label" for="wed">
                                        Wednesday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="thu" name="thu" checked>
                                    <label class="form-check-label" for="thu">
                                        Thursday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="fri" name="fri" checked>
                                    <label class="form-check-label" for="fri">
                                        Friday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="sat" name="sat" checked>
                                    <label class="form-check-label" for="sat">
                                        Saturday
                                    </label>
                                </div>
                                <div class="form-check mb-2 form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="checkbox"
                                        value="Y" id="sun" name="sun" checked>
                                    <label class="form-check-label" for="sun">
                                        Sunday
                                    </label>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>



    @else
        <div class="row">
            <div class="col-12 text-center">
                <p>Apply to all routes</p>
            </div>
        </div>
    @endif

    <hr>
                <div class="row">
                    <div class="col-12 text-center">
                        <x-button-submit-loading class="btn-lg w--30 me-4 button-orange-bg" :form_id="_('frm')"
                            :fieldset_id="_('field-frm')" :text="_('Create')" />
                        <a href="{{ route('routeSchedules.index') }}" class="btn btn-secondary btn-lg w--30">Cancel</a>
                        <small id="user-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
            </fieldset>
        </form>

@stop

@section('script')
    <script>
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

    <script>
        const all_check = document.querySelector('#check-all-route')
        const check = document.querySelectorAll('.check-route')
        all_check.addEventListener('click', () => {
            if (all_check.checked) check.forEach(c => {
                c.checked = true
            })
            else check.forEach(c => {
                c.checked = false
            })
        })
    </script>
@stop
