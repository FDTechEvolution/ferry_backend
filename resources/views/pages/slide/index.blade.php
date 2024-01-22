@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2">Media <small class="fs-4">/ Slide</small></h1>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card bg-main-color" id="create-slide">
            @include('pages.slide.create')
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
                            <th class="text-center">Pic Slide</th>
                            <th class="text-center">Status Show</th>
                            <th class="text-center">Sort</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($slides as $index => $slide)
                            <tr class="text-center align-middle">
                                <td style="max-width: 100px;">
                                    <a class="fancybox" href="{{ asset($slide->image->path.'/'.$slide->image->name) }}">
                                        <img src="{{ asset($slide->image->path.'/'.$slide->image->name) }}" class="w-100">
                                    </a>
                                </td>
                                <td>
                                    <label class="align-items-center text-center">
                                        <input class="d-none-cloaked" type="checkbox" name="switch-checkbox" value="{{ $slide->id }}" @checked($slide->isactive == 'Y') onClick="showInHomepage(this)">
                                        <i class="switch-icon switch-icon-primary"></i>
                                    </label>
                                </td>
                                <td>{{ $slide->sort }}</td>
                                <td>
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('slide-edit', ['id' => $slide->id])"
                                        id="btn-slide-edit"
                                    />
                                    <x-action-delete
                                        :url="route('slide-delete', ['id' => $slide->id])"
                                        :message="_('Are you sure? Delete this slide ?')"
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
<script>
    const slides = {{ Js::from($slides) }}
</script>
<script src="{{ asset('assets/js/app/slide.js') }}"></script>
@stop
