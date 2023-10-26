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
                <div class="row bg-transparent mt-lg-5">
                    <div class="col-sm-12 col-sm-10 mx-auto">

                        <div class="row">
                            <div class="col-sm-12 col-md-8 col-lg-7 px-4">
                                <h1 class="fw-bold text-second-color mb-4"><span>Add new Activity manage</h1>

                                <div class="mb-3 row">
                                    <label for="activity-name" class="col-sm-3 col-form-label-sm text-start">Activity Name* :</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control form-control-sm" id="activity-name" name="name" value="{{ $activity['name'] }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="activity-price" class="col-sm-3 col-form-label-sm text-start">Price* :</label>
                                    <div class="col-sm-9">
                                        <input type="number" required class="form-control form-control-sm w--40" id="activity-price" name="price" value="{{ intval($activity['price']) }}">
                                    </div>
                                </div>
                                <div class="mb-3 row">
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
                                <div class="mb-3 pt-4 pt-md-5 pt-lg-4 row mt-6">
                                    <label class="col-sm-3 col-form-label-sm text-start">Icon :</label>
                                    <div class="col-sm-1 text-lg-center align-self-center">
                                        <img src="{{ asset($activity['icon']['path']) }}" id="icon-selected" class="icon-size">
                                    </div>
                                    <div class="col-sm-8 ps-md-4 ps-lg-2">
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
                                                @foreach($icons as $index => $icon)
                                                <li>
                                                    <a class="dropdown-item rounded" href="javascript:void(0)" onClick="selectActivityIcon({{ $index }})">
                                                        <img src="{{ asset($icon->path) }}" class="me-2 icon-size">
                                                        <span>{{ $icon['name'] }}</span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="icon_id" id="icon-id" value="">
                                </div>
                                <div class="mb-3 row">
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

                            <div class="col-sm-12 col-md-4 col-lg-5">
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
<script>
    const icons = {{ Js::from($icons) }}
</script>
<script src="{{ asset('assets/js/app/activity.js') }}"></script>
@stop