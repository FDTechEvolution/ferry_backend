@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">
        Edit {{ $promotion['code'] }}</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form novalidate class="bs-validate" id="promotion-create-form" method="POST"
                action="{{ route('promotion-update') }}" enctype="multipart/form-data">
                <input type="hidden" name="id" value="{{ $promotion['id'] }}">
                @csrf
                <fieldset id="promotion-create">
                    <div class="row mb-2">
                        <label class="col-12 col-md-3 col-form-label-sm">Title <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-md-7">
                            <textarea class="form-control form-control-sm" rows="4" name="title">
                                {{ $promotion['title'] }}
                            </textarea>
                        </div>

                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Code <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="text" class="form-control form-control-sm" name="code"
                                value="{{ $promotion['code'] }}">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Discount <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-6 col-lg-4">
                            <input required type="number" class="form-control form-control-sm text-center" name="discount"
                                id="discount" value="{{ $promotion['discount'] }}">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <select required class="form-select form-select-sm text-center" name="discount_type"
                                id="discount_type">
                                <option value="PERCENT" @if ($promotion['discount_type'] == 'PERCENT') selected @endif>%</option>
                                <option value="THB" @if ($promotion['discount_type'] == 'THB') selected @endif>THB</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Usage <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="number" class="form-control form-control-sm" name="times_use_max"
                                value="{{ $promotion['times_use_max'] }}">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-md-3 col-form-label-sm">Depart Date Range <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-lg-4 mb-2">
                            <input autocomplete="off" type="text" name="daterange" id="daterange" required
                                class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                data-ranges="false"
                                data-date-start="{{ date('d/m/Y', strtotime($promotion['depart_date_start'])) }}"
                                data-date-end="{{ date('d/m/Y', strtotime($promotion['depart_date_end'])) }}"
                                data-date-format="DD/MM/YYYY"
                                data-quick-locale='{
		"lang_apply"	: "Apply",
		"lang_cancel" : "Cancel",
		"lang_crange" : "Custom Range",
		"lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
		"lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
	}'>
                        </div>

                    </div>
                    <div class="row">
                        <label class="col-12 col-md-3 col-form-label-sm">Booking Date Range <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-lg-4 mb-2">
                            <input autocomplete="off" type="text" name="booking_daterange" id="booking_daterange" required
                                class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                data-ranges="false" data-date-start="{{ date('d/m/Y', strtotime($promotion['booking_start_date'])) }}"
                                data-date-end="{{ date('d/m/Y', strtotime($promotion['booking_end_date'])) }}"
                                data-date-format="DD/MM/YYYY"
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
                        <label class="col-12 col-md-3 col-form-label-sm">Active</label>
                        <div class="col-12 col-md-7">
                            <div class="form-check mb-2">
                                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                    id="isactive" name="isactive" @if ($promotion['isactive'] == 'Y') checked @endif>
                                <label class="form-check-label" for="isactive">
                                    Active and Show on home page.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-md-3 col-form-label-sm">Description</label>
                        <div class="col-12 col-md-7">
                            <textarea name="description" id="description" rows="4" class="form-control">{{ $promotion['description'] }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2" style="display: none;">
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
                        <div class="col-12">
                            <h5 class="text-main-color"><i class="fa-solid fa-route"></i> Promotion code Conditions</h5>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="trip_type" name="trip_type" aria-label="">
                                            <option value="all">None</option>
                                            @foreach ($tripTypes as $index => $item)
                                                <option value="{{ $index }}"
                                                    @if ($promotion['trip_type'] == $index) selected @endif>{{ $item }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="trip_type">Trip Type</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox"
                                            value="Y" id="isfreecreditcharge" name="isfreecreditcharge"
                                            @checked($promotion['isfreecreditcharge'] == 'Y')>
                                        <label class="form-check-label" for="isfreecreditcharge">
                                            Free credit charge
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox"
                                            value="Y" id="isfreepremiumflex" name="isfreepremiumflex"
                                            @checked($promotion['isfreepremiumflex'] == 'Y')>
                                        <label class="form-check-label" for="isfreepremiumflex">
                                            Free premium flex
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12 col-lg-6 border-end">
                                    <strong>Station From</strong>
                                    <a href="#"
                                        data-href="{{ route('promotion.addStation', ['id' => $promotion->id, 'type' => 'STATION_FROM']) }}"
                                        data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" class="js-ajax-modal"
                                        data-ajax-modal-backdrop="static"><i class="fa-solid fa-square-plus"></i>
                                        Add/Remove</a>

                                    <table class="table table-sm table-datatable" data-lng-empty="None"
                                        data-lng-page-info="_TOTAL_ stations"
                                        data-lng-filtered="(filtered from _MAX_ total entries)"
                                        data-lng-loading="Loading..." data-lng-processing="Processing..."
                                        data-lng-search="Search..." data-lng-norecords="No matching records found"
                                        data-lng-sort-ascending=": activate to sort column ascending"
                                        data-lng-sort-descending=": activate to sort column descending"
                                        data-main-search="true" data-column-search="false" data-row-reorder="false"
                                        data-col-reorder="false" data-responsive="true" data-header-fixed="false"
                                        data-select-onclick="false" data-enable-paging="true"
                                        data-enable-col-sorting="false" data-autofill="false" data-group="false"
                                        data-items-per-page="10" data-enable-column-visibility="false"
                                        data-lng-column-visibility="Column Visibility" data-enable-export="false">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Station Name</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($promotion->promotionStationFroms as $index => $station)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ sprintf('%s-%s', $station->nickname, $station->name) }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <strong>Station To</strong>
                                    <a href="#"
                                        data-href="{{ route('promotion.addStation', ['id' => $promotion->id, 'type' => 'STATION_TO']) }}"
                                        data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" class="js-ajax-modal"
                                        data-ajax-modal-backdrop="static"><i class="fa-solid fa-square-plus"></i>
                                        Add/Remove</a>
                                    <table class="table table-sm table-datatable" data-lng-empty="None"
                                        data-lng-page-info="_TOTAL_ stations"
                                        data-lng-filtered="(filtered from _MAX_ total entries)"
                                        data-lng-loading="Loading..." data-lng-processing="Processing..."
                                        data-lng-search="Search..." data-lng-norecords="No matching records found"
                                        data-lng-sort-ascending=": activate to sort column ascending"
                                        data-lng-sort-descending=": activate to sort column descending"
                                        data-main-search="true" data-column-search="false" data-row-reorder="false"
                                        data-col-reorder="false" data-responsive="true" data-header-fixed="false"
                                        data-select-onclick="false" data-enable-paging="true"
                                        data-enable-col-sorting="false" data-autofill="false" data-group="false"
                                        data-items-per-page="10" data-enable-column-visibility="false"
                                        data-lng-column-visibility="Column Visibility" data-enable-export="false">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Station Name</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($promotion->promotionStationTos as $index => $station)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ sprintf('%s-%s', $station->nickname, $station->name) }}</td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <strong>Route</strong>
                                    <a href="#"
                                        data-href="{{ route('promotion.addRoute', ['id' => $promotion->id, 'type' => 'ROUTE']) }}"
                                        data-ajax-modal-size="modal-lg" data-ajax-modal-centered="true"
                                        data-ajax-modal-callback-function="" class="js-ajax-modal"
                                        data-ajax-modal-backdrop="static"><i class="fa-solid fa-square-plus"></i>
                                        Add/Remove</a>

                                    <table class="table table-sm table-datatable table-hover" data-lng-empty="None"
                                        data-lng-page-info="None"
                                        data-lng-filtered="(filtered from _MAX_ total entries)"
                                        data-lng-loading="Loading..." data-lng-processing="Processing..."
                                        data-lng-search="Search..." data-lng-norecords="No matching records found"
                                        data-lng-sort-ascending=": activate to sort column ascending"
                                        data-lng-sort-descending=": activate to sort column descending"
                                        data-main-search="true" data-column-search="false" data-row-reorder="false"
                                        data-col-reorder="false" data-responsive="true" data-header-fixed="false"
                                        data-select-onclick="false" data-enable-paging="true"
                                        data-enable-col-sorting="false" data-autofill="false" data-group="false"
                                        data-items-per-page="10" data-enable-column-visibility="false"
                                        data-lng-column-visibility="Column Visibility" data-enable-export="false">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Partner</th>
                                                <th>Route</th>
                                                <th class="text-center">Arrive/Depart Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($promotionRoutes as $index => $route)
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $index + 1 }}

                                                    </td>
                                                    <td>{{ $route->name }}</td>
                                                    <td>{{ $route->route_name }}</td>
                                                    <td class="text-center">{{ date('H:i', strtotime($route->depart_time)) }}/{{ date('H:i', strtotime($route->arrive_time)) }}
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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


@section('script')
    <script>
        $(document).ready(function() {
            $('textarea').each(function() {
                $(this).val($(this).val().trim());
            });
        });
    </script>
@stop
