<form novalidate class="bs-validate" id="station-create-form" method="POST" action="{{ route('station-create') }}">
    @csrf
    <fieldset id="station-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w--80 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Add new station</h1>

                <div class="row">
                    <div class="col-6 px-4 border-end">
                        <div class="mb-3 row">
                            <label for="station-name" class="col-sm-4 col-form-label-sm text-start">Station Name* :</label>
                            <div class="col-sm-8">
                                <input type="text" required class="form-control form-control-sm" id="station-name" name="name" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="station-pier" class="col-sm-4 col-form-label-sm text-start">Station Pier :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="station-pier" name="pier" value="">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="station-nickname" class="col-sm-4 col-form-label-sm text-start">Station Nickname* :</label>
                            <div class="col-sm-5">
                                <input type="text" required class="form-control form-control-sm" id="station-nickname" name="nickname" value="">
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="station-info-from" class="col-sm-4 col-form-label-sm text-start">Master Info From :</label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-info-from" name="info_from">
                                    <option value="" selected>-- No Content --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="station-info-to" class="col-sm-4 col-form-label-sm text-start">Master Info To :</label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-info-to" name="info_to">
                                    <option value="" selected>-- No Content --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="station-shuttle-bus" class="col-sm-4 col-form-label-sm text-start">
                                Shuttle bus :
                                <label class="d-flex align-items-center mb-2">
                                    <input class="d-none-cloaked" type="checkbox" id="station-shuttle-bus-status" name="shuttle_status" value="1" checked>
                                    <i class="switch-icon switch-icon-primary"></i>
                                    <span class="px-2 user-select-none" id="station-shuttle-bus-checked">On</span>
                                </label>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-shuttle-bus" name="shuttle_bus">
                                    <option value="" selected disabled>-- Select --</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 row">
                            <label for="station-longtail-boat" class="col-sm-4 col-form-label-sm text-start">
                                Longtail boat :
                                <label class="d-flex align-items-center mb-2">
                                    <input class="d-none-cloaked" type="checkbox" id="station-longtail-boat-status" name="longtail_status" value="1" checked>
                                    <i class="switch-icon switch-icon-primary"></i>
                                    <span class="px-2 user-select-none" id="station-longtail-boat-checked">On</span>
                                </label>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-select form-select-sm" id="station-longtail-boat" name="longtail_boat">
                                    <option value="" selected disabled>-- Select --</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-6 px-4">
                        <div class="mb-3 row">
                            <label for="station-status" class="col-sm-4 col-form-label-sm text-start">Station Status :</label>
                            <div class="col-sm-5">
                                <label class="d-flex align-items-center mb-3">
                                    <input class="d-none-cloaked" type="checkbox" id="station-status" name="isactive" value="1" checked>
                                    <i class="switch-icon switch-icon-primary"></i>
                                    <span class="px-3 user-select-none" id="station-status-checked">On</span>
                                </label>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Section* :</label>
                            <div class="col-sm-8">
                                <select required class="form-select form-select-sm" id="station-section" name="section">
                                    <option value="" selected disabled>-- Select --</option>
                                    @foreach($sections as $section)
                                        <option value="{{ $section['id'] }}">{{ $section['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="station-sort" class="col-sm-4 col-form-label-sm text-start">Sort* :</label>
                            <div class="col-sm-8">
                                <select required class="form-select form-select-sm" id="station-sort" name="sort">
                                    <option value="" selected disabled>-- Select --</option>
                                    @for($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="extra-service" class="col-sm-4 col-form-label-sm text-start">Extra Service :</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm input-suggest" id="extra-service" value=""
                                    placeholder="Product Search..."
                                    data-name="product_id[]"
                                    data-input-suggest-mode="append"
                                    data-input-suggest-typing-delay="300"
                                    data-input-suggest-typing-min-char="3"
                                    data-input-suggest-append-container="#inputSuggestContainer"
                                    data-input-suggest-ajax-url="_ajax/input_suggest_append.json"
                                    data-input-suggest-ajax-method="GET"
                                    data-input-suggest-ajax-action="input_search"
                                    data-input-suggest-ajax-limit="20">

                                <div id="inputSuggestContainer" class="sortable">
                                    <!-- Preadded -->
                                    <div class="p-1 clearfix rounded">
                                        <a href="#" class="item-suggest-append-remove fi fi-close fs-6 float-start text-decoration-none"></a>
                                        <span>Preadded Example</span>
                                        <input type="hidden" name="product_id[]" value="1">
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center mt-4">
                        <x-button-submit-loading 
                            class="btn-lg w--10 me-5"
                            :form_id="_('station-create-form')"
                            :fieldset_id="_('station-create')"
                            :text="_('Add')"
                        />
                        <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-create">Cancel</button>
                        <small id="user-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>

            </div>
        </div>
    </fieldset>
</form>