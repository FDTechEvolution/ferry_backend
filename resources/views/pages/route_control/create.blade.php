<form novalidate class="bs-validate" id="meal-create-form" method="POST" action="{{ route('meal-create') }}" enctype="multipart/form-data">
    @csrf
    <fieldset id="meal-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-12 w-75 mx-auto">

                <div class="row">
                    <div class="col-12 px-4">
                        <h1 class="fw-bold text-main-color-2 mb-4">Add new Route</h1>

                        <div class="mb-4 w-75 row">
                            <label class="col-sm-3 col-form-label-sm text-start fw-bold">Station From* :</label>
                            <div class="col-sm-9">
                                <select class="form-select form-select-sm" name="station_from">
                                    <option value="">--- Choose ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-4 w-75 row">
                            <label class="col-sm-3 col-form-label-sm text-start fw-bold">Station To* :</label>
                            <div class="col-sm-9">
                                <select class="form-select form-select-sm" name="station_to">
                                    <option value="">--- Choose ---</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-0 pb-0 row">
                            <label class="col-sm-4 col-form-label-sm text-start">More detail</label>
                        </div>
                        <div class="mb-2 row">
                            <div class="col-2">
                                <label class="col-form-label-sm text-start fw-bold">Depart Time</label>
                                <input type="text" name="depart_time" class="form-control form-control-sm datepicker"
                                    data-show-weeks="true"
                                    data-today-highlight="true"
                                    data-today-btn="true"
                                    data-clear-btn="false"
                                    data-autoclose="true"
                                    data-date-start="today"
                                    data-format="MM/DD/YYYY">
                            </div>
                            <div class="col-2">
                                <label class="col-form-label-sm text-start fw-bold">Arrive Time</label>
                                <input type="text" name="arrive_time" class="form-control form-control-sm datepicker"
                                    data-show-weeks="true"
                                    data-today-highlight="true"
                                    data-today-btn="true"
                                    data-clear-btn="false"
                                    data-autoclose="true"
                                    data-date-start="today"
                                    data-format="MM/DD/YYYY">
                            </div>
                            <div class="col-2">
                                <label for="regular-price" class="col-form-label-sm text-start fw-bold">Regular Price</label>
                                <input type="number" class="form-control form-control-sm" id="regular-price" name="regular_price">
                            </div>
                            <div class="col-2">
                                <label for="child-price" class="col-form-label-sm text-start fw-bold">Child</label>
                                <input type="number" class="form-control form-control-sm" id="child-price" name="child_price">
                            </div>
                            <div class="col-2">
                                <label for="extra" class="col-form-label-sm text-start fw-bold">Extra</label>
                                <select class="form-control form-control-sm" id="extra" name="extra">

                                </select>
                            </div>
                            <div class="col-2">
                                <label for="infant" class="col-form-label-sm text-start fw-bold">Infant</label>
                                <select class="form-control form-control-sm" id="infant" name="infant">
                                    
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <label for="icon" class="col-form-label-sm text-start fw-bold">Icon</label>
                                <select class="form-control form-control-sm" id="icon" name="icon">
                                    
                                </select>
                            </div>
                            <div class="col-9 show-icon">
                                <label for="icon" class="col-form-label-sm text-start fw-bold"></label>
                                <p class="mt-4">Show icon....</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</div>