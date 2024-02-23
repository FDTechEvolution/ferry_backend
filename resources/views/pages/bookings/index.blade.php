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
                        <option value="" selected>-- All --</option>
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
                        <option value="" selected>-- All --</option>
                        @foreach ($station['station_to'] as $item)
                            <option value="{{ $item['id'] }}" @if ($item['id'] == $station_to) selected @endif>
                                {{ $item['name'] }}</option>
                        @endforeach
                    </select>
                    <label for="station_to">Station To</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_to" aria-label="" name="station_to">
                        <option value="" selected>-- All --</option>
                        @foreach ($tripTypes as $key => $title)
                            <option value="{{$key}}">{{$title}}</option>
                        @endforeach
                    </select>
                    <label for="station_to">Trip Type</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <select class="form-select" id="station_to" aria-label="" name="station_to">
                        <option value="" selected>-- All --</option>
                        @foreach ($bookChannels as $key => $title)
                            <option value="{{$key}}">{{$title}}</option>
                        @endforeach
                    </select>
                    <label for="station_to">Salse Channel</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <input autocomplete="off" type="text" name="daterange" id="daterange"
                        class="form-control form-control-sm rangepicker" data-bs-placement="left" data-ranges="false"
                        data-date-start="{{ $startDate }}" data-date-end="{{ $endDate }}"
                        data-date-format="DD/MM/YYYY"
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
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="ticketno" name="ticketno" value="{{ $ticketno }}">
                    <label for="ticketno">Ticket Number</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="bookingno" name="bookingno" value="{{ $bookingno }}">
                    <label for="bookingno">Invoice Number</label>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="form-floating mb-3">
                    <select class="form-select" id="status" aria-label="" name="status">
                        <option value="" selected>-- All --</option>
                        @foreach ($bookingStatus as $key => $status)
                            <option value="{{$key}}">{{$status['title']}}</option>
                        @endforeach
                    </select>
                    <label for="status">Status</label>
                </div>
            </div>
            <div class="col-12 text-center">
                <a class="btn btn-sm btn-secondary" href="{{ route('booking-index') }}"><i
                        class="fa-solid fa-arrows-rotate"></i> Clear</a>
                <button type="submit" class="btn btn-sm btn-ferry"><i class="fa-solid fa-magnifying-glass"></i>
                    Search</button>
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
                    <li class="breadcrumb-item">
                        <a href="#" id="action-print" data-action="selectbook"
                            data-url="{{ route('print.multipleticket') }}" class="disabled"><i class="fi fi-print m-0"></i>
                            Print Ticket</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" id="action-send-email" class="disabled" data-action="selectbook"
                            data-url="{{ route('booking.sendConfirmEmail') }}"><i class="fa-regular fa-envelope"></i>
                            Send Email</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-12">

            <div class="table-responsive ">
                <form novalidate class="bs-validate" id="frm_action" method="POST" target="_blank" action="">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="action" id="action" value="TICKET">
                    <table class="table-datatable table table-hover" id=""
                        data-lng-empty="No data available in table"
                        data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                        data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                        data-lng-processing="Processing..." data-lng-search="Search..."
                        data-lng-norecords="No matching records found"
                        data-lng-sort-ascending=": activate to sort column ascending"
                        data-lng-sort-descending=": activate to sort column descending" data-main-search="false"
                        data-column-search="false" data-row-reorder="false" data-col-reorder="false"
                        data-responsive="false" data-header-fixed="true" data-select-onclick="false"
                        data-enable-paging="true" data-enable-col-sorting="false" data-autofill="false"
                        data-group="false" data-items-per-page="50" data-enable-column-visibility="false"
                        data-lng-column-visibility="Column Visibility" data-enable-export="false"
                        data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF"
                        data-lng-xls="XLS" data-lng-print="Print" data-lng-all="All"
                        data-export-pdf-disable-mobile="false" data-export='["csv", "pdf", "xls"]'
                        data-custom-config='{"searching":false}'>
                        <thead>
                            <tr>
                                <th class="align-content-between">

                                </th>
                                <th class="">Booking Date</th>
                                <th>Invoice No</th>
                                <th>Ticket No</th>
                                <th>Ticket Type</th>
                                <th>Travel Date</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Price</th>
                                <th>Route</th>
                                <th>Time</th>
                                <th>Status</th>
                                <th>Bank Ref.</th>
                                <th>Amend</th>

                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="">

                            @foreach ($bookings as $index => $item)
                                <tr>
                                    <td>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input form-check-input-primary"
                                                data-action="check_all" type="checkbox" value="{{ $item['bookingno'] }}"
                                                id="book_{{ $item['id'] }}" name="booking_nos[]">

                                        </div>
                                    </td>
                                    <td><small>{{ date('d/m/Y H:i', strtotime($item['created_at'])) }}</small></td>
                                    <td>{{ $item['bookingno'] }}</td>
                                    <td>{{ $item['ticketno'] }}</td>
                                    <td>{{ $item['type'] }}</td>
                                    <td>{{ $item['traveldate'] }}</td>
                                    <td>{{ $item['customer_name'] }}</td>
                                    <td>{{ $item['email'] }}</td>
                                    <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                    <td> {{ $item['route'] }}</td>
                                    <td>
                                        <small>
                                            <span class="badge rounded-pill bg-secondary">
                                                {{ date('H:i', strtotime($item['depart_time'])) }}-{{ date('H:i', strtotime($item['arrive_time'])) }}
                                            </span>
                                        </small>
                                    </td>
                                    <td class="text-center">
                                        <small class="{{$bookingStatus[$item['status']]['class']}}">{{$bookingStatus[$item['status']]['title']}}</small>
                                    </td>
                                    <td></td>
                                    <td class="text-center">{{$item['amend']}}</td>
                                    <td class="text-end">
                                        <div class="d-none">
                                            <div class="btn-group" role="group" aria-label="Basic example">
                                                @if ($item['ispayment'] == 'Y')
                                                    <a href="{{ route('print-ticket', ['bookingno' => $item['bookingno']]) }}"
                                                        class="transition-hover-top me-2 fs-5" rel="noopener"
                                                        target="_blank" data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Print Ticket">
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
                                        </div>
                                        <div class="">
                                            <div class="dropstart">
                                                <a href="#" class="btn btn-sm btn-light rounded-circle"
                                                    data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                                    <span class="group-icon">
                                                        <i class="fi fi-dots-vertical-full"></i>
                                                        <i class="fi fi-close"></i>
                                                    </span>
                                                </a>
                                                <div
                                                    class="dropdown-menu dropdown-menu-clean dropdown-click-ignore max-w-220">
                                                    <div class="scrollable-vertical max-vh-50">
                                                        @if ($item['ispayment'] == 'Y')
                                                            <a href="{{ route('print-ticket', ['bookingno' => $item['bookingno']]) }}"
                                                                class="dropdown-item text-truncate" rel="noopener"
                                                                target="_blank">
                                                                <i class="fi fi-print m-1"></i> Print Ticket
                                                            </a>
                                                        @endif

                                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                                            class="dropdown-item text-truncate" rel="noopener"
                                                            target="_blank">
                                                            <i class="fi fi-pencil m-1"></i> View/Edit
                                                        </a>
                                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                                            class="dropdown-item text-warning" rel="noopener"
                                                            target="_blank">
                                                            <i class="fi fi-close m-1"></i> Cancel
                                                        </a>
                                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                                            class="dropdown-item text-danger" rel="noopener"
                                                            target="_blank">
                                                            <i class="fi fi-thrash m-1"></i> Delete
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
                </form>
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
                    if (item.checked) {
                        settingActionLink(true);
                        return true;
                    }
                });
            });

            $('a[data-action="selectbook"]').on('click', function(e) {
                let url = $(this).data('url');
                console.log(url);
                e.preventDefault();
                //$("#frm_action").attr("method", "POST");
                $('#frm_action').attr('action', url).submit();
                //$('#frm')
            });
        });
    </script>
@stop
