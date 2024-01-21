@extends('layouts.default')

@section('head_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API Route</span> Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 mb-3">
        <a href="{{ route('api.index') }}" class="btn btn-sm btn-secondary">Back</a>
        {{-- <a href="{{ route('api-route-updateroute', ['merchant_id' => $merchant_id]) }}" class="btn btn-sm btn-primary">Update</a> --}}
    </div>
    <div class="col-12 col-lg-12 ">
        <div class="card card-body mx-3 table-responsiv">
            <table class="table-datatable table table-hover"
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
                data-export='["pdf", "xls"]' data-responsive="false"
            >
                <thead>
                    <tr>
                        <th>Route</th>
                        <th>Price (THB)</th>
                        <th>Discount (THB)</th>
                        <th>Amount (THB)</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $index => $item)
                        @php
                            $station_from = $item['route']['station_from'];
                            $station_to = $item['route']['station_to'];
                        @endphp
                        <tr>
                            <td>
                                <p class="mb-0">[{{ $station_from['nickname'] }}] {{ $station_from['name'] }} --> [{{ $station_to['nickname'] }}] {{ $station_to['name'] }}</p>
                                <p class="mb-0 small">Depart : {{ date('H:i', strtotime($item['route']['depart_time'])) }} | Arrive : {{ date('H:i', strtotime($item['route']['arrive_time'])) }}</p>
                            </td>
                            <td class="position-relative">
                                <input type="number" class="form-control form-control-sm input-regular" id="regular-{{ $index }}"
                                        data-index="{{ $index }}" value="{{ intval($item['regular_price']) }}">
                                <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="price-updating-{{ $index }}"></i>
                                <i class="fi mdi-check check-updated d-none" id="price-updated-{{ $index }}"></i>
                                <i class="fi mdi-close fail-updated text-danger d-none" id="price-fail-{{ $index }}"></i>
                            </td>
                            <td class="position-relative">
                                <input type="number" class="form-control form-control-sm input-discount" id="discount-{{ $index }}"
                                    data-index="{{ $index }}" value="{{ intval($item['discount']) }}">
                                <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="discount-updating-{{ $index }}"></i>
                                <i class="fi mdi-check check-updated d-none" id="discount-updated-{{ $index }}"></i>
                                <i class="fi mdi-close fail-updated text-danger d-none" id="discount-fail-{{ $index }}"></i>
                            </td>
                            <td><input type="number" class="form-control form-control-sm input-amount" id="amount-{{ $index }}" data-index="{{ $index }}" value="{{ intval($item['totalamt']) }}" readonly></td>
                            <td class="text-center">
                                <label class="d-flex justify-content-center align-items-center mt-2">
                                    <input class="d-none-cloaked section-isactive input-isactive" id="number-{{ $index }}" type="checkbox" name="isactive" value="{{ $item['id'] }}" @checked(old('isactive', $item['isactive'] == 'Y')) />
                                    <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                                </label>
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
<script src="{{ asset('assets/js/app/api_route.js') }}"></script>
<style>
    .spin-updating, .check-updated, .fail-updated {
        position: absolute;
        right: 17px;
        top: 19px;
    }
</style>
@stop
