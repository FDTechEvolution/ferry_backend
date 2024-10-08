<div class="card-body">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light">Add Details</h2>
        </div>
    </div>
    <form novalidate class="bs-validate" id="route-map-create-form" method="POST"
        action="{{ route('route-map-create') }}" enctype="multipart/form-data">
        @csrf
        <fieldset id="route-map-create">
            <div class="mb-4 row">
                <div class="col-sm-12 col-lg-6">
                    <div class="row mb-3">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm text-start text-light fw-bold">Picture Full*
                            :</label>
                        <div class="col-sm-12 col-lg-9">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                                style="background-color: #fff;">
                                <input type="file" name="file_picture" data-file-ext="jepg, jpg, png, gif"
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
                                    title="jpeg, jpg, png, gif (2MB)" data-bs-toggle="tooltip" required>

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div
                                        class="js-file-input-container-multiple-list-static-picture position-relative hide-empty mt-2">
                                        <!-- container -->
                                    </div>
                                </div>
                                <div class="col-2 text-center">
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

                    <div class="row mb-3">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm text-start text-light fw-bold">Picture Banner
                            :</label>
                        <div class="col-sm-12 col-lg-9">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                                style="background-color: #fff;">
                                <input type="file" name="file_banner" data-file-ext="jepg, jpg, png, gif"
                                    data-file-max-size-kb-per-file="2048" data-file-max-size-kb-total="2048"
                                    data-file-max-total-files="100" data-file-ext-err-msg="Allowed:"
                                    data-file-exist-err-msg="File already exists:"
                                    data-file-size-err-item-msg="File too large!"
                                    data-file-size-err-total-msg="Total allowed size exceeded!"
                                    data-file-size-err-max-msg="Maximum allowed files:"
                                    data-file-toast-position="bottom-center"
                                    data-file-preview-container=".js-file-input-container-multiple-list-static-banner"
                                    data-file-preview-img-height="80"
                                    data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-banner"
                                    data-file-preview-show-info="true" data-file-preview-list-type="list"
                                    class="custom-file-input absolute-full cursor-pointer"
                                    title="jpeg, jpg, png, gif (2MB) [size : 1200 x 434 px]" data-bs-toggle="tooltip">

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div
                                        class="js-file-input-container-multiple-list-static-banner position-relative hide-empty mt-2">
                                        <!-- container -->
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip"
                                        id="remove-banner"
                                        class="js-file-input-btn-multiple-list-static-remove-banner hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm text-start text-light fw-bold">Picture Thumb
                            :</label>
                        <div class="col-sm-12 col-lg-9">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                                style="background-color: #fff;">
                                <input type="file" name="file_thumb" data-file-ext="jepg, jpg, png, gif"
                                    data-file-max-size-kb-per-file="1024" data-file-max-size-kb-total="1024"
                                    data-file-max-total-files="100" data-file-ext-err-msg="Allowed:"
                                    data-file-exist-err-msg="File already exists:"
                                    data-file-size-err-item-msg="File too large!"
                                    data-file-size-err-total-msg="Total allowed size exceeded!"
                                    data-file-size-err-max-msg="Maximum allowed files:"
                                    data-file-toast-position="bottom-center"
                                    data-file-preview-container=".js-file-input-container-multiple-list-static-thumb"
                                    data-file-preview-img-height="80"
                                    data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-thumb"
                                    data-file-preview-show-info="true" data-file-preview-list-type="list"
                                    class="custom-file-input absolute-full cursor-pointer"
                                    title="jpeg, jpg, png, gif (1MB) [size : 800 x 500 px]" data-bs-toggle="tooltip">

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div
                                        class="js-file-input-container-multiple-list-static-thumb position-relative hide-empty mt-2">
                                        <!-- container -->
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip"
                                        id="remove-thumb"
                                        class="js-file-input-btn-multiple-list-static-remove-thumb hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-6">
                    <div class="mb-3 row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm text-lg-end text-light fw-bold">Detail
                            :</label>
                        <div class="col-sm-12 col-lg-9">
                            <textarea class="form-control" rows="2" name="detail"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-12 col-lg-3 col-form-label-sm text-lg-end text-light fw-bold">Sort
                            :</label>
                        <div class="col-sm-12 col-lg-4">
                            <input type="number" class="form-control form-control-sm text-center" name="sort">
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-2 row">
                <div class="col-12 justify-content-end d-flex align-items-end">
                    <x-button-submit-loading class="btn-sm w--10 me-2 button-green-bg border-radius-10"
                        :form_id="_('route-map-create-form')" :fieldset_id="_('route-map-create')" :text="_('Save')" />
                    <button type="reset" class="btn btn-light btn-sm w--10 align-self-end border-radius-10"
                        onClick="resetImage()">Reset</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>