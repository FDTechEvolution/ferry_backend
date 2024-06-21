@extends('layouts.default')

@section('head_meta')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@stop

@section('page-title')
    <h1 class="ms-2 mb-0" id="meal-page-title">Meal manage</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-meal-create" />
@stop

@section('content')
<div class="row mt-4">

    <div class="col-sm-12 col-lg-10 mx-auto">
        <div id="to-meal-list">
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
                            <th class="text-center w--15">Icon</th>
                            <th>Name Meal</th>
                            <th class="text-center">Price (THB)</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($meals as $index => $meal)
                            <tr class="text-center" id="meal-row-{{ $index }}">
                                <td>
                                    <div class="avatar avatar-md {{ !isset($meal['image_icon_id']) ? 'opacity-25' : 'opacity-100' }}"
                                        style="background-image:url({{ isset($meal['image_icon_id']) ? asset(''.$meal['icon']['path'].'/'.$meal['icon']['name']) : asset('icon/no_image_icon.svg') }})">
                                    </div>
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
                                <input type="hidden" data-id="image" value="{{ $meal['image_id'] != '' ? $meal['image']['path'].'/'.$meal['image']['name'] : '' }}">
                                <input type="hidden" data-id="description" value="{{ $meal['description'] }}">
                                <input type="hidden" data-id="id" value="{{ $meal['id'] }}">
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-meal-create" class="m-auto d-none">
            @include('pages.meals.create')
        </div>
        <div id="to-meal-edit" class="m-auto d-none">

        </div>
    </div>
</div>
@stop

@section('modal')
    @include('pages.meals.upload_icon')
@stop

@section('script')
<script>
    const meals = {{ Js::from($meals) }}
</script>
<script src="{{ asset('assets/js/app/meal.js') }}?v=@php echo date('YmdHis'); @endphp"></script>
@stop
