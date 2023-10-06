@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-info-page-title"><span class="text-main-color-2">Station</span> infomation</h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-3 btn-sm w--10" id="btn-station-info-create" />
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div id="to-station-info-list">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="station-info-datatable" 
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-enable-col-sorting="false"
                    data-items-per-page="15"

                    data-enable-column-visibility="false"
                    data-enable-export="true"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="text-center">Detail</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($s_info as $index => $info)
                            <tr class="text-center" id="station-row-{{ $index }}">
                                <td class="text-start">{{ $info['name'] }}</td>
                                <td>
                                    <a href="javascript:void(0)" class="me-2 text-dark" data-bs-toggle="modal" data-bs-target="#modalLong2" onClick="setModalContent({{ $index }})">
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-file-richtext" viewBox="0 0 16 16">  
                                            <path d="M7 4.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0zm-.861 1.542 1.33.886 1.854-1.855a.25.25 0 0 1 .289-.047l1.888.974V7.5a.5.5 0 0 1-.5.5H5a.5.5 0 0 1-.5-.5V7s1.54-1.274 1.639-1.208zM5 9a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1H5zm0 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1H5z"></path>  
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1z"></path>
                                        </svg>
                                    </a>
                                </td>
                                <td>{!! $info_status[$info['status']] !!}</td>
                                <td>
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-station-edit"
                                        onClick="updateStationInfoEditData({{ $index }})"
                                    />
                                    <x-action-delete 
                                        :url="route('station-info-delete', ['id' => $info['id']])"
                                        :message="_('Are you sure? Delete this item.?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-station-info-create" class="m-auto d-none">
            @include('pages.station_infomations.create')
        </div>
        <div id="to-station-info-edit" class="m-auto d-none">
            @include('pages.station_infomations.edit')
        </div>
    </div>
</div>

<style>
    .ql-editor, .ql-container.ql-snow {
        background-color: #fff;
    }
    .ql-container.ql-snow {
        padding: 12px 15px;
    }
    .detail-custom {
        line-height: 22px;
        width: 40%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@stop

@section('modal')
<div class="modal fade" id="modalLong2" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-xl">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="station-info-modal-title"></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" id="station-info-modal-content">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script>
    const s_info = {{ Js::from($s_info) }}
</script>
<script src="{{ asset('assets/js/app/station_info.js') }}"></script>
@stop