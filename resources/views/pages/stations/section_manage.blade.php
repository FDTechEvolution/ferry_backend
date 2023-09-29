<div class="row bg-transparent mt-2">
    <div class="ms-5 mb-3">
        <button class="btn btn-secondary" id="btn-section-cancel-manage">< Back</button>
    </div>
    <div class="col-12 w--90 mx-auto">
        <div id="to-section-list">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="section-datatable" 
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-enable-col-sorting="false"
                    data-items-per-page="15"

                    data-enable-column-visibility="false"
                    data-enable-export="true"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th class="text-center w--5">#</th>
                            <th>name</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sections as $index => $section)
                            <tr class="text-center">
                                <td>{{ $index +1 }}</td>
                                <td id="section-name-{{ $index }}" class="text-start">{{ $section['name'] }}</td>
                                <td>
                                    <input type="hidden" name="section_id" id="section-id-{{ $index }}" value="{{ $section['id'] }}">
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-section-edit"
                                        onClick="updateSectionEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="route('section-delete', ['id' => $section['id']])"
                                        :message="_('Are you sure? Delete '. $section['name'] .'?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div id="to-section-edit" class="m-auto d-none">
            <form novalidate class="bs-validate" id="section-edit-form" method="POST" action="{{ route('section-update') }}">
                @csrf
                <fieldset id="section-edit">
                    <div class="row bg-transparent mt-5">
                        <div class="col-sm-6 mx-auto">
                            <h1 class="fw-bold text-second-color mb-4">Section edit</h1>

                            <div class="mb-4 row">
                                <label for="section-name-edit" class="col-sm-3 col-form-label-sm text-start">Section* :</label>
                                <div class="col-sm-9">
                                    <input type="text" required class="form-control form-control-sm" id="section-name-edit" name="name" value="">
                                </div>
                            </div>

                            <div class="text-center mt-5">
                                <x-button-submit-loading 
                                    class="btn-lg w--30 me-5"
                                    :form_id="_('section-edit-form')"
                                    :fieldset_id="_('section-edit')"
                                    :text="_('Edit')"
                                />
                                <button type="button" class="btn btn-secondary btn-lg w--30" id="btn-section-cancel-edit">Cancel</button>
                                <small id="section-edit-error-notice" class="text-danger mt-3"></small>
                            </div>
                        </div>
                        <input type="hidden" name="section_id" id="section-id-edit" value="">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>