@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Add</span> new station</h1>
@stop

@section('content')

    <div class="row mt-3">
        <div class="col-12">
            <form novalidate class="bs-validate" id="station-create-form" method="POST" action="{{ route('station-create') }}"
                enctype="multipart/form-data">
                @csrf
                <fieldset id="station-create">
                    <div class="row">
                        <div class="col-12 col-lg-7 border-end">
                            <div class="mb-3 row">
                                <label class="col-sm-4 col-form-label-sm text-start">Station Status :</label>
                                <div class="col-sm-5">
                                    <label class="d-flex align-items-center mb-3">
                                        <input class="d-none-cloaked" type="checkbox" id="isactive"
                                            name="isactive" value="Y" checked>
                                        <i class="switch-icon switch-icon-primary"></i>
                                        <span class="px-3 user-select-none" id="edit-station-status-checked">On</span>
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Section <strong
                                        class="text-danger">*</strong>
                                    :</label>
                                <div class="col-sm-8">
                                    <select required class="form-select form-select-sm" id="station-section" name="section_id">
                                        <option value="" selected disabled>-- Select --</option>
                                        @foreach ($sections as $section)
                                            <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-name" class="col-sm-4 col-form-label-sm text-start">Station
                                    Name <strong class="text-danger">*</strong> :</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control form-control-sm" id="station-name"
                                        name="name" value="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-name" class="col-sm-4 col-form-label-sm text-start">Station
                                    Name (TH)<strong class="text-danger">*</strong> :</label>
                                <div class="col-sm-8">
                                    <input type="text" required class="form-control form-control-sm" id="station-nameขะ้"
                                        name="thai_name" value="">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="station-pier" class="col-sm-4 col-form-label-sm text-start">Station Pier
                                    :</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control form-control-sm" id="station-pier"
                                        name="piername" value="">
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




                        </div>

                        <div class="col-12 col-lg-5">
                            <div class="row">
                                <div class="col-12">
                                    <strong>Check-In Information</strong>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="address" name="address" style="height: 130px"></textarea>
                                        <label for="address">Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="" class="col-sm-4 col-form-label-sm text-start">Image :</label>
                                <div class="col-12 col-md-8">
                                    <label
                                        class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                                        style="background-color: #fff;">
                                        <input type="file" name="image_file" id="image_file"
                                            data-file-ext="jepg, jpg, png, gif" data-file-max-size-kb-per-file="2048"
                                            data-file-max-size-kb-total="2048" data-file-max-total-files="100"
                                            data-file-ext-err-msg="Allowed:" data-file-exist-err-msg="File already exists:"
                                            data-file-size-err-item-msg="File too large!"
                                            data-file-size-err-total-msg="Total allowed size exceeded!"
                                            data-file-size-err-max-msg="Maximum allowed files:"
                                            data-file-toast-position="bottom-center"
                                            data-file-preview-container=".js-file-input-container-multiple-list-static-picture"
                                            data-file-preview-img-height="80"
                                            data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-picture"
                                            data-file-preview-show-info="true" data-file-preview-list-type="list"
                                            class="custom-file-input absolute-full cursor-pointer"
                                            title="jpeg, jpg, png, gif (2MB) [size : 800 x 388 px]" data-bs-toggle="tooltip"
                                            accept=".png, .jpg, .jpeg">

                                        <span class="group-icon cursor-pointer">
                                            <i class="fi fi-arrow-upload"></i>
                                            <i class="fi fi-circle-spin fi-spin"></i>
                                        </span>

                                        <span class="cursor-pointer">Upload image</span>
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

                            <div class="mb-3 row">
                                <label for="address" class="col-sm-4 col-form-label-sm text-start">Google Map :</label>
                                <div class="col-12 col-md-8">
                                    <input type="text" name="google_map" id="google_map" class="form-control"
                                        placeholder="Coordinates 99.0000,99.000">
                                </div>
                                <div class="col-12 mt-3" style="display: none;">
                                    <div class="map-leaflet w-100 rounded" style="height:300px" data-map-tile="voyager"
                                        data-map-zoom="13"
                                        data-map-json='[
		{
			"map_lat": 40.750765,
			"map_long": -73.993428,
			"map_popup": ""
		}
	]'>
                                        <!-- map container-->
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="row mt-2">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <strong class="text-main-color"><i class="fa-solid fa-circle-info"></i> Master
                                                Informations</strong>

                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="master_from" name="master_from"
                                                    style="height: 130px"></textarea>
                                                <label for="master_from">Master From</label>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <div class="form-floating mb-3">
                                                <textarea class="form-control" id="master_to" name="master_to"
                                                    style="height: 130px"></textarea>
                                                <label for="master_to">Master To</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        $infos = [
                            [
                                'title' => 'Shuttle Bus transfer',
                                'key' => 'shuttle_bus',
                            ],
                            [
                                'title' => 'Private Taxi transfer',
                                'key' => 'private_taxi',
                            ],
                            [
                                'title' => 'Longtail boat transfer',
                                'key' => 'longtail_boat',
                            ],
                        ];
                    @endphp

                    @foreach ($infos as $index => $info)
                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <strong class="text-main-color"><i class="fa-solid fa-circle-info"></i>
                                                    {{ $info['title'] }}</strong>

                                            </div>
                                            <div class="col-12 col-lg-8">
                                                <div class="row mb-2">
                                                    <label for=""
                                                        class="col-4 col-lg-3 col-form-label-sm text-start">Price: </label>
                                                    <div class="col-8 col-lg-5">
                                                        <input type="number"
                                                            class="form-control form-control-sm"
                                                            id="{{$info['key']}}_price"
                                                            name="{{$info['key']}}_price">
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label for=""
                                                        class="col-4 col-lg-3 col-form-label-sm text-start">Mouseover:
                                                    </label>
                                                    <div class="col-8 col-lg-9">
                                                        <textarea name="{{$info['key']}}_mouseover" id="{{$info['key']}}_mouseover"
                                                            rows="3" class="form-control"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-2">
                                                    <label for=""
                                                        class="col-4 col-lg-3 col-form-label-sm text-start">Text: </label>
                                                    <div class="col-8 col-lg-9">
                                                        <input type="text"
                                                            class="form-control form-control-sm"
                                                            id="{{$info['key']}}_text"
                                                            name="{{$info['key']}}_text">
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach


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

@stop

@section('script')
    <script>
        $(document).ready(function() {
            $('#google_map').on('keyup', function() {
                let google_map = $(this).val();

            });
        });
    </script>
    <script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop
