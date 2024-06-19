@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0 text-main-color-2" style="width: 400px;">Media <small class="fs-4">/ Billboard / Edit</small></h1>
        </div>
    </div>
@stop

@section('content')
<form class="bs-validate" id="slide-create-form" method="POST" action="{{ route('billboard-update') }}">
    @csrf
    <fieldset id="slide-create">
        <div class="mb-5 mb-lg-4 row">
            <div class="col-12 col-lg-12">
                <div class="row mb-4">
                    <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Title<span class="text-danger">*</span></label>
                    <div class="col-sm-12 col-lg-12">
                        <input required type="text" class="form-control form-control-sm" name="title" value="{{ $billboard->title }}">
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 ps-lg-3 order-lg-2">
                <div class="row mb-4">
                    <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Bacground Color</label>
                    <div class="col-sm-12 col-lg-12">
                        <input type="color" name="color" class="form-control form-control-color d-inline-block" id="background-color-select" value="{{ $billboard->color }}" title="Choose background color">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <h5>Icon</h5>
                        <div class="checkgroup" data-checkgroup-checkbox-single="true"
                            data-checkgroup-ajax-toast-position="top-center">
                            @foreach ($icons as $index => $icon)
                                <div class="form-check">
                                    <input class="form-check-input form-check-input-primary" type="checkbox" name="icon"
                                        value="{{$index}}" id="icon-{{$index}}" @checked($index==$billboard->icon) @required(true)>
                                    <label class="form-check-label" for="icon-{{$index}}">
                                        <div class="avatar avatar-xs" style="background-image:url({{asset($icon)}})"></div>
                                    </label>
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                <hr/>
                <div class="mb-4 row">
                    <label class="col-sm-12 col-lg-12 col-form-label-sm fw-bold">Sort </label>
                    <div class="col-sm-12 col-lg-12">
                        <select class="form-select form-slect-sm" name="sort">
                            @for ($sort = 1; $sort <= $max_sort; $sort++)
                                <option value="{{ $sort }}" @selected($sort == $billboard->sort)>{{ $sort }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9 pe-lg-3 order-lg-1">
                <label class="col-sm-12 col-lg-12 col-form-label-sm text-start fw-bold">Content</label>
                <div class="col-sm-12 col-lg-12 mb-3 mb-lg-0">
                    <div class="quill-editor editor-edit"
                        data-textarea-name="description"
                        data-max-length="5"
                        data-quill-config='{
                            "modules": {
                                "toolbar": [
                                    [{ "header": [2, 3, 4, 5, 6, false] }],
                                    ["bold", "italic", "underline"],
                                    [{ "color": [] }],
                                    ["blockquote"],
                                    [{ "align": [] }],
                                    ["clean"]
                                ]
                            },

                            "placeholder": "Content here..."
                        }'
                        onKeyup="counterWord(this)"
                        style="background-color: {{ $billboard->color }}">
                        {!! $billboard->description !!}
                    </div>
                </div>
                <p class="text-danger smaller">Max <small class="character-count text-danger smaller"></small> character</p>
            </div>
        </div>
        <div class="mb-2 mt-3 row">
            <div class="col-sm-12 col-lg-6 offset-lg-6 justify-content-end d-flex align-items-end">
                <x-button-submit-loading
                    class="btn-sm w--20 me-2 button-green-bg border-radius-10"
                    :form_id="_('slide-create-form')"
                    :fieldset_id="_('slide-create')"
                    :text="_('Update')"
                />
                <a href="{{ route('billboard-index') }}" class="btn btn-light btn-sm w--20 align-self-end border-radius-10">Cancel</a>
            </div>
        </div>
        <input type="hidden" name="billboard_id" value="{{ $billboard->id }}">
    </fieldset>
</form>
@stop

@section('script')
<style>
    .ql-container.ql-snow {
        height: 300px;
    }
</style>
<script src="{{ asset('assets/js/app/billboard.js') }}"></script>
@stop
