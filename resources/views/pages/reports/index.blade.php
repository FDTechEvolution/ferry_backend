@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Report</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <form class="bs-validate" id="promotion-create-form" method="POST" action="{{ route('report-get') }}" enctype="multipart/form-data">
            @csrf
            <fieldset id="promotion-create">
                <div class="row">
                    <div class="col-12 col-lg-4">
                        <div class="form-floating mb-3">
                            <input autocomplete="off" type="text" name="daterange" id="daterange"
                                class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                data-ranges="false" data-date-start=""
                                data-date-end="" data-date-format="DD/MM/YYYY"
                                data-quick-locale='{
                                        "lang_apply"	: "Apply",
                                        "lang_cancel" : "Cancel",
                                        "lang_crange" : "Custom Range",
                                        "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                        "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                                    }'>
                            <label for="departdate">Depart Date</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select" name="station_from" id="station-from" aria-label="Station From Select">
                                <option selected disabled>Select</option>
                                @foreach ($sections as $index => $section)
                                    <optgroup label="{{ $section['name'] }}">
                                        @foreach ($section['stations'] as $station)
                                            <option value="{{ $station['id'] }}">
                                                @if($station['nickname'] != '') [{{ $station['nickname'] }}] @endif
                                                {{ $station['name'] }}
                                                @if($station['piername'] != '') ({{ $station['piername'] }}) @endif
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <label for="station-from">Station From</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select" name="station_to" id="station-to" aria-label="Station To Select">
                                <option selected disabled>Select</option>
                                @foreach ($sections as $index => $section)
                                    <optgroup label="{{ $section['name'] }}">
                                        @foreach ($section['stations'] as $station)
                                            <option value="{{ $station['id'] }}">
                                                @if($station['nickname'] != '') [{{ $station['nickname'] }}] @endif
                                                {{ $station['name'] }}
                                                @if($station['piername'] != '') ({{ $station['piername'] }}) @endif
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            <label for="station-to">Station To</label>
                        </div>
                    </div>
                    <div class="col-12 col-lg-2">
                        <button type="submit" class="btn btn-sm btn-primary">Search</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

<div class="row">
    @if (!empty($reports))
        <div class="card">
            <div class="card-body">
                <h1>Reports</h1>
            </div>
        </div>
    @endif
</div>
@stop

@section('script')

@stop
