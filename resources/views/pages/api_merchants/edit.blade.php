@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API Service</span> Setting</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('api.index') }}" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Back</a>
        </div>

    </div>

    <hr>
    <div class="row">
        <div class="col-12 text-end">
            <div class="btn-group" role="group">
                <a href="" href="#" data-href="{{ route('api.addRoute', ['id' => $apiMerchant->id]) }}"
                    data-ajax-modal-size="modal-lg" data-ajax-modal-centered="true" data-ajax-modal-callback-function=""
                    data-ajax-modal-backdrop="static" class="btn btn-primary js-ajax-modal">Add/Delete Route</a>
            </div>
        </div>
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
                        <th></th>
                        <th class="text-center">#</th>
                        <th>Partner</th>
                        <th class="">Route</th>
                        @if ($apiMerchant->)
                            
                        @endif
                        <th class="text-center">Regular</th>
                        <th class="text-center">Child</th>
                        <th class="text-center ">Infant</th>
                        <th class="text-end">Seat</th>
                        <th class="text-end">Discount%</th>
                        <th class="text-end">On Top%</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apiMerchant->apiRoutes as $index => $route)
                        <tr data-id="#{{ $route->route_id }}" data-action="click">
                            <td></td>
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
                            <td class="">
                                {{ $route->station_from->name }}
                                <i class="fa-solid fa-angles-right text-info"></i>
                                {{ $route->station_to->name }} <br>
                                {{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
                            </td>
                            <td class="text-center">
                                @if ($route->pivot->discount > 0)
                                    <del>{{ number_format($route->regular_price) }}</del>
                                    <strong>{{ number_format($route->regular_price - ($route->regular_price * $route->pivot->discount) / 100) }}</strong>
                                @else
                                    {{ number_format($route->regular_price) }}
                                @endif

                            </td>
                            <td class="text-center">

                                @if ($route->pivot->discount > 0)
                                    <del>{{ number_format($route->child_price) }}</del>
                                    <strong>{{ number_format($route->child_price - ($route->child_price * $route->pivot->discount) / 100) }}</strong>
                                @else
                                    {{ number_format($route->child_price) }}
                                @endif

                            </td>
                            <td class="text-center">
                                @if ($route->pivot->discount > 0 && $route->infant_price >0)
                                    <del>{{ number_format($route->infant_price) }}</del>
                                    <strong>{{ number_format($route->infant_price - ($route->infant_price * $route->pivot->discount) / 100) }}</strong>
                                @else
                                    {{ number_format($route->infant_price) }}
                                @endif
                            </td>
                            <td class="text-end">
                                {{ $route->pivot->seat }}
                                <a href="#"
                                    data-href="{{ route('apiagent.edit', ['id' => $route->pivot->id, 'type' => 'seat']) }}"
                                    data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                    data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                    class="js-ajax-modal">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                            <td class="text-end">
                                {{ $route->pivot->discount }}%

                                <a href="#"
                                    data-href="{{ route('apiagent.edit', ['id' => $route->pivot->id, 'type' => 'discount']) }}"
                                    data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                    data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                    class="js-ajax-modal">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                            <td class="text-end">
                                {{ $route->pivot->ontop }}%

                                <a href="#"
                                    data-href="{{ route('apiagent.edit', ['id' => $route->pivot->id, 'type' => 'ontop']) }}"
                                    data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                    data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                    class="js-ajax-modal">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path
                                            d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z">
                                        </path>
                                        <path fill-rule="evenodd"
                                            d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z">
                                        </path>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
