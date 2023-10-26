<form novalidate class="bs-validate" id="meal-create-form" method="POST" action="{{ route('meal-create') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="meal-create">
        <div class="row bg-transparent mt-lg-5">
            <div class="col-sm-12 col-lg-9 mx-auto">

                <div class="row">
                    <div class="col-sm-12 col-md-7 col-lg-7 px-4">
                        <h1 class="fw-bold text-second-color mb-4"><span>Add new Meal</h1>

                        <div class="mb-3 row">
                            <label for="meal-name" class="col-sm-3 col-form-label-sm text-start">Meal Name* :</label>
                            <div class="col-sm-9">
                                <input type="text" required class="form-control form-control-sm" id="meal-name" name="name" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="meal-price" class="col-sm-3 col-form-label-sm text-start">Price* :</label>
                            <div class="col-sm-9">
                                <input type="number" required class="form-control form-control-sm w--40" id="meal-price" name="price" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Detail Meal :</label>
                            <div class="col-sm-9">
                                <textarea class="form-control form-control-sm" id="meal-detail" name="detail" row="3"></textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="meal-detail" class="col-sm-3 col-form-label-sm text-start">Icon :</label>
                            <label class="col-sm-1 col-form-label-sm text-start pe-1">
                                <img src="../assets/images/no_image_icon.svg" id="icon-image-show" width="22" height="22">
                            </label>
                            <div class="col-sm-7 ps-0 pe-1">
                                <select class="form-select form-select-sm" id="meal-icon" name="icon">
                                    <option value="" selected>-- No icon --</option>
                                </select>
                            </div>
                            <label class="col-sm-1 col-form-label-sm text-end ps-1">
                                <a href="javascript:void(0)" class="text-dark me-1" data-bs-toggle="modal" data-bs-target="#upload-icon" onClick="showIconList()">
                                    <svg width="22px" height="22px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-slash-minus" viewBox="0 0 16 16">  
                                        <path d="m1.854 14.854 13-13a.5.5 0 0 0-.708-.708l-13 13a.5.5 0 0 0 .708.708ZM4 1a.5.5 0 0 1 .5.5v2h2a.5.5 0 0 1 0 1h-2v2a.5.5 0 0 1-1 0v-2h-2a.5.5 0 0 1 0-1h2v-2A.5.5 0 0 1 4 1Zm5 11a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5A.5.5 0 0 1 9 12Z"></path>
                                    </svg>
                                </a>
                            </label>
                        </div>
                        <div class="mb-3 row">
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
                                        <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary mt-4 text-center">
                                            <i class="fi fi-close mx-auto"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-5 col-lg-5">
                        <div class="bg-light p-4 rounded">
                            <p>View</p>
                            <div class="form-check ms-3 mb-3">
                                <input class="form-check-input form-check-input-primary" type="checkbox" name="route_station" value="1" id="route-station">
                                <label class="form-check-label" for="route-station">
                                    Route station
                                </label>
                            </div>
                            <div class="form-check ms-3 mb-3">
                                <input class="form-check-input form-check-input-primary" type="checkbox" name="main_menu" value="1" id="main-menu">
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
                            :fieldset_id="_('meal-created')"
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