<form novalidate class="bs-validate" id="station-info-edit-form" method="POST" action="{{ route('station-info-update') }}">
    @csrf
    <fieldset id="station-info-edit">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w--80 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Edit station infomation</h1>
            
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="mb-3 row">
                            <label for="edit-station-info-name" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                            <div class="col-sm-8">
                                <input required type="text" class="form-control form-control-sm" id="edit-station-info-name" name="name">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="edit-station-info-type" class="col-sm-2 col-form-label-sm text-start">Type* :</label>
                            <div class="col-sm-8">
                                <select required class="form-select form-select-sm" id="edit-station-info-type" name="type">
                                    <option value="" selected disabled>-- Select --</option>
                                    <option value="from">Master Info From</option>
                                    <option value="to">Master Info To</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label-sm text-start">Detail* :</label>
                            <div class="col-sm-8">
                                <div class="quill-editor"
                                    id="station-info-edit-detail"
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

                                        "placeholder": "Type here..."
                                    }'>
                                    <p></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-6">
                        <input type="hidden" id="station-info-edit-id" name="station_info_id">
                        <x-button-submit-loading 
                            class="btn-lg w--10 me-5"
                            :form_id="_('station-info-edit-form')"
                            :fieldset_id="_('station-info-edit')"
                            :text="_('Edit')"
                        />
                        <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-edit">Cancel</button>
                        <small id="station-info-edit-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>