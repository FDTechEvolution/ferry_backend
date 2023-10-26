@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Add new</span> Review</h1> 
@stop

@section('content') 
<form novalidate class="bs-validate" id="frm-review-create" method="POST" action="{{ route('review-store') }}">
    @csrf
    <fieldset id="fs-review-create">
    <div class="row mt-4"> 
        <div class="col-md-8 col-sm-10 col-12 mx-auto">
            <div class="mb-3 row">
                <label for="title" class="col-sm-4 col-form-label">Topic Name<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text"  class="form-control" id="title" name="title" value="{{ old('reviewname') }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="reviewname" class="col-sm-4 col-form-label">Writer<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <input type="text"  class="form-control" id="reviewname" name="reviewname" value="{{ old('reviewname') }}" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="rating" class="col-sm-4 col-form-label">
                    Rating 
                    <i class="fi fi-star-full text-warning"></i>
                    <i class="fi fi-star-full text-warning"></i>
                    <i class="fi fi-star-full text-warning"></i>
                    <i class="fi fi-star-full text-warning"></i>
                    <i class="fi fi-star-full text-warning"></i>
                    <span class="text-danger">*</span>
                </label>
                <div class="col-sm-8">
                    <input type="text"  class="form-control" id="rating" name="rating" value="5" required>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="body" class="col-sm-4 col-form-label">Review Text<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                    <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
                </div>
            </div>
            <hr/>
            <div>
                <div class="col-12 text-center mt-4">
                    <x-button-submit-loading 
                                        class="btn-lg w--10 me-5"
                                        :form_id="_('frm-review-create')"
                                        :fieldset_id="_('fs-review-create')"
                                        :text="_('Add')"
                                    />
                    <a href="{{ route('review-index') }}" class="btn btn-secondary btn-lg w--10">Cancel</a>
                    <small id="user-create-error-notice" class="text-danger mt-3"></small>
                </div>
            </div>
        </div>
    </div>
    </fieldset>
</form>
@stop