@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="activity-page-title"><span class="text-main-color-2">Edit</span> Activity</h1>
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">

        <form novalidate class="bs-validate" id="activity-edit-form" method="POST" action="{{ route('activity-update') }}" enctype="multipart/form-data">
            @csrf
            <fieldset id="activity-edit">
                <div class="row bg-transparent mt-5">
                    <div class="col-sm-12 w--80 mx-auto">

                        <div class="row">
                            <div class="col-7 px-4">
                                <h1 class="fw-bold text-second-color mb-4"><span>Add new Activity manage</h1>

                                <div class="mb-4 row">
                                    <label for="activity-name" class="col-sm-3 col-form-label-sm text-start">Activity Name* :</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control form-control-sm" id="activity-name" name="name" value="{{ $activity['name'] }}">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="activity-price" class="col-sm-3 col-form-label-sm text-start">Price* :</label>
                                    <div class="col-sm-9">
                                        <input type="number" required class="form-control form-control-sm w--40" id="activity-price" name="price" value="{{ intval($activity['price']) }}">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-form-label-sm text-start">Detail Activity :</label>
                                    <div class="col-sm-9">
                                        <div class="quill-editor"
                                            data-ajax-url="_ajax/demo.summernote.php"
                                            data-ajax-params="['action','upload']['param2','value2']"
                                            data-textarea-name="detail"
                                            data-quill-config='{
                                                "modules": {
                                                    "toolbar": [
                                                        [{ "header": [2, 3, 4, 5, 6, false] }],
                                                        ["bold", "italic", "underline", "strike"],
                                                        [{ "color": [] }, { "background": [] }],
                                                        [{ "script": "super" }, { "script": "sub" }],
                                                        ["blockquote"],
                                                        [{ "list": "ordered" }, { "list": "bullet"}, { "indent": "-1" }, { "indent": "+1" }],
                                                        [{ "align": [] }],
                                                        ["link", "image", "video"],
                                                        ["clean", "code-block"]
                                                    ]
                                                },

                                                "placeholder": "Type here..."
                                            }'>
                                            {!! $activity['detail'] !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 pt-4 row mt-6">
                                    <label class="col-sm-3 col-form-label-sm text-start">Icon :</label>
                                    <div class="col-sm-1 text-center align-self-center">
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">  
                                            <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"></path>  
                                            <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"></path>
                                        </svg>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="dropdown">
                                            <a class="btn btn-outline-dark btn-sm dropdown-toggle w-100" href="#" role="button" id="dropdownIcons" data-bs-toggle="dropdown" aria-expanded="false" data-bs-offset="0,6">
                                                Select Icon
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
                                                <li>
                                                    <a class="dropdown-item rounded" href="#">
                                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">  
                                                            <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"></path>  
                                                            <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"></path>
                                                        </svg>
                                                        <span>Icon 1</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item rounded" href="#">
                                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">  
                                                            <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"></path>  
                                                            <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"></path>
                                                        </svg>
                                                        <span>Icon 2</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item rounded" href="#">
                                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-alarm" viewBox="0 0 16 16">  
                                                            <path d="M8.5 5.5a.5.5 0 0 0-1 0v3.362l-1.429 2.38a.5.5 0 1 0 .858.515l1.5-2.5A.5.5 0 0 0 8.5 9V5.5z"></path>  
                                                            <path d="M6.5 0a.5.5 0 0 0 0 1H7v1.07a7.001 7.001 0 0 0-3.273 12.474l-.602.602a.5.5 0 0 0 .707.708l.746-.746A6.97 6.97 0 0 0 8 16a6.97 6.97 0 0 0 3.422-.892l.746.746a.5.5 0 0 0 .707-.708l-.601-.602A7.001 7.001 0 0 0 9 2.07V1h.5a.5.5 0 0 0 0-1h-3zm1.038 3.018a6.093 6.093 0 0 1 .924 0 6 6 0 1 1-.924 0zM0 3.5c0 .753.333 1.429.86 1.887A8.035 8.035 0 0 1 4.387 1.86 2.5 2.5 0 0 0 0 3.5zM13.5 1c-.753 0-1.429.333-1.887.86a8.035 8.035 0 0 1 3.527 3.527A2.5 2.5 0 0 0 13.5 1z"></path>
                                                        </svg>
                                                        <span>Icon 3</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label class="col-sm-3 col-form-label-sm text-start">Picture :</label>
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

                                        <div class="row">
                                            <div class="col-10">
                                                <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2"><!-- container --></div>
                                            </div>
                                            <div class="col-2 text-center">
                                                <!-- remove button -->
                                                <a href="#" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                                    <i class="fi fi-close mx-auto"></i>
                                                </a>
                                            </div>
                                        </div>

                                        @if($activity['image_id'] != '')
                                            <div class="row" id="current-image">
                                                <div class="col-10">
                                                    <div class="position-relative hide-empty mt-2">
                                                        <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                                            <div class="position-relative d-inline-block bg-cover" id="edit-image-cover">
                                                                <img src="" id="edit-image-src" class="animate-bouncein mw-100">
                                                            </div>
                                                            <div class="flex-fill d-flex min-w-0 align-items-center" style="padding-left:15px;padding-right:15px;">
                                                                <span class="text-truncate d-block line-height-1">Current picture</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-2 text-center">
                                                    <!-- remove button -->
                                                    <a href="JavaScript:void(0);" title="Delete Images" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-image', 'restore-image')" class="btn btn-secondary mt-4 text-center">
                                                        <i class="fi fi-close mx-auto"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <svg id="restore-image" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-image', 'restore-image', '{{ $activity['image_id'] }}')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">  
                                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>  
                                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <input type="hidden" name="current_image" id="is-current-image" value="{{ $activity['image_id'] }}">
                                <input type="hidden" name="id" value="{{ $activity['id'] }}">
                            </div>

                            <div class="col-5">
                                <div class="bg-light p-4 rounded">
                                    <p>View</p>
                                    <div class="form-check ms-3 mb-3">
                                        <input class="form-check-input form-check-input-primary" type="checkbox" name="route_station" value="" id="route-station">
                                        <label class="form-check-label" for="route-station">
                                            Route station
                                        </label>
                                    </div>
                                    <div class="form-check ms-3 mb-3">
                                        <input class="form-check-input form-check-input-primary" type="checkbox" name="main_menu" value="" id="main-menu">
                                        <label class="form-check-label" for="main-menu">
                                            Main menu
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-center mt-4">
                                <x-button-submit-loading 
                                    class="btn-lg w--20 me-5"
                                    :form_id="_('activity-edit-form')"
                                    :fieldset_id="_('activity-edit')"
                                    :text="_('Edit')"
                                />
                                <a href="{{ route('activity-index') }}" class="btn btn-secondary btn-lg w--20">Cancel</a>
                                <small id="user-create-error-notice" class="text-danger mt-3"></small>
                            </div>

                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>

@if($activity['image_id'] != '')
<style>
    #edit-image-cover {
        background-image: url("{{ asset($activity['image']['path'].'/'.$activity['image']['name']) }}");
        width: 80px; 
        height: 80px; 
        min-width: 80px;
    }
</style>
@endif

<style>
    .ql-editor, .ql-container.ql-snow {
        background-color: #fff;
    }
</style>
@stop

@section('script')
<script src="{{ asset('assets/js/app/activity.js') }}"></script>
@stop