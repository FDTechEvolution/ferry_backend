@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="shuttle-bus-boat-page-title"><span class="text-main-color-2">Edit</span> Shuttle Bus &amp; Boat</h1>
@stop

@section('head_meta')
<style>
    .shuttle-form .ql-editor,
    .shuttle-form .ql-container.ql-snow {
        background-color: #fff;
        min-height: 400px;
    }

    .shuttle-form .section-title {
        font-size: 0.8rem;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        color: var(--bs-secondary-color);
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .shuttle-form .upload-dropzone {
        background-color: #fff;
        border: 1px dashed rgba(0, 0, 0, 0.18);
        border-radius: 0.75rem;
        min-height: 3.25rem;
    }

    .shuttle-form .upload-hint {
        font-size: 0.75rem;
        color: var(--bs-secondary-color);
    }

    #edit-image-cover {
        width: 80px;
        height: 80px;
        min-width: 80px;
        @if (! empty($item['image_id']) && ! empty($item['image']))
        background-image: url("{{ asset($item['image']['path'].'/'.$item['image']['name']) }}");
        @endif
    }
</style>
@endsection

@section('content')
<div class="row shuttle-form">
    <div class="col-12 col-xl-10 mx-auto">
        <form novalidate class="bs-validate" id="shuttle-bus-boat-edit-form" method="POST" action="{{ route('shuttle-bus-boat-update') }}" enctype="multipart/form-data">
            @csrf
            <fieldset id="shuttle-bus-boat-edit">
                <input type="hidden" name="id" value="{{ $item['id'] }}">
                <input type="hidden" name="current_image" id="is-current-image" value="{{ $item['image_id'] }}">

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="section-title">Info</div>
                        <div class="row g-3">
                            <div class="col-12 col-md-8">
                                <div class="form-floating">
                                    <input type="text" required class="form-control" id="item-name" name="name" value="{{ old('name', $item['name']) }}" placeholder="Name">
                                    <label for="item-name">Name <span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="form-floating">
                                    <input type="number" required class="form-control" id="item-price" name="price" value="{{ old('price', intval($item['amount'])) }}" min="0" step="1" placeholder="Price">
                                    <label for="item-price">Price (฿) <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="section-title">Media</div>
                        <label class="form-label fw-semibold mb-1">Picture</label>
                        <p class="upload-hint mb-2">jpeg, jpg, png, gif, webp · max 2MB</p>

                        <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 upload-dropzone d-flex align-items-center justify-content-center gap-2">
                            <input type="file" name="file_picture"
                                accept=".jpeg,.jpg,.png,.gif,.webp,image/jpeg,image/png,image/gif,image/webp"
                                data-file-ext="jpeg, jpg, png, gif, webp"
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
                                title="jpeg, jpg, png, gif, webp (2MB)" data-bs-toggle="tooltip"
                                onChange="getImageUpload('current-image')"
                            >
                            <span class="group-icon cursor-pointer">
                                <i class="fi fi-arrow-upload"></i>
                                <i class="fi fi-circle-spin fi-spin"></i>
                            </span>
                            <span class="cursor-pointer">Upload image</span>
                        </label>

                        <div class="row mt-2">
                            <div class="col-10">
                                <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty"></div>
                            </div>
                            <div class="col-2 text-center">
                                <a href="#" title="Clear Images" data-bs-toggle="tooltip" onClick="restoreCurrentImageByUpload('current-image')" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary btn-sm text-center">
                                    <i class="fi fi-close mx-auto"></i>
                                </a>
                            </div>
                        </div>

                        @if (! empty($item['image_id']))
                        <div class="row mt-2" id="current-image">
                            <div class="col-10">
                                <div class="position-relative hide-empty">
                                    <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                        <div class="position-relative d-inline-block bg-cover" id="edit-image-cover">
                                            <img src="" id="edit-image-src" class="animate-bouncein mw-100" alt="">
                                        </div>
                                        <div class="flex-fill d-flex min-w-0 align-items-center px-3">
                                            <span class="text-truncate d-block line-height-1">Current picture</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 text-center">
                                <a href="javascript:void(0);" title="Delete Images" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-image', 'restore-image')" class="btn btn-secondary btn-sm text-center">
                                    <i class="fi fi-close mx-auto"></i>
                                </a>
                            </div>
                        </div>
                        <svg id="restore-image" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-image', 'restore-image', '{{ $item['image_id'] }}')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>
                            <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                        </svg>
                        @endif
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body p-4">
                        <div class="section-title">Details</div>
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
                                "placeholder": "Type details..."
                            }'>
                            {!! $item['description'] !!}
                        </div>
                    </div>
                </div>

                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-4">
                    <a href="{{ route('shuttle-bus-boat-index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                    <x-button-submit-loading
                        class="px-4"
                        :form_id="_('shuttle-bus-boat-edit-form')"
                        :fieldset_id="_('shuttle-bus-boat-edit')"
                        :text="_('Save')"
                    />
                </div>

            </fieldset>
        </form>
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/shuttle-bus-boat.js') }}"></script>
@stop
