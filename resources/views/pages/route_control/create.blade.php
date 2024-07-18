@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title">
        <span class="text-main-color-2">Add</span> new Route
    </h1>
    <div class="route-search d-none">
        <div class="mb-3">
            <label for="station-from" class="form-label">Station From* </label>
            <input type="text" class="form-control" id="station-from">
        </div>
        <div class="mb-3">
            <label for="station-to" class="form-label">Station to </label>
            <input type="text" class="form-control" id="station-to">
        </div>
        <x-button-orange :type="_('button')" :text="_('search')" />
    </div>
@stop

@section('content')
    <div class="row mt-4">
        <div class="col-12">
            <form novalidate class="bs-validate" id="route-create-form" method="POST" action="{{ route('route-store') }}">
                @csrf
                <fieldset id="route-create">
                    <div class="row">
                        <div class="col-12">

                            <div class="row">
                                <div class="col-12 px-4">
                                    <div class="mb-4 row">
                                        <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Station From *
                                            :</label>
                                        <div class="col-sm-9 col-lg-7">
                                            <select required class="form-select form-select-sm" id="station-from-selected"
                                                name="station_from">
                                                <option value="" selected disabled>--- Choose ---</option>
                                                @foreach ($stations as $station)
                                                    <option value="{{ $station['id'] }}">{{ $station['name'] }} @if ($station['piername'] != '')
                                                            [{{ $station['piername'] }}]
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Station To*
                                            :</label>
                                        <div class="col-sm-9 col-lg-7">
                                            <select required class="form-select form-select-sm" id="station-to-selected"
                                                name="station_to">
                                                <option value="" selected disabled>--- Choose ---</option>
                                                @foreach ($stations as $station)
                                                    <option value="{{ $station['id'] }}">{{ $station['name'] }} @if ($station['piername'] != '')
                                                            [{{ $station['piername'] }}]
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Partner
                                            :</label>
                                        <div class="col-sm-9 col-lg-7">
                                            <select class="form-select form-select-sm" id="partner-selected"
                                                name="partner_id">
                                                <option value="" selected disabled>--- Choose ---</option>
                                                @foreach ($partners as $partner)
                                                    <option value="{{ $partner['id'] }}">{{ $partner['name'] }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-2 row">
                                        <div class="col-sm-12 col-md-6 col-lg-2">
                                            <label class="col-form-label-sm text-start fw-bold">Depart Time*</label>
                                            <input required type="time" name="depart_time"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-sm-12 col-md-6 col-lg-2">
                                            <label class="col-form-label-sm text-start fw-bold">Arrive Time*</label>
                                            <input required type="time" name="arrive_time"
                                                class="form-control form-control-sm">
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-2">
                                            <label for="regular-price" class="col-form-label-sm text-start fw-bold">Regular
                                                Price*</label>
                                            <input required type="number" class="form-control form-control-sm"
                                                id="regular-price" name="regular_price">
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-2">
                                            <label for="child-price" class="col-form-label-sm text-start fw-bold">Child
                                                Price</label>
                                            <input type="number" class="form-control form-control-sm" id="child-price"
                                                name="child_price">
                                        </div>
                                        <div class="col-sm-12 col-md-4 col-lg-2">
                                            <label for="infant-price" class="col-form-label-sm text-start fw-bold">Infant
                                                Price</label>
                                            <input type="number" class="form-control form-control-sm" id="infant-price"
                                                name="infant_price">
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-sm-12 col-lg-5">
                                            <label class="col-form-label-sm text-start fw-bold">Activity</label>
                                            <div class="dropdown">
                                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#"
                                                    role="button" id="dropdownActivity" data-bs-toggle="dropdown"
                                                    aria-expanded="false" data-bs-offset="0,6">
                                                    Select activity
                                                    <span class="group-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg>
                                                    </span>
                                                </a>

                                                <ul class="dropdown-menu shadow-lg p-1 w-100" id="activity-dropdown"
                                                    aria-labelledby="dropdownActivity">
                                                    @foreach ($activities as $index => $activity)
                                                        <li id="activity-active-{{ $index }}"
                                                            data-id="{{ $activity->id }}">
                                                            <a class="dropdown-item rounded" href="javascript:void(0)"
                                                                onClick="addRouteActivity({{ $index }})">
                                                                @if (isset($activity->icon))
                                                                    <img src="{{ asset($activity->icon->path . '/' . $activity->icon->name) }}"
                                                                        class="me-2" width="24" height="24">
                                                                @endif
                                                                <span>{{ $activity->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <ul class="list-group" id="ul-activity-selected">
                                            </ul>
                                        </div>
                                        <div class="col-sm-12 col-lg-5">
                                            <label class="col-form-label-sm text-start fw-bold">Meal</label>
                                            <div class="dropdown">
                                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100"
                                                    href="#" role="button" id="dropdownMeal"
                                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                    Select meal
                                                    <span class="group-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg>
                                                    </span>
                                                </a>

                                                <ul class="dropdown-menu shadow-lg p-1 w-100"
                                                    aria-labelledby="dropdownMeal">
                                                    @foreach ($meals as $index => $meal)
                                                        <li id="meal-active-{{ $index }}"
                                                            data-id="{{ $meal['id'] }}">
                                                            <a class="dropdown-item rounded" href="javascript:void(0)"
                                                                onClick="addRouteMeal({{ $index }})">
                                                                @if (isset($meal->image_icon))
                                                                    <img src="{{ asset('icon/meal/icon/' . $meal->image_icon) }}"
                                                                        class="me-2" width="24" height="24">
                                                                @endif
                                                                <span>{{ $meal->name }}</span>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <ul class="list-group" id="ul-meal-selected">
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="row mb-4">
                                        <div class="col-sm-12 col-md-3 col-lg-3">
                                            <label class="col-form-label-sm text-start fw-bold">Icon <small
                                                    class="text-danger d-none" id="icon-notice">MAX!</small></label>
                                            <div class="dropdown">
                                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100"
                                                    href="#" role="button" id="dropdownIcons"
                                                    data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                    Select icon
                                                    <span class="group-icon">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <polyline points="6 9 12 15 18 9"></polyline>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px"
                                                            height="18px" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round">
                                                            <line x1="18" y1="6" x2="6"
                                                                y2="18"></line>
                                                            <line x1="6" y1="6" x2="18"
                                                                y2="18"></line>
                                                        </svg>
                                                    </span>
                                                </a>

                                                <ul class="dropdown-menu shadow-lg p-1 w-100"
                                                    aria-labelledby="dropdownIcons">
                                                    @foreach ($icons as $index => $icon)
                                                        <li id="icon-active-{{ $index }}" class="text-start">
                                                            <a class="dropdown-item rounded py-1"
                                                                href="javascript:void(0)"
                                                                onClick="addRouteIcon({{ $index }})">
                                                                <img src="{{ asset($icon->path) }}" class="me-2"
                                                                    width="42" height="42"> {{ $icon->name }} <small>(1)</small>
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-md-9 col-lg-9 show-icon">
                                            <label class="col-form-label-sm text-start fw-bold"></label>
                                            <ul class="list-group list-group-horizontal">
                                            </ul>
                                            <input type="hidden" name="icons" id="route-add-icon" value="">
                                        </div>
                                    </div>



                                    <div class="row mb-3">
                                        <div class="col-12 col-lg-5">
                                            <label>Text 1</label>
                                            <input type="text" name="text_1" id="text_1" class="form-control" />
                                        </div>
                                        <div class="col-12 col-lg-5">
                                            <label>Text 2</label>
                                            <input type="text" name="text_2" id="text_2" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <label class="col-6 col-lg-4 text-start fw-bold">Status :</label>
                                                <div class="col-5">
                                                    <label class="d-flex align-items-center mb-3">
                                                        <input class="d-none-cloaked" type="checkbox"
                                                            id="route-status-switch" name="status" value="1"
                                                            checked>
                                                        <i class="switch-icon switch-icon-primary"></i>
                                                        <span class="px-3 user-select-none"
                                                            id="route-status-text">On</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-12 col-lg-6">
                                            <div class="row">
                                                <label class="col-6 col-lg-4 text-start fw-bold">PromoCode
                                                    :</label>
                                                <div class="col-5">
                                                    <label class="d-flex align-items-center mb-3">
                                                        <input class="d-none-cloaked" type="checkbox"
                                                            id="route-promocode-switch" name="promocode" value="1">
                                                        <i class="switch-icon switch-icon-primary"></i>
                                                        <span class="px-3 user-select-none"
                                                            id="route-promocode-text">Off</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                </div>


                            </div>
                            <hr>
                            <div class="row mb-4">
                                <div class="col-12 col-lg-6 px-4">
                                    <div class="row border rounded bg-gray-100">
                                        <div class="col-12">
                                            <strong>Master From</strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-flex align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox" name="master_from_info"
                                                    id="master_from_info" value="Y" data-action="boxswitch">
                                                <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                <span class="px-3 user-select-none">On/Off</span>
                                            </label>
                                        </div>

                                        <div class="col-12" style="display: none;" id="box_master_from_info">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="master_from" name="master_from" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 px-4">
                                    <div class="row border rounded bg-gray-100">
                                        <div class="col-12">
                                            <strong>Master To</strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-flex align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox" name="master_to_info"
                                                    id="master_to_info" value="Y" data-action="boxswitch">
                                                <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                <span class="px-3 user-select-none">On/Off</span>
                                            </label>
                                        </div>

                                        <div class="col-12" style="display: none;" id="box_master_to_info">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="master_to" name="master_to" rows="4"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-12 col-lg-6 px-4">
                                    <div class="row border rounded bg-gray-100">
                                        <div class="col-12">
                                            <strong>Info From</strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-flex align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox"
                                                    name="isinformation_from_active" id="isinformation_from_active"
                                                    value="Y" data-action="boxswitch">
                                                <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                <span class="px-3 user-select-none">On/Off</span>
                                            </label>
                                        </div>

                                        <div class="col-12" style="display: none;" id="box_isinformation_from_active">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="information_from" name="information_from" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-12 col-lg-6 px-4">
                                    <div class="row border rounded bg-gray-100">
                                        <div class="col-12">
                                            <strong>Info To</strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="d-flex align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox"
                                                    name="isinformation_to_active" id="isinformation_to_active"
                                                    value="Y" data-action="boxswitch">
                                                <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                <span class="px-3 user-select-none">On/Off</span>
                                            </label>
                                        </div>

                                        <div class="col-12" style="display: none;" id="box_isinformation_to_active">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="information_to" name="information_to" rows="3"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            @foreach ($infos as $info)
                                <div class="row mb-4">
                                    <div class="col-12 col-lg-6 px-4">
                                        <div class="row border rounded bg-gray-100">
                                            <div class="col-12">
                                                <strong>{{ $info['title'] }} From</strong>

                                            </div>
                                            <div class="col-6">
                                                <label class="d-flex align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="{{ $info['key'] }}_isactive_from"
                                                        id="{{ $info['key'] }}_isactive_from" value="Y"
                                                        data-action="boxswitch">
                                                    <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                    <span class="px-3 user-select-none">On/Off</span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-flex align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="{{ $info['key'] }}_isservice_charge_from"
                                                        id="{{ $info['key'] }}_isservice_charge_from" value="Y">
                                                    <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                    <span class="px-3 user-select-none">Service charge</span>
                                                </label>
                                            </div>
                                            <div class="col-12" style="display: none;"
                                                id="box_{{ $info['key'] }}_isactive_from">
                                                <div class="row">

                                                    <div class="col-12 col-lg-5">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" class="form-control"
                                                                id="{{ $info['key'] }}_price_from"
                                                                name="{{ $info['key'] }}_price_from">
                                                            <label for="{{ $info['key'] }}_price_from">Price</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" id="{{ $info['key'] }}_mouseover_from" name="{{ $info['key'] }}_mouseover_from"
                                                                style="height: 100px"></textarea>
                                                            <label
                                                                for="{{ $info['key'] }}_mouseover_from">Mouseover</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                id="{{ $info['key'] }}_text_from"
                                                                name="{{ $info['key'] }}_text_from">
                                                            <label for="{{ $info['key'] }}_text_from">Message</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6 px-4">
                                        <div class="row border rounded bg-gray-100">
                                            <div class="col-12">
                                                <strong>{{ $info['title'] }} To</strong>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-flex align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="{{ $info['key'] }}_isactive_to"
                                                        id="{{ $info['key'] }}_isactive_to" value="Y"
                                                        data-action="boxswitch">
                                                    <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                    <span class="px-3 user-select-none">On/Off</span>
                                                </label>
                                            </div>
                                            <div class="col-6">
                                                <label class="d-flex align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="{{ $info['key'] }}_isservice_charge_to"
                                                        id="{{ $info['key'] }}_isservice_charge_to" value="Y">
                                                    <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                                    <span class="px-3 user-select-none">Service charge</span>
                                                </label>
                                            </div>
                                            <div class="col-12" style="display: none;"
                                                id="box_{{ $info['key'] }}_isactive_to">
                                                <div class="row">
                                                    <div class="col-12 col-lg-5">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" class="form-control"
                                                                id="{{ $info['key'] }}_price_to"
                                                                name="{{ $info['key'] }}_price_to">
                                                            <label for="{{ $info['key'] }}_price_to">Price</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" id="{{ $info['key'] }}_mouseover_to" name="{{ $info['key'] }}_mouseover_to"
                                                                style="height: 100px"></textarea>
                                                            <label
                                                                for="{{ $info['key'] }}_mouseover_to">Mouseover</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                id="{{ $info['key'] }}_text_to"
                                                                name="{{ $info['key'] }}_text_to">
                                                            <label for="{{ $info['key'] }}_text_to">Message</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <hr>
                            <div class="row">
                                <div class="col-12 mt-4 text-center">
                                    <x-button-submit-loading class="btn-lg w--30 me-4 button-orange-bg" :form_id="_('route-create-form')"
                                        :fieldset_id="_('route-create')" :text="_('Add')" />
                                    <a href="{{ route('route-index') }}"
                                        class="btn btn-secondary btn-lg w--30">Cancel</a>
                                    <small id="user-create-error-notice" class="text-danger mt-3"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <style>
        .icon-del-style {
            position: absolute;
            right: 10px;
            top: -5px;
        }
    </style>
@stop

@section('modal')
    <x-modal-info />

    <x-modal-create-infomation />
@stop

@section('script')
    <script>
        const icons = {{ Js::from($icons) }}
        const activities = {{ Js::from($activities) }}
        const meals = {{ Js::from($meals) }}
        const fare_child = {{ Js::from($fare_child) }}
        const fare_infant = {{ Js::from($fare_infant) }}
        let stations = ''
        const stationJson = {{ Js::from($stations) }};
        //console.log(stationJson);
        function appendMasterInfo(station, type) {
            $('#master_' + type).text(station['master_' + type]);
            if ($('#master_' + type).val() != '') {
                $('#master_' + type + '_info').prop('checked', true);
                $('#box_master_' + type + '_info').show();
            } else {
                $('#master_' + type + '_info').prop('checked', false);
                $('#box_master_' + type + '_info').hide();
            }

            //let types = ['shuttle_bus', 'private_taxi', 'longtail_boat'];
            let types = ['shuttle_bus', 'longtail_boat'];

            $.each(types, function(index, _type) {
                let isactive = false;
                if (String(station[_type + '_price']) !== '' && station[_type + '_price'] != 0) {
                    $('#' + _type + '_price_' + type).val(station[_type + '_price']);
                    isactive = true;
                    //console.log('shuttle_bus_price_');
                } else {
                    $('#' + _type + '_' + type).val('');
                }

                if ((station[_type + '_text'] !== '') && station[_type + '_text'] !== null) {
                    $('#' + _type + '_text_' + type).val(station[_type + '_text']);
                    isactive = true;
                    //console.log('shuttle_bus_text_');
                    //console.log(station['shuttle_bus_text']);
                } else {
                    $('#' + _type + '_text_' + type).val('');
                }

                if (String(station[_type + '_mouseover']) !== '' && station[_type + '_mouseover'] !== null) {
                    $('#' + _type + '_mouseover_' + type).val(station[_type + '_mouseover']);
                    isactive = true;
                    //console.log('shuttle_bus_mouseover_');
                } else {
                    $('#' + _type + '_mouseover_' + type).val('');
                }

                if (isactive) {
                    $('#' + _type + '_isactive_' + type).prop('checked', true);
                    $('#box_' + _type + '_isactive_' + type).show();
                } else {
                    $('#' + _type + '_isactive_' + type).prop('checked', false);
                    $('#box_' + _type + '_isactive_' + type).hide();
                }
            });


        }

        $(document).ready(function() {
            $('input[data-action="boxswitch"]').on('change', function() {
                let id = ($(this).attr('id'));
                let checked = (this.checked);
                if (checked) {
                    $('#box_' + id).show();
                } else {
                    $('#box_' + id).hide();
                }
            });

            $('#station-from-selected').on('change', function() {
                let station_from_id = this.value;
                //console.log(station_from_id);
                $.each(stationJson, function(index, station) {
                    if (station.id === station_from_id) {
                        appendMasterInfo(station, 'from');
                        return true;
                    }
                });
            });

            $('#station-to-selected').on('change', function() {
                let station_from_id = this.value;
                //console.log(station_from_id);
                $.each(stationJson, function(index, station) {
                    if (station.id === station_from_id) {
                        appendMasterInfo(station, 'to');
                        return true;
                    }
                });
            });
        });
    </script>
    <script src="{{ asset('assets/js/app/route_control.js') }}"></script>
@stop
