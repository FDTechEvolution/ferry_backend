@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2">Route Map</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color" id="create-route-map">
            @include('pages.route_map.create')
        </div>

        <div class="card bg-main-color d-none" id="edit-route-map">
            @include('pages.route_map.edit')
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom"
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-main-search="false"
                    data-column-search="false"
                    data-row-reorder="false"
                    data-col-reorder="fasle"
                    data-responsive="true"
                    data-enable-paging="true"
                    data-enable-col-sorting="false"
                    data-autofill="false"
                    data-group="false"
                    data-items-per-page="10"

                    data-enable-column-visibility="false"
                    data-lng-column-visibility="Column Visibility"

                    data-enable-export="false"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-csv="CSV"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-copy="Copy"
                    data-lng-print="Print"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["csv", "pdf", "xls"]'
                    data-options='["copy", "print"]'

                    data-custom-config='{}'>
                    <thead>
                        <tr>
                            <th class="text-center">Pic Route Map</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">News Show In Homepage</th>
                            <th class="text-center">Sort</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($route_maps as $index => $map)
                            <tr class="text-center align-middle">
                                <td class="mx-w--100">
                                    <a class="fancybox" href="{{ asset($map->image->path.'/'.$map->image->name) }}">
                                        <img src="{{ asset($map->image->path.'/'.$map->image->name) }}" class="w--100 w-sm--200">
                                    </a>
                                </td>
                                <td>{{ $map->detail }}</td>
                                <td>
                                    <label class="align-items-center text-center">
                                        <input class="d-none-cloaked" type="checkbox" name="switch-checkbox" value="{{ $map->id }}" @checked($map->isactive == 'Y') onClick="showInHomepage(this)">
                                        <i class="switch-icon switch-icon-primary"></i>
                                    </label>
                                </td>
                                <td>{{ $map->sort }}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-route-map-edit"
                                        onClick="updateEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="route('route-map-delete', ['id' => $map->id])"
                                        :message="_('Are you sure? Delete this route map ?')"
                                    />
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
    main#middle {
        padding-top: 0 !important;
    }
</style>
@stop

@section('script')
<script>
    const route_maps = {{ Js::from($route_maps) }}
</script>
<script src="{{ asset('assets/js/app/route_map.js') }}"></script>
@stop