@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2">Time Table</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <h2 class="text-light">Add Details</h2>
                    </div>
                </div>
                <form novalidate class="bs-validate" id="time-table-create-form" method="POST" action="{{ route('time-table-create') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4 row">
                        <label class="col-sm-1 col-form-label-sm text-start text-light fw-bold">Picture :</label>
                        <div class="col-sm-5">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                <input type="file" name="file_picture"
                                    data-file-ext="jepg, jpg, png, gif"
                                    data-file-max-size-kb-per-file="2048"
                                    data-file-max-size-kb-total="2048"
                                    data-file-max-total-files="100"
                                    data-file-ext-err-msg="Allowed:"
                                    data-file-exist-err-msg="File already exists:"
                                    data-file-size-err-item-msg="File too large!"
                                    data-file-size-err-total-msg="Total allowed size exceeded!"
                                    data-file-size-err-max-msg="Maximum allowed files:"
                                    data-file-toast-position="bottom-center"
                                    data-file-preview-container=".js-file-input-container-multiple-list-static-picture"
                                    data-file-preview-img-height="80"
                                    data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-picture"
                                    data-file-preview-show-info="true"
                                    data-file-preview-list-type="list"
                                    class="custom-file-input absolute-full cursor-pointer"
                                    title="jpeg, jpg, png, gif (2MB) [size : 800 x 388 px]" data-bs-toggle="tooltip"
                                    required
                                >

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2"><!-- container --></div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <label class="col-sm-1 offset-1 col-form-label-sm text-end text-light fw-bold">Sort :</label>
                        <div class="col-2">
                            <input type="number" class="form-control form-control-sm" name="sort">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-sm-1 col-form-label-sm text-start text-light fw-bold">Detail :</label>
                        <div class="col-5">
                            <textarea class="form-control" rows="2" name="detail"></textarea>
                        </div>
                        <div class="col-6 justify-content-end d-flex">
                            <x-button-green
                                class="btn-sm w--15 align-self-end me-2"
                                :type="_('submit')"
                                :text="_('Save')"
                            />
                            <button class="btn btn-light btn-sm w--15 align-self-end border-radius-10">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
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
                            <th class="text-center">Choose News Show Im Homepage</th>
                            <th class="text-center">Sort</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($time_tables as $table)
                            <tr class="text-center">
                                <td style="max-width: 150px;">
                                    <a class="fancybox" href="{{ asset($table->image->path.'/'.$table->image->name) }}">
                                        <img src="{{ asset($table->image->path.'/'.$table->image->name) }}" class="w-100">
                                    </a>
                                </td>
                                <td>{{ $table->detail }}</td>
                                <td>{{ $table->isactive }}</td>
                                <td>{{ $table->sort }}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('#')"
                                        id="btn-route-edit"
                                    />
                                    <x-action-delete 
                                        :url="_('#')"
                                        :message="_('Are you sure? Delete this route ?')"
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
@stop