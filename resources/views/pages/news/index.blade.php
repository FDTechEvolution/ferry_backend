@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">News</span> manager</h1> <x-a-href-green
    :text="_('Add')" :href="route('news-create')" :target="_('_self')" class="ms-3 btn-sm w--10" />
@stop

@section('content')
<div class="row mt-4">
    <div class="col-sm-12 col-md-11 col-lg-10 mx-auto">
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
                            <th>#Seq</th>
                            <th class="">Topic</th>
                            <th class="text-center">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($news as $index => $item)
                            <tr class="" id="row-{{ $index }}">
                                <td class="text-start">{{ $index+1 }}</td>
                                <td>{{ $item['title'] }}</td>
                                <td class="text-center">
                                    <label class="d-flex justify-content-center align-items-center mt-2">
                                        <input class="d-none-cloaked news-isactive" type="checkbox" name="isactive" value="{{ $item->id }}" @checked(old('isactive', $item->isactive == 'Y'))>
                                        <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                                    </label>
                                </td>
                                <td class="text-end">
                                    <x-action-edit
                                        class="me-2"
                                        :url="route('news-edit',['news'=> $item])"
                                        id="btn-station-edit"
                                    />
                                    <x-action-delete
                                        :url="route('news-delete', ['id' => $item['id']])"
                                        :message="_('Are you sure? Delete this item.?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    const isactives = document.querySelectorAll('.news-isactive')
    isactives.forEach((isactive) => {
        isactive.addEventListener('change', async (e) => {
            let response = await fetch(`/ajax/news/status/${e.target.value}`)
            let res = await response.json()

            if(res['result']) $.SOW.core.toast.show('success', '', `News status updated.`, 'top-right', 0, true);
            else $.SOW.core.toast.show('danger', '', `Something wrong.`, 'top-right', 0, true);
        })
    })
</script>
@stop
