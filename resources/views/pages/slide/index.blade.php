@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0 text-main-color-2" style="width: 300px;">Media <small class="fs-4">/ Blog</small></h1>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <x-a-href-green :text="_('Add')" :href="route('blog-create')" :target="_('_self')" class="" />
        </div>
    </div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color d-none" id="create-slide">

        </div>

        <div class="card bg-main-color d-none" id="edit-slide">

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
                            <th class="text-center" style="width: 120px;">Image</th>
                            <th>Title</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slides as $index => $slide)
                            <tr class="text-center align-middle">
                                <td>{{ $slide->sort }}</td>
                                <td class="px-3" style="max-width: 40px;">
                                    @if($slide->image != NULL)
                                        <a class="fancybox" href="{{ asset($slide->image->path.'/'.$slide->image->name) }}">
                                            <img src="{{ asset($slide->image->path.'/'.$slide->image->name) }}" class="w-100">
                                        </a>
                                    @endif
                                </td>
                                <td class="text-start">{{ $slide->title }}</td>
                                <td>
                                    <label class="align-items-center text-center">
                                        <input class="d-none-cloaked" type="checkbox" name="switch-checkbox" value="{{ $slide->id }}" @checked($slide->isactive == 'Y') onClick="showInHomepage(this)">
                                        <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                    </label>
                                </td>
                                <td>
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('blog-edit', ['id' => $slide->id])"
                                        id="btn-slide-edit"
                                    />
                                    <x-action-delete
                                        :url="route('blog-delete', ['id' => $slide->id])"
                                        :message="_('Are you sure? Delete this blog ?')"
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
    .position-relative.d-inline-block.bg-cover {
        width: 220px !important;
    }
</style>
@stop

@section('script')
<script src="{{ asset('assets/js/app/slide.js') }}"></script>
@stop
