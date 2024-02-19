@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            Add Station {{ $type == 'STATION_FROM' ? 'From' : 'To' }}
        </h4>

        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>
    </div>

    <form novalidate class="bs-validate" id="frm" method="POST" action="{{ route('promotion.storestation') }}">
        @csrf
        <input type="hidden" name="promotion_id" id="promotion_id" value="{{$id}}">
        <input type="hidden" name="type" id="type" value="{{$type}}">
        <div class="modal-body p-2">
            <div class="row">
                <div class="col-12">
                    <table class="table table-sm table-datatable" data-lng-empty="No data available in table"
                        data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                        data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..."
                        data-lng-processing="Processing..." data-lng-search="Search..."
                        data-lng-norecords="No matching records found"
                        data-lng-sort-ascending=": activate to sort column ascending"
                        data-lng-sort-descending=": activate to sort column descending" data-main-search="true"
                        data-column-search="false" data-row-reorder="false" data-col-reorder="false" data-responsive="true"
                        data-header-fixed="false" data-select-onclick="false" data-enable-paging="true"
                        data-enable-col-sorting="false" data-autofill="false" data-group="false" data-items-per-page="10"
                        data-enable-column-visibility="false" data-lng-column-visibility="Column Visibility"
                        data-enable-export="false">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Station Name</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stations as $index => $station)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input form-check-input-success" type="checkbox" value="{{$station->id}}" id="{{$station->id}}" name="stations[]" @checked($station->isactive=='Y')>
                                            <label class="form-check-label w-100" for="{{$station->id}}">
                                                {{ sprintf('%s-%s', $station->nickname, $station->name) }}
                                            </label>
                                        </div>


                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop
