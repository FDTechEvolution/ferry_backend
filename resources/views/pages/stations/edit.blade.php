@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Edit</span> station</h1>
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <form novalidate class="bs-validate" id="station-edit-form" method="POST" action="{{ route('station-update') }}">
            @csrf
            <fieldset id="station-edit">
                <div class="row bg-transparent mt-5">
                    <div class="col-sm-12 w--80 mx-auto">
                        <h1 class="fw-bold text-second-color mb-4">Edit station</h1>

                        <div class="row">
                            <div class="col-6 px-4 border-end">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Station Name* :</label>
                                    <div class="col-sm-8">
                                        <input type="text" required class="form-control form-control-sm" id="edit-station-name" name="name" value="{{ $station['name'] }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Station Pier :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="edit-station-pier" name="pier" value="{{ $station['piername'] }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Station Nickname* :</label>
                                    <div class="col-sm-5">
                                        <input type="text" required class="form-control form-control-sm" id="edit-station-nickname" name="nickname" value="{{ $station['nickname'] }}">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Master Info From :</label>
                                    <div class="col-sm-8">
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm w-100" href="#" role="button" data-bs-toggle="modal" data-bs-target="#modal-master-info-from">
                                                Select Info From
                                            </a>
                                            <!-- <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownInfoFrom" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select Info From
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

                                            <ul class="dropdown-menu shadow-lg p-1 w-100" id="ul-dropdown-info-from" aria-labelledby="dropdownInfoFrom">
                                                @foreach($info as $index => $item)
                                                    <li id="info-from-active-{{ $index }}">
                                                        <a class="dropdown-item rounded" href="javascript:void(0)" onClick="addMasterInfoFrom({{ $index }})">
                                                            <span>{{ $item->name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul> -->
                                        </div>
                                        <ul class="mb-0 py-2 d-none" id="station-info-from-list" style="background-color: #fff; border-radius: 0 0 3px 3px;">
                                        </ul>
                                    </div>
                                    <input type="hidden" name="station_info_from_list" id="input-station-info-from-list">
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Master Info To :</label>
                                    <div class="col-sm-8">
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm w-100" href="#" role="button" data-bs-toggle="modal" data-bs-target="#modal-master-info-to">
                                                Select Info From
                                            </a>
                                            <!-- <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownInfoTo" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select Info To
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

                                            <ul class="dropdown-menu shadow-lg p-1 w-100" id="ul-dropdown-info-to" aria-labelledby="dropdownInfoTo">
                                                @foreach($info as $index => $item)
                                                    <li id="info-to-active-{{ $index }}">
                                                        <a class="dropdown-item rounded" href="javascript:void(0)" onClick="addMasterInfoTo({{ $index }})">
                                                            <span>{{ $item->name }}</span>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul> -->
                                        </div>
                                        <ul class="mb-0 py-2 d-none" id="station-info-to-list" style="background-color: #fff; border-radius: 0 0 3px 3px;">
                                        </ul>
                                    </div>
                                    <input type="hidden" name="station_info_to_list" id="input-station-info-to-list">
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">
                                        Shuttle bus :
                                        <label class="d-flex align-items-center mb-2">
                                            <input class="d-none-cloaked" type="checkbox" id="station-shuttle-bus-status" name="shuttle_status" value="1" checked>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-2 user-select-none" id="station-shuttle-bus-checked">On</span>
                                        </label>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select-sm" id="station-shuttle-bus" name="shuttle_bus">
                                            <option value="" selected disabled>-- Select --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">
                                        Longtail boat :
                                        <label class="d-flex align-items-center mb-2">
                                            <input class="d-none-cloaked" type="checkbox" id="station-longtail-boat-status" name="longtail_status" value="1" checked>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-2 user-select-none" id="station-longtail-boat-checked">On</span>
                                        </label>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-select form-select-sm" id="station-longtail-boat" name="longtail_boat">
                                            <option value="" selected disabled>-- Select --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 px-4">
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Station Status :</label>
                                    <div class="col-sm-5">
                                        <label class="d-flex align-items-center mb-3">
                                            <input class="d-none-cloaked" type="checkbox" id="edit-station-status" name="isactive" value="1" checked>
                                            <i class="switch-icon switch-icon-primary"></i>
                                            <span class="px-3 user-select-none" id="edit-station-status-checked">On</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Section* :</label>
                                    <div class="col-sm-8">
                                        <select required class="form-select form-select-sm" id="edit-station-section" name="section">
                                            <option value="" disabled>-- Select --</option>
                                            @foreach($sections as $section)
                                                <option value="{{ $section['id'] }}" @selected($station['section_id'] == $section['id'])>{{ $section['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-sm-4 col-form-label-sm text-start">Sort* :</label>
                                    <div class="col-sm-8">
                                        <select required class="form-select form-select-sm" id="edit-station-sort" name="sort">
                                            <option value="" disabled>-- Select --</option>
                                            @for($i = 1; $i <= 10; $i++)
                                                <option value="{{ $i }}" @selected($station['sort'] == $i)>{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="extra-service" class="col-sm-4 col-form-label-sm text-start">Extra Service :</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm input-suggest" id="extra-service" value=""
                                            placeholder="Product Search..."
                                            data-name="product_id[]"
                                            data-input-suggest-mode="append"
                                            data-input-suggest-typing-delay="300"
                                            data-input-suggest-typing-min-char="3"
                                            data-input-suggest-append-container="#inputSuggestContainer"
                                            data-input-suggest-ajax-url="_ajax/input_suggest_append.json"
                                            data-input-suggest-ajax-method="GET"
                                            data-input-suggest-ajax-action="input_search"
                                            data-input-suggest-ajax-limit="20">

                                        <div id="inputSuggestContainer" class="sortable">
                                            <!-- Preadded -->
                                            <div class="p-1 clearfix rounded">
                                                <a href="#" class="item-suggest-append-remove fi fi-close fs-6 float-start text-decoration-none"></a>
                                                <span>Preadded Example</span>
                                                <input type="hidden" name="product_id[]" value="1">
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <input type="hidden" name="id" id="edit-station-id" value="{{ $station['id'] }}">
                                <x-button-submit-loading 
                                    class="btn-lg w--10 me-5"
                                    :form_id="_('station-edit-form')"
                                    :fieldset_id="_('station-edit')"
                                    :text="_('Edit')"
                                />
                                <a href="{{ route('stations-index') }}" class="btn btn-secondary btn-lg w--10">Cancel</a>
                                <small id="station-edit-error-notice" class="text-danger mt-3"></small>
                            </div>
                        </div>

                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop

@section('modal')
<x-modal-info />

<x-modal-data-list 
    :header="_('Master Info From List')"
    :data="$info"
    :modal_id="_('modal-master-info-from')"
    :type="_('from')"
/>

<x-modal-data-list 
    :header="_('Master Info To List')"
    :data="$info"
    :modal_id="_('modal-master-info-to')"
    :type="_('to')"
/>
@stop

@section('script')
<script>
    const station_info = {{ Js::from($info) }}
    const info_lines = {{ Js::from($station['info_line']) }}
</script>
<script src="{{ asset('assets/js/app/station.js') }}"></script>
<script>
    setMasterInfo()
</script>
@stop