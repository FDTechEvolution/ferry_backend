@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            {{$route->station_from->name}} {{$route->station_to->name}} Calendar view
        </h4>



        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>


    </div>


    <div class="modal-body p-2">
        <div class="row">
            <div class="col-12">

            </div>
        </div>

        <div class="row">
            @foreach ($yearCalendar as $monthCalendar)
                <div class="col-12 col-lg-4 p-2 ">
                    <h4 class="text-center">{{$monthCalendar['name']}}</h4>
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
                            @foreach ($monthCalendar['calendar'] as $row)
                                <tr>
                                    @foreach ($row as $col)
                                        <td class="text-end @if (isset($routeDailyMaps[$col['date']]))
                                            text-success
                                        @endif">
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

    </div>
    <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

    </div>



@stop

@section('script')

@stop
