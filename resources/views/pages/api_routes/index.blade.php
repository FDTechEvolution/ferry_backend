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
        {{-- <a href="{{ route('api-route-updatecommission') }}" class="btn btn-sm btn-primary">Update</a> --}}
        <a href="{{route('routeSchedules.index')}}?merchant_id={{$merchant_id}}" class="btn btn-warning btn-sm"><i class="fi fi-calendar"></i> Open/Close API Route Schedule</a>
        <img src="{{$api_merchant->logo}}" width="200px" class="d-none" />
    </div>
    <div class="col-12 col-lg-12 ">
        <div class="card card-body mx-3 table-responsiv">
            <div class="row mb-2">
                <div class="col-6 col-lg-2">
                    <input type="text" class="form-control form-control-sm" id="filter-station-from" placeholder="Station From">
                </div>
                <div class="col-6 col-lg-2">
                    <input type="text" class="form-control form-control-sm" id="filter-station-to" placeholder="Station To">
                </div>
            </div>
            <table class="table-datatable table table-hover" id="api-route-datatable"
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
                data-custom-config='{
                    "searching":false
                }'
            >
                <thead>
                    <tr>
                        <th>Route</th>
                        <th class="w--15 text-center">Price <small>(THB)</small></th>
                        <th class="w--15 text-center">Discount <small>(THB)</small></th>
                        <th class="text-center d-none">Com. <small>(<span class="is-commission">{{ $commission }}</span>%)</small></th>
                        <th class="text-center d-none">Vat. <small>(<span class="is-vat">{{ $vat }}</span>%)</small></th>
                        <th class="text-center d-none">Total <small>(THB)</small></th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $index => $item)
                        @php
                            $f_nickname = $item['route'] ? $item['route']['station_from']['nickname'] : '';
                            $f_name = $item['route'] ? $item['route']['station_from']['name'] : '';
                            $t_name = $item['route'] ? $item['route']['station_to']['name'] : '';
                            $t_nickname = $item['route'] ? $item['route']['station_to']['nickname'] : '';
                            $f_pier = $item['route'] ? $item['route']['station_from']['piername'] : '';
                            $t_pier = $item['route'] ? $item['route']['station_to']['piername'] : '';
                            $depart = $item['route'] ? $item['route']['depart_time'] : '';
                            $arrive = $item['route'] ? $item['route']['arrive_time'] : '';
                        @endphp
                        <tr>
                            <td>
                                <p class="mb-0">[{{ $f_nickname }}] {{ $f_name }} <span class="small">({{ $f_pier }})</span> <span class="fw-bold mx-2 text-danger">--></span> [{{ $t_nickname }}] {{ $t_name }} <span class="small">({{ $t_pier }})</span></p>
                                <p class="mb-0 small">Depart : {{ date('H:i', strtotime($depart)) }} <span class="mx-2">|</span> Arrive : {{ date('H:i', strtotime($arrive)) }}</p>
                            </td>
                            <td class="position-relative">
                                <input type="number" class="form-control form-control-sm input-regular text-center" id="regular-{{ $index }}"
                                        data-index="{{ $index }}" value="{{ intval($item['regular_price']) }}">
                                <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="price-updating-{{ $index }}"></i>
                                <i class="fi mdi-check check-updated d-none" id="price-updated-{{ $index }}"></i>
                                <i class="fi mdi-close fail-updated text-danger d-none" id="price-fail-{{ $index }}"></i>
                            </td>
                            <td class="position-relative">
                                <input type="number" class="form-control form-control-sm input-discount text-center" id="discount-{{ $index }}"
                                    data-index="{{ $index }}" value="{{ intval($item['discount']) }}">
                                <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="discount-updating-{{ $index }}"></i>
                                <i class="fi mdi-check check-updated d-none" id="discount-updated-{{ $index }}"></i>
                                <i class="fi mdi-close fail-updated text-danger d-none" id="discount-fail-{{ $index }}"></i>
                            </td>
                            <td class="text-center d-none">
                                <p class="mt-2" id="commission-{{ $index }}">{{ $item['commission'] }}</p>
                            </td>
                            <td class="text-center d-none">
                                <p class="mt-2" id="vat-{{ $index }}">{{ $item['vat'] }}</p>
                            </td>
                            <td class="text-center d-none">
                                <p class="mt-2 fw-bold" id="amount-{{ $index }}" data-index="{{ $index }}">{{ number_format($item['totalamt'], 2) }}</p>
                            </td>
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
<script>
    const routes = {{ Js::from($routes) }}
</script>
<script src="{{ asset('assets/js/app/api_route.js') }}?v=@php echo date('YmdHis'); @endphp"></script>
<style>
    .spin-updating, .check-updated, .fail-updated {
        position: absolute;
        right: 17px;
        top: 19px;
    }
</style>
@stop
