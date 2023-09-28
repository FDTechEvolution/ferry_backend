<form novalidate class="bs-validate" id="section-create-form" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <fieldset id="section-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w-75 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Add new section</h1>

                <div class="mb-4 row">
                    <label for="section-name" class="col-sm-3 col-form-label-sm text-start">Section* :</label>
                    <div class="col-sm-9">
                        <input type="text" required class="form-control form-control-sm" id="section-name" name="name" value="">
                    </div>
                </div>
            </div>

            <div class="col-12 text-center mt-5">
                <x-button-submit-loading 
                    class="btn-lg w--20 me-2"
                    :form_id="_('section-create-form')"
                    :fieldset_id="_('section-created')"
                    :text="_('Add')"
                />
                <button type="button" class="btn btn-secondary btn-lg w--20" id="btn-section-cancel-create">Cancel</button>
                <small id="section-create-error-notice" class="text-danger mt-3"></small>
            </div>
        </div>
    </fieldset>
</div>