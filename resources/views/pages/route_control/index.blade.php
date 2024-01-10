@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title"><span class="text-main-color-2">Route</span> control</h1>
    <a href="{{ route('route-create') }}" class="btn button-green-bg border-radius-10 ms-3 btn-sm w--15">Add</a>
@stop

@section('content')
    <div class="row mt-3">
        <div class="col-12 mb-2 col-lg-3">
            <input type="text" class="form-control form-control-sm" id="filter-station-from" value=""
                placeholder="Station From">
        </div>
        <div class="col-12 mb-2 col-lg-3">
            <input type="text" class="form-control form-control-sm" id="filter-station-to" value=""
                placeholder="Station To">
        </div>
        <div class="col-6 col-lg-1 offset-lg-4">
            <form novalidate class="bs-validate" method="POST" target="_blank" action="{{ route('route-selected-pdf') }}">
                @csrf
                <input type="hidden" name="route_selected" id="input-pdf-selected" value="">
                <button class="btn btn-sm btn-outline-dark w-100 me-1 a-href-disabled" id="btn-confirm-route-selected-pdf"
                    data-bs-toggle="tooltip" data-bs-placement="top" title="Print All Select">
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
            </form>
        </div>
        <div class="col-6 col-lg-1">
            <form novalidate class="bs-validate" id="form-route-selected-delete" method="POST"
                action="{{ route('route-selected-delete') }}">
                @csrf
                <input type="hidden" name="route_selected" id="input-delete-selected" value="">
            </form>
            <a href="#" class="js-ajax-confirm btn btn-sm btn-outline-dark w-100 a-href-disabled"
                id="btn-confirm-route-selected-delete" data-ajax-confirm-type="danger" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Delete All Select" data-ajax-confirm-mode="ajax"
                data-ajax-confirm-method="GET" data-ajax-confirm-size="modal-md" data-ajax-confirm-centered="false"
                data-ajax-confirm-title="Please Confirm" data-ajax-confirm-body="Please confirm delete routes!"
                data-ajax-confirm-btn-yes-class="btn-sm btn-danger" data-ajax-confirm-btn-yes-text="Yes, delete"
                data-ajax-confirm-btn-yes-icon="fi fi-check" data-ajax-confirm-btn-no-class="btn-sm btn-light"
                data-ajax-confirm-btn-no-text="Cancel" data-ajax-confirm-btn-no-icon="fi fi-close"
                data-ajax-confirm-callback-function="confirmRouteSelectedDelete">
                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="bi bi-trash" viewBox="0 0 16 16">
                    <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z">
                    </path>
                    <path fill-rule="evenodd"
                        d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z">
                    </path>
                </svg>
            </a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div id="to-route-list" class="table-responsive">

                <table class="table-datatable table table-datatable-custom table-hover" id="route-datatable"
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                    data-lng-processing="Processing..." data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                    data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="false"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS"
                    data-lng-all="All" data-export-pdf-disable-mobile="true" data-responsive="false"
                    data-export='["pdf", "xls"]'
                    data-custom-config='{
                        "searching":false
                    }'>
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 60px;">Choose</th>
                            <th class="text-start">Station From</th>
                            <th class="text-start">Station To</th>
                            <th class="text-center">Depart</th>
                            <th class="text-center">Arrive</th>
                            <th class="text-center fix-width-120">Icon</th>
                            <th class="text-center">Price</th>
                            <th class="text-center">status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-route">
                        @foreach ($routes as $index => $route)
                            <tr class="text-center" data-from="{{ $route['station_from']['id'] }}"
                                data-to="{{ $route['station_to']['id'] }}">
                                <td>
                                    <input class="form-check-input form-check-input-primary route-selected-action"
                                        type="checkbox" value="{{ $route['id'] }}" id="route-check-{{ $index }}"
                                        onClick="routeSelectedAction(this)">
                                </td>
                                <td class="text-start lh--1-2">
                                    {{ $route['station_from']['name'] }}
                                    @if ($route['station_from']['piername'] != '')
                                        <small
                                            class="text-secondary fs-d-80">({{ $route['station_from']['piername'] }})</small>
                                    @endif
                                </td>
                                <td class="text-start lh--1-2">
                                    {{ $route['station_to']['name'] }}
                                    @if ($route['station_to']['piername'] != '')
                                        <small
                                            class="text-secondary fs-d-80">({{ $route['station_to']['piername'] }})</small>
                                    @endif
                                </td>
                                <td>{{ date('H:i', strtotime($route['depart_time'])) }}</td>
                                <td>{{ date('H:i', strtotime($route['arrive_time'])) }}</td>
                                <td>
                                    <div class="row mx-auto justify-center-custom">
                                        @foreach ($route['icons'] as $icon)
                                            <div class="col-sm-4 px-0" style="max-width: 30px;">
                                                <img src="{{ $icon['path'] }}" class="w-100">
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                                <td>{{ number_format($route['regular_price']) }}</td>
                                <td>{!! $route_status[$route['isactive']] !!}</td>
                                <td>
                                    <x-action-edit class="me-2" :url="route('route-edit', ['id' => $route['id']])" id="btn-route-edit" />
                                    <x-action-delete :url="route('route-delete', ['id' => $route['id']])" :message="_('Are you sure? Delete this route ?')" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <a href="#" id="confirm-delete-hidden" style="visibility: hidden;" class="js-ajax-confirm" data-href=""
        data-ajax-confirm-mode="regular" data-ajax-confirm-type="danger" data-ajax-confirm-size="modal-md"
        data-ajax-confirm-centered="false" data-ajax-confirm-title="Please Confirm"
        data-ajax-confirm-body="Are you sure? Delete this route ?" data-ajax-confirm-btn-yes-class="btn-danger"
        data-ajax-confirm-btn-yes-text="Yes, delete" data-ajax-confirm-btn-yes-icon="fi fi-check"
        data-ajax-confirm-btn-no-class="btn-light" data-ajax-confirm-btn-no-text="Cancel"
        data-ajax-confirm-btn-no-icon="fi fi-close">
    </a>

    <style>
        .custom-padding {
            padding-top: 9px;
            padding-bottom: 8px;
        }

        .fix-width-120 {
            width: 120px;
        }

        .a-href-disabled {
            pointer-events: none;
            cursor: default;
            opacity: 0.5;
        }

        div.dataTables_wrapper div.dataTables_filter input {
            margin-left: 0;
        }

        .lh--1-2 {
            line-height: 1.2rem !important;
        }
    </style>
@stop

@section('script')
    <script>
        const icons = {{ Js::from($icons) }}
        const routes = {{ Js::from($routes) }}
    </script>
    <script src="{{ asset('assets/js/app/route_control.js') }}"></script>
@stop
