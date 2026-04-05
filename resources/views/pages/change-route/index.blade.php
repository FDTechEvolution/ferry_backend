@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2" id="change-booking-page-title">Route</h1>
@stop

@section('content')
<div class="row">
    @if (! $agentRoutesOk)
    <div class="col-12">
        <div class="alert alert-danger mb-3">
            @if (! empty($agentRoutesError))
            ไม่สามารถเชื่อมต่อ API ได้: {{ $agentRoutesError }}
            @else
            ไม่สามารถโหลดข้อมูล route ได้ (HTTP {{ $agentRoutesStatus }})
            @endif
        </div>
    </div>
    @endif


    <div class="col-12">
        <div class="table-responsive">
            <table class="table-datatable table table-bordered table-striped" data-lng-empty="No data available in table" data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries" data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..." data-lng-processing="Processing..." data-lng-search="Search..." data-lng-norecords="No matching records found" data-lng-sort-ascending=": activate to sort column ascending" data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false" data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="false" data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS" data-lng-all="All" data-export-pdf-disable-mobile="true" data-responsive="false" data-export='["pdf", "xls"]' data-main-search="false" data-column-search="false" data-custom-config='{

                    }'>

                <thead>
                    <tr>

                        <th>Route</th>
                        <th>Time Table</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $route)
                    <tr>

                        <td>{{ $route['departure_station']['name'] }} -> {{ $route['destination_station']['name'] }}</td>
                        <td>
                            @foreach ($route['sub_routes'] as $time)
                            <span class="badge bg-secondary-soft">{{ $time['depart_time'] }}/{{ $time['arrival_time'] }}</span>
                            @endforeach
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop
