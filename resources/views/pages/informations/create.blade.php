@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id=""><span class="text-main-color-2">Add new</span> Information</h1> 
@stop

@section('content') 
<form novalidate class="bs-validate" id="frm-information-create" method="POST" action="{{ route('information-store') }}">
    @csrf
    <fieldset id="fs-information-create">
    <div class="row mt-4"> 
        <div class="col-md-8 col-sm-10 col-12">
            <div class="mb-3 row">
                <label for="title" class="col-sm-4 col-form-label">Title<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text"  class="form-control" id="title" name="title" value="{{ old('title') }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="position" class="col-sm-4 col-form-label">Position<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                <select class="form-select form-select-sm" aria-label="" name="position" id="position">
                    <option selected value="TERM">Terms & Conditions</option>
                </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="body" class="col-sm-4 col-form-label">Text/Message<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
                </div>
            </div>
            <hr/>
            <div>
                <div class="col-12 text-center mt-4">
                    <x-button-submit-loading 
                                        class="btn-lg w--10 me-5"
                                        :form_id="_('frm-information-create')"
                                        :fieldset_id="_('fs-information-create')"
                                        :text="_('Add')"
                                    />
                    <a href="{{ route('information-index') }}" class="btn btn-secondary btn-lg w--10">Cancel</a>
                    <small id="" class="text-danger mt-3"></small>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
</form>
@stop