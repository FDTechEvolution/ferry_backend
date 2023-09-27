@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="meal-page-title">Meal manager</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-meal-create" />
@stop

@section('content')
<div class="row mt-4">

    <div class="col-12">
        <div id="to-meal-list">
            <div class="card-body w--90 mx-auto">
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
                                    <div class="avatar avatar-md" 
                                        style="background-image:url({{ $meal['image_icon_id'] == '' ? 
                                                                        asset('assets/images/meal/meal-no-picture.png') : 
                                                                        asset($meal['icon']['path'].'/'.$meal['icon']['name'])
                                                                    }})">
                                    </div>
                                </td>
                                <td class="text-start" data-id="name">{{ $meal['name'] }}</td>
                                <td data-id="price">{{ number_format($meal['amount']) }}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-meal-edit"
                                        onClick="updateEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="_('#')"
                                        :message="_('Are you sure? Delete '. $meal['name'] .'?')"
                                    />
                                </td>
                                <input type="hidden" data-id="icon" value="{{ $meal['icon']['path'].'/'.$meal['icon']['name'] }}">
                                <input type="hidden" data-id="image" value="{{ $meal['image']['path'].'/'.$meal['image']['name'] }}">
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
            @include('pages.meals.edit')
        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/meal.js') }}"></script>
@stop