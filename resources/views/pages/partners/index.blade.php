@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Partner</span> manager</h1>
    <x-a-href-green :text="_('Add')" :href="route('partner-create')" :target="_('_self')" class="ms-3 btn-sm w--10" />
@stop


@section('content')
    <div class="section mb-3">
        <div class="row mt-4">
            <div class="col-12 mx-auto">
                <div id="to-station-info-list">
                    <div class="card-body">
                        <table class="table-datatable table table-datatable-custom" id="station-info-datatable"
                            data-lng-empty="No data available in table"
                            data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                            data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                            data-lng-processing="Processing..." data-lng-search="Search..."
                            data-lng-norecords="No matching records found"
                            data-lng-sort-ascending=": activate to sort column ascending"
                            data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false"
                            data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="true"
                            data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF"
                            data-lng-xls="XLS" data-lng-all="All" data-export-pdf-disable-mobile="true"
                            data-export='["pdf", "xls"]'>
                            <thead>
                                <tr>
                                    <th class="">Logo/Image</th>
                                    <th class="">Name</th>
                                    <th class="">Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($partners as $index => $item)
                                    <tr class="" id="row-{{ $index }}">
                                        <td>
                                            @if (isset($item->image->path))
                                                <div class="avatar avatar-sm"
                                                    style="background-image:url({{ asset('/' . $item->image->path) }})"></div>
                                            @endif
                                        </td>
                                        <td class="text-start">{{ $item['name'] }}</td>
                                        <td>
                                            @if ($item['isactive'] == 'Y')
                                                <span class="badge bg-success-soft">Active</span>
                                            @else
                                                <span class="badge bg-secondary-soft">Disable</span>
                                            @endif
                                        </td>
                                        <td>
                                            <x-action-edit class="me-2" :url="route('partner-edit', ['partner' => $item])" id="btn-edit" />
                                            <x-action-delete :url="route('partner-delete', ['id' => $item['id']])" :message="_('Are you sure? Delete this item.?')" />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
