@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Station</span> manager</h1>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <x-a-href-green :text="_('Add')" :href="route('create-station')" :target="_('_self')" class="" />


            <x-a-href-orange :text="_('Manage Section')" :href="route('manage-section')" :target="_('_self')" class="" />
        </div>
    </div>
@stop

@section('content')

    <div class="row mt-4">

        <div class="col-12">
            <div id="to-station-list" class="table-responsive">
                <div class="card-body">
                    <div class="d-flex justify-content-center d-flex align-items-center mb-4">
                        <div class="form-check me-3">
                            <input class="form-check-input form-check-input-primary" type="checkbox" value=""
                                id="station-check-select">
                            <label class="form-check-label" for="station-check-select">
                                Select
                            </label>
                        </div>
                        <div class="form-check me-5">
                            <input class="form-check-input form-check-input-primary" type="checkbox" value=""
                                id="station-check-all">
                            <label class="form-check-label" for="station-check-all">
                                ALL
                            </label>
                        </div>

                        <!-- edit -->
                        <x-action-edit class="me-3 ms-5" style="margin-top: -2px;" :url="_('#')" />

                        <!-- delete -->
                        <x-action-delete :url="_('#')" :message="_('ยืนยันการลบ ?')" />
                    </div>
                    <table class="table-datatable table table-datatable-custom" id="station-datatable"
                        data-lng-empty="No data available in table"
                        data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                        data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                        data-lng-processing="Processing..." data-lng-search="Search..."
                        data-lng-norecords="No matching records found"
                        data-lng-sort-ascending=": activate to sort column ascending"
                        data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                        data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="true"
                        data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS"
                        data-lng-all="All" data-export-pdf-disable-mobile="true" data-export='["pdf", "xls"]'
                        data-responsive="false">
                        <thead>
                            <tr>
                                <th class="text-center w--5">Choose</th>
                                <th class="text-center">Sections Group</th>
                                <th class="text-start">Station Name</th>
                                <th class="text-start">Nickname</th>
                                <th class="text-start">Station Pier</th>

                                <th class="text-center">Sort</th>

                                <th class="text-center">Status</th>
                                <th>Map Image</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stations as $index => $station)
                                <tr class="text-center" id="station-row-{{ $index }}">
                                    <td><input class="form-check-input form-check-input-primary station-check mt-2"
                                            type="checkbox" value=""></td>
                                    <td>{{ $station['section']['name'] }}</td>
                                    <td data-id="name" class="text-start">{{ $station['name'] }}</td>
                                    <td data-id="nickname" class="text-start">{{ $station['nickname'] }}</td>
                                    <td data-id="piername" class="text-start">{{ $station['piername'] }}</td>

                                    <td data-id="sort">{{ $station['sort'] }}</td>

                                    <td>{!! $status[$station['isactive']] !!}</td>
                                    <td>
                                        @if (isset($station->image->path))
                                            <div class="avatar avatar-sm"
                                                style="background-image:url({{ asset('/'.$station->image->path) }})"></div>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="hidden" id="station-id-{{ $index }}"
                                            value="{{ $station['id'] }}">
                                        <input type="hidden" id="station-section-{{ $index }}"
                                            value="{{ $station['section']['id'] }}">
                                        <input type="hidden" id="station-status-{{ $index }}"
                                            value="{{ $station['isactive'] }}">
                                        <x-action-edit class="me-2" :url="route('edit-station', ['id' => $station['id']])" id="btn-station-edit" />
                                        <x-action-delete :url="route('station-delete', ['id' => $station['id']])" :message="_('Are you sure? Delete ' . $station['name'] . '?')" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <style>
        @media (max-width: 412px) {
            body.layout-admin #middle {
                margin-top: 140px !important;
            }
        }
    </style>
@stop

@section('modal')
    <div class="modal fade" id="modal-station-info" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="station-info-modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="station-info-modal-content">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        const stations = {{ Js::from($stations) }}
        const station_info = {{ Js::from($info) }}
    </script>
    <script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop
