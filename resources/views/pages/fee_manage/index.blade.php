@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="fee-manage-page-title">Fee Manage</h1>
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12 col-lg-12 mx-auto">
        <form novalidate class="bs-validate" id="fee-update-form" method="POST" action="{{ route('fee.update') }}">
            @csrf
            <fieldset id="fee-update">
                @foreach ($fee as $f)
                    <x-fee-manage-list
                        :fee="$f"
                    />
                @endforeach

                <div class="row btn-section">
                    <div class="col-12 text-end mt-4">
                        <x-button-submit-loading
                            class="btn-sm me-3"
                            :form_id="_('fee-update-form')"
                            :fieldset_id="_('fee-update')"
                            :text="_('Submit')"
                        />
                        <a href="{{ route('fee.index') }}" class="btn btn-danger border-radius-10 btn-sm">Reset</a>
                        <small id="user-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>
@stop

@section('script')

@stop
