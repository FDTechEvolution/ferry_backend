@extends('layouts.default')

@section('page-title')

@stop

@section('content')
<div class="row">
    <div class="col-12">
        <a href="{{ route('api.edit',['id'=>$apiMerchant->id]) }}" class="btn btn-secondary"><i
                class="fa-solid fa-circle-left"></i> Back to {{$apiMerchant->name}} API Setting</a>
    </div>
</div>
<hr>
<div class="row">

    <div class="col-12">
        <form action="{{ route('apiroute.calendar', ['id' => $apiRouteId]) }}" method="GET" id="frm">
            @csrf
            <input type="hidden" name="api_merchant_id" id="api_merchant_id" value="{{ $apiMerchant->id }}">
            <div class="row">
                <div class="col-12">
                    <h4>Agent: {{ $apiMerchant->name }}</h4>
                </div>
                <!--
                <div class="col-12 col-lg-7">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="api_route_id" name="api_route_id" aria-label=""
                            data-action="change">
                            @foreach ($apiMerchant->apiRoutes as $apiRoute)
                            <option value="{{ $apiRoute->pivot->id }}" @selected($apiRoute->pivot->id == $apiRouteId)>
                                {{ sprintf('%s > %s : %s/%s', $apiRoute->station_from->name,
                                $apiRoute->station_to->name, date('H:i', strtotime($apiRoute->depart_time)), date('H:i',
                                strtotime($apiRoute->arrive_time))) }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Route</label>
                    </div>
                </div>
            -->
                <div class="col-6 col-lg-3">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="month" name="month" data-action="change">
                            @foreach ($monthOptions as $key => $name)
                            <option value="{{ $key }}" @selected($month==$key)>{{ $name }}
                            </option>
                            @endforeach


                        </select>
                        <label for="floatingSelect">Month</label>
                    </div>
                </div>
                <div class="col-6 col-lg-2">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="year" name="year" data-action="change">
                            @foreach ($years as $key => $name)
                            <option value="{{ $key }}" @selected($year==$key)>{{ $name }}
                            </option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Year</label>
                    </div>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="text-main-color-2">{{$monthOptions[$month]}} {{$years[$year]}}</h2>
            </div>
            <div class="col-12">
                <table class="table table-bordered table-align-middle">
                    <thead>
                        <tr class="text-end">
                            <th>SUN</th>
                            <th>MON</th>
                            <th>TUE</th>
                            <th>WED</th>
                            <th>THU</th>
                            <th>FRI</th>
                            <th>SAT</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($monthCalendar as $row)
                        <tr>
                            @foreach ($row as $col)
                            <td class="text-end">
                                <h4 class="@if ($col['current_month'] == 'N') text-gray-300 @endif">
                                    {{ $col['day'] }}</h4>
                                <span>
                                    @if (is_null($col['id']) || $col['id'] =='')
                                    <a href="#"
                                        data-href="{{route('routeCalendar.create',['api_route_id'=>$apiRouteId,'date'=>$col['date']])}}"
                                        data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                        class="js-ajax-modal">
                                        Max seat <strong>{{ number_format($col['seat']) }} <i
                                                class="fa-solid fa-pen-to-square"></i></strong>
                                    </a>
                                    @else
                                    <a href="#"
                                        data-href="{{route('routeCalendar.edit',['routeCalendar'=>$col['id']])}}"
                                        data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                        class="js-ajax-modal text-warning">
                                        Max seat <strong>{{ number_format($col['seat']) }} <i
                                                class="fa-solid fa-pen-to-square"></i></strong>
                                    </a>
                                    @endif

                                </span><br>
                                <span class="text-success">Sold <strong>{{ number_format(0) }}</strong></span>
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop


@section('script')
<script>
    $(document).ready(function() {
            $('[data-action="change"]').on('change', function() {
                $('#page-loader').show();
                $('#frm').submit();
            });
        });
</script>

@stop