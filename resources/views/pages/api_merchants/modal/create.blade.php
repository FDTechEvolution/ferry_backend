@extends('layouts.ajaxmodal')

@section('content')
<div class="modal-header">
    <h4 class="modal-title m-0">
        Create New API Agent Service
    </h4>

    <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
        <span class="fi fi-close " aria-hidden="true"></span>
    </button>
</div>

<form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('api.store') }}"
    enctype="multipart/form-data">
    @csrf

    <div class="modal-body p-4">
        <div class="row">
            <div class="col-12 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="name" name="name" required>
                    <label for="name">Agent Name *</label>
                </div>
            </div>

            <div class="col-12 mb-2">
                <label for="logofile" class="form-label">Agent Logo</label>
                <input class="form-control" type="file" id="logofile" name="logofile">
            </div>

            <div class="col-12 mb-2">
                <div class="form-floating">
                    <input type="text" class="form-control" id="code" name="code" required>
                    <label for="name">API Code *</label>
                </div>
                <small class="text-danger"><i class="fa-solid fa-circle-info"></i> Code 4-10 ตัวอักษร
                    ต้องไม่ซ้ำกับรายการอื่นในระบบ</small>
            </div>

            <div class="col-12 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="key" name="key" value="{{ $api_key }}">
                    <label for="key">API KEY *</label>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="prefix" name="prefix" value="">
                    <label for="prefix">Ticket Prefix *</label>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="form-check mb-2">
                    <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                        id="isopenregular" name="isopenregular" checked>
                    <label class="form-check-label" for="isopenregular">
                        Open Regular Price
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input form-check-input-success" type="checkbox" value="Y" id="isopenchild"
                        name="isopenchild" checked>
                    <label class="form-check-label" for="isopenchild">
                        Open Child Price
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input form-check-input-success" type="checkbox" value="Y" id="isopeninfant"
                        name="isopeninfant" checked>
                    <label class="form-check-label" for="isopeninfant">
                        Open Infant Price
                    </label>
                </div>
                <div class="form-check mb-2">
                    <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                        id="isopendiscount" name="isopendiscount">
                    <label class="form-check-label" for="isopendiscount">
                        Open Discount Price
                    </label>
                </div>
            </div>

            <div class="col-12 mb-2">
                <div class="form-floating mb-3">
                    <textarea class="form-control" id="description" name="description" style="height: 100px"></textarea>
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