@extends('layouts.default')

@section('head_meta')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<style>
    .meal-form .meal-section-title {
        font-size: 0.8rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--bs-secondary-color);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .meal-form .upload-dropzone {
        background-color: #fff;
        border: 1px dashed rgba(0, 0, 0, 0.18);
        border-radius: 0.75rem;
        min-height: 3.25rem;
    }

    .meal-form .upload-hint {
        font-size: 0.75rem;
        color: var(--bs-secondary-color);
    }

    .meal-form .note-editor.note-frame {
        background-color: #fff;
    }
</style>
@stop

@section('page-title')
    <h1 class="ms-2 mb-0" id="meal-page-title">Meal manage</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm" id="btn-meal-create" />
@stop

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div id="to-meal-list" class="table-responsive">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="meals-datatable"
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
                            <th class="text-center w--10">#</th>
                            <th class="text-center w--15">Cover</th>
                            <th>Name</th>
                            <th class="text-center">Price (THB)</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meals as $index => $meal)
                            <tr class="text-center" id="meal-row-{{ $index }}">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if (! empty($meal->image?->path) && ! empty($meal->image?->name))
                                        <a class="fancybox d-inline-block" href="{{ asset($meal->image->path.'/'.$meal->image->name) }}">
                                            <img
                                                src="{{ asset($meal->image->path.'/'.$meal->image->name) }}"
                                                alt="{{ $meal->name }}"
                                                class="rounded border"
                                                style="width: 72px; height: 48px; object-fit: cover;"
                                            >
                                        </a>
                                    @else
                                        <div class="d-inline-flex align-items-center justify-content-center rounded border bg-light text-muted"
                                            style="width: 72px; height: 48px;">
                                            <i class="fi fi-image opacity-50"></i>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-start" data-id="name">{{ $meal['name'] }}</td>
                                <td data-id="price">{{ number_format($meal['amount']) }}</td>
                                <td>
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('meal-edit', ['id' => $meal['id']])"
                                    />
                                    <x-action-delete
                                        :url="route('meal-delete', ['id' => $meal['id']])"
                                        :message="_('Are you sure? Delete '. $meal['name'] .'?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="to-meal-create" class="col-12 col-xl-10 mx-auto m-auto d-none">
            @include('pages.meals.create')
        </div>
    </div>
</div>
@stop

@section('modal')
    @include('pages.meals.upload_icon')
@stop

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    const meals = {{ Js::from($meals) }};

    if ($('#meal-detail').length) {
        $('#meal-detail').summernote({
            placeholder: 'Type meal details...',
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
    }
</script>
<script src="{{ asset('assets/js/app/meal.js') }}?v=@php echo date('YmdHis'); @endphp"></script>
@stop
