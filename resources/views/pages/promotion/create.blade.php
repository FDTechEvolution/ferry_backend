@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">
        Add Promotion code discount</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form novalidate class="bs-validate" id="promotion-create-form" method="POST"
                action="{{ route('promotion-store') }}" enctype="multipart/form-data">
                @csrf
                <fieldset id="promotion-create">
                    <div class="row mb-2">
                        <label class="col-12 col-md-3 col-form-label-sm">Title <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-md-7">
                            <textarea class="form-control form-control-sm" rows="4" name="title">

                            </textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Code <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="text" class="form-control form-control-sm" name="code"
                                value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Discount <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-6 col-lg-4">
                            <input required type="number" class="form-control form-control-sm text-center" name="discount"
                                id="discount" value="">
                        </div>
                        <div class="col-sm-4 col-lg-3">
                            <select required class="form-select form-select-sm text-center" name="discount_type"
                                id="discount_type">
                                <option value="PERCENT" selected>%</option>
                                <option value="THB">THB</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm fw-bold">Usage <strong
                                class="text-danger">*</strong></label>
                        <div class="col-sm-12 col-lg-4">
                            <input required type="number" class="form-control form-control-sm" name="times_use_max"
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-12 col-md-3 col-form-label-sm">Depart Date Range <strong
                                class="text-danger">*</strong></label>
                        <div class="col-12 col-lg-4 mb-2">
                            <input autocomplete="off" type="text" name="daterange" id="daterange" required
                                class="form-control form-control-sm rangepicker" data-bs-placement="left"
                                data-ranges="false" data-date-start="{{ date('d-m-Y') }}"
                                data-date-end="{{ date('d-m-Y', strtotime('+30 day', time())) }}"
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
                                data-ranges="false" data-date-start="{{ date('d-m-Y') }}"
                                data-date-end="{{ date('d-m-Y', strtotime('+30 day', time())) }}"
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
                                    id="isactive" name="isactive" checked>
                                <label class="form-check-label" for="isactive">
                                    Active and Show on home page.
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label class="col-12 col-md-3 col-form-label-sm">Description</label>
                        <div class="col-12 col-md-7">
                            <textarea name="description" id="description" rows="4" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row mb-2" style="display: none;">
                        <label class="col-12 col-md-3 col-form-label-sm">Image</label>
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
                                            <option value="one-way">One Way</option>
                                            <option value="round-trip">Round Trip</option>
                                            <option value="multi-trip">Multi Island</option>
                                        </select>
                                        <label for="trip_type">Trip Type</label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox"
                                            value="Y" id="isfreecreditcharge" name="isfreecreditcharge">
                                        <label class="form-check-label" for="isfreecreditcharge">
                                            Free credit charge
                                        </label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-success" type="checkbox"
                                            value="Y" id="isfreepremiumflex" name="isfreepremiumflex">
                                        <label class="form-check-label" for="isfreepremiumflex">
                                            Free premium flex
                                        </label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <button class="btn btn-success btn-lg" type="submit">Next <i class="fa-solid fa-forward"></i></button>
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
