@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            Add Route to Agent
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
                    <div class="alert alert-primary" role="alert">
                        เส้นทางที่แสดง คือเส้นทางที่ยังไม่เคยเพิ่มใน Agent นี้มาก่อน
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2 col-lg-3">
                    <input type="text" class="form-control form-control-sm" id="search-station-from" value=""
                        placeholder="Station From">
                </div>
                <div class="col-12 mb-2 col-lg-3">
                    <input type="text" class="form-control form-control-sm" id="search-station-to" value=""
                        placeholder="Station To">
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-datatable-custom table-hover table table-align-middle table-bordered" id="route-datatable"
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
                    data-export='["pdf", "xls"]' data-main-search="false" data-column-search="false"
                    data-custom-config='{

                    }'>
                        <thead>
                            <tr class="small">
                                <th class="text-center">#</th>
                                <th>Partner</th>
                                <th>Depart Station</th>
                                <th>Arrive Station</th>
                                <th class="text-center">Arrive/Depart Time</th>

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
                                    <td data-id="{{ $route->route_id }}" data-action="click">{{ $route->station_from }}</td>
                                    <td data-id="{{ $route->route_id }}" data-action="click">{{ $route->station_to }}</td>
                                    <td class="text-center" data-id="{{ $route->route_id }}" data-action="click">
                                        {{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
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
            line-height: 1rem !important;
        }
    </style>

@stop

@section('script')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <script>
        var _routes = document.querySelectorAll('.route-select')
        if(_routes.length > 0) {
            _routes.forEach((item, index) => {
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

            let table = new DataTable('#route-datatable', {
                searching: true,
                ordering: true,

                pageLength: 10
            });
            table.order([2, 'asc']).draw();
            $('#route-datatable_filter').empty();




            $('#search-station-from').on('keyup', function() {
                //console.log(table.columns(2).search(this.value));
                //console.log(this.value);
                table.column(2).search(this.value).draw();
            });

            $('#search-station-to').on('keyup', function() {
                //console.log(table.columns(2).search(this.value));
                //console.log(this.value);
                table.column(3).search(this.value).draw();
            });

        });



    </script>
@stop
