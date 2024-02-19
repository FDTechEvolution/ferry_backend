@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            Update Route
        </h4>

        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>
    </div>

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('promotion.storeroute') }}">
        @csrf
        <input type="hidden" name="promotion_id" id="promotion_id" value="{{ $id }}">
        <input type="hidden" name="type" id="type" value="ROUTE">
        <div class="modal-body p-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-datatable table-hover" data-lng-empty="No data available in table"
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
                                <th class="text-center">#</th>
                                <th>Partner</th>
                                <th>Route</th>
                                <th class="text-center">Arrive/Depart Time</th>
                                <th class="text-center">Open to use Promotion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $index => $route)
                                <tr data-id="#{{ $route->route_id }}" data-action="click">
                                    <td class="text-center">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input form-check-input-success" type="checkbox"
                                                value="{{ $route->route_id }}" id="{{ $route->route_id }}" name="routes[]"
                                                @checked($route->isactive == 'Y')>
                                            <label>{{ $index + 1 }}</label>
                                        </div>

                                    </td>
                                    <td>{{ $route->name }}</td>
                                    <td>{{ $route->route_name }}</td>
                                    <td class="text-center">{{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
                                    <td class="text-center">
                                        @if ($route->ispromocode == 'Y')
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-muted"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop

@section('script')
    <script>
        $(document).ready(function() {
            $('tr[data-action="click"]').on('click', function() {
                let id = $(this).data('id');
                if ($(id).is(":checked")) {
                    $(id).prop('checked', false);
                } else {
                    $(id).prop('checked', true);
                }

            });
        });
    </script>
@stop
