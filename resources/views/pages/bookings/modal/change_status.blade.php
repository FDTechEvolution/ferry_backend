@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">

        </h4>

        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>
    </div>

    <form novalidate class="bs-validate" id="frm" method="POST"
        action="{{ route('booking.updateStatus', ['booking' => $booking_id]) }}">
        @csrf
        <input type="hidden" name="status" value="{{ $status }}">
        <input type="hidden" name="booking_id" value="{{ $booking_id }}">
        <div class="modal-body p-4">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-danger">{{ $statusLabel[$status]['action'] }} this Booking</h3>
                </div>
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description" style="height: 100px" required></textarea>
                        <label for="floatingTextarea2">Reason <strong class="text-danger">*</strong></label>
                    </div>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Confirm </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop
