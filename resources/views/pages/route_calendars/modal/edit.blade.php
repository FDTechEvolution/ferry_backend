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
        action="{{ route('routeCalendar.update', ['routeCalendar' => $routeCalendar]) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" id="id" value="{{ $routeCalendar->id }}">
        <div class="modal-body p-2">
            <div class="row">
                <div class="col-12">
                    <div class="form-floating mb-3">
                        <input type="number" class="form-control" id="seat" name="seat" value="{{$routeCalendar->seat}}">
                        <label for="seat">Max Seat</label>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here" id="description" name="description" style="height: 100px"></textarea>
                        <label for="description">Description</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop

@section('script')
    <script>
        $(document).ready(function() {
            $('tr[data-action="click"]').on('click', function() {
                let id = $(this).data('id');
                if ($(id).is(":checked")) {
                    $(id).prop('checked', false);
                } else {
                    $(id).prop('checked', true);
                }

            });
        });
    </script>
@stop
