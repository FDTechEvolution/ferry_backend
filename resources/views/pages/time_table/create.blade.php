<div class="card-body">
    <div class="row">
        <div class="col-12">
            <h2 class="text-light">Add Details</h2>
        </div>
    </div>
    <form novalidate class="bs-validate" id="time-table-create-form" method="POST"
        action="{{ route('time-table-create') }}" enctype="multipart/form-data">
        @csrf
        <fieldset id="time-table-create">
            <div class="mb-4 row">
                <label class="col-sm-12 col-lg-1 col-form-label-sm text-start text-light fw-bold">Picture <strong class="">*</strong>:</label>
                <div class="col-sm-12 col-lg-5">
                    <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border"
                        style="background-color: #fff;">
                        <input type="file" name="file_picture" data-file-ext="jepg, jpg, png, gif"
                            data-file-max-size-kb-per-file="2048" data-file-max-size-kb-total="2048"
                            data-file-max-total-files="100" data-file-ext-err-msg="Allowed:"
                            data-file-exist-err-msg="File already exists:" data-file-size-err-item-msg="File too large!"
                            data-file-size-err-total-msg="Total allowed size exceeded!"
                            data-file-size-err-max-msg="Maximum allowed files:" data-file-toast-position="bottom-center"
                            data-file-preview-container=".js-file-input-container-multiple-list-static-picture"
                            data-file-preview-img-height="80"
                            data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-picture"
                            data-file-preview-show-info="true" data-file-preview-list-type="list"
                            class="custom-file-input absolute-full cursor-pointer"
                            title="jpeg, jpg, png, gif (2MB) [size : 800 x 388 px]" data-bs-toggle="tooltip" required>

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
                                <!-- container --></div>
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

                <label class="col-sm-12 col-lg-1 offset-lg-1 col-form-label-sm text-lg-end text-light fw-bold">Sort
                    :</label>
                <div class="col-sm-12 col-lg-2">
                    <input type="number" class="form-control form-control-sm text-center" name="sort">
                </div>
            </div>
            <div class="mb-2 row">
                <label class="col-sm-12 col-lg-1 col-form-label-sm text-start text-light fw-bold">Title :</label>
                <div class="col-sm-12 col-lg-5 mb-3 mb-lg-0">
                    <input class="form-control" name="title"></input>
                </div>
                <div class="col-sm-12 col-lg-6 justify-content-end d-flex align-items-end">
                    <x-button-submit-loading class="btn-sm w--20 me-2 button-green-bg border-radius-10"
                        :form_id="_('time-table-create-form')" :fieldset_id="_('time-table-create')" :text="_('Save')" />
                    <button type="reset" class="btn btn-light btn-sm w--20 align-self-end border-radius-10"
                        onClick="resetImage()">Reset</button>
                </div>
            </div>
        </fieldset>
    </form>
</div>
