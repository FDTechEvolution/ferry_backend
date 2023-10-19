@extends('layouts.blank')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" 
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" 
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <button id="download-button">Download as PDF</button>
        <div id="pdf-route">
            <table class="table-datatable table table-bordered table-hover table-striped fs--80"
                data-lng-empty="No data available in table"
                data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                data-lng-filtered="(filtered from _MAX_ total entries)"
                data-lng-loading="Loading..."
                data-lng-processing="Processing..."
                data-lng-search="Search..."
                data-lng-norecords="No matching records found"
                data-lng-sort-ascending=": activate to sort column ascending"
                data-lng-sort-descending=": activate to sort column descending"

                data-main-search="true"
                data-column-search="false"
                data-row-reorder="false"
                data-col-reorder="true"
                data-responsive="true"
                data-header-fixed="true"
                data-select-onclick="true"
                data-enable-paging="true"
                data-enable-col-sorting="true"
                data-autofill="false"
                data-group="false"
                data-items-per-page="10"

                data-enable-column-visibility="true"
                data-lng-column-visibility="Column Visibility"

                data-enable-export="true"
                data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                data-lng-csv="CSV"
                data-lng-pdf="PDF"
                data-lng-xls="XLS"
                data-lng-copy="Copy"
                data-lng-print="Print"
                data-lng-all="All"
                data-export-pdf-disable-mobile="true"
                data-export='["csv", "pdf", "xls"]'
                data-options='["copy", "print"]'

                data-custom-config='{}'>
                <thead>
                    <tr>
                        <th class="text-start">Station From</th>
                        <th class="text-start">Station To</th>
                        <th class="text-center">Depart</th>
                        <th class="text-center">Arrive</th>
                        <th class="text-center">Vehicle</th>
                        <th class="text-center">Regular Price</th>
                        <th class="text-center">Child Price</th>
                        <th class="text-center">Infant Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($routes as $index => $route)
                        <tr class="text-center">
                            <td class="text-start" style="line-height: 1.2rem;">
                                <p class="m-0">{{ $route['station_from']['name'] }}</p>
                                @if($route['station_from']['piername'] != '')
                                    <small class="text-secondary fs-d-80">({{$route['station_from']['piername']}})</small>
                                @endif
                            </td>
                            <td class="text-start" style="line-height: 1.2rem;">
                                <p class="m-0">{{ $route['station_to']['name'] }}</p>
                                @if($route['station_to']['piername'] != '')
                                    <small class="text-secondary fs-d-80">({{$route['station_to']['piername']}})</small>
                                @endif
                            </td>
                            <td>{{ date('H:i', strtotime($route['depart_time'])) }}</td>
                            <td>{{ date('H:i', strtotime($route['arrive_time'])) }}</td>
                            <td>
                                <div class="row mx-auto justify-center-custom">
                                    @foreach($route['icons'] as $icon)
                                    <div class="col-sm-4 px-0" style="max-width: 24px;">
                                        <img src="{{ $icon['path'] }}" class="w-100">
                                    </div>
                                    @endforeach
                                </div>
                            </td>
                            <td>{{ number_format($route['regular_price']) }}</td>
                            <td>{{ $route['child_price'] != 0 ? number_format($route['child_price']) : '-' }}</td>
                            <td>{{ $route['infant_price'] != 0 ? number_format($route['infant_price']) : '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
    .fs--80 {
        font-size: 80%;
    }
</style>
@stop

@section('script')
<script>
    const button = document.getElementById('download-button');

    function generatePDF() {
        let date = getDataNow()
        let file_name = `route_${date}_pdf.pdf`
        // Setting pdf file
        let opt = {
            margin:       [0.1, 0.3],
            filename:     file_name,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        }
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('pdf-route');
        // Choose the element and save the PDF for your user.
        html2pdf().set(opt).from(element).save();
        // window.close()
    }

    function getDataNow() {
        const date = new Date();

        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        return `${day}-${month}-${year}`;
    }

    button.addEventListener('click', generatePDF);
</script>
@stop