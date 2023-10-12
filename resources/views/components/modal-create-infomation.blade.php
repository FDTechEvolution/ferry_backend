<div class="modal fade" id="create-infomation" style="z-index: 1061;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new station infomation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="mb-3 row">
                            <label for="station-info-name" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                            <div class="col-sm-8">
                                <input required type="text" class="form-control form-control-sm" id="station-info-name" name="name">
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label-sm text-start">Detail* :</label>
                            <div class="col-sm-8">
                                <div class="quill-editor"
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
                        <x-button-submit-loading 
                            class="btn-lg w--10 me-5"
                            :form_id="_('station-info-create-form')"
                            :fieldset_id="_('station-info-create')"
                            :text="_('Add')"
                        />
                        <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-create">Cancel</button>
                        <small id="station-info-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>