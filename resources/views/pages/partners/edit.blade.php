@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id=""><span class="text-main-color-2">Add new</span> Partner</h1>
@stop

@section('content')
    <div class="section mb-3">

        <form novalidate class="bs-validate" id="frm-create" method="POST"
            action="{{ route('partner-update', ['partner' => $partner]) }}" enctype="multipart/form-data">
            @csrf
            <fieldset id="fs-create">
                <div class="row mt-4">
                    <div class="col-md-10 col-12 mx-auto px-4">
                        <div class="mb-3 row">
                            <label for="title" class="col-md-3 col-12 col-form-label">Name<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9 col-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ $partner['name'] }}" required>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <label for="title" class="col-md-3 col-12 col-form-label">Active</label>
                            <div class="col-12 col-md-7">
                                <div class="form-check mb-2">
                                    <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                                        id="isactive" name="isactive" @if ($partner['isactive'] == 'Y') checked @endif>
                                    <label class="form-check-label" for="isactive">
                                        Active.
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="title" class="col-md-3 col-12 col-form-label">Logo/Image</label>
                            <div class="col-md-9 col-12">
                                <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
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
                                @if (isset($partner->image->path))
                                    <div class="row">
                                        <div class="col-12 col-lg-4">
                                            <input type="hidden" name="isremoveimage" value="N" id="isremoveimage">
                                            <img src="{{ asset($partner->image->path) }}" class="w-100" alt=""
                                                id="box-current-image">
                                            Current Logo/Image <a href="javascript:void(0)" id="btn-remove-image"><i
                                                    class="fa-solid fa-trash"></i> Remove</a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>



                        <hr />
                        <div>
                            <div class="col-12 text-center mt-4">
                                <x-button-submit-loading class="btn-lg w--15 me-5" :form_id="_('frm-create')" :fieldset_id="_('fs-create')"
                                    :text="_('Save')" />
                                <a href="{{ route('partner-index') }}" class="btn btn-secondary btn-lg w--15">Cancel</a>
                                <small id="" class="text-danger mt-3"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@stop

@section('script')
<script>
    $(document).ready(function() {
        $('#btn-remove-image').on('click', function() {
            let isremoveimage = $('#isremoveimage').val();
            if (isremoveimage === 'N') {
                $('#isremoveimage').val('Y');
                $('#box-current-image').hide();
                $(this).text('Restore image');
            } else {
                $('#isremoveimage').val('N');
                $('#box-current-image').show();
                $(this).text('Remove');
            }

        });
    });
</script>
@stop
