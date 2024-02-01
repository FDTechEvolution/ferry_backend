@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="report-page-title">Report</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <form class="bs-validate" id="report-create-form" method="POST" action="{{ route('report-get') }}">
            @csrf
            <fieldset id="report-create">
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
                            <label for="daterange">Depart Date</label>
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
    <div class="col-12">
        @if (!empty($reports))
            <div class="card">
                <div class="card-body">
                    <p class="">
                        <span class="fw-bold">Depart Date :</span> <span class="">{{ $depart_date }}</span>
                    </p>
                    <div id="report-list" class="table-responsive">
                        <table class="table-datatable table table-datatable-custom" id="report-datatable"
                            data-lng-empty="No data available in table"
                            data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                            data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                            data-lng-processing="Processing..." data-lng-search="Search..."
                            data-lng-norecords="No matching records found"
                            data-lng-sort-ascending=": activate to sort column ascending"
                            data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                            data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="true"
                            data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS"
                            data-lng-all="All" data-export-pdf-disable-mobile="true" data-export='["pdf", "xls"]'
                            data-responsive="false">
                            <thead>
                                <tr class="small">
                                    <th class="text-center">#</th>
                                    <th class="">InvoiceNo.</th>
                                    <th class="text-center">Travel Date</th>
                                    <th class="text-center">Passenger</th>
                                    <th class="text-center">Route Amount (THB)</th>
                                    <th class="text-center">Extra Amount (THB)</th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center">Trip Type</th>
                                    <th class="text-center">Booking Chanel</th>
                                    <th class="text-center">Premium Flex</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $index => $item)
                                    <tr class="">
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $item['bookingno'] }}</td>
                                        <td class="text-center">{{ $item['travel_date'] }}</td>
                                        <td class="text-center">{{ intval($item['adult_passenger']) + intval($item['child_passenger']) + intval($item['infant_passenger']) }}</td>
                                        <td class="text-center">{{ number_format($item['totalamt']) }}</td>
                                        <td class="text-center">{{ number_format($item['extraamt']) }}</td>
                                        <td class="text-center">
                                            @if($item['promotion_id'] != '')
                                                <p class="small">
                                                    {{ number_format($item['promotion']['discount']) }}
                                                    @if($item['promotion']['discount'] == THB) THB @else % @endif
                                                </p>
                                                <small class="smaller">{{ $item['promotion']['code'] }}</small>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $item['trip_type'] }}</td>
                                        <td class="text-center">{{ $item['book_channel'] }}</td>
                                        <td class="text-center">@if($item['ispremiumflex'] == 'Y') YES @else - @endif</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@stop

@section('script')

@stop
