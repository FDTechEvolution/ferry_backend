@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title"><span class="text-main-color-2">Edit</span> Route</h1>
    <div class="route-search d-none">
        <div class="mb-3">
            <label for="station-from" class="form-label">Station From* </label>
            <input type="text" class="form-control" id="station-from">
        </div>
        <div class="mb-3">
            <label for="station-to" class="form-label">Station to </label>
            <input type="text" class="form-control" id="station-to">
        </div>
        <x-button-orange
            :type="_('button')"
            :text="_('search')"
        />
    </div>
@stop

@section('content')
<script>
let from_list = []
let to_list = []
function saveAllList(type, list_id, ul_id, input_id) {
    if(type === 'from') {
        let _from = {
            'list': list_id,
            'ul': ul_id,
            'input': input_id
        }
        from_list.push(_from)
    }
    if(type === 'to') {
        let _to = {
            'list': list_id,
            'ul': ul_id,
            'input': input_id
        }
        to_list.push(_to)
    }
}
</script>
<div class="row mt-4">
    <div class="col-12">
        <form novalidate class="bs-validate" id="route-update-form" method="POST" action="{{ route('route-update') }}">
            @csrf
            <fieldset id="route-update">
                <div class="row bg-transparent mt-lg-5">
                    <div class="col-sm-12 col-lg-10 mx-auto">

                        <div class="row">
                            <div class="col-12 px-4">
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Station From* :</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <select required class="form-select form-select-sm" id="station-from-selected" name="station_from">
                                            @foreach($stations as $station)
                                                <option value="{{ $station['id'] }}" @selected($station['id'] == $route['station_from_id'])>{{ $station['name'] }} @if($station['piername'] != '') [ {{ $station['piername'] }} ] @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Station To* :</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <select required class="form-select form-select-sm" id="station-to-selected" name="station_to">
                                            @foreach($stations as $station)
                                                <option value="{{ $station['id'] }}" @selected($station['id'] == $route['station_to_id'])>{{ $station['name'] }} @if($station['piername'] != '') [{{ $station['piername'] }}] @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-lg-2 col-form-label-sm text-start fw-bold">Partner :</label>
                                    <div class="col-sm-9 col-lg-7">
                                        <select required class="form-select form-select-sm" id="station-to-selected" name="partner_id">
                                            <option value="" selected disabled>--- Choose ---</option>
                                            @foreach($partners as $partner)
                                                <option value="{{ $partner['id'] }}" @selected($partner['id'] == $route['partner_id'])>{{ $partner['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0 pb-0 row">
                                    <label class="col-sm-12 col-lg-4 pb-0 col-form-label-sm text-start">More detail</label>
                                </div>
                                <div class="mb-2 row">
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <label class="col-form-label-sm text-start fw-bold">Depart Time*</label>
                                        <input required type="time" name="depart_time" class="form-control form-control-sm" value="{{ date('H:i', strtotime($route['depart_time'])) }}">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-2">
                                        <label class="col-form-label-sm text-start fw-bold">Arrive Time*</label>
                                        <input required type="time" name="arrive_time" class="form-control form-control-sm" value="{{ date('H:i', strtotime($route['arrive_time'])) }}">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2">
                                        <label for="regular-price" class="col-form-label-sm text-start fw-bold">Regular Price*</label>
                                        <input required type="number" class="form-control form-control-sm" id="regular-price" name="regular_price" value="{{ intval($route['regular_price']) }}">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2">
                                        <label for="child-price" class="col-form-label-sm text-start fw-bold">Child</label>
                                        <input type="number" class="form-control form-control-sm" id="child-price" name="child_price" value="{{ intval($route['child_price']) }}">
                                    </div>
                                    <div class="col-sm-12 col-md-4 col-lg-2">
                                        <label for="infant-price" class="col-form-label-sm text-start fw-bold">Infant</label>
                                        <input type="number" class="form-control form-control-sm" id="infant-price" name="infant_price" value="{{ intval($route['infant_price']) }}">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="col-form-label-sm text-start fw-bold">Activity</label>
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownActivity" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select activity
                                                <span class="group-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </span>
                                            </a>

                                            <ul class="dropdown-menu shadow-lg p-1 w-100" id="activity-dropdown" aria-labelledby="dropdownActivity">
                                                @foreach($activities as $index => $activity)
                                                    <li id="activity-active-{{ $index }}" data-id="{{ $activity->id }}">
                                                        <a class="dropdown-item rounded" href="javascript:void(0)" onClick="addRouteActivity({{ $index }})">
                                                            @if(isset($activity->icon))
                                                                <img src="{{ asset($activity->icon->path.'/'.$activity->icon->name) }}" class="me-2" width="24" height="24">
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
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="col-form-label-sm text-start fw-bold">Meal</label>
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownMeal" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select meal
                                                <span class="group-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </span>
                                            </a>

                                            <ul class="dropdown-menu shadow-lg p-1 w-100" aria-labelledby="dropdownMeal">
                                                @foreach($meals as $index => $meal)
                                                    <li id="meal-active-{{ $index }}" data-id="{{ $meal['id'] }}">
                                                        <a class="dropdown-item rounded" href="javascript:void(0)" onClick="addRouteMeal({{ $index }})">
                                                            @if(isset($meal->image_icon))
                                                                <img src="{{ asset('icon/meal/icon/'.$meal->image_icon) }}" class="me-2" width="24" height="24">
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
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="col-form-label-sm text-start fw-bold">Shuttle bus</label>
                                        <button type="button" class="btn btn-outline-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#create-shuttle-bus">Add shuttle bus</button>
                                        <x-modal-create-shuttle-bus />

                                        <ul class="list-group" id="shuttle-bus-list"></ul>
                                        <div class="shuttle-bus-input-list"></div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-3">
                                        <label class="col-form-label-sm text-start fw-bold">Longtail boat</label>
                                        <button type="button" class="btn btn-outline-dark btn-sm w-100" data-bs-toggle="modal" data-bs-target="#create-longtail-boat">Add longtail boat</button>
                                        <x-modal-create-longtail-boat />

                                        <ul class="list-group" id="longtail-boat-list"></ul>
                                        <div class="longtail-boat-input-list"></div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12 col-md-3 col-lg-3">
                                        <label class="col-form-label-sm text-start fw-bold">Icon <small class="text-danger d-none" id="icon-notice">MAX!</small></label>
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownIcons" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select icon
                                                <span class="group-icon">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <polyline points="6 9 12 15 18 9"></polyline>
                                                    </svg>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                </span>
                                            </a>

                                            <ul class="dropdown-menu shadow-lg p-1 w-100" aria-labelledby="dropdownIcons">
                                                @foreach($icons as $index => $icon)
                                                    <li id="icon-active-{{ $index }}" class="text-start">
                                                        <a class="dropdown-item rounded py-1" href="javascript:void(0)" onClick="addRouteIcon({{ $index }})">
                                                            <img src="{{ asset($icon->path) }}" class="me-2" width="42" height="42"> {{ $icon->name }}
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

                                <div class="row mb-4">
                                    <div class="col-12 col-lg-5 mb-3">
                                        <label class="d-flex align-items-center mb-1">
                                            <span class="user-select-none fw-bold me-2">Master From </span>
                                            <input class="d-none-cloaked" type="checkbox" id="master-from-switch" name="master_from_on" value="1" @checked(old('master_from_on', $route['master_from_info'] == 'Y'))>
                                            <i class="switch-icon switch-icon-primary switch-icon-xs"></i>
                                            <span class="ms-1 user-select-none" id="master-from-text">
                                                @if($route['master_from_info'] == 'Y') On
                                                @else Off
                                                @endif
                                            </span>
                                        </label>

                                        <input type="hidden" id="master-from-selected" name="master_from_selected" value=''>
                                        <x-modal-route-edit-infomation
                                            :header="_('Master From')" 
                                            :turnon="$route['master_from_info']"
                                            :select_id="_('station-from-selected')"
                                            :type="_('from')"
                                            :ismaster="_('Y')"
                                            :input_id="_('master-from-selected')"
                                            :data="$route['station_lines']"
                                            :stations="$stations"
                                        />

                                    </div>

                                    <div class="col-12 col-lg-5 mb-3">
                                        <label class="d-flex align-items-center mb-1">
                                            <span class="user-select-none fw-bold me-2">Master To </span>
                                            <input class="d-none-cloaked" type="checkbox" id="master-to-switch" name="master_to_on" value="1" @checked(old('master_to_on', $route['master_to_info'] == 'Y'))>
                                            <i class="switch-icon switch-icon-primary switch-icon-xs"></i>
                                            <span class="ms-1 user-select-none" id="master-to-text">
                                                @if($route['master_to_info'] == 'Y') On
                                                @else Off
                                                @endif
                                            </span>
                                        </label>

                                        <input type="hidden" id="master-to-selected" name="master_to_selected" value=''>
                                        <x-modal-route-edit-infomation
                                            :header="_('Master To')"
                                            :select_id="_('station-to-selected')"
                                            :type="_('to')"
                                            :ismaster="_('Y')"
                                            :input_id="_('master-to-selected')"
                                            :data="$route['station_lines']"
                                            :stations="$stations"
                                        />

                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12 col-md-6 col-lg-5 mb-3">
                                        <label class="d-flex align-items-center mb-1 fw-bold">
                                            Infomation From
                                        </label>

                                        <input type="hidden" id="info-from-selected" name="info_from_selected" value=''>
                                        <x-modal-route-edit-infomation
                                            :header="_('Infomation From')"
                                            :select_id="_('station-from-selected')"
                                            :type="_('from')"
                                            :ismaster="_('N')"
                                            :input_id="_('info-from-selected')"
                                            :data="$route['station_lines']"
                                            :stations="$stations"
                                        />
                                    </div>

                                    <div class="col-sm-12 col-md-6 col-lg-5 mb-3">
                                        <label class="d-flex align-items-center mb-1 fw-bold">
                                            Infomation To
                                        </label>

                                        <input type="hidden" id="info-to-selected" name="info_to_selected" value=''>
                                        <x-modal-route-edit-infomation
                                            :header="_('Infomation To')"
                                            :select_id="_('station-to-selected')"
                                            :type="_('to')"
                                            :ismaster="_('N')"
                                            :input_id="_('info-to-selected')"
                                            :data="$route['station_lines']"
                                            :stations="$stations"
                                        />

                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12 col-lg-5">
                                        <label for="">Text 1</label>
                                        <textarea name="text_1" id="text_1"  rows="3" class="form-control">{{$route['text_1']}}</textarea>
                                    </div>
                                    <div class="col-12 col-lg-5">
                                        <label for="">Text 2</label>
                                        <textarea name="text_2" id="text_2"  rows="3" class="form-control">{{$route['text_2']}}</textarea>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-6 col-md-2 col-lg-2 text-start fw-bold">Status :</label>
                                    <div class="col-5">
                                        <label class="d-flex align-items-center mb-3">
                                            <input class="d-none-cloaked" type="checkbox" id="route-status-switch" name="status" value="1" @checked(old('status', $route['isactive'] == 'Y'))>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-3 user-select-none" id="route-status-text">
                                                @if($route['isactive'] == 'Y') On
                                                @else Off
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-6 col-md-2 col-lg-2 text-start fw-bold">PromoCode :</label>
                                    <div class="col-5">
                                        <label class="d-flex align-items-center mb-3">
                                            <input class="d-none-cloaked" type="checkbox" id="route-promocode-switch" name="promocode" value="1" @checked(old('promocode', $route['ispromocode'] == 'Y'))>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-3 user-select-none" id="route-promocode-text">
                                                @if($route['ispromocode'] == 'Y') On
                                                @else Off
                                                @endif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4 text-center text-lg-start">
                                <input type="hidden" name="route_id" value="{{ $route['id'] }}">
                                <x-button-submit-loading
                                    class="btn-lg w--30 me-4 button-orange-bg"
                                    :form_id="_('route-update-form')"
                                    :fieldset_id="_('route-update')"
                                    :text="_('Edit')"
                                />
                                <a href="{{ route('route-index') }}" class="btn btn-secondary btn-lg w--30">Cancel</a>
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
    const fare_infant = {{ Js::from($fare_infant) }}

    $(document).ready(function(){
        $('#master-from-switch').on('change',function(){
            //console.log(this.checked);
            if(this.checked){
                $('#box-Y-from').show();
            }else{
                $('#box-Y-from').hide();
            }
        });

        $('#master-to-switch').on('change',function(){
            //console.log(this.checked);
            if(this.checked){
                $('#box-Y-to').show();
            }else{
                $('#box-Y-to').hide();
            }
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
