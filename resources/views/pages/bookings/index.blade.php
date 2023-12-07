@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">Booking</span> Management</h1>
    <x-a-href-green :text="_('New')" :href="route('booking-route')" class="ms-3 btn-sm w--10" />
@stop

@php
    $colors = [
        'one-way' => '#0580c4',
        'return' => '#00bf63',
        'multiple' => '#ff6100',
    ];
@endphp

@section('content')

    <div class="row">
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
                    data-enable-export="true" data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF" data-lng-xls="XLS" data-lng-print="Print" data-lng-all="All"
                    data-export-pdf-disable-mobile="true" data-export='["csv", "pdf", "xls"]'
                    data-custom-config='{"searching":true}'>
                    <thead>
                        <tr>
                            <th>Booking No</th>
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
                                <td>{{ $item['bookingno'] }}</td>
                                <td><strong>{{ isset($item['tickets'][0]) ? $item['tickets'][0]['ticketno'] : '-' }}</strong>
                                </td>
                                <td>{{ $item['trip_type'] }}</td>
                                <td>
                                    {{ $item['bookingRoutes'][0]['station_from']['nickname'] }}-{{ $item['bookingRoutes'][0]['station_to']['nickname'] }}<br>
                                    <small><span
                                            class="badge rounded-pill bg-secondary">{{ date('H:i', strtotime($item['bookingRoutes'][0]['depart_time'])) }}-{{ date('H:i', strtotime($item['bookingRoutes'][0]['arrive_time'])) }}</span></small>
                                </td>
                                <td>{{ date('d/m/Y', strtotime($item['departdate'])) }}</td>
                                <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                <td class="text-center">
                                    @if ($item['ispayment'] == 'Y')
                                        <span class="text-success">Pay</span>
                                    @else
                                        <span class="text-danger">Unpay</span>
                                    @endif

                                </td>
                                <td>
                                    @if (isset($item['user']['id']))
                                        {{ $item['user']['firstname'] }}
                                    @endif
                                </td>
                                <td><small>{{ $item['book_channel'] }}</small></td>
                                <td class="text-end">
                                    <div class="d-none d-md-block">
                                        @if ($item['ispayment'] == 'Y')
                                            <a href="{{ route('print-ticket', ['bookingno' => $item['bookingno']]) }}"
                                                class="btn btn-outline-secondary btn-sm transition-hover-top" rel="noopener"
                                                target="_blank">
                                                <i class="fi fi-print m-0"></i>
                                            </a>
                                        @endif
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="btn btn-outline-secondary btn-sm transition-hover-top" rel="noopener"
                                            target="_blank">
                                            <i class="fi fi-pencil m-0"></i>
                                        </a>
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="btn btn-outline-danger btn-sm transition-hover-top" rel="noopener"
                                            target="_blank">
                                            <i class="fi fi-close m-0"></i>
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
                                                        class="dropdown-item text-truncate" rel="noopener" target="_blank">
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
