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

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('apiagent.update',['id'=>$apiRoute->id]) }}">
        @csrf
        <input type="hidden" name="id" value="{{$apiRoute->id}}">
        <input type="hidden" name="type" value="{{$type}}">
        <div class="modal-body p-4">
            <div class="row">
                @if ($type == 'seat')
                    <div class="col-12 mb-2">
                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="seat" name="seat"
                                value="{{ $apiRoute->seat }}" required>
                            <label for="seat">Seat *</label>
                        </div>
                    </div>
                @endif

                @if ($type == 'discount')
                    <div class="col-12 mb-2">
                        <div class="form-floating">
                            <input type="number" class="form-control" id="discount" name="discount" required value="{{ $apiRoute->discount }}">
                            <label for="discount">Discount *</label>
                        </div>

                    </div>
                @endif
                <div class="col-12 mb-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input form-check-input-success" type="checkbox" value="Y" id="isapply" name="isapply">
                        <label class="form-check-label" for="isapply">
                            Apply to all routes
                        </label>
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
