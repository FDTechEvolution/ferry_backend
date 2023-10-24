@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2">Time Table</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color" id="create-time-table-detail">
            @include('pages.time_table.create')
        </div>

        <div class="card bg-main-color d-none" id="edit-time-table-detail">
            @include('pages.time_table.edit')
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
                            <th class="text-center">Pic Time Table</th>
                            <th class="text-center">Title</th>
                            <th class="text-center">Choose News Show In Homepage</th>
                            <th class="text-center">Sort</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($time_tables as $index => $table)
                            <tr class="text-center align-middle">
                                <td style="max-width: 100px;">
                                    <a class="fancybox" href="{{ asset($table->image->path.'/'.$table->image->name) }}">
                                        <img src="{{ asset($table->image->path.'/'.$table->image->name) }}" class="w-100">
                                    </a>
                                </td>
                                <td>{{ $table->detail }}</td>
                                <td>
                                    <label class="align-items-center text-center mb-3">
                                        <input class="d-none-cloaked" type="checkbox" name="switch-checkbox" value="{{ $table->id }}" @checked($table->isactive == 'Y') onClick="showInHomepage(this)">
                                        <i class="switch-icon switch-icon-primary"></i>
                                    </label>
                                </td>
                                <td>{{ $table->sort }}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-time-table-edit"
                                        onClick="updateEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="route('time-table-delete', ['id' => $table->id])"
                                        :message="_('Are you sure? Delete this time table ?')"
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
    const time_tables = {{ Js::from($time_tables) }}
</script>

<script src="{{ asset('assets/js/app/time_table.js') }}"></script>
@stop