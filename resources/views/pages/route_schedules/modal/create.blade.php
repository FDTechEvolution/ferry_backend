@extends('layouts.blank')

@section('content')
<div class="modal-header">
	<h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
	<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
	<div class="row mb-3">
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-input-success" type="radio" name="type"
                    id="type_open" value="OPEN">
                <label class="form-check-label" for="type_open">Open Route</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input form-check-input-danger" type="radio" name="type"
                    id="type_close" value="CLOSE" checked>
                <label class="form-check-label" for="type_close">Close Route</label>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-12">
            <div class="form-floating mb-3">
                <input autocomplete="off" type="text" name="daterange" id="daterange"
                    class="form-control form-control-sm rangepicker" data-bs-placement="left"
                    data-ranges="false" data-date-start="" data-date-end=""
                    data-date-format="DD/MM/YYYY"
                    data-quick-locale='{
    "lang_apply"	: "Apply",
    "lang_cancel" : "Cancel",
    "lang_crange" : "Custom Range",
    "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
}'>
                <label for="departdate">Effective date</label>
            </div>
        </div>
    </div>

    <div class="row mb-3" style="display: none;">
        <div class="col-12">
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                    id="mon" name="mon" checked>
                <label class="form-check-label" for="mon">
                    Monday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox" value="Y"
                    id="tru" name="tru" checked>
                <label class="form-check-label" for="tru">
                    Tuesday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox"
                    value="Y" id="wed" name="wed" checked>
                <label class="form-check-label" for="wed">
                    Wednesday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox"
                    value="Y" id="thu" name="thu" checked>
                <label class="form-check-label" for="thu">
                    Thursday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox"
                    value="Y" id="fri" name="fri" checked>
                <label class="form-check-label" for="fri">
                    Friday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox"
                    value="Y" id="sat" name="sat" checked>
                <label class="form-check-label" for="sat">
                    Saturday
                </label>
            </div>
            <div class="form-check mb-2 form-check-inline">
                <input class="form-check-input form-check-input-success" type="checkbox"
                    value="Y" id="sun" name="sun" checked>
                <label class="form-check-label" for="sun">
                    Sunday
                </label>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="form-floating mb-3">
                <textarea class="form-control" id="description" name="description" style="height: 130px"></textarea>
                <label for="floatingTextarea2">Note/Description</label>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
	<button type="button" class="btn btn-primary">Understood</button>
</div>
@stop