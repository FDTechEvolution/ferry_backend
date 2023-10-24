<div class="card-body">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light">Edit Details</h2>
        </div>
    </div>
    <form novalidate class="bs-validate" id="time-table-update-form" method="POST" action="{{ route('time-table-update') }}" enctype="multipart/form-data">
        @csrf
        <fieldset id="time-table-update">
            <div class="mb-4 row">
                <label class="col-sm-1 col-form-label-sm text-start text-light fw-bold">Picture :</label>
                <div class="col-sm-5">
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
                            title="jpeg, jpg, png, gif (2MB) [size : 800 x 388 px]" data-bs-toggle="tooltip"
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
                            <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
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
                    <svg id="restore-image" title="Restore Images" data-bs-toggle="tooltip" onClick="restoreCurrentImage('current-image', 'has-image', 'restore-image')" width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-counterclockwise d-none cursor-pointer" viewBox="0 0 16 16">  
                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 1-4.546 2.914.5.5 0 0 0-.908-.417A6 6 0 1 0 8 2v1z"></path>  
                        <path d="M8 4.466V.534a.25.25 0 0 0-.41-.192L5.23 2.308a.25.25 0 0 0 0 .384l2.36 1.966A.25.25 0 0 0 8 4.466z"></path>
                    </svg>

                    <input type="hidden" name="_image" id="has-image" value="0">
                    <input type="hidden" name="_id" id="time-table-id-edit" value="">
                </div>

                <label class="col-sm-1 offset-1 col-form-label-sm text-end text-light fw-bold">Sort :</label>
                <div class="col-2">
                    <input type="number" class="form-control form-control-sm" id="time-table-sort-edit" name="sort">
                </div>
            </div>
            <div class="mb-2 row">
                <label class="col-sm-1 col-form-label-sm text-start text-light fw-bold">Detail :</label>
                <div class="col-5">
                    <textarea class="form-control" rows="2" name="detail" id="time-table-detail-edit"></textarea>
                </div>
                <div class="col-6 justify-content-end d-flex align-items-end">
                    <x-button-submit-loading 
                        class="btn-sm w--20 me-2 button-green-bg border-radius-10"
                        :form_id="_('time-table-update-form')"
                        :fieldset_id="_('time-table-update')"
                        :text="_('Update')"
                    />
                    <button type="button" class="btn btn-light btn-sm w--20 align-self-end border-radius-10" id="btn-cancel-time-table-edit">Cancel</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>