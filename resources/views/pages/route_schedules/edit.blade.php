@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Edit @if(!is_null($routeSchedule->api_merchant_id))API @endif Route</span> Schedule</h1>

@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('routeSchedules.index') }}?merchant_id={{$routeSchedule->api_merchant_id}}" class="btn btn-secondary"><i class="fi fi-arrow-left"></i> Back</a>

            @if (!is_null($apiMerchant))
            <img src="{{$apiMerchant->logo}}" width="200px" class="px-2"/>
            @endif
        </div>
    </div>
    <hr>

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('routeSchedules.update',['routeSchedule'=>$routeSchedule]) }}">
        
        @csrf
        @method('PUT')
        
        <fieldset id="field-frm">
            <div class="row">
                <div class="col-12 col-lg-7 border-end">
                    <h4>
                        <img src="{{asset($routeSchedule->route->partner->image->path)}}" class="rounded-circle" width="40" />
                        {{ $routeSchedule->route->station_from->name }} <i class="fa-solid fa-angles-right px-2 fa-1x"></i>
                        {{ $routeSchedule->route->station_to->name }}</h4>
                    <h3 class="text-main-color">
                        {{ date('H:i', strtotime($routeSchedule['route']['depart_time'])) }}-{{ date('H:i', strtotime($routeSchedule['route']['arrive_time'])) }}
                    </h3>

                    <table class="table table-striped">
                        <tbody>
                            @foreach ($routeScheduleInRoutes as $index => $routeScheduleInRoute)
                                <tr>
                                    <td>
                                        <p class="p-0 m-0">
                                            <span
                                                class="badge @if ($routeScheduleInRoute->type == 'CLOSE') bg-danger @else bg-success @endif">{{ $routeScheduleInRoute->type }}</span>
                                            {{ date('D,d M Y', strtotime($routeScheduleInRoute->start_datetime)) }} -
                                            {{ date('D,d M Y', strtotime($routeScheduleInRoute->end_datetime)) }}</p>
                                        <small>{{ $routeScheduleInRoute->description }}</small>
                                    </td>
                                    <td class="text-end">
                                        @if($routeScheduleInRoute->id == $routeSchedule->id)
                                            Current <span class="animate-blink text-success"><i class="fa-regular fa-circle-dot"></i></span>
                                        @else
                                        <x-action-edit class="me-2" :url="route('routeSchedules.edit', ['routeSchedule' => $routeScheduleInRoute->id])" id="btn-section-edit" />
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-12 col-lg-5">
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input form-check-input-success" type="radio" name="type"
                                    id="type_open" value="OPEN" @checked($routeSchedule->type=='OPEN')>
                                <label class="form-check-label" for="type_open">Open Route</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input form-check-input-danger" type="radio" name="type"
                                    id="type_close" value="CLOSE" @checked($routeSchedule->type=='CLOSE')>
                                <label class="form-check-label" for="type_close">Close Route</label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input autocomplete="off" type="text" name="daterange" id="daterange"
                                    class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                    data-ranges="false" data-date-start="{{ date('d/m/Y', strtotime($routeSchedule->start_datetime)) }}" data-date-end="{{ date('d/m/Y', strtotime($routeSchedule->end_datetime)) }}" data-date-format="DD/MM/YYYY"
                                    data-quick-locale='{
                        "lang_apply"	: "Apply",
                        "lang_cancel" : "Cancel",
                        "lang_crange" : "Custom Range",
                        "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                    }'>
                                <label for="departdate">Effective date</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3" style="display: none;">
                        <div class="col-12">
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="mon" name="mon" @checked($routeSchedule->mon=='Y')>
                                <label class="form-check-label" for="mon">
                                    Monday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="tru" name="tru" @checked($routeSchedule->tru=='Y')>
                                <label class="form-check-label" for="tru">
                                    Tuesday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="wed" name="wed" @checked($routeSchedule->wed=='Y')>
                                <label class="form-check-label" for="wed">
                                    Wednesday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="thu" name="thu" @checked($routeSchedule->thu=='Y')>
                                <label class="form-check-label" for="thu">
                                    Thursday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="fri" name="fri" @checked($routeSchedule->fri=='Y')>
                                <label class="form-check-label" for="fri">
                                    Friday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="sat" name="sat" @checked($routeSchedule->sat=='Y')>
                                <label class="form-check-label" for="sat">
                                    Saturday
                                </label>
                            </div>
                            <div class="form-check mb-2 form-check-inline">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="sun" name="sun" @checked($routeSchedule->sun=='Y')>
                                <label class="form-check-label" for="sun">
                                    Sunday
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="description" name="description" style="height: 130px">{{$routeSchedule->description}}</textarea>
                                <label for="floatingTextarea2">Note/Description</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <hr>
            <div class="row">
                <div class="col-12 text-center">
                    <x-button-submit-loading class="btn-lg w--30 me-4 button-orange-bg" :form_id="_('frm')" :fieldset_id="_('field-frm')"
                        :text="_('Save')" />
                    <a href="{{ route('routeSchedules.index') }}?merchant_id={{$routeSchedule->api_merchant_id}}" class="btn btn-secondary btn-lg w--30">Cancel</a>
                    <small id="user-create-error-notice" class="text-danger mt-3"></small>
                </div>
            </div>
        </fieldset>
    </form>

@stop
