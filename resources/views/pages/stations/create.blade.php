@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Add</span> new station</h1>
@stop

@section('content')

    <div class="row mt-3">
        <div class="col-12">
            <form novalidate class="bs-validate" id="station-create-form" method="POST" action="{{ route('station-create') }}" enctype="multipart/form-data">
                @csrf
                <fieldset id="station-create">
                    <div class="row">
                        <div class="col-12 col-md-6 border-end">
                            <div class="mb-3 row">
                                <label for="station-name" class="col-sm-4 col-form-label-sm text-start">Station
                                    Name <strong class="text-danger">*</strong> :</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control form-control-sm" id="station-name"
                                        name="name" value="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-pier" class="col-sm-4 col-form-label-sm text-start">Station Pier
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="station-pier"
                                        name="pier" value="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-nickname" class="col-sm-4 col-form-label-sm text-start">Station
                                    Nickname <strong class="text-danger">*</strong> :</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control form-control-sm"
                                        id="station-nickname" name="nickname" value="">
                                </div>
                            </div>

                            <div class="mb-4 row">
                                <label class="col-sm-4 col-form-label-sm text-start">Master Info From :</label>
                                <div class="col-sm-8">
                                    <div class="dropdown">
                                        <a class="btn btn-outline-dark btn-sm w-100" href="#" role="button"
                                            data-bs-toggle="modal" data-bs-target="#modal-master-info-from">
                                            Select Info From
                                        </a>

                                    </div>
                                    <ul class="mb-0 py-2 slimscroll-custom d-none" id="station-info-from-list">
                                    </ul>
                                </div>
                                <input type="hidden" name="station_info_from_list" id="input-station-info-from-list">
                            </div>
                            <div class="mb-4 row">
                                <label class="col-sm-4 col-form-label-sm text-start">Master Info To :</label>
                                <div class="col-sm-8">
                                    <div class="dropdown">
                                        <a class="btn btn-outline-dark btn-sm w-100" href="#" role="button"
                                            data-bs-toggle="modal" data-bs-target="#modal-master-info-to">
                                            Select Info From
                                        </a>

                                    </div>
                                    <ul class="mb-0 py-2 slimscroll-custom d-none" id="station-info-to-list">
                                    </ul>
                                </div>
                                <input type="hidden" name="station_info_to_list" id="input-station-info-to-list">
                            </div>
                            <div class="mb-4 row">
                                <label for="station-shuttle-bus" class="col-sm-4 col-form-label-sm text-start">
                                    Shuttle bus :
                                    <label class="d-flex align-items-center mb-2">
                                        <input class="d-none-cloaked" type="checkbox" id="station-shuttle-bus-status"
                                            name="shuttle_status" value="1" checked>
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
                                <label for="station-longtail-boat" class="col-sm-4 col-form-label-sm text-start">
                                    Longtail boat :
                                    <label class="d-flex align-items-center mb-2">
                                        <input class="d-none-cloaked" type="checkbox" id="station-longtail-boat-status"
                                            name="longtail_status" value="1" checked>
                                        <i class="switch-icon switch-icon-primary"></i>
                                        <span class="px-2 user-select-none" id="station-longtail-boat-checked">On</span>
                                    </label>
                                </label>
                                <div class="col-sm-8">
                                    <select class="form-select form-select-sm" id="station-longtail-boat"
                                        name="longtail_boat">
                                        <option value="" selected disabled>-- Select --</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        <div class="col-12 col-md-6">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label-sm text-start">Station Status :</label>
                                <div class="col-sm-5">
                                    <label class="d-flex align-items-center mb-3">
                                        <input class="d-none-cloaked" type="checkbox" id="station-status"
                                            name="isactive" value="1" checked>
                                        <i class="switch-icon switch-icon-primary"></i>
                                        <span class="px-3 user-select-none" id="station-status-checked">On</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Section <strong class="text-danger">*</strong>
                                    :</label>
                                <div class="col-sm-8">
                                    <select required class="form-select form-select-sm" id="station-section"
                                        name="section">
                                        <option value="" selected disabled>-- Select --</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Sort <strong class="text-danger">*</strong>
                                    :</label>
                                <div class="col-sm-8">
                                    <select required class="form-select form-select-sm" id="station-sort" name="sort">
                                        <option value="" selected disabled>-- Select --</option>
                                        @for ($i = 1; $i <= 10; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row" style="display: none;">
                                <label for="extra-service" class="col-sm-4 col-form-label-sm text-start">Extra
                                    Service :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm input-suggest"
                                        id="extra-service" value="" placeholder="Product Search..."
                                        data-name="product_id[]" data-input-suggest-mode="append"
                                        data-input-suggest-typing-delay="300" data-input-suggest-typing-min-char="3"
                                        data-input-suggest-append-container="#inputSuggestContainer"
                                        data-input-suggest-ajax-url="_ajax/input_suggest_append.json"
                                        data-input-suggest-ajax-method="GET" data-input-suggest-ajax-action="input_search"
                                        data-input-suggest-ajax-limit="20">

                                    <div id="inputSuggestContainer" class="sortable">
                                        <!-- Preadded -->
                                        <div class="p-1 clearfix rounded">
                                            <a href="#"
                                                class="item-suggest-append-remove fi fi-close fs-6 float-start text-decoration-none"></a>
                                            <span>Preadded Example</span>
                                            <input type="hidden" name="product_id[]" value="1">
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="address" class="col-sm-4 col-form-label-sm text-start">Address :</label>
                                <div class="col-12 col-md-8">
                                    <textarea name="address" id="address" rows="4" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="image_file" class="col-sm-4 col-form-label-sm text-start">Map Image :</label>
                                <div class="col-12 col-md-8">
                                    <label
                                        class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                                        style="background-color: #fff;">
                                        <input type="file" name="image_file" id="image_file" data-file-ext="jepg, jpg, png, gif"
                                            data-file-max-size-kb-per-file="2048" data-file-max-size-kb-total="2048"
                                            data-file-max-total-files="100" data-file-ext-err-msg="Allowed:"
                                            data-file-exist-err-msg="File already exists:"
                                            data-file-size-err-item-msg="File too large!"
                                            data-file-size-err-total-msg="Total allowed size exceeded!"
                                            data-file-size-err-max-msg="Maximum allowed files:"
                                            data-file-toast-position="bottom-center"
                                            data-file-preview-container=".js-file-input-container-multiple-list-static-picture"
                                            data-file-preview-img-height="80"
                                            data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-picture"
                                            data-file-preview-show-info="true" data-file-preview-list-type="list"
                                            class="custom-file-input absolute-full cursor-pointer"
                                            title="jpeg, jpg, png, gif (2MB) [size : 800 x 388 px]"
                                            data-bs-toggle="tooltip" accept=".png, .jpg, .jpeg">

                                        <span class="group-icon cursor-pointer">
                                            <i class="fi fi-arrow-upload"></i>
                                            <i class="fi fi-circle-spin fi-spin"></i>
                                        </span>

                                        <span class="cursor-pointer">Upload map image</span>
                                    </label>

                                    <div class="row">
                                        <div class="col-10 col-md-10">
                                            <div
                                                class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2">
                                                <!-- container -->
                                            </div>
                                        </div>
                                        <div class="col-2 col-md-2 text-center">
                                            <!-- remove button -->
                                            <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip"
                                                id="remove-picture"
                                                class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                                <i class="fi fi-close mx-auto"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <hr>

                    <div class="row">
                        <div class="col-12 text-center mt-4">
                            <x-button-submit-loading class="btn-lg w--10 me-5" :form_id="_('station-create-form')" :fieldset_id="_('station-create')"
                                :text="_('Add')" />
                            <a href="{{ route('stations-index') }}" class="btn btn-secondary btn-lg w--10">Cancel</a>
                            <small id="user-create-error-notice" class="text-danger mt-3"></small>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>

    <style>
        #station-info-to-list,
        #station-info-from-list {
            background-color: #fff;
            border-radius: 0 0 3px 3px;
            max-height: 120px;
            overflow-y: auto;
        }
    </style>
@stop

@section('modal')
    <x-modal-info />

    <x-modal-data-list :header="_('Master Info From List')" :data="$info" :modal_id="_('modal-master-info-from')" :type="_('from')" />

    <x-modal-data-list :header="_('Master Info To List')" :data="$info" :modal_id="_('modal-master-info-to')" :type="_('to')" />
@stop

@section('script')
    <script>
        const station_info = {{ Js::from($info) }}
    </script>
    <script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop
