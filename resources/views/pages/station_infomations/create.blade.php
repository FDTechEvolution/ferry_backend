<form novalidate class="bs-validate" id="station-info-create-form" method="POST" action="{{ route('station-info-create') }}">
    @csrf
    <fieldset id="station-info-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w--80 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Add new station infomation</h1>
            
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
                        
                        <div class="mb-3 row mt-6 pt-3">
                            <label for="station-select-create" class="col-sm-2 col-form-label-sm text-start">Station :</label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-select-create" name="station_id">
                                    <option value="" selected>-- No Station --</option>
                                    @foreach($stations as $station)
                                        <option value="{{ $station->id }}">{{ $station->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="station-master-create" class="col-sm-2 col-form-label-sm text-start">Master Info :</label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-master-create" name="master_info" disabled>
                                    <option value="" selected disabled>-- Select --</option>
                                    <option value="from">From</option>
                                    <option value="to">To</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-center">
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
        </div>
    </fieldset>
</form>