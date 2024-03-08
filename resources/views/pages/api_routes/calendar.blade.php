@extends('layouts.default')

@section('page-title')

@stop

@section('content')
<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1">
        <div class="row">
            <div class="col-12">

            </div>
        </div>

        <div class="row">
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
                                        <h4 class="@if($col['current_month'] =='N') text-gray-300 @endif">{{$col['day']}}</h4>
                                        <span>Max seat <strong>{{number_format($col['seat'])}}</strong></span><br>
                                        <span>Sold <strong>{{number_format(0)}}</strong></span>
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
