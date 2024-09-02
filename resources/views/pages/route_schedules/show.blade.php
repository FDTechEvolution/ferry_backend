@extends('layouts.default')
@section('page-title')
    <h2 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">{{ $route->station_from->name }} <i
                class="fa-solid fa-angles-right px-2"></i>
            {{ $route->station_to->name }}</span> Calendar view</h2>

@stop

@section('content')
<form novalidate class="bs-validate" id="frm-fillter" method="GET" action="{{ route('routeSchedules.show', ['routeSchedule' => $routeId]) }}">
    <div class="row">
        <div class="col-12 col-lg-4">
            <strong>Year rang</strong>
            <div class="row">
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="start_year" name="start_year">
                            @foreach ($years as $year)
                                <option value="{{$year->y}}" @selected($startYear==((int)$year->y))>{{$year->y}}</option>
                            @endforeach
                        </select>
                        <label for="start_year">Start Year</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating mb-3">
                        <select class="form-select" id="end_year" name="end_year">
                            @foreach ($years as $year)
                                <option value="{{$year->y}}" @selected($endYear==((int)$year->y))>{{$year->y}}</option>
                            @endforeach
                        </select>
                        <label for="end_year">End Year</label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>
    <hr>
    <div class="row">
        @foreach ($yearCalendar as $monthCalendar)
            <div class="col-12 col-lg-3 p-2 ">
                <h5 class="text-center">{{ $monthCalendar['name'] }}</h5>
                <table class="table table-bordered table-align-middle">
                    <thead class="">
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
                        @foreach ($monthCalendar['calendar'] as $row)
                            <tr>
                                @foreach ($row as $col)
                                    <td
                                        class="text-end @if (isset($routeDailyMaps[$col['date']]) && $routeDailyMaps[$col['date']] == 'Y') text-success
                                        @else text-danger @endif">
                                        <strong class="@if ($col['current_month'] == 'N') text-gray-300 @endif">
                                            {{ $col['day'] }}</strong>

                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@stop

@section('script')
    <script>
        $(document).ready(function() {
            $('#start_year, #end_year').change(function() {
                $('#page-loader').show();
                //const selectedMonth = $('#month').val();
                //const selectedYear = $('#year').val();

                $('#frm-fillter').submit();
               // console.log(`Selected Month: ${selectedMonth}, Selected Year: ${selectedYear}`);
            });
        });
    </script>
@stop
