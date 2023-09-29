@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Station</span> manager</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-station-create" />
    <x-button-orange :type="_('button')" :text="_('Edit')" class="ms-3 btn-sm w--10" id="btn-station-edit"/>
    <x-button-green :type="_('button')" :text="_('Add Section')" class="ms-3 btn-sm w--15" id="btn-section-create" />
    <x-button-orange :type="_('button')" :text="_('Manage Section')" class="ms-3 btn-sm w--15" id="btn-section-manage" />
@stop

@section('content')
<div class="row mt-4">

    <div class="col-12">
        <div id="to-station-list">
            <div class="card-body">
                <div class="d-flex justify-content-center d-flex align-items-center mb-4">
                    <div class="form-check me-3">
                        <input class="form-check-input form-check-input-primary" type="checkbox" value="" id="station-check-select">
                        <label class="form-check-label" for="station-check-select">
                            Select
                        </label>
                    </div>
                    <div class="form-check me-5">
                        <input class="form-check-input form-check-input-primary" type="checkbox" value="" id="station-check-all">
                        <label class="form-check-label" for="station-check-all">
                            ALL
                        </label>
                    </div>

                    <!-- edit -->
                    <x-action-edit 
                        class="me-3 ms-5"
                        style="margin-top: -2px;"
                        :url="_('#')"
                    />

                    <!-- delete -->
                    <x-action-delete 
                        :url="_('#')"
                        :message="_('ยืนยันการลบ ?')"
                    />
                </div>
                <table class="table-datatable table table-datatable-custom" id="station-datatable" 
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
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th class="text-center w--5">Choose</th>
                            <th class="text-center">Station Name</th>
                            <th class="text-center">Station Pier</th>
                            <th class="text-center">Nickname</th>
                            <th class="text-center">Sort</th>
                            <th class="text-center">Sections Group</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stations as $index => $station)
                            <tr class="text-center" id="station-row-{{ $index }}">
                                <td><input class="form-check-input form-check-input-primary station-check mt-2" type="checkbox" value=""></td>
                                <td data-id="name">{{ $station['name'] }}</td>
                                <td data-id="piername">{{ $station['piername'] }}</td>
                                <td data-id="nickname">{{ $station['nickname'] }}</td>
                                <td data-id="sort">{{ $station['sort'] }}</td>
                                <td>{{ $station['section']['name'] }}</td>
                                <td>{!! $status[$station['isactive']] !!}</td>
                                <td>
                                    <input type="hidden" id="station-id-{{ $index }}" value="{{ $station['id'] }}">
                                    <input type="hidden" id="station-section-{{ $index }}" value="{{ $station['section']['id'] }}">
                                    <input type="hidden" id="station-status-{{ $index }}" value="{{ $station['isactive'] }}">
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-station-edit"
                                        onClick="updateStationEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="route('station-delete', ['id' => $station['id']])"
                                        :message="_('Are you sure? Delete '. $station['name'] .'?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-station-create" class="m-auto d-none">
            @include('pages.stations.create')
        </div>
        <div id="to-station-edit" class="m-auto d-none">
            @include('pages.stations.edit')
        </div>
        <div id="to-section-create" class="m-auto d-none">
            @include('pages.stations.section_create')
        </div>
        <div id="to-section-manage" class="m-auto d-none">
            @include('pages.stations.section_manage')
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    let stations = {{ Js::from($stations) }}
</script>
<script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop