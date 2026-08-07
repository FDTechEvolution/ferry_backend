@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="rent-a-bike-page-title">Rent a Bike</h1>
    <x-a-href-green :text="_('Add')" :href="route('rent-a-bike-create')" :target="_('_self')" class="ms-3 btn-sm" />
@stop

@section('content')
<div class="row mt-3">
    <div class="col-12">
        <div class="table-responsive">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="rent-a-bike-datatable"
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
                    data-responsive="false"
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
                        @foreach ($items as $index => $item)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    @if (! empty($item->image?->path) && ! empty($item->image?->name))
                                        <a class="fancybox d-inline-block" href="{{ asset($item->image->path.'/'.$item->image->name) }}">
                                            <img
                                                src="{{ asset($item->image->path.'/'.$item->image->name) }}"
                                                alt="{{ $item->name }}"
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
                                <td class="text-start">{{ $item->name }}</td>
                                <td>{{ number_format((float) $item->amount) }}</td>
                                <td>
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('rent-a-bike-edit', ['id' => $item->id])"
                                    />
                                    <x-action-delete
                                        :url="route('rent-a-bike-delete', ['id' => $item->id])"
                                        :message="_('Are you sure? Delete '. $item->name .'?')"
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
