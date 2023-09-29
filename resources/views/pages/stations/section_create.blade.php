<form novalidate class="bs-validate" id="section-create-form" method="POST" action="{{ route('section-create') }}">
    @csrf
    <fieldset id="section-create">
        <div class="row bg-transparent mt-5">
            <div class="col-sm-4 mx-auto">
                <h1 class="fw-bold text-second-color mb-4">Add new section</h1>

                <div class="mb-4 row">
                    <label for="section-create-name" class="col-sm-3 col-form-label-sm text-start">Section* :</label>
                    <div class="col-sm-9">
                        <input type="text" required class="form-control form-control-sm" id="section-create-name" name="name" value="">
                    </div>
                </div>

                <div class="text-center mt-5">
                    <x-button-submit-loading 
                        class="btn-lg w--30 me-5"
                        :form_id="_('section-create-form')"
                        :fieldset_id="_('section-create')"
                        :text="_('Add')"
                    />
                    <button type="button" class="btn btn-secondary btn-lg w--30" id="btn-section-cancel-create">Cancel</button>
                    <small id="section-create-error-notice" class="text-danger mt-3"></small>
                </div>
            </div>

            <div class="col-sm-4 mx-auto">
                <div class="bg-light p-4 rounded">
                    <label class="col-sm-3 col-form-label-sm text-start text-second-color fw-bold">Section list</label>
                    <ul>
                        @foreach($sections as $index => $section)
                            <li>{{ $section['name'] }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </fieldset>
</form>