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
                    <div class="row">
                        <div class="col-12 col-lg-10">
                            <p class="small">
                                <span class="fw-bold">Depart Date :</span> <span class="">{{ $depart_date }}</span>
                                <span class="fw-bold ms-3">Station From : </span>
                                <span class="">@if($from->nickname != '') [{{ $from->nickname }}] @endif {{ $from->name }} @if($from->piername != '') ({{ $from->piername }}) @endif</span>
                                <span class="fw-bold ms-3">Station To : </span>
                                <span class="">@if($to->nickname != '') [{{ $to->nickname }}] @endif {{ $to->name }} @if($to->piername != '') ({{ $to->piername }}) @endif</span>
                            </p>
                        </div>

                        {{-- PDF Button : display: none; --}}
                        <div class="col-12 col-lg-2 text-end d-none">
                            <form novalidate class="bs-validate" method="POST" target="_blank" action="{{ route('report-pdf') }}">
                                @csrf
                                <button class="btn btn-sm btn-outline-dark w-50 me-1 a-href-disabled"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Download PDF">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                        class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                        <path
                                            d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z">
                                        </path>
                                        <path
                                            d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z">
                                        </path>
                                    </svg>
                                </button>
                                <input type="hidden" name="daterange" value="{{ $depart_date }}">
                                <input type="hidden" name="station_from" value="{{ $from->id }}">
                                <input type="hidden" name="station_to" value="{{ $to->id }}">
                            </form>
                        </div>
                    </div>
                    <div id="report-list" class="table-responsive">
                        <table class="table-datatable table table-datatable-custom" id="report-datatable"
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
                            data-responsive="true">
                            <thead>
                                <tr class="small">
                                    <th class="text-center">#</th>
                                    <th class="">InvoiceNo.</th>
                                    <th class="text-center">Route</th>
                                    <th class="text-center">Passenger</th>
                                    <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Route Amount">
                                        <p class="mb-0">R.Amount</p>(THB)
                                    </th>
                                    <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Extra Amount">
                                        <p class="mb-0">E.Amount</p>(THB)
                                    </th>
                                    <th class="text-center">Discount</th>
                                    <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Amount">
                                        <p class="mb-0">T.Amount</p>(THB)
                                    </th>
                                    <th class="text-center">Trip Type</th>
                                    <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Booking Channel">B.Channel</th>
                                    <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Premium Flex">P.Flex</th>
                                    <th class="text-center">Payment</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($reports as $index => $item)
                                    <tr class="">
                                        <td class="text-center">{{ $index+1 }}</td>
                                        <td>{{ $item['bookingno'] }}</td>
                                        <td class="text-center">
                                            <p class="mb-0">{{ $from->nickname }} - {{ $to->nickname }}</p>
                                            <small>{{ $item['travel_date'] }}</small>
                                        </td>
                                        <td class="text-center">{{ intval($item['adult_passenger']) + intval($item['child_passenger']) + intval($item['infant_passenger']) }}</td>
                                        <td class="text-center">{{ number_format($item['totalamt']) }}</td>
                                        <td class="text-center">{{ number_format($item['extraamt']) }}</td>
                                        <td class="text-center">
                                            @if($item['promotion_id'] != '')
                                                <p class="mb-0">
                                                    {{ number_format($item['promotion']['discount']) }} @if($item['promotion']['discount'] == 'THB') THB @else % @endif
                                                </p>
                                                <small class="smaller ms-1">[{{ $item['promotion']['code'] }}]</small>
                                            @else
                                                <span>-</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ number_format($item['payments'][0]['totalamt']) }}</td>
                                        <td class="text-center">{{ $item['trip_type'] }}</td>
                                        <td class="text-center">{{ $item['book_channel'] }}</td>
                                        <td class="text-center">@if($item['ispremiumflex'] == 'Y') <i class="fa-regular fa-circle-check"></i> @else - @endif</td>
                                        <td class="text-center">
                                            @if($item['payments'][0]['status'] == 'CO') {{ $item['payments'][0]['payment_method'] }}
                                            @else -
                                            @endif
                                        </td>
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
<style>
    div.dt-button-collection {
        width: 100px;
        left: unset !important;
        right: 0;
    }
    div.dt-button-collection .dt-button:not(.dt-btn-split-drop) {
        min-width: 0 !important;
    }
</style>
@stop
