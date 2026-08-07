<form novalidate class="bs-validate meal-form" id="meal-create-form" method="POST" action="{{ route('meal-create') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="meal-create">

        {{-- Basic info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <div class="meal-section-title">Meal info</div>

                <div class="row g-3">
                    <div class="col-12 col-md-8">
                        <div class="form-floating">
                            <input type="text" required class="form-control" id="meal-name" name="name" value="{{ old('name') }}" placeholder="Meal Name">
                            <label for="meal-name">Meal Name <span class="text-danger">*</span></label>
                        </div>
                    </div>
                    <div class="col-12 col-md-4">
                        <div class="form-floating">
                            <input type="number" required class="form-control" id="meal-price" name="price" value="{{ old('price') }}" min="0" step="1" placeholder="Price">
                            <label for="meal-price">Price (฿) <span class="text-danger">*</span></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Media --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <div class="meal-section-title">Media</div>

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
                    >
                    <span class="group-icon cursor-pointer">
                        <i class="fi fi-arrow-upload"></i>
                        <i class="fi fi-circle-spin fi-spin"></i>
                    </span>
                    <span class="cursor-pointer">Upload image</span>
                </label>

                <div class="row mt-2">
                    <div class="col-10">
                        <div class="js-file-input-container-multiple-list-static-picture position-relative hide-empty">
                            <!-- container -->
                        </div>
                    </div>
                    <div class="col-2 text-center">
                        <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-picture hide btn btn-secondary btn-sm text-center">
                            <i class="fi fi-close mx-auto"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-4">
                <div class="meal-section-title">Details</div>
                <textarea name="detail" class="w-100" id="meal-detail">{{ old('detail') }}</textarea>
            </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex flex-wrap align-items-center justify-content-end gap-2 mb-4">
            <a href="{{ route('meals-index') }}" class="btn btn-outline-secondary px-4" id="btn-cancel-create">Cancel</a>
            <x-button-submit-loading
                class="px-4"
                :form_id="_('meal-create-form')"
                :fieldset_id="_('meal-create')"
                :text="_('Add')"
            />
            <small id="user-create-error-notice" class="text-danger w-100 text-end"></small>
        </div>

    </fieldset>
</form>
