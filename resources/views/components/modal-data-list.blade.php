@props(['data' => [], 'header' => '', 'modal_id' => '', 'type' => ''])

<div class="modal fade" id="{{ $modal_id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">{{ $header }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <table class="table-datatable table table-datatable-custom" id="station-datatable" 
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
                    data-enable-export="false"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th class="text-center w--15">Choose</th>
                            <th class="text-start">Name</th>
                        </tr>
                    </thead>
                    <tbody id="modal-data-list-tbody">
                        @foreach($data as $index => $item)
                            <tr class="text-center tr-master-list" id="station-row-{{ $index }}">
                                <td>
                                    @if($type == 'from')
                                        <input class="form-check-input form-check-input-primary station-check mt-2" id="input-from-checked-{{ $index }}" type="checkbox" value="" onClick="addMasterInfoFrom(this, {{ $index }})"></td>
                                    @elseif($type == 'to')
                                        <input class="form-check-input form-check-input-primary station-check mt-2" id="input-to-checked-{{ $index }}" type="checkbox" value="" onClick="addMasterInfoTo(this, {{ $index }})"></td>
                                    @endif
                                <td data-id="name" class="text-start">{{ $item['name'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>