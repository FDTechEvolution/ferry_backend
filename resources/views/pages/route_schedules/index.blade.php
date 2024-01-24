@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Route</span> Schedule</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('routeSchedules.create') }}" class="btn button-orange-bg">Create New</a>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-align-middle table-hover">
                    <thead class="bg-light">
                        <tr>
                            <th>Route</th>
                            <th>Time</th>
                            <th>Effective date</th>
                            <th>Note/Description</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($routeSchedules as $index => $routeSchedule)
                            @if ($routeSchedule->isactive == 'Y')
                                <tr>
                                    <td>
                                        <p class="pb-0 mb-0">
                                        <span
                                            class="badge @if ($routeSchedule->type == 'CLOSE') bg-danger @else bg-success @endif">{{ $routeSchedule->type }}</span>
                                        {{ $routeSchedule->route->station_from->name }} -
                                        {{ $routeSchedule->route->station_to->name }}</p>
                                        
                                        @if($routeSchedule->mon =='Y') <span class="badge bg-danger-soft">Mon</span> @endif
                                        @if($routeSchedule->tru =='Y') <span class="badge bg-danger-soft">Tru</span> @endif
                                        @if($routeSchedule->wed =='Y') <span class="badge bg-danger-soft">Wed</span> @endif
                                        @if($routeSchedule->thu =='Y') <span class="badge bg-danger-soft">Thu</span> @endif
                                        @if($routeSchedule->fri =='Y') <span class="badge bg-danger-soft">Fri</span> @endif
                                        @if($routeSchedule->sat =='Y') <span class="badge bg-danger-soft">Sat</span> @endif
                                        @if($routeSchedule->sun =='Y') <span class="badge bg-danger-soft">Sun</span> @endif
                                    </td>
                                    <td>
                                        <span
                                            class="badge rounded-pill bg-secondary">{{ date('H:i', strtotime($routeSchedule['route']['depart_time'])) }}-{{ date('H:i', strtotime($routeSchedule['route']['arrive_time'])) }}</span>
                                    </td>

                                    <td>{{ date('d/m/Y', strtotime($routeSchedule->start_datetime)) }} - {{ date('d/m/Y', strtotime($routeSchedule->end_datetime)) }}</td>
                                   
                                    <td><small>{{ $routeSchedule->description }}</small></td>
                                    <td class="text-end">
                                        <x-action-edit class="me-2" :url="route('routeSchedules.edit',['routeSchedule'=>$routeSchedule])" id="btn-section-edit" />
                                        <x-delete-button :url="route('routeSchedules.destroy', ['routeSchedule' => $routeSchedule])" :id="$routeSchedule->id" />
                                    </td>
                                </tr>
                            @else
                                <tr class="text-gray-400">
                                    <td class="text-blue-gray-200">
                                        <span class="badge bg-secondary-soft">{{ $routeSchedule->type }}</span>
                                        {{ $routeSchedule->route->station_from->name }} -
                                        {{ $routeSchedule->route->station_to->name }}
                                       
                                    </td>
                                    <td>
                                        <span
                                        class="badge rounded-pill bg-secondary-soft">{{ date('H:i', strtotime($routeSchedule['route']['depart_time'])) }}-{{ date('H:i', strtotime($routeSchedule['route']['arrive_time'])) }}</span>
                                    </td>

                                    <td class="text-blue-gray-200">
                                        {{ date('d/m/Y', strtotime($routeSchedule->start_datetime)) }} - {{ date('d/m/Y', strtotime($routeSchedule->end_datetime)) }}
                                    </td>
                                   
                                    <td class="text-blue-gray-200"><small>{{ $routeSchedule->description }}</small></td>
                                    <td class="text-end">
                                        <x-delete-button :url="route('routeSchedules.destroy', ['routeSchedule' => $routeSchedule])" :id="$routeSchedule->id" />
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        var send_delete = function(el, data) {
            let url = (el.attr('data-href'));
            let id = (el.attr('data-id'));
            $('#frm-' + id).submit();
        }
    </script>
@stop
