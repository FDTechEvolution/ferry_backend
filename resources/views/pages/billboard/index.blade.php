@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0 text-main-color-2" style="width: 340px;">Media <small class="fs-4">/ Billboard</small></h1>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <x-a-href-green :text="_('Add')" :href="route('billboard-create')" :target="_('_self')" class="" />
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
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
                    data-items-per-page="15"

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
                            <th class="text-center">#</th>
                            <th>Icon</th>
                            <th>Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billboard as $index => $item)
                            <tr class="text-center align-middle">
                                <td>{{ $item->sort }}</td>
                                <td>
                                    <div class="avatar avatar-sm" style="background-image:url({{asset($icons[$item->icon])}})"></div>
                                </td>
                                <td class="text-start">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs me-2" style="background-color:{{ $item->color }}"></div>
                                        {{ $item->title }}
                                    </div>
                                </td>
                                <td>
                                    <label class="d-flex align-items-center justify-content-center">
                                        <input class="d-none-cloaked billboard-isactive" type="checkbox" name="switch-checkbox" value="{{ $item->id }}" @checked($item->isactive == 'Y')>
                                        <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                    </label>
                                </td>
                                <td>
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('billboard-edit', ['id' => $item->id])"
                                        id="btn-slide-edit"
                                    />
                                    <x-action-delete
                                        :url="route('billboard-delete', ['id' => $item->id])"
                                        :message="_('Are you sure? Delete this billboard ?')"
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
@stop

@section('script')
<script src="{{ asset('assets/js/app/billboard.js') }}"></script>
@stop
