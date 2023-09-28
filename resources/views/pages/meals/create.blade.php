<form novalidate class="bs-validate" id="meal-create-form" method="POST" action="{{ route('meal-create') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="meal-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w-75 mx-auto">

                <div class="row">
                    <div class="col-7 px-4">
                        <h1 class="fw-bold text-second-color mb-4"><span>Add new Meal</h1>

                        <div class="mb-4 row">
                            <label for="meal-name" class="col-sm-3 col-form-label-sm text-start">Meal Name* :</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control form-control-sm" id="meal-name" name="name" value="">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-price" class="col-sm-3 col-form-label-sm text-start">Price* :</label>
                            <div class="col-sm-9">
                                <input type="number" required class="form-control form-control-sm w--40" id="meal-price" name="price" value="">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Detail Meal :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control form-control-sm" id="meal-detail" name="detail" row="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Icon :</label>
                            <div class="col-sm-9">
                                <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border" style="background-color: #fff;">
                                    <input type="file" name="file_icon"
                                        data-file-ext="jpeg, jpg, png, gif, svg"
                                        data-file-max-size-kb-per-file="1024"
                                        data-file-max-size-kb-total="1024"
                                        data-file-max-total-files="100"
                                        data-file-ext-err-msg="Allowed:"
                                        data-file-exist-err-msg="File already exists:"
                                        data-file-size-err-item-msg="File too large!"
                                        data-file-size-err-total-msg="Total allowed size exceeded!"
                                        data-file-size-err-max-msg="Maximum allowed files:"
                                        data-file-toast-position="bottom-center"
                                        data-file-preview-container=".js-file-input-container-multiple-list-static"
                                        data-file-preview-img-height="80"
                                        data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove"
                                        data-file-preview-show-info="true"
                                        data-file-preview-list-type="list"
                                        class="custom-file-input absolute-full cursor-pointer"
                                        title="jpeg, jpg, png, gif, svg (1MB)" data-bs-toggle="tooltip"
                                    >

                                    <span class="group-icon cursor-pointer">
                                        <i class="fi fi-arrow-upload"></i>
                                        <i class="fi fi-circle-spin fi-spin"></i>
                                    </span>

                                    <span class="cursor-pointer">Upload image</span>
                                </label>

                                <div class="row">
                                    <div class="col-10">
                                        <div class="js-file-input-container-multiple-list-static position-relative hide-empty mt-2"><!-- container --></div>
                                    </div>
                                    <div class="col-2 text-center">
                                        <!-- remove button -->
                                        <a href="#" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove hide btn btn-secondary mt-4 text-center">
                                            <i class="fi fi-close mx-auto"></i>
                                        </a>
                                    </div>
                                </div>
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
                            </div>
                        </div>
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

                    <div class="col-12 text-center mt-5">
                        <x-button-submit-loading 
                            class="btn-lg w--20 me-2"
                            :form_id="_('meal-create-form')"
                            :fieldset_id="_('meal-update')"
                            :text="_('Add')"
                        />
                        <button type="button" class="btn btn-secondary btn-lg w--20" id="btn-cancel-create">Cancel</button>
                        <small id="user-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>

            </div>
        </div>
    </fieldset>
</form>