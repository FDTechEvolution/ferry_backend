<form novalidate class="bs-validate" id="station-info-edit-form" method="POST" action="{{ route('station-info-update') }}">
    @csrf
    <fieldset id="station-info-edit">
        <div class="row bg-transparent mt-lg-5">
            <div class="col-sm-12 col-lg-9 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Edit station infomation</h1>
            
                <div class="row">
                    <div class="col-12 px-4">
                        <div class="mb-3 row">
                            <label for="edit-station-info-name" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                            <div class="col-sm-8">
                                <input required type="text" class="form-control form-control-sm" id="edit-station-info-name" name="name">
                            </div>
                        </div>

                        <!-- <div class="mb-3 row">
                            <label for="edit-station-info-type" class="col-sm-2 col-form-label-sm text-start">Type* :</label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="edit-station-info-type" name="type">
                                    <option value="" selected disabled>-- Select --</option>
                                    <option value="from">Master Info From</option>
                                    <option value="to">Master Info To</option>
                                </select>
                            </div>
                        </div> -->

                        <div class="mb-3 row">
                            <label class="col-sm-2 col-form-label-sm text-start">Detail* :</label>
                            <div class="col-sm-8" id="quill-editable">
                                <div id="station-info-edit-detail"></div>
                                <textarea class="d-none" id="edit-detail-textarea" name="detail"></textarea>
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