@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Edit </span> News</h1>
@stop

@section('content')
<form novalidate class="bs-validate" id="frm-news-create" method="POST" action="{{ route('news-update', $news->id) }}">
    @csrf
    <fieldset id="fs-news-create">
        <div class="row mt-4">
            <div class="col-md-8 col-sm-10 col-12 mx-auto">
                <div class="mb-3 row">
                    <label for="title" class="col-sm-4 col-form-label">Topic Name<span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <input type="text"  class="form-control" id="title" name="title" value="{{ $news['title'] }}" required>
                    </div>
                </div>

                <div class="mb-8 row">
                    <label class="col-sm-4 col-form-label">News Text<span class="text-danger">*</span></label>
                    <div class="col-sm-8">
                        <div class="quill-editor"
                            data-ajax-url="_ajax/demo.summernote.php"
                            data-ajax-params="['action','upload']['param2','value2']"
                            data-textarea-name="body"
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
                            }'
                            required>
                            {!! $news['body'] !!}
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="isactive" class="col-sm-4 col-form-label">Status</label>
                    <div class="col-sm-8">
                        <label class="d-flex align-items-center mb-3">
                            <input class="d-none-cloaked" type="checkbox" name="isactive" value="1" @checked(old('isactive', $news['isactive'] == 'Y'))>
                            <i class="switch-icon"></i>
                        </label>
                    </div>
                </div>
                <hr/>
                <div>
                    <div class="col-12 text-center mt-4">
                        <x-button-submit-loading
                            class="btn-lg w--15 me-5"
                            :form_id="_('frm-news-create')"
                            :fieldset_id="_('fs-news-create')"
                            :text="_('Save')"
                        />
                        <a href="{{ route('news-index') }}" class="btn btn-secondary btn-lg w--15">Cancel</a>
                        <small id="user-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
</form>
@stop
