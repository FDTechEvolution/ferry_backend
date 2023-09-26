<form novalidate class="bs-validate" id="station-create-form" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="row bg-transparent mt-5">
        <div class="col-sm-12 w-75 mx-auto">
            <h1 class="fw-bold text-second-color mb-4">Add new station</h1>

            <div class="row">
                <div class="col-6">
                    <div class="mb-3 row">
                        <label for="station-name" class="col-sm-4 col-form-label-sm text-start">Station Name*</label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control form-control-sm" id="station-name" name="name" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-pier" class="col-sm-4 col-form-label-sm text-start">Station Pier</label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control form-control-sm" id="station-pier" name="pier" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-nickname" class="col-sm-4 col-form-label-sm text-start">Station Nickname*</label>
                        <div class="col-sm-5">
                            <input type="text" required class="form-control form-control-sm" id="station-nickname" name="nickname" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-status" class="col-sm-4 col-form-label-sm text-start">Station Status</label>
                        <div class="col-sm-5">
                            <label class="d-flex align-items-center mb-3">
                                <input class="d-none-cloaked" type="checkbox" id="station-status" name="switch-checkbox" name="status" value="1" checked>
                                <i class="switch-icon switch-icon-primary"></i>
                                <span class="px-3 user-select-none" id="station-status-checked">On</span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Sort*</label>
                        <div class="col-sm-5">
                            <select class="form-select" id="station-sort" name="sort">
                                <option value="" selected disabled>-- Select --</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-info-from" class="col-sm-4 col-form-label-sm text-start">Master Info From</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" id="station-info-from" name="info_from" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-info-to" class="col-sm-4 col-form-label-sm text-start">Master Info To</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" id="station-info-to" name="info_to" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-shuttle-bus" class="col-sm-4 col-form-label-sm text-start">Shuttle bus</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" id="station-shuttle-bus" name="shuttle_bus" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="station-longtail-boat" class="col-sm-4 col-form-label-sm text-start">Longtail boat</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" id="station-longtail-boat" name="longtail_boat" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-6">

                </div>

                <div class="col-12 text-center mt-4">
                    <x-button-orange :type="_('submit')" :text="_('Add')" class="btn-lg w--10 me-2" />
                    <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-create">Cancel</button>
                    <small id="user-create-error-notice" class="text-danger mt-3"></small>
                </div>
            </div>

        </div>
    </div>
</form>