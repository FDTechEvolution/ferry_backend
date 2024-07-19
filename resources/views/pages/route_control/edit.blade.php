@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title">
        <span class="text-main-color-2">Edit</span> Route
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
    <script>
        let from_list = []
        let to_list = []

        function saveAllList(type, list_id, ul_id, input_id) {
            if (type === 'from') {
                let _from = {
                    'list': list_id,
                    'ul': ul_id,
                    'input': input_id
                }
                from_list.push(_from)
            }
            if (type === 'to') {
                let _to = {
                    'list': list_id,
                    'ul': ul_id,
                    'input': input_id
                }
                to_list.push(_to)
            }
        }
    </script>
    <div class="row">
        <div class="col-12">
            <form novalidate class="bs-validate" id="route-update-form" method="POST" action="{{ route('route-update') }}">
                @csrf
                <fieldset id="route-update">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="station-from-selected" name="station_from" required>
                                    @foreach ($stations as $station)
                                        <option value="{{ $station['id'] }}" @selected($station['id'] == $route['station_from_id'])>
                                            {{ $station['name'] }} @if ($station['piername'] != '')
                                                [ {{ $station['piername'] }} ]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <label for="station-from-selected">Station From *</label>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-floating mb-3">
                                <select class="form-select" id="station-to-selected" name="station_to" required>
                                    @foreach ($stations as $station)
                                        <option value="{{ $station['id'] }}" @selected($station['id'] == $route['station_to_id'])>
                                            {{ $station['name'] }} @if ($station['piername'] != '')
                                                [ {{ $station['piername'] }} ]
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                <label for="station-to-selected">Station To *</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 row">
                        <label class="col-12 col-lg-2 col-form-label-sm text-start fw-bold">Partner
                            :</label>
                        <div class="col-12 col-lg-4">
                            <select required class="form-select form-select-sm" id="station-to-selected" name="partner_id">
                                <option value="" selected disabled>--- Choose ---</option>
                                @foreach ($partners as $partner)
                                    <option value="{{ $partner['id'] }}" @selected($partner['id'] == $route['partner_id'])>
                                        {{ $partner['name'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-2 row">
                        <div class="col-sm-12 col-lg-3">
                            <label class="col-form-label-sm text-start fw-bold">Depart Time*</label>
                            <input required type="time" name="depart_time" class="form-control form-control-sm"
                                value="{{ date('H:i', strtotime($route['depart_time'])) }}">
                        </div>
                        <div class="col-sm-12 col-lg-3">
                            <label class="col-form-label-sm text-start fw-bold">Arrive Time*</label>
                            <input required type="time" name="arrive_time" class="form-control form-control-sm"
                                value="{{ date('H:i', strtotime($route['arrive_time'])) }}">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-2">
                            <label for="regular-price" class="col-form-label-sm text-start fw-bold">Regular
                                Price*</label>
                            <input required type="number" class="form-control form-control-sm" id="regular-price"
                                name="regular_price" value="{{ intval($route['regular_price']) }}">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-2">
                            <label for="child-price" class="col-form-label-sm text-start fw-bold">Child</label>
                            <input type="number" class="form-control form-control-sm" id="child-price" name="child_price"
                                value="{{ intval($route['child_price']) }}">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-2">
                            <label for="infant-price" class="col-form-label-sm text-start fw-bold">Infant</label>
                            <input type="number" class="form-control form-control-sm" id="infant-price" name="infant_price"
                                value="{{ intval($route['infant_price']) }}">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-sm-12 col-lg-6">
                            <label class="col-form-label-sm text-start fw-bold">Activity</label>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button"
                                    id="dropdownActivity" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-offset="0,6">
                                    Select activity
                                    <span class="group-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </span>
                                </a>

                                <ul class="dropdown-menu shadow-lg p-1 w-100" id="activity-dropdown"
                                    aria-labelledby="dropdownActivity">
                                    @foreach ($activities as $index => $activity)
                                        <li id="activity-active-{{ $index }}" data-id="{{ $activity->id }}">
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
                        <div class="col-sm-12 col-lg-6">
                            <label class="col-form-label-sm text-start fw-bold">Meal</label>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#"
                                    role="button" id="dropdownMeal" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-offset="0,6">
                                    Select meal
                                    <span class="group-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </span>
                                </a>

                                <ul class="dropdown-menu shadow-lg p-1 w-100" aria-labelledby="dropdownMeal">
                                    @foreach ($meals as $index => $meal)
                                        <li id="meal-active-{{ $index }}" data-id="{{ $meal['id'] }}">
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
                            <label class="col-form-label-sm text-start fw-bold">Icon <small class="text-danger d-none"
                                    id="icon-notice">MAX!</small></label>
                            <div class="dropdown">
                                <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#"
                                    role="button" id="dropdownIcons" data-bs-toggle="dropdown" aria-expanded="false"
                                    data-bs-offset="0,6">
                                    Select icon
                                    <span class="group-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="6 9 12 15 18 9"></polyline>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </span>
                                </a>

                                <ul class="dropdown-menu shadow-lg p-1 w-100 dd-overflow-y" aria-labelledby="dropdownIcons">
                                    @foreach ($icons as $index => $icon)
                                        <li id="icon-active-{{ $index }}" class="text-start">
                                            <a class="dropdown-item rounded py-1" href="javascript:void(0)"
                                                onClick="addRouteIcon({{ $index }})">
                                                <img src="{{ asset($icon->path) }}" class="me-2" width="42"
                                                    height="42"> {{ $icon->name }}
                                            </a>
                                        </li>
                                        @if($index == 8)
                                            <li><hr class="dropdown-divider my-3" style="border-color: #afafaf;"></li>
                                        @endif
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
                        <div class="col-12 col-lg-6">
                            <label for="">Text 1</label>
                            <input type="text" name="text_1" id="text_1" class="form-control"
                                value="{{ $route['text_1'] }}" />
                        </div>
                        <div class="col-12 col-lg-6">
                            <label for="">Text 2</label>
                            <input type="text" name="text_2" id="text_2" class="form-control"
                                value="{{ $route['text_2'] }}" />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <label class="col-6 col-md-2 col-lg-2 text-start fw-bold">Status :</label>
                        <div class="col-5">
                            <label class="d-flex align-items-center mb-3">
                                <input class="d-none-cloaked" type="checkbox" id="route-status-switch" name="status"
                                    value="1" @checked(old('status', $route['isactive'] == 'Y'))>
                                <i class="switch-icon switch-icon-primary"></i>
                                <span class="px-3 user-select-none" id="route-status-text">
                                    @if ($route['isactive'] == 'Y')
                                        On
                                    @else
                                        Off
                                    @endif
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <label class="col-6 col-md-2 col-lg-2 text-start fw-bold">PromoCode :</label>
                        <div class="col-5">
                            <label class="d-flex align-items-center mb-3">
                                <input class="d-none-cloaked" type="checkbox" id="route-promocode-switch"
                                    name="promocode" value="1" @checked(old('promocode', $route['ispromocode'] == 'Y'))>
                                <i class="switch-icon switch-icon-primary"></i>
                                <span class="px-3 user-select-none" id="route-promocode-text">
                                    @if ($route['ispromocode'] == 'Y')
                                        On
                                    @else
                                        Off
                                    @endif
                                </span>
                            </label>
                        </div>
                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <div class="row mb-4">
                                <div class="col-12 col-lg-6 px-4">
                                    <div class="row border rounded bg-gray-100">
                                        <div class="col-12">
                                            <strong>Master From</strong>
                                        </div>
                                        <div class="col-6">
                                            <label class="align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox" name="master_from_info"
                                                    id="master_from_info" value="Y" data-action="boxswitch"
                                                    data-id="master_from_info"
                                                    @if ($route->master_from_info == 'Y') @checked(true) @endif>
                                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                            </label><span class="px-3 user-select-none">On/Off</span>
                                        </div>

                                        <div class="col-12" id="box_master_from_info">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="master_from" name="master_from" rows="5">{{ $route->master_from }}</textarea>
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
                                            <label class="align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox" name="master_to_info"
                                                    id="master_to_info" value="Y" data-action="boxswitch"
                                                    data-id="master_to_info"
                                                    @if ($route->master_to_info == 'Y') @checked(true) @endif>
                                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                            </label> <span class="px-3 user-select-none">On/Off</span>
                                        </div>

                                        <div class="col-12" id="box_master_to_info">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="master_to" name="master_to" rows="5">{{ $route->master_to }}</textarea>
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
                                            <label class=" align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox"
                                                    name="isinformation_from_active" id="isinformation_from_active"
                                                    value="Y" data-action="boxswitch"
                                                    data-id="isinformation_from_active"
                                                    @if ($route->isinformation_from_active == 'Y') @checked(true) @endif>
                                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                            </label> <span class="px-3 user-select-none">On/Off</span>
                                        </div>

                                        <div class="col-12" id="box_isinformation_from_active">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="information_from" name="information_from" rows="3">{{ $route->information_from }}</textarea>
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
                                            <label class="align-items-center mb-3">
                                                <input class="d-none-cloaked" type="checkbox"
                                                    name="isinformation_to_active" id="isinformation_to_active"
                                                    value="Y" data-action="boxswitch"
                                                    data-id="isinformation_to_active"
                                                    @if ($route->isinformation_to_active == 'Y') @checked(true) @endif>
                                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                            </label> <span class="px-3 user-select-none">On/Off</span>
                                        </div>

                                        <div class="col-12" id="box_isinformation_to_active">
                                            <div class="row">
                                                <div class="col-12 mb-2">
                                                    <textarea class="form-control" id="information_to" name="information_to" rows="3">{{ $route->information_to }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                @foreach ($route->routeAddonEdit as $index => $item)
                                    <div class="col-12 col-lg-6 px-4 mb-3">
                                        <div class="row border rounded bg-gray-100">
                                            <div class="col-12">
                                                <strong>{{ $item['name'] }}</strong>

                                            </div>
                                            <div class="col-6">
                                                <label class="align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="route_addons[{{ $index }}][isactive]"
                                                        id="{{ $item->type }}_isactive_{{ $item->subtype }}"
                                                        value="Y"
                                                        data-id="{{ $item->type }}_{{ $item->subtype }}"
                                                        data-action="boxswitch"
                                                        @if ($item->isactive == 'Y') @checked(true) @endif>
                                                    <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                                </label><span class="px-3 user-select-none">On/Off</span>
                                                <input type="hidden" name="route_addons[{{ $index }}][id]"
                                                    value="{{ $item->id }}">
                                                <input type="hidden" name="route_addons[{{ $index }}][type]"
                                                    value="{{ $item->type }}">
                                                <input type="hidden" name="route_addons[{{ $index }}][subtype]"
                                                    value="{{ $item->subtype }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="align-items-center mb-3">
                                                    <input class="d-none-cloaked" type="checkbox"
                                                        name="route_addons[{{ $index }}][isservice_charge]"
                                                        id="" value="Y"
                                                        @if ($item->isservice_charge == 'Y') @checked(true) @endif>
                                                    <i class="switch-icon switch-icon-success switch-icon-sm"></i>

                                                </label><span class="px-3 user-select-none">Service charge</span>
                                            </div>
                                            <div class="col-12" id="box_{{ $item->type }}_{{ $item->subtype }}">
                                                <div class="row">

                                                    <div class="col-12 col-lg-5">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" class="form-control"
                                                                id="{{ $item->type }}_price_{{ $item->subtype }}"
                                                                name="route_addons[{{ $index }}][price]"
                                                                value="{{ $item->price }}">
                                                            <label for="">Price</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="form-floating mb-3">
                                                            <textarea class="form-control" id="{{ $item->type }}_mouseover_{{ $item->subtype }}"
                                                                name="route_addons[{{ $index }}][mouseover]" style="height: 100px">{{ $item->mouseover }}</textarea>
                                                            <label for="">Mouseover</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-lg-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" class="form-control"
                                                                id="{{ $item->type }}_message_{{ $item->subtype }}"
                                                                name="route_addons[{{ $index }}][message]"
                                                                value="{{ $item->message }}">
                                                            <label for="">Message</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 mt-4 text-center">
                                    <input type="hidden" name="route_id" value="{{ $route['id'] }}">
                                    <x-button-submit-loading class="btn-lg w--30 me-4 button-orange-bg" :form_id="_('route-update-form')"
                                        :fieldset_id="_('route-update')" :text="_('SAVE')" />
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
        .dd-overflow-y {
            max-height: 400px;
            overflow-y: auto;
        }
        /* width */
        .dd-overflow-y::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        .dd-overflow-y::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        .dd-overflow-y::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        .dd-overflow-y::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
@stop

@section('modal')
    <x-modal-info />

    <x-modal-create-infomation />
@stop

@section('script')

    <script>
        //$.SOW.core.toast.show('danger', '', `Something wrong.`, 'top-right', 0, true);

        const icons = {{ Js::from($icons) }}
        let stations = ''
        const route = {{ Js::from($route) }}
        const route_icons = {{ Js::from($route['icons']) }}
        const info_lines = {{ Js::from($route['station_lines']) }}
        const route_id = {{ Js::from($route['id']) }}
        const station_from_id = {{ Js::from($route['station_from_id']) }}
        const station_to_id = {{ Js::from($route['station_to_id']) }}
        const activities = {{ Js::from($activities) }}
        const meals = {{ Js::from($meals) }}
        const route_activity = {{ Js::from($route['activity_lines']) }}
        const route_meal = {{ Js::from($route['meal_lines']) }}
        const shuttle_bus = {{ Js::from($route['shuttle_bus']) }}
        const longtail_boat = {{ Js::from($route['longtail_boat']) }}
        const fare_child = {{ Js::from($fare_child) }}
        const fare_infant = {{ Js::from($fare_infant) }};

        const stationJson = {{ Js::from($stations) }};
        var countCheckFrom =0;
        var countCheckTo =0;
        //console.log(stationJson);
        function appendMasterInfo(station, type) {
            $('#master_' + type).text(station['master_' + type]);
            //$('#master_to').text(station.master_to);

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
                    $('#' + _type + '_message_' + type).val(station[_type + '_text']);
                    isactive = true;
                    //console.log('shuttle_bus_text_');
                    //console.log(station['shuttle_bus_text']);
                } else {
                    $('#' + _type + '_message_' + type).val('');
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
                    $('#box_' + _type + '_' + type).show();
                } else {
                    $('#' + _type + '_isactive_' + type).prop('checked', false);
                    $('#box_' + _type + '_' + type).hide();
                }
            });


        }

        $(document).ready(function() {
            $('#station-from-selected').on('click', function() {
                if(countCheckFrom !==0){
                    return;
                }

                if (confirm('การเปลี่ยน Station จะทำให้ข้อมูลของ Master Info เปลี่ยนไป')) {
                    countCheckFrom++;
                }
            });

            $('#station-to-selected').on('click', function() {
                if(countCheckTo !==0){
                    return;
                }

                if (confirm('การเปลี่ยน Station จะทำให้ข้อมูลของ Master Info เปลี่ยนไป')) {
                    countCheckTo++;
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

    <script>
        setRouteIcon()
        setActivityData()
        setMealData()
        setShuttleBus()
        setLongtailBoat()
        // setInfomationDataList()
        // setMasterInfoListData()
    </script>
@stop
