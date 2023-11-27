@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id=""><span class="text-main-color-2">Edit</span> Information</h1>
@stop

@section('content')
    <div class="section mb-3">
        <form novalidate class="bs-validate" id="frm-information-update" method="POST"
            action="{{ route('information-update', $information->id) }}">
            @csrf
            <fieldset id="fs-information-update">
                <div class="row mt-4">
                    <div class="col-md-10 col-12 mx-auto px-4">
                        <div class="mb-3 row">
                            <label for="title" class="col-md-3 col-12 col-form-label">Title<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="title" name="title"
                                    value="{{ $information->title }}" required>
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="position" class="col-md-3 col-12 col-form-label">Position<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9 col-12">
                                <select class="form-select form-select-sm" aria-label="" name="position" id="position">
                                    <option value="">-- please select --</option>
                                    @foreach ($positions as $key => $position)
                                        <option value="{{ $key }}" @if($information->position==$key)@selected(true) @endif>{{ $position }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-3 row mb-6">
                            <label for="body" class="col-md-3 col-12 col-form-label">Text/Message<span
                                    class="text-danger">*</span></label>
                            <div class="col-md-9 col-12">
                                <div class="quill-editor w-100" data-ajax-url="_ajax/demo.summernote.php"
                                    data-ajax-params="['action','upload']['param2','value2']" data-textarea-name="body"
                                    data-quill-config='{
                                "modules": {
                                    "toolbar": [
                          
                                        ["bold", "italic", "underline", "strike"],
                                        [{ "color": [] }, { "background": [] }],
                                        [{ "script": "super" }, { "script": "sub" }],
                                        ["blockquote"],
                                        [{ "list": "ordered" }, { "list": "bullet"}, { "indent": "-1" }, { "indent": "+1" }],
                                        [{ "align": [] }]
                                       
                                    ]
                                },

                                "placeholder": "Type here..."
                            }'>
                                    <p>{!! $information->body !!}</p>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div>
                            <div class="col-12 text-center mt-4">
                                <x-button-submit-loading class="btn-lg w--15 me-5" :form_id="_('frm-information-update')" :fieldset_id="_('fs-information-update')"
                                    :text="_('Save')" />
                                <a href="{{ route('information-index') }}" class="btn btn-secondary btn-lg w--15">Cancel</a>
                                <small id="" class="text-danger mt-3"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
@stop
