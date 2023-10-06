@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="route-page-title"><span class="text-main-color-2">Add</span> new Route</h1>
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
<div class="row mt-4">
    <div class="col-12">
        <form novalidate class="bs-validate" id="route-create-form" method="POST" action="{{ route('route-create') }}">
            @csrf
            <fieldset id="route-create">
                <div class="row bg-transparent mt-5">
                    <div class="col-sm-12 w-75 mx-auto">

                        <div class="row">
                            <div class="col-12 px-4">
                                <h1 class="fw-bold text-main-color-2 mb-4">Add new Route</h1>

                                <div class="mb-4 w-75 row">
                                    <label class="col-sm-3 col-form-label-sm text-start fw-bold">Station From* :</label>
                                    <div class="col-sm-9">
                                        <select required class="form-select form-select-sm" name="station_from">
                                            <option value="">--- Choose ---</option>
                                            @foreach($stations as $station)
                                                <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != '') [ {{ $station['piername'] }} ] @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 w-75 row">
                                    <label class="col-sm-3 col-form-label-sm text-start fw-bold">Station To* :</label>
                                    <div class="col-sm-9">
                                        <select required class="form-select form-select-sm" name="station_to">
                                            <option value="">--- Choose ---</option>
                                            @foreach($stations as $station)
                                                <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != '') [{{ $station['piername'] }}] @endif</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-0 pb-0 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">More detail</label>
                                </div>
                                <div class="mb-2 row">
                                    <div class="col-2">
                                        <label class="col-form-label-sm text-start fw-bold">Depart Time</label>
                                        <input type="time" name="depart_time" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-2">
                                        <label class="col-form-label-sm text-start fw-bold">Arrive Time</label>
                                        <input type="time" name="arrive_time" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-2">
                                        <label for="regular-price" class="col-form-label-sm text-start fw-bold">Regular Price</label>
                                        <input type="number" class="form-control form-control-sm" id="regular-price" name="regular_price">
                                    </div>
                                    <div class="col-2">
                                        <label for="child-price" class="col-form-label-sm text-start fw-bold">Child</label>
                                        <input type="number" class="form-control form-control-sm" id="child-price" name="child_price">
                                    </div>
                                    <div class="col-2">
                                        <label for="extra" class="col-form-label-sm text-start fw-bold">Extra</label>
                                        <select class="form-control form-control-sm" id="extra" name="extra">

                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <label for="infant" class="col-form-label-sm text-start fw-bold">Infant</label>
                                        <select class="form-control form-control-sm" id="infant" name="infant">
                                            
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-3">
                                        <label for="icon" class="col-form-label-sm text-start fw-bold">Icon</label>
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm dropdown-toggle" href="#" role="button" id="dropdownIcons" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
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

                                            <ul class="dropdown-menu shadow-lg p-1" aria-labelledby="dropdownIcons">
                                                @foreach($icons as $index => $icon)
                                                    <li id="icon-active-{{ $index }}">
                                                        <a class="dropdown-item rounded" href="javascript:void(0)" onClick="addRouteIcon({{ $index }})">
                                                            <img src="{{ asset($icon->path) }}" class="me-2" width="24" height="24">
                                                            <span>{{ $icon->name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-9 show-icon">
                                        <label for="icon" class="col-form-label-sm text-start fw-bold"></label>
                                        <ul class="list-group list-group-horizontal">
                                        </ul>
                                        <input type="hidden" name="icons[]" id="route-add-icon" value="">
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-4">
                                        <label class="d-flex align-items-center mb-1">
                                            <span class="user-select-none fw-bold me-2">Master From </span>
                                            <input class="d-none-cloaked" type="checkbox" name="master_from_on" value="1">
                                            <i class="switch-icon switch-icon-primary switch-icon-xs"></i>
                                            <span class="ms-1 user-select-none">Off</span>
                                        </label>
                                        <select class="form-select" size="4" name="manter_from" aria-label="size 3 select example">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label class="d-flex align-items-center mb-1">
                                            <span class="user-select-none fw-bold me-2">Master To </span>
                                            <input class="d-none-cloaked" type="checkbox" name="master_to_on" value="1">
                                            <i class="switch-icon switch-icon-primary switch-icon-xs"></i>
                                            <span class="ms-1 user-select-none">Off</span>
                                        </label>
                                        <select class="form-select" size="4" name="master_to" aria-label="size 3 select example">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-4">
                                        <label class="d-flex align-items-center mb-1 fw-bold">
                                            Infomation From 
                                            <i class="fi fi-round-plus text-main-color-2 ms-2"></i>
                                            <i class="fi fi-round-close text-main-color-2 ms-2"></i>
                                        </label>
                                        <select class="form-select" size="4" name="info_from" aria-label="size 3 select example">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>

                                    <div class="col-4">
                                        <label class="d-flex align-items-center mb-1 fw-bold">
                                            Infomation To 
                                            <i class="fi fi-round-plus text-main-color-2 ms-2"></i>
                                            <i class="fi fi-round-close text-main-color-2 ms-2"></i>
                                        </label>
                                        <select class="form-select" size="4" name="info_to" aria-label="size 3 select example">
                                            <option selected>Open this select menu</option>
                                            <option value="1">One</option>
                                            <option value="2">Two</option>
                                            <option value="3">Three</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <label class="col-sm-2 text-start fw-bold">Status :</label>
                                    <div class="col-sm-2">
                                        <label class="d-flex align-items-center mb-3">
                                            <input class="d-none-cloaked" type="checkbox" name="status" value="1" checked>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-3 user-select-none">On</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <x-button-submit-loading 
                                    class="btn-lg w--20 me-4 button-orange-bg"
                                    :form_id="_('route-create-form')"
                                    :fieldset_id="_('route-update')"
                                    :text="_('Add')"
                                />
                                <a href="{{ route('route-index') }}" class="btn btn-secondary btn-lg w--20">Cancel</a>
                                <small id="user-create-error-notice" class="text-danger mt-3"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop

@section('script')
<script>
    const icons = {{ Js::from($icons) }}
</script>
<script src="{{ asset('assets/js/app/route_control.js') }}"></script>
@stop