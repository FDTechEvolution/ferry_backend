@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Affected</span> bookings</h1>

@stop

@php
    $colors = [
        'one-way' => '#0580c4',
        'round-trip' => '#00bf63',
        'multi-trip' => '#ff6100',
    ];
@endphp

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('routeSchedules.index') }}?merchant_id={{$merchant_id}}" class="btn btn-secondary"><i class="fi fi-arrow-left"></i> Back</a>

        @if (isset($apiMerchant) && !is_null($apiMerchant))
        <img src="{{$apiMerchant->logo}}" width="200px" class="px-2"/>
        @endif
    </div>
</div>
<hr>
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
                            <th class="text-center">Passengers</th>
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
                                <td class="text-center">
                                    {{ $item['adult_passenger'] + $item['child_passenger'] + $item['infant_passenger'] }}</strong>
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
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="transition-hover-top fs-5" rel="noopener" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View and Edit ooking">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
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
