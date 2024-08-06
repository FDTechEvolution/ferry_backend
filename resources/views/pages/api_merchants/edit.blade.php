@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">{{$apiMerchant->name}}</span> API Setting</h1>
@stop

@section('content')
    <div class="row mb-3">
        <div class="col-2">
            <a href="{{ route('api.index') }}" class="btn btn-secondary"><i class="fa-solid fa-circle-left"></i> Back to all API</a>
        </div>

    </div>

    <hr>
    <div class="row">
        <div class="col-6 mb-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-light p-1">
                    <li class="breadcrumb-item">
                        <div class="form-check mb-2">
                            <input class="form-check-input form-check-input-primary" type="checkbox"id="check_all">
                            <label for="check_all">Select All ({{ sizeof($apiMerchant->apiRoutes) }} routes)
                        </div>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="#" id="action-delete" data-action="selectbook"
                            data-url="{{ route('apiroute.multiple_delete') }}" class="disabled text-danger">
                            <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                                </path>
                                <path fill-rule="evenodd"
                                    d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                                </path>
                            </svg>
                            Delete</a>
                    </li>

                </ol>
            </nav>
        </div>
        <div class="col-6 mb-2 text-end">
            <div class="btn-group" role="group">
                <a href="#" data-href="{{ route('api.addRoute', ['id' => $apiMerchant->id]) }}"
                    data-ajax-modal-size="modal-xl" data-ajax-modal-centered="true" data-ajax-modal-callback-function=""
                    data-ajax-modal-backdrop="static" class="btn btn-primary js-ajax-modal">Add Route</a>
            </div>
        </div>
        <div class="col-12">
            <form novalidate class="bs-validate" id="frm_action" method="POST" action="">
                @csrf
                <input type="hidden" name="api_merchant_id" id="api_merchant_id" value="{{$apiMerchant->id}}">
                <table class="table table-sm table-datatable table-align-middle table-hover table-bordered"
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                    data-lng-processing="Processing..." data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
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
                            <th class="text-center">Partner</th>
                            <th class="">Route</th>
                            @if ($apiMerchant->isopenregular == 'Y')
                                <th class="text-center">Regular</th>
                            @endif
                            @if ($apiMerchant->isopenchild == 'Y')
                                <th class="text-center">Child</th>
                            @endif
                            @if ($apiMerchant->isopeninfant == 'Y')
                                <th class="text-center">Infant</th>
                            @endif
                            <th class="text-center">Seat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apiMerchant->apiRoutes as $index => $route)
                            <tr data-id="#{{ $route->route_id }}" data-action="click">
                                <td class="text-center">
                                    <div class="form-check d-flex justify-content-center">
                                        <input class="form-check-input form-check-input-success" type="checkbox"
                                            data-action="check_all" value="{{ $route->pivot->id }}"
                                            id="{{ $route->pivot->id }}" name="api_route_id[]">
                                    </div>

                                </td>
                                <td class="text-center">
                                    <label>{{ $index + 1 }}</label>
                                </td>
                                <td class="text-center">
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

                                @if ($apiMerchant->isopenregular == 'Y')
                                    <td class="text-center">
                                        <x-agent-discount-column :price="$route->pivot->regular_price" :discount="$route->pivot->discount" :ontop="$route->pivot->ontop" />
                                    </td>
                                @endif

                                @if ($apiMerchant->isopenchild == 'Y')
                                    <td class="text-center">
                                        <x-agent-discount-column :price="$route->pivot->child_price" :discount="$route->pivot->discount" :ontop="$route->pivot->ontop" />
                                    </td>
                                @endif

                                @if ($apiMerchant->isopeninfant == 'Y')
                                    <td class="text-center">
                                        <x-agent-discount-column :price="$route->pivot->infant_price" :discount="$route->pivot->discount" :ontop="$route->pivot->ontop" />
                                    </td>
                                @endif

                                <td class="text-center">
                                    {{ $route->pivot->seat }}
                                </td>
                                <td class="text-end">
                                    <a href="#"
                                        data-href="{{ route('apiagent.edit', ['id' => $route->pivot->id]) }}"
                                        data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                        class="me-2 js-ajax-modal">
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
                                    <a href="{{ route('apiroute.calendar', ['id' => $route->pivot->id, 'api_route_id' => $route->pivot->id]) }}"
                                        class="me-2 text-primary" >
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg"
                                            fill="currentColor" class="bi bi-calendar-week" viewBox="0 0 16 16">
                                            <path
                                                d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-5 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z">
                                            </path>
                                            <path
                                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z">
                                            </path>
                                        </svg>
                                    </a>
                                    <x-action-delete />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </form>
        </div>
    </div>
@stop



@section('script')
    <script>
        function settingActionLink(active) {
            if (active) {
                $('#action-delete').removeClass('disabled');
                //$('#action-send-email').removeClass('disabled');
            } else {
                $('#action-delete').addClass('disabled');
                //$('#action-send-email').addClass('disabled');
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
