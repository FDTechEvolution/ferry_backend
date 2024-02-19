@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API Service</span> Setting</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('api.index') }}" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Back</a>
        </div>
        <div class="col-10 text-end">
            <div class="btn-group" role="group">
                <a href="" href="#" data-href="{{ route('api.addRoute', ['id' => $apiMerchant->id]) }}"
                    data-ajax-modal-size="modal-lg" data-ajax-modal-centered="true" data-ajax-modal-callback-function=""
                    data-ajax-modal-backdrop="static" class="btn btn-primary js-ajax-modal">Add/Delete Route</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <table class="table table-sm table-datatable table-align-middle table-hover"
                data-lng-empty="No data available in table" data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                data-lng-processing="Processing..." data-lng-search="Search..."
                data-lng-norecords="No matching records found" data-lng-sort-ascending=": activate to sort column ascending"
                data-lng-sort-descending=": activate to sort column descending" data-main-search="true"
                data-column-search="false" data-row-reorder="false" data-col-reorder="false" data-responsive="true"
                data-header-fixed="false" data-select-onclick="false" data-enable-paging="true"
                data-enable-col-sorting="false" data-autofill="false" data-group="false" data-items-per-page="10"
                data-enable-column-visibility="false" data-lng-column-visibility="Column Visibility"
                data-enable-export="false">
                <thead>
                    <tr>
                        <th class="text-center">#</th>
                        <th>Partner</th>
                        <th class="text-center">Route</th>
                        <th class="text-center">Regular</th>
                        <th class="text-center">Child</th>
                        <th class="text-center ">Infant</th>
                        <th class="text-center w-25">Seat</th>
                        <th class="w-25">Discount%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apiMerchant->apiRoutes as $index => $route)
                        <tr data-id="#{{ $route->route_id }}" data-action="click">
                            <td class="text-center">
                                <label>{{ $index + 1 }}</label>
                            </td>
                            <td>
                                <span>
                                    @if (!is_null($route->partner->image) && $route->partner->image->path != '')
                                        <div class="avatar avatar-xs"
                                            style="background-image:url({{ asset($route->partner->image->path) }})">
                                        </div>
                                    @endif
                                    {{ $route->name }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $route->station_from->name }}
                                <i class="fa-solid fa-angles-right text-info"></i>
                                {{ $route->station_to->name }} <br>
                                {{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
                            </td>
                            <td class="text-center">{{number_format($route->regular_price)}}</td>
                            <td class="text-center">{{number_format($route->child_price)}}</td>
                            <td class="text-center">{{number_format($route->infant_price)}}</td>
                            <td>
                                <input type="number" name="seat" class="form-control form-control-sm" value="{{$route->pivot->seat}}" />

                            </td>
                            <td>
                                <input type="number" name="seat" class="form-control form-control-sm" value="{{$route->pivot->discount}}"  />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
