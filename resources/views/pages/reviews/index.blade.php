@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Review</span> manager</h1> <x-a-href-green
    :text="_('Add')" :href="route('review-create')" :target="_('_self')" class="ms-3 btn-sm w--10" /> 
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
                            <th>#Seq</th>
                            <th class="">Writer</th>
                            <th class="">Topic</th>
                            <th class="">Rating</th>
                            <th class="">Review Text</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $index => $item)
                            <tr class="" id="row-{{ $index }}">
                                <td class="text-start">{{ $item['seq'] }}</td>
                                <td>{{$item['reviewname']}}</td>
                                <td>{{$item['title']}}</td>
                                <td>
                                    @for($i=0; $i< $item['rating'];$i++)
                                    <i class="fi fi-star-full text-warning"></i>
                                    @endfor
                                </td>
                                <td>{{$item['body']}}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="route('review-edit',['review'=> $item])"
                                        id="btn-station-edit"
                                    />
                                    <x-action-delete 
                                        :url="route('review-delete', ['id' => $item['id']])"
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