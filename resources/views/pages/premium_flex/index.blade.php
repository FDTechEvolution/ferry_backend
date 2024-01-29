@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0 text-main-color-2" style="width: 340px;">Premium Flex</h1>
        </div>
    </div>
@stop

@section('content')
<form class="bs-validate" id="pmf-create-form" method="POST" action="{{ route('pmf-update') }}">
    @csrf
    <fieldset id="pmf-create">
        <div class="row">
            <div class="col-6">
                <div class="card mt-3">
                    <div class="card-body">
                        <input required type="text" class="form-control form-control-sm" name="ol_title" value="{{ $pmf[0]->title }}">
                        <br />
                        <div class="quill-editor"
                            data-textarea-name="ol_body"
                            data-max-length="5"
                            data-quill-config='{
                                "modules": {
                                    "toolbar": [
                                        [{ "header": [2, 3, 4, 5, 6, false] }],
                                        ["bold", "italic", "underline"],
                                        [{ "color": [] }],
                                        ["blockquote"],
                                        [{ "list": "ordered" }, { "list": "bullet"}],
                                        [{ "align": [] }],
                                        ["clean"]
                                    ]
                                },

                                "placeholder": "Content here..."
                            }' required>
                            {!! $pmf[0]->body !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card mt-3">
                    <div class="card-body">
                        <input required type="text" class="form-control form-control-sm" name="pmf_title" value="{{ $pmf[1]->title }}">
                        <br />
                        <div class="quill-editor"
                            data-textarea-name="pmf_body"
                            data-max-length="5"
                            data-quill-config='{
                                "modules": {
                                    "toolbar": [
                                        [{ "header": [2, 3, 4, 5, 6, false] }],
                                        ["bold", "italic", "underline"],
                                        [{ "color": [] }],
                                        ["blockquote"],
                                        [{ "list": "ordered" }, { "list": "bullet"}],
                                        [{ "align": [] }],
                                        ["clean"]
                                    ]
                                },

                                "placeholder": "Content here..."
                            }' required>
                            {!! $pmf[1]->body !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-end pt-3">
                <x-button-submit-loading
                    class="btn-sm w--10 me-2 button-green-bg border-radius-10"
                    :form_id="_('pmf-create-form')"
                    :fieldset_id="_('pmf-create')"
                    :text="_('Update')"
                />
            </div>
            <input type="hidden" name="ol_id" value="{{ $pmf[0]->id }}">
            <input type="hidden" name="pmf_id" value="{{ $pmf[1]->id }}">
        </div>
    </fieldset>
</form>
@stop

@section('script')
<style>
    .ql-editor {
        height: 300px;
    }
</style>
@stop
