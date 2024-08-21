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

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('api.storeroute', ['id' => $id]) }}">
        @csrf
        <input type="hidden" name="api_merchant_id" value="{{ $id }}">
        <div class="modal-body p-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-datatable table-align-middle table-hover"
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
                            <tr class="small">
                                <th class="text-center">#</th>
                                <th>Partner</th>
                                <th>Route</th>
                                <th class="text-center">Arrive/Depart Time</th>
                                <th class="text-center">Adult</th>
                                <th class="text-center">Child</th>
                                <th class="text-center">Infant</th>
                                <th class="text-center">Seat</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($routes as $index => $route)
                                <tr class="cursor-pointer">
                                    <td class="text-center">
                                        <div class="form-check mb-2">
                                            <input class="form-check-input form-check-input-success route-select" type="checkbox"
                                                value="{{ $route->route_id }}" id="{{ $route->route_id }}" name="routes[]"
                                                @checked($route->isactive == 'Y')>
                                            <label>{{ $index + 1 }}</label>
                                        </div>
                                    </td>
                                    <td data-id="{{ $route->route_id }}" data-action="click" >
                                        <span>
                                            @if (!is_null($route->path) && $route->path != '')
                                                <div class="avatar avatar-xs"
                                                    style="background-image:url({{ asset($route->path) }})">
                                                </div>
                                            @endif

                                        </span>
                                    </td>
                                    <td data-id="{{ $route->route_id }}" data-action="click">{{ $route->route_name }}</td>
                                    <td class="text-center" data-id="{{ $route->route_id }}" data-action="click">
                                        {{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
                                    </td>
                                    <td>
                                        <div class="col-auto">
                                            <label class="sr-only" for="adult_{{$route->route_id}}">Regular Price</label>
                                            <input type="number" class="form-control form-control-sm text-center" id="adult_{{$route->route_id}}"
                                                placeholder="" name="" value="" step="any">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-auto">
                                            <label class="sr-only" for="child_{{$route->route_id}}">Child Price</label>
                                            <input type="number" class="form-control form-control-sm text-center" id="child_{{$route->route_id}}"
                                                placeholder="" name="" value="" step="any">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-auto">
                                            <label class="sr-only" for="infant_{{$route->route_id}}">Infant Price</label>
                                            <input type="number" class="form-control form-control-sm text-center" id="infant_{{$route->route_id}}"
                                                placeholder="" name="" value="" step="any">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="col-auto">
                                            <label class="sr-only" for="seat_{{$route->route_id}}">Seat</label>
                                            <input type="number" class="form-control form-control-sm text-center" id="seat_{{$route->route_id}}"
                                                placeholder="" name="" value="">
                                        </div>
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
            $('td[data-action="click"]').on('click', function() {
                let id = $(this).data('id');
                if ($('#'+id).is(":checked")) {
                    $('#'+id).prop('checked', false);
                    setOffInput(id)
                } else {
                    $('#'+id).prop('checked', true);
                    setInput(id)
                }

            });
        });

        const routes = document.querySelectorAll('.route-select')
        if(routes.length > 0) {
            routes.forEach((item, index) => {
                item.addEventListener('click', () => {
                    if(item.checked) setInput(item.id)
                    else setOffInput(item.id)
                })
            })
        }

        function setOffInput(id) {
            $('#adult_'+id).attr('name','');
            $('#child_'+id).attr('name','');
            $('#infant_'+id).attr('name','');
            $('#seat_'+id).attr('name','');
        }

        function setInput(id) {
            $('#adult_'+id).attr('name','adult_'+id);
            $('#child_'+id).attr('name','child_'+id);
            $('#infant_'+id).attr('name','infant_'+id);
            $('#seat_'+id).attr('name','seat_'+id);
        }
    </script>
@stop
