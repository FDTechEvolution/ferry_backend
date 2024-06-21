@extends('layouts.default')

@section('head_meta')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@stop

@section('page-title')
    <h1 class="ms-2 mb-0" id="meal-page-title"><span class="text-main-color-2">Edit</span> Meal</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-meal-create" />
@stop

@section('content')
<form novalidate class="bs-validate" id="meal-edit-form" method="POST" action="{{ route('meal-update') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="meal-update">
        <div class="row bg-transparent mt-lg-5">
            <div class="col-sm-12 col-lg-12 mx-auto">

                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 px-4" id="edit-meal-input">
                        <h1 class="fw-bold text-second-color mb-4"><span>Edit Meal</h1>

                        <div class="mb-4 row">
                            <label for="meal-name" class="col-sm-3 col-form-label-sm text-start">Meal Name<span class="text-danger">*</span>  :</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control form-control-sm" data-set="name" id="edit-meal-name" name="name" value="{{ $meal['name'] }}">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-price" class="col-sm-3 col-form-label-sm text-start">Price<span class="text-danger">*</span>  :</label>
                            <div class="col-sm-9">
                                <input type="number" required class="form-control form-control-sm w--40" data-set="price" id="edit-meal-price" name="price" value="{{ intval($meal['amount']) }}">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Detail Meal :</label>
                            <div class="col-sm-9">
                                <textarea name="detail" class="w-100" id="edit-meal-detail" data-set="description">
                                    {!! $meal['description'] !!}
                                </textarea>
                                <script type="text/javascript">
                                    $('#edit-meal-detail').summernote({
                                        placeholder: '',
                                        tabsize: 2,
                                        height: 200,
                                        toolbar: [
                                            ['style', ['style']],
                                            ['font', ['bold', 'underline', 'clear']],
                                            ['color', ['color']],
                                            ['para', ['ul', 'ol', 'paragraph']],
                                            ['table', ['table']],
                                            ['insert', ['link', 'picture']],
                                            ['view', ['fullscreen', 'codeview', 'help']]
                                        ]
                                    })
                                </script>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label class="col-sm-3 col-form-label-sm text-start">Icon :</label>
                            <div class="col-sm-9">
                                <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                    <input type="file" name="file_icon"
                                        data-file-ext="jepg, jpg, png, gif, svg"
                                        data-file-max-size-kb-per-file="1024"
                                        data-file-max-size-kb-total="1024"
                                        data-file-max-total-files="100"
                                        data-file-ext-err-msg="Allowed:"
                                        data-file-exist-err-msg="File already exists:"
                                        data-file-size-err-item-msg="File too large!"
                                        data-file-size-err-total-msg="Total allowed size exceeded!"
                                        data-file-size-err-max-msg="Maximum allowed files:"
                                        data-file-toast-position="bottom-center"
                                        data-file-preview-container=".js-file-input-container-multiple-list-static-icon"
                                        data-file-preview-img-height="80"
                                        data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-icon"
                                        data-file-preview-show-info="true"
                                        data-file-preview-list-type="list"
                                        class="custom-file-input absolute-full cursor-pointer"
                                        title="jpeg, jpg, png, gif, svg (1MB)" data-bs-toggle="tooltip"
                                        onChange="getImageUpload('current-icon')"
                                    >

                                    <span class="group-icon cursor-pointer">
                                        <i class="fi fi-arrow-upload"></i>
                                        <i class="fi fi-circle-spin fi-spin"></i>
                                    </span>

                                    <span class="cursor-pointer">Upload icon</span>
                                </label>

                                <div class="row">
                                    <div class="col-10">
                                        <div class="js-file-input-container-multiple-list-static-icon position-relative hide-empty mt-2"><!-- container --></div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <!-- remove button -->
                                        <a href="#" title="Clear Images" data-bs-toggle="tooltip" onClick="restoreCurrentImageByUpload('current-icon')" class="js-file-input-btn-multiple-list-static-remove-icon hide btn btn-secondary mt-4 text-center">
                                            <i class="fi fi-close mx-auto"></i>
                                        </a>
                                    </div>
                                </div>

                                @if($meal['image_icon_id'] != '')
                                    <div class="row" id="current-icon">
                                        <div class="col-10 col-lg-6">
                                            <div class="position-relative hide-empty mt-2">
                                                <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                                    <div class="position-relative d-inline-block bg-cover" id="edit-icon-cover" style="width: 40%;">
                                                        <img src="{{ asset(''.$meal['icon']['path'].'/'.$meal['icon']['name']) }}" id="edit-icon-src" class="animate-bouncein mw-100">
                                                    </div>
                                                    <div class="flex-fill d-flex min-w-0 align-items-center" style="padding-left:15px;padding-right:15px;">
                                                        <span class="text-truncate d-block line-height-1">Current icon</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-center">
                                            <!-- remove button -->
                                            <a href="JavaScript:void(0);" title="Delete Icon" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-icon', 'has-icon','restore-icon')" class="btn btn-secondary mt-2 text-center">
                                                <i class="fi fi-close mx-auto"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <svg id="restore-icon" title="Restore Icon" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-icon', 'has-icon','restore-icon', '{{ $meal['image_icon_id'] }}')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Picture :</label>
                            <div class="col-sm-9">
                                <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                    <input type="file" name="file_picture"
                                        data-file-ext="jepg, jpg, png, gif"
                                        data-file-max-size-kb-per-file="2048"
                                        data-file-max-size-kb-total="2048"
                                        data-file-max-total-files="100"
                                        data-file-ext-err-msg="Allowed:"
                                        data-file-exist-err-msg="File already exists:"
                                        data-file-size-err-item-msg="File too large!"
                                        data-file-size-err-total-msg="Total allowed size exceeded!"
                                        data-file-size-err-max-msg="Maximum allowed files:"
                                        data-file-toast-position="bottom-center"
                                        data-file-preview-container=".js-file-input-container-multiple-list-static-picture"
                                        data-file-preview-img-height="80"
                                        data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-picture"
                                        data-file-preview-show-info="true"
                                        data-file-preview-list-type="list"
                                        class="custom-file-input absolute-full cursor-pointer"
                                        title="jpeg, jpg, png, gif (2MB)" data-bs-toggle="tooltip"
                                    >

                                    <span class="group-icon cursor-pointer">
                                        <i class="fi fi-arrow-upload"></i>
                                        <i class="fi fi-circle-spin fi-spin"></i>
                                    </span>

                                    <span class="cursor-pointer">Upload image</span>
                                </label>

                                <div class="row" id="update-image">
                                    <div class="col-10">
                                        <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2">

                                        </div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <!-- remove button -->
                                        <a href="#" title="Clear Image" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                            <i class="fi fi-close mx-auto"></i>
                                        </a>
                                    </div>
                                </div>

                                @if($meal['image_id'] != NULL)
                                    <div class="row" id="current-image">
                                        <div class="col-10 col-lg-6">
                                            <div class="position-relative hide-empty mt-2">
                                                <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                                    <div class="position-relative d-inline-block bg-cover" id="edit-image-cover" style="width: 40%;">
                                                        <img src="{{ asset(''.$meal['image']['path'].'/'.$meal['image']['name']) }}" id="edit-image-src" class="animate-bouncein mw-100">
                                                    </div>
                                                    <div class="flex-fill d-flex min-w-0 align-items-center" style="padding-left:15px;padding-right:15px;">
                                                        <span class="text-truncate d-block line-height-1">Current picture</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-2 text-center">
                                            <!-- remove button -->
                                            <a href="JavaScript:void(0);" title="Delete Images" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-image', 'has-image', 'restore-image')" class="btn btn-secondary mt-2 text-center">
                                                <i class="fi fi-close mx-auto"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <svg id="restore-image" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-image', 'has-image', 'restore-image')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                    </svg>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 col-lg-12 px-4 mt-4">
                        <div class="mb-3 row">
                            <label class="col-sm-3 col-form-label-sm text-start">View : </label>
                            <div class="col-sm-9 py-2">
                                <div class="form-check ms-3 mb-3">
                                    <input class="form-check-input form-check-input-primary" type="checkbox" name="route_station" value="1" id="edit-route-station">
                                    <label class="form-check-label" for="edit-route-station">
                                        Route station
                                    </label>
                                </div>
                                <div class="form-check ms-3 mb-3">
                                    <input class="form-check-input form-check-input-primary" type="checkbox" name="main_menu" value="1" id="edit-main-menu">
                                    <label class="form-check-label" for="edit-main-menu">
                                        Main menu
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="id" id="edit-id" value="{{ $meal['id'] }}">
                    <input type="hidden" name="_image" id="has-image" value="0">
                    <input type="hidden" name="_icon" id="has-icon" value="0">
                    <div class="col-12 text-center mt-5">
                        <x-button-submit-loading
                            class="btn-lg w--20 me-2"
                            :form_id="_('meal-edit-form')"
                            :fieldset_id="_('meal-update')"
                            :text="_('Edit')"
                        />
                        <a href="{{ route('meals-index') }}" type="button" class="btn btn-secondary btn-lg w--20" id="btn-cancel-edit">Cancel</a>
                        <small id="user-edit-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>
@stop

@section('script')
<script>
    const is_meal = {{ Js::from($meal) }}
</script>
<script src="{{ asset('assets/js/app/meal.js') }}?v=@php echo date('YmdHis'); @endphp"></script>
@stop
