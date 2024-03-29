@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Add</span> Section</h1>
    <x-a-href-orange :text="_('Manage Section')" :href="route('section.index')" :target="_('_self')" class="ms-3 btn-sm w--15" />
@stop

@section('content')
    <div class="row mt-3">
        <div class="col-12 col-md-6">
            <form novalidate class="bs-validate" id="section-create-form" method="POST" action="{{ route('section.store') }}">
                @csrf
                <fieldset id="section-create">
                    <div class="row bg-transparent">
                        <div class="col-12">
                            <h1 class="fw-bold text-second-color mb-4">Add new section</h1>
                        </div>
                        <div class="col-12">
                            <div class="row mb-2">
                                <label for="section-create-name"
                                    class="col-12 col-md-3 col-form-label-sm text-start">Section*
                                    :</label>
                                <div class="col-12 col-md-9">
                                    <input type="text" required class="form-control form-control-sm"
                                        id="section-create-name" name="name" value="">
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12 text-center">
                                    <x-button-submit-loading class="btn-lg w--30 me-5" :form_id="_('section-create-form')" :fieldset_id="_('section-create')"
                                        :text="_('Add')" />
                                    <a href="{{ route('stations-index') }}"
                                        class="btn btn-secondary btn-lg w--30">Cancel</a>
                                    <small id="section-create-error-notice" class="text-danger mt-3"></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
        <div class="col-12 col-md-6">
            <div class="bg-light p-4 rounded">
                <label class="col-form-label-sm text-start text-second-color fw-bold">Section list</label>
                <ul>
                    @foreach ($sections as $index => $section)
                        <li>{{ $section['name'] }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop
