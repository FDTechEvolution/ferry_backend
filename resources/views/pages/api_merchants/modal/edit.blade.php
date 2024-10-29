@extends('layouts.ajaxmodal')

@section('content')
<div class="modal-header">
    <h4 class="modal-title m-0">
        Update Route
    </h4>

    <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
        <span class="fi fi-close " aria-hidden="true"></span>
    </button>
</div>

<form novalidate class="bs-validate" id="frm" method="POST"
    action="{{ route('apiagent.update',['id'=>$apiRoute->id]) }}">
    @csrf
    <input type="hidden" name="id" value="{{$apiRoute->id}}">
    <div class="modal-body p-4">
        <div class="row">
            @if ($apiRoute->api_merchant->isopenregular == 'Y')
            <div class="col-12 mb-2">
                <div class="form-floating">
                    <input type="number" class="form-control" id="adult" name="adult_price" required
                        value="{{ $apiRoute->regular_price }}" step="any">
                    <label for="adult">Regular Price *</label>
                </div>
            </div>
            @endif

            @if ($apiRoute->api_merchant->isopenchild == 'Y')
            <div class="col-12 mb-2">
                <div class="form-floating">
                    <input type="number" class="form-control" id="child" name="child_price" required
                        value="{{ $apiRoute->child_price }}" step="any">
                    <label for="child">Child Price *</label>
                </div>
            </div>
            @endif

            @if ($apiRoute->api_merchant->isopeninfant == 'Y')
            <div class="col-12 mb-2">
                <div class="form-floating">
                    <input type="number" class="form-control" id="infant" name="infant_price" required
                        value="{{ $apiRoute->infant_price }}" step="any">
                    <label for="infant">Infant *</label>
                </div>
            </div>
            @endif

            <div class="col-12 mb-2">
                <div class="form-floating mb-3">
                    <input type="number" class="form-control" id="seat" name="seat" required
                        value="{{ $apiRoute->seat }}">
                    <label for="seat">Seat *</label>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

    </div>
</form>


@stop