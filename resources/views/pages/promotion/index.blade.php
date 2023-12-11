@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Promotion code discount</h1>
    <x-a-href-green :text="_('Add')" :href="route('promotion-create')" :target="_('_self')" class="ms-3 btn-sm w--10" />
@stop

@section('content')
    <div class="row mt-3">
        <div class="col-12">
            <table class="table-datatable table table-datatable-custom" id="station-info-datatable"
                data-lng-empty="No data available in table" data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                data-lng-processing="Processing..." data-lng-search="Search..."
                data-lng-norecords="No matching records found" data-lng-sort-ascending=": activate to sort column ascending"
                data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="true"
                data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS"
                data-lng-all="All" data-export-pdf-disable-mobile="true" data-export='["pdf", "xls"]'>
                <thead>
                    <tr>
                        <th>Image Cover</th>
                        <th class="">Title</th>
                        <th class="">Code</th>
                        <th class="">Discount</th>
                        <th class="">Type</th>
                        <th class="text-end">Times to use Max</th>
                        <th class="text-end">Used</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($promotions as $item)
                        <tr>
                            <td>
                                @if(isset($item->image->path))
                                <div class="avatar avatar-sm"
                                style="background-image:url({{ asset('/'.$item->image->path) }})"></div>
                                @endif
                            </td>
                            <td>{{ $item['title'] }}</td>
                            <td>{{ $item['code'] }}</td>
                            <td>{{ $item['discount'] }}</td>
                            <td>{{ $item['discount_type'] }}</td>
                            <td class="text-end">{{ $item['times_use_max'] }}</td>
                            <td class="text-end">{{ $item['times_used'] }}</td>
                            <td>
                                <x-action-edit class="me-2" :url="route('promotion-edit', ['promotion' => $item])" id="btn-edit" />
                                <x-action-delete :url="route('promotion-delete', ['id' => $item['id']])" :message="_('Are you sure? Delete ' . $item['title'] . '?')" />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
@stop
