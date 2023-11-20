<div class="modal fade" id="create-longtail-boat" style="z-index: 1061;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new longtail boat</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12 px-4" id="longtail-boat-input">
                        <div class="mb-3 row">
                            <label for="longtail-boat-name" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="longtail-boat-name" name="name">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="longtail-boat-price" class="col-sm-2 col-form-label-sm text-start">Price* :</label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control form-control-sm" id="longtail-boat-price" name="price">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="longtail-boat-description" class="col-sm-2 col-form-label-sm text-start">Description :</label>
                            <div class="col-sm-8">
                                <textarea class="form-control form-control-sm" id="longtail-boat-description" name="description"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 px-4 text-center create-longtail-btn">
                        <x-button-green 
                            class="w--15 me-2 border-radius-10"
                            id="btn-longtail-boat-create"
                            :type="_('button')"
                            :text="_('Add')"
                        />
                        <button type="button" class="btn btn-secondary border-radius-10 w--15" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                    <div class="col-12 px-4 text-center edit-longtail-btn d-none">
                        <input type="hidden" id="longtail-boat-edit-ref" value="" disabled>
                        <x-button-green 
                            class="w--15 me-2 border-radius-10"
                            id="btn-longtail-boat-edit"
                            :type="_('button')"
                            :text="_('Edit')"
                        />
                        <button type="button" class="btn btn-secondary border-radius-10 w--15" id="btn-edit-longtail-cancel" data-bs-dismiss="modal" aria-label="Close">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>