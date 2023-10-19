@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Information</span> manager</h1> <x-a-href-green
    :text="_('Add')" :href="route('information-create')" :target="_('_self')" class="ms-3 btn-sm w--10" /> 
@stop


@section('content') 
<div class="row mt-4"> 
    <div class="col-12">
    <div id="to-station-info-list">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="station-info-datatable" 
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
                            <th class="">Title</th>
                            <th class="">Position</th>
                            <th class="">Text/Message</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($informations as $index => $item)
                            <tr class="" id="row-{{ $index }}">
                                <td class="text-start">{{ $item['title'] }}</td>
                                <td>{{$positions[$item['position']]}}</td>
                                <td><small>{{$item['body']}}</small></td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="route('information-edit',['information'=> $item])"
                                        id="btn-information-edit"
                                    />
                                    <x-action-delete 
                                        :url="route('information-delete', ['id' => $item['id']])"
                                        :message="_('Are you sure? Delete this item.?')"
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