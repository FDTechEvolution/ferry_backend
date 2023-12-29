@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">
        Edit {{$promotion['code']}}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form novalidate class="bs-validate" id="promotion-create-form" method="POST"
            action="{{ route('promotion-update') }}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{$promotion['id']}}">
                @csrf
                <fieldset id="promotion-create">
                    <div class="row mb-2">
                        <label class="col-12 col-md-2 col-form-label-sm">Title <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-md-7">
                            <input required type="text" class="form-control form-control-sm" name="title"
                                value="{{$promotion['title']}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-2 col-form-label-sm fw-bold">Code <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="text" class="form-control form-control-sm" name="code"
                                value="{{$promotion['code']}}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-2 col-form-label-sm fw-bold">Discount <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-6 col-lg-4">
                            <input required type="number" class="form-control form-control-sm text-center" name="discount"
                                id="discount" value="{{$promotion['discount']}}">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <select required class="form-select form-select-sm text-center" name="discount_type"
                                id="discount_type">
                                <option value="PERCENT" @if($promotion['discount_type']=='PERCENT') selected @endif>%</option>
                                        <option value="THB" @if($promotion['discount_type']=='THB') selected @endif>THB</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-2 col-form-label-sm fw-bold">Usage <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="number" class="form-control form-control-sm" name="times_use_max"
                                value="{{$promotion['times_use_max']}}">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-md-2 col-form-label-sm">Depart Date Range <strong
                            class="text-danger">*</strong></label>
                        <div class="col-12 col-lg-4 mb-2">
                            <input autocomplete="off" type="text" name="daterange" id="daterange" class="form-control form-control-sm rangepicker"
                                data-bs-placement="left" data-ranges="false" data-date-start="{{ date('d/m/Y', strtotime($promotion['depart_date_start'])) }}"
                                data-date-end="{{ date('d/m/Y', strtotime($promotion['depart_date_end'])) }}" data-date-format="DD/MM/YYYY"
                                data-quick-locale='{
		"lang_apply"	: "Apply",
		"lang_cancel" : "Cancel",
		"lang_crange" : "Custom Range",
		"lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		"lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
	}'>
                        </div>

                        
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-md-2 col-form-label-sm">Active</label>
                        <div class="col-12 col-md-7">
                            <div class="form-check mb-2">
                                <input class="form-check-input form-check-input-success" type="checkbox"
                                    value="Y" id="isactive" name="isactive" @if($promotion['isactive']=='Y') checked @endif>
                                <label class="form-check-label" for="isactive">
                                    Active and Show on home page.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-md-2 col-form-label-sm">Description</label>
                        <div class="col-12 col-md-7">
                            <textarea name="description" id="description" rows="4" class="form-control">{{$promotion['description']}}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-md-2 col-form-label-sm">Image</label>
                        <div class="col-12 col-md-7">
                            <div class="mb-3">

                                <input type="file" name="image_file" data-file-ext="jpg, png"
                                    data-file-max-size-kb-per-file="30000" data-file-ext-err-msg="Allowed:"
                                    data-file-size-err-item-msg="File too large!"
                                    data-file-size-err-total-msg="Total allowed size exceeded!"
                                    data-file-toast-position="bottom-center"
                                    data-file-preview-container=".js-file-input-preview-single-container2"
                                    data-file-preview-img-height="auto" data-file-preview-show-info="false"
                                    data-file-btn-clear="a.js-file-upload-clear2" class="form-control"
                                    accept=".png, .jpg, .jpeg">
                                <small class="text-danger">*** image size 700px*330px</small>
                            </div>

                            <div class="js-file-input-preview-single-container2 ms--n6 me--n6 mt-4 hide-empty">
                                <!-- preview container -->
                            </div>

                            <!--
                                        clear files button
                                        hidden by default
                                    -->
                            <div class="mt-1">
                                <a href="#" class="hide js-file-upload-clear2 btn btn-light btn-sm">
                                    Remove Image
                                </a>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-4 row">
                        <div class="col-sm-12 col-lg-8">
                            <h5>Promotion code Conditions</h5>
                            <div class="row">
                                <label class="col-12 col-md-3 col-form-label-sm ">Trip Type</label>
                                <div class="col-12 col-md-3 mb-2">
                                    <select name="trip_type" id="trip_type" class="form-select">
                                        <option value="all">All</option>
                                        @foreach ($tripTypes as $index=>$item)
                                        <option value="{{ $index }}" @if($promotion['trip_type']==$index) selected @endif>{{ $item }}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-12 col-md-3 col-form-label-sm ">Free credit charge</label>
                                <div class="col-12 col-md-3 mb-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox" value="Y" id="isfreecreditcharge" name="isfreecreditcharge" @if($promotion['isfreecreditcharge']=='Y') checked @endif>
                                        <label class="form-check-label" for="checkDefault">
                                            
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <label class="col-12 col-md-3 col-form-label-sm ">Free premium flex</label>
                                <div class="col-12 col-md-3 mb-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox" value="Y" id="isfreepremiumflex" name="isfreepremiumflex" @if($promotion['isfreepremiumflex']=='Y') checked @endif>
                                        <label class="form-check-label" for="checkDefault">
                                            
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-12 col-md-3 col-form-label-sm">Station From</label>
                                <div class="col-sm-12 col-lg-9">
                                    <select class="form-select form-select-sm" name="station_from_id">
                                        <option value="">-- Use for All Station --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}
                                                @if ($station->piername != null)
                                                    ({{ $station->piername }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-12 col-md-3 col-form-label-sm">Station To</label>
                                <div class="col-sm-12 col-lg-9">
                                    <select class="form-select form-select-sm" name="station_to_id">
                                        <option value="">-- Use for All Station --</option>
                                        @foreach ($stations as $station)
                                            <option value="{{ $station->id }}">{{ $station->name }}
                                                @if ($station->piername != null)
                                                    ({{ $station->piername }})
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <label class="col-12 col-md-3 col-form-label-sm">Route</label>
                                <div class="col-sm-12 col-lg-9">
                                    <select class="form-select form-select-sm" name="route_id">
                                        <option value="">-- Use for all Route --</option>
                                        @foreach ($routes as $route)
                                            <option value="{{ $route->id }}">
                                                {{ $route->station_from->name }} ->
                                                {{ $route->station_to->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row mb-3">
                        <div class="col-12 text-center">
                            <x-button-submit-loading class="btn-lg w--10 me-5" :form_id="_('promotion-create-form')" :fieldset_id="_('promotion-create')"
                                :text="_('Save')" />
                            <a href="{{ route('promotion-index') }}" class="btn btn-secondary btn-lg w--10">Cancel</a>
                            <small id="user-create-error-notice" class="text-danger mt-3"></small>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
@stop
