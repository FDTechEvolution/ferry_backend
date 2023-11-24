@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2" id="fare-page-title">Fare manage</h1> 
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-12">
                        <h2 class="text-main-color-2 mb-1">Fare manage</h2>
                        <small class="fs-6">Last update : {{ date('d-m-Y', strtotime($updated_at)) }}</small>
                    </div>
                </div>
                <form novalidate class="bs-validate" id="fare-create-form" method="POST" action="{{ route('fare-update') }}">
                    @csrf
                    <fieldset id="fare-create">
                        <div class="row mb-3">
                            <div class="col-11 mx-auto">
                                <div class="row mb-2">
                                    <div class="col-md-3 offset-md-3 offset-lg-2 text-center fw-bold d-none d-md-block">
                                        Standard
                                    </div>
                                    <!-- <div class="col-md-3 text-center fw-bold d-none d-md-block">
                                        Online
                                    </div> -->
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 offset-md-3 offset-lg-2 d-none d-md-block">
                                        <div class="row">
                                            <div class="col-6 text-center">THB</div>
                                            <div class="col-6 text-center">%</div>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3 d-none d-md-block">
                                        <div class="row">
                                            <div class="col-6 text-center">THB</div>
                                            <div class="col-6 text-center">%</div>
                                        </div>
                                    </div> -->
                                </div>

                                @foreach($fares as $index => $fare)
                                    <div class="row mb-5 mb-md-2 space-on-resp">
                                        <div class="col-md-3 col-lg-2 d-flex align-items-center ps-0">
                                            <span class="text-on-resp">{{ $fare->name }}</span>
                                        </div>
                                        <div class="col-md-3 col-standard-{{ $index }} p-2 p-md-0">
                                            <div class="row">
                                                <div class="col-sm-12 fw-bold mb-2 mb-md-0 d-md-none">Standard</div>
                                                <div class="col-2 text-center d-md-none d-flex align-items-center">THB</div>
                                                <div class="col-10 col-md-6 text-center mb-2 mb-md-0">
                                                    <input type="number" name="standard_thb[]" class="form-control form-control-sm text-center" onKeyUp="getValueStandard(this, {{ $index }})" value="{{ $fare->standard_thb }}">
                                                </div>
                                                <div class="col-2 text-center d-md-none d-flex align-items-center">%</div>
                                                <div class="col-10 col-md-6 text-center">
                                                    <input type="number" name="standard_percent[]" class="form-control form-control-sm text-center" onKeyUp="getValueStandard(this, {{ $index }})" value="{{ $fare->standard_percent }}">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-3 col-online-{{ $index }}">
                                            <div class="row">
                                                <div class="col-sm-12 fw-bold mb-2 mb-md-0 d-md-none">Online</div>
                                                <div class="col-2 text-center d-md-none d-flex align-items-center">THB</div>
                                                <div class="col-10 col-md-6 text-center mb-2 mb-md-0">
                                                    <input type="number" name="online_thb[]" class="form-control form-control-sm text-center" onKeyUp="getValueOnline(this, {{ $index }})" value="{{ $fare->online_thb }}">
                                                </div>
                                                <div class="col-2 text-center d-md-none d-flex align-items-center">%</div>
                                                <div class="col-10 col-md-6 text-center">
                                                    <input type="number" name="online_percent[]" class="form-control form-control-sm text-center" onKeyUp="getValueOnline(this, {{ $index }})" value="{{ $fare->online_percent }}">
                                                </div>
                                            </div>
                                        </div> -->
                                        <input type="hidden" name="fare_id[]" value="{{ $fare->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 text-center text-lg-end">
                                <x-button-submit-loading 
                                    class="btn-sm w--10 me-2 button-green-bg border-radius-10"
                                    :form_id="_('fare-create-form')"
                                    :fieldset_id="_('fare-create')"
                                    :text="_('Submit')"
                                />
                                <button type="reset" class="btn btn-danger btn-sm w--10 align-self-end border-radius-10">Reset</button>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    const fares = {{ Js::from($fares) }}
</script>
<script src="{{ asset('assets/js/app/fare.js') }}"></script>
@stop