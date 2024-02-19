@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            Create New API Service
        </h4>

        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>
    </div>

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('api.store') }}">
        @csrf

        <div class="modal-body p-4">
            <div class="row">
                <div class="col-12 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" name="name" required>
                        <label for="name">Name *</label>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <div class="form-floating">
                        <input type="text" class="form-control" id="code" name="code" required>
                        <label for="name">Code *</label>
                    </div>
                    <small class="text-warning"><i class="fa-solid fa-circle-info"></i> Code 4-10 ตัวอักษร ต้องไม่ซ้ำกับรายการอื่นในระบบ</small>
                </div>

                <div class="col-12 mb-2">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="key" name="key" value="{{$api_key}}">
                        <label for="key">API KEY *</label>
                    </div>
                </div>

                <div class="col-12 mb-2">
                    <div class="form-floating mb-3">
                        <textarea class="form-control"  id="description" name="description" style="height: 100px"></textarea>
                        <label for="description">Description/Note</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Next <i class="fa-solid fa-forward"></i></button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop
