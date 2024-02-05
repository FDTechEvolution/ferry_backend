@extends('layouts.default')

@section('head_meta')
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@stop

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2">Media <small class="fs-4">/ Blog / Create</small></h1>
@stop

@section('content')
<form class="bs-validate" id="slide-create-form" method="POST" action="{{ route('blog-store') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="slide-create">
        <div class="mb-5 mb-lg-4 row">
            <div class="col-12 col-lg-12">
                <div class="row mb-4">
                    <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-lg-12">
                        <input required type="text" class="form-control form-control-sm" name="title" value="">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 ps-lg-3 order-lg-2">
                <div class="row mb-4">
                    <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Image<span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-lg-12">
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
                                required
                            >

                            <span class="group-icon cursor-pointer">
                                <i class="fi fi-arrow-upload"></i>
                                <i class="fi fi-circle-spin fi-spin"></i>
                            </span>

                            <span class="cursor-pointer">Upload image</span>
                        </label>

                        <div class="row">
                            <div class="col-9">
                                <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2"><!-- container --></div>
                            </div>
                            <div class="col-2 text-center">
                                <!-- remove button -->
                                <a href="javascript:void(0)" title="Clear Images" id="remove-picture" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                    <i class="fi fi-close mx-auto"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 pe-lg-3 order-lg-1">
                <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Content</label>
                <div class="col-sm-12 col-lg-12 mb-3 mb-lg-0">
                    <textarea name="description" class="w-100" id="is-summernote"></textarea>
                    <script type="text/javascript">
                        $('#is-summernote').summernote({
                            placeholder: '',
                            tabsize: 2,
                            height: 400,
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
        </div>
        <div class="mb-2 mt-3 row">
            <div class="col-sm-12 col-lg-6 offset-lg-6 justify-content-end d-flex align-items-end">
                <x-button-submit-loading
                    class="btn-sm w--20 me-2 button-green-bg border-radius-10"
                    :form_id="_('slide-create-form')"
                    :fieldset_id="_('slide-create')"
                    :text="_('Save')"
                />
                <a href="{{ route('blog-index') }}" class="btn btn-light btn-sm w--20 align-self-end border-radius-10">Cancel</a>
            </div>
        </div>
    </fieldset>
</form>
@stop

@section('script')
<style>
    .ql-container.ql-snow {
        height: 600px;
    }
    .note-editor .note-toolbar .note-color-all .note-dropdown-menu,
    .note-popover .popover-content .note-color-all .note-dropdown-menu {
        min-width: 350px;
    }
</style>
<script src="{{ asset('assets/js/app/slide.js') }}"></script>
@stop
