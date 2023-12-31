@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">Booking</span> Management</h1>
    <x-a-href-green :text="_('Create New Booking Staff Only')" :href="route('booking-route')" class="ms-3 btn-sm w--50" />
@stop

@php
    $colors = [
        'one-way' => '#0580c4',
        'round-trip' => '#00bf63',
        'multi-trip' => '#ff6100',
    ];
@endphp

@section('content')
    <form novalidate class="bs-validate" id="frm" method="GET">
        <div class="row">

            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_from" aria-label="" name="station_from">
                        <option selected></option>
                        @foreach ($station['station_from'] as $item)
                            <option value="{{ $item['id'] }}" @if ($item['id'] == $station_from) selected @endif>
                                {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="station_from">Station From</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_to" aria-label="" name="station_to">
                        <option selected></option>
                        @foreach ($station['station_to'] as $item)
                            <option value="{{ $item['id'] }}" @if ($item['id'] == $station_to) selected @endif>
                                {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="station_to">Station From</label>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-floating mb-3">
                    <input type="text" name="departdate" id="departdate" class="form-control form-control-sm datepicker"
                        data-show-weeks="true" data-today-highlight="true" data-today-btn="true" data-clear-btn="false"
                        data-autoclose="true" data-date-start="today" data-format="DD/MM/YYYY" value="">
                    <label for="departdate">Depart Date</label>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="ticketno" name="ticketno" value="{{ $ticketno }}">
                    <label for="ticketno">Ticket Number</label>
                </div>
            </div>
            <div class="col-12 col-md-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="bookingno" name="bookingno" value="{{ $bookingno }}">
                    <label for="bookingno">Invoice Number</label>
                </div>
            </div>
            <div class="col-12 text-center">
                <button type="reset" class="btn btn-secondary">Clear</button>
                <button type="submit" class="btn btn-ferry">Search</button>
            </div>
        </div>
    </form>
    <hr>
    <div class="row">
        <div class="col-12 mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-3">
                    <li class="breadcrumb-item">
                        <div class="form-check mb-2">
                            <input class="form-check-input form-check-input-primary" type="checkbox"id="check_all">
                            <label for="check_all">Select All ({{ sizeof($bookings) }} bookings)
                        </div>
                    </li>
                    <li class="breadcrumb-item"><a href="#" id="action-print" class="disabled"><i
                                class="fi fi-print m-0"></i> Print Ticket</a></li>
                    <li class="breadcrumb-item"><a href="#" id="action-send-email" class="disabled"><i
                                class="fa-regular fa-envelope"></i> Send Email</a></li>
                </ol>
            </nav>
        </div>
        <div class="col-12">

            <div class="table-responsive ">

                <table class="table-datatable table table-hover" id="" data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                    data-lng-processing="Processing..." data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending" data-main-search="true"
                    data-column-search="false" data-row-reorder="false" data-col-reorder="false" data-responsive="false"
                    data-header-fixed="true" data-select-onclick="false" data-enable-paging="true"
                    data-enable-col-sorting="false" data-autofill="false" data-group="false" data-items-per-page="50"
                    data-enable-column-visibility="false" data-lng-column-visibility="Column Visibility"
                    data-enable-export="false" data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF" data-lng-xls="XLS" data-lng-print="Print" data-lng-all="All"
                    data-export-pdf-disable-mobile="false" data-export='["csv", "pdf", "xls"]'
                    data-custom-config='{"searching":false}'>
                    <thead>
                        <tr>
                            <th class="align-content-between">

                            </th>
                            <th class="">Issue Date</th>
                            <th>Invoice No</th>
                            <th>Ticket No</th>
                            <th>Type</th>
                            <th>Route</th>
                            <th>Depart Date</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Status</th>
                            <th>Admin</th>
                            <th>Sales Ch</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="">

                        @foreach ($bookings as $index => $item)
                            <tr
                                style="color: {{ $colors[$item['trip_type']] }};--bs-table-color:{{ $colors[$item['trip_type']] }};">
                                <td>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-primary" data-action="check_all"
                                            type="checkbox" value="{{ $item['id'] }}" id="book_{{ $item['id'] }}"
                                            name="book_{{ $item['id'] }}">

                                    </div>
                                </td>
                                <td><small>{{ date('d/m/Y H:i', strtotime($item['created_at'])) }}</small></td>
                                <td>{{ $item['bookingno'] }}</td>
                                <td><strong>{{ $item['ticketno'] }}</strong>
                                </td>
                                <td>{{ $item['trip_type'] }}</td>
                                <td>
                                    {{ $item['route'] }}<br>
                                    <small><span
                                            class="badge rounded-pill bg-secondary">{{ date('H:i', strtotime($item['depart_time'])) }}-{{ date('H:i', strtotime($item['arrive_time'])) }}</span></small>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($item['traveldate'])) }}</td>
                                <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                <td class="text-center">
                                    @if ($item['ispayment'] == 'Y')
                                        <span class="text-success">Paid</span>
                                    @else
                                        <span class="text-danger">Unpay</span>
                                    @endif

                                </td>
                                <td>
                                    {{ $item['firstname'] }}
                                </td>
                                <td><small>{{ $item['book_channel'] }}</small></td>
                                <td class="text-end">
                                    <div class="d-none d-md-block">
                                        @if ($item['ispayment'] == 'Y')
                                            <a href="{{ route('print-ticket', ['bookingno' => $item['bookingno']]) }}"
                                                class="transition-hover-top me-2 fs-5" rel="noopener" target="_blank"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Print Ticket">
                                                <i class="fi fi-print m-0"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="transition-hover-top me-2 fs-5" rel="noopener" target="_blank"
                                            style="display: none;">
                                            <i class="fi fi-pencil m-0"></i>
                                        </a>
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="transition-hover-top fs-5" rel="noopener" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="View and Edit ooking">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="d-md-none">
                                        <div class="dropstart">
                                            <a href="#" class="btn btn-sm btn-light rounded-circle"
                                                data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                                <span class="group-icon">
                                                    <i class="fi fi-dots-vertical-full"></i>
                                                    <i class="fi fi-close"></i>
                                                </span>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-clean dropdown-click-ignore max-w-220">
                                                <div class="scrollable-vertical max-vh-50">
                                                    @if ($item['ispayment'] == 'Y')
                                                        <a href="{{ route('print-ticket', ['bookingno' => $item['bookingno']]) }}"
                                                            class="dropdown-item text-truncate" rel="noopener"
                                                            target="_blank">
                                                            <i class="fi fi-print m-0"></i> Print Ticket
                                                        </a>
                                                    @endif

                                                    <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                                        class="dropdown-item text-truncate" rel="noopener"
                                                        target="_blank">
                                                        <i class="fi fi-pencil m-0"></i> View Detail
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>


        </div>
    </div>
@stop

@section('script')
    <script>
        function settingActionLink(active) {
            if (active) {
                $('#action-print').removeClass('disabled');
                $('#action-send-email').removeClass('disabled');
            } else {
                $('#action-print').addClass('disabled');
                $('#action-send-email').addClass('disabled');
            }
        }
        $(document).ready(function() {
            $('#check_all').on('change', function() {
                let all_booking_checks = $('input[data-action="check_all"]');
                let checked = false;

                if (this.checked) {
                    checked = true;
                    settingActionLink(true);
                } else {
                    settingActionLink(false);
                }

                $.each(all_booking_checks, function(index, item) {
                    item.checked = checked;
                });
            });

            $('input[data-action="check_all"]').on('change', function() {
                let all_booking_checks = $('input[data-action="check_all"]');

                settingActionLink(false);
                $.each(all_booking_checks, function(index, item) {
                    if(item.checked){
                        settingActionLink(true);
                        return true;
                    }
                });
            });
        });
    </script>
@stop
