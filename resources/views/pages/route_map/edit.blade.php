<div class="card-body">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light">Edit Details</h2>
        </div>
    </div>
    <form novalidate class="bs-validate" id="route-map-edit-form" method="POST" action="{{ route('route-map-update') }}" enctype="multipart/form-data">
        @csrf
        <fieldset id="route-map-edit">
            <div class="mb-4 row">
                <div class="col-6">
                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label-sm text-start text-light fw-bold">Picture Full* :</label>
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
                                    onChange="getImageUpload('current-image')"
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
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" onClick="restoreCurrentImageByUpload('current-image')" id="remove-picture-edit" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row d-none" id="current-image">
                                <div class="col-12">
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
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label-sm text-start text-light fw-bold">Picture Banner :</label>
                        <div class="col-sm-9">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                <input type="file" name="file_banner"
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
                                    data-file-preview-container=".js-file-input-container-multiple-list-static-banner"
                                    data-file-preview-img-height="80"
                                    data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-banner"
                                    data-file-preview-show-info="true"
                                    data-file-preview-list-type="list"
                                    class="custom-file-input absolute-full cursor-pointer"
                                    title="jpeg, jpg, png, gif (2MB) [size : 1200 x 434 px]" data-bs-toggle="tooltip"
                                    onChange="getImageUpload('current-banner')"
                                >

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div class="js-file-input-container-multiple-list-static-banner position-relative hide-empty mt-2"><!-- container --></div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" onClick="restoreCurrentImageByUpload('current-banner')" id="remove-banner-edit" class="js-file-input-btn-multiple-list-static-remove-banner hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row d-none" id="current-banner">
                                <div class="col-10">
                                    <div class="position-relative hide-empty mt-2">
                                        <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                            <div class="position-relative d-inline-block bg-cover" id="edit-banner-cover">
                                                <img src="" id="edit-banner-src" class="animate-bouncein mw-100">
                                            </div>
                                            <div class="flex-fill d-flex min-w-0 align-items-center" style="padding-left:15px;padding-right:15px;">
                                                <span class="text-truncate d-block line-height-1">Current picture banner</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="JavaScript:void(0);" title="Delete Images" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-banner', 'has-banner', 'restore-banner')" class="btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                                <input type="hidden" name="_banner" id="has-banner" value="0">
                            </div>
                            <svg id="restore-banner" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-banner', 'has-banner', 'restore-banner')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">  
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>  
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label-sm text-start text-light fw-bold">Picture Thumb :</label>
                        <div class="col-sm-9">
                            <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                <input type="file" name="file_thumb"
                                    data-file-ext="jepg, jpg, png, gif"
                                    data-file-max-size-kb-per-file="1024"
                                    data-file-max-size-kb-total="1024"
                                    data-file-max-total-files="100"
                                    data-file-ext-err-msg="Allowed:"
                                    data-file-exist-err-msg="File already exists:"
                                    data-file-size-err-item-msg="File too large!"
                                    data-file-size-err-total-msg="Total allowed size exceeded!"
                                    data-file-size-err-max-msg="Maximum allowed files:"
                                    data-file-toast-position="bottom-center"
                                    data-file-preview-container=".js-file-input-container-multiple-list-static-thumb"
                                    data-file-preview-img-height="80"
                                    data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-thumb"
                                    data-file-preview-show-info="true"
                                    data-file-preview-list-type="list"
                                    class="custom-file-input absolute-full cursor-pointer"
                                    title="jpeg, jpg, png, gif (1MB) [size : 800 x 500 px]" data-bs-toggle="tooltip"
                                    onChange="getImageUpload('current-thumb')"
                                >

                                <span class="group-icon cursor-pointer">
                                    <i class="fi fi-arrow-upload"></i>
                                    <i class="fi fi-circle-spin fi-spin"></i>
                                </span>

                                <span class="cursor-pointer">Upload image</span>
                            </label>

                            <div class="row">
                                <div class="col-10">
                                    <div class="js-file-input-container-multiple-list-static-thumb position-relative hide-empty mt-2"><!-- container --></div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" onClick="restoreCurrentImageByUpload('current-thumb')" id="remove-thumb-edit" class="js-file-input-btn-multiple-list-static-remove-thumb hide btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="row d-none" id="current-thumb">
                                <div class="col-10">
                                    <div class="position-relative hide-empty mt-2">
                                        <div class="d-flex clearfix position-relative show-hover-container shadow-md mb-2 rounded">
                                            <div class="position-relative d-inline-block bg-cover" id="edit-thumb-cover">
                                                <img src="" id="edit-thumb-src" class="animate-bouncein mw-100">
                                            </div>
                                            <div class="flex-fill d-flex min-w-0 align-items-center" style="padding-left:15px;padding-right:15px;">
                                                <span class="text-truncate d-block line-height-1">Current picture thumb</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2 text-center">
                                    <!-- remove button -->
                                    <a href="JavaScript:void(0);" title="Delete Images" data-bs-toggle="tooltip" onClick="deleteCurrentImage('current-thumb', 'has-thumb', 'restore-thumb')" class="btn btn-secondary mt-4 text-center">
                                        <i class="fi fi-close mx-auto"></i>
                                    </a>
                                </div>
                                <input type="hidden" name="_thumb" id="has-thumb" value="0">
                            </div>
                            <svg id="restore-thumb" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-thumb', 'has-thumb', 'restore-thumb')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">  
                                <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>  
                                <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label-sm text-end text-light fw-bold">Detail :</label>
                        <div class="col-9">
                            <textarea class="form-control" rows="2" id="route-map-detail-edit" name="detail"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-3 col-form-label-sm text-end text-light fw-bold">Sort :</label>
                        <div class="col-4">
                            <input type="number" class="form-control form-control-sm text-center" id="route-map-sort-edit" name="sort">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mb-2 row">
                <div class="col-12 justify-content-end d-flex align-items-end">
                    <x-button-submit-loading 
                        class="btn-sm w--10 me-2 button-green-bg border-radius-10"
                        :form_id="_('route-map-edit-form')"
                        :fieldset_id="_('route-map-edit')"
                        :text="_('Update')"
                    />
                    <button type="button" id="btn-cancel-route-map-edit" class="btn btn-light btn-sm w--10 align-self-end border-radius-10">Cancel</button>
                    <input type="hidden" name="route_map_id" id="route-map-id-edit" value="">
                </div>
            </div>
        </fieldset>
    </form>
</div>