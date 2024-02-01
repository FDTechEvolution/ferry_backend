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
    </div>
    <div class="col-12" id="pdf-report">
        <div class="row">
            <div class="col-12 col-lg-10">
                <p class="small">
                    <span class="fw-bold">Depart Date :</span> <span class="">{{ $depart_date }}</span>
                    <span class="fw-bold ms-3">Station From : </span>
                    <span class="">@if($from->nickname != '') [{{ $from->nickname }}] @endif {{ $from->name }} @if($from->piername != '') ({{ $from->piername }}) @endif</span>
                    <span class="fw-bold ms-3">Station To : </span>
                    <span class="">@if($to->nickname != '') [{{ $to->nickname }}] @endif {{ $to->name }} @if($to->piername != '') ({{ $to->piername }}) @endif</span>
                </p>
            </div>
        </div>
        <div id="report-list" class="table-responsive">
            <table class="table-datatable table table-datatable-custom" id="report-datatable"
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
                data-items-per-page="-1"
                data-enable-column-visibility="false"
                data-enable-export="false"
                data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                data-lng-pdf="PDF"
                data-lng-xls="XLS"
                data-lng-all="All"
                data-export-pdf-disable-mobile="true"
                data-export='["pdf", "xls"]'
                data-responsive="false"
                data-column-search="false">
                <thead>
                    <tr class="small">
                        <th class="text-center">#</th>
                        <th class="">InvoiceNo.</th>
                        <th class="text-center">Route</th>
                        <th class="text-center">Passenger</th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Route Amount">
                            <p class="mb-0">R.Amount</p>(THB)
                        </th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Extra Amount">
                            <p class="mb-0">E.Amount</p>(THB)
                        </th>
                        <th class="text-center">Discount</th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Total Amount">
                            <p class="mb-0">T.Amount</p>(THB)
                        </th>
                        <th class="text-center">Trip Type</th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Booking Channel">B.Channel</th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Premium Flex">P.Flex</th>
                        <th class="text-center">Payment</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $index => $item)
                        <tr class="">
                            <td class="text-center">{{ $index+1 }}</td>
                            <td>{{ $item['bookingno'] }}</td>
                            <td class="text-center">
                                <p class="mb-0">{{ $from->nickname }} - {{ $to->nickname }}</p>
                                <small>{{ $item['travel_date'] }}</small>
                            </td>
                            <td class="text-center">{{ intval($item['adult_passenger']) + intval($item['child_passenger']) + intval($item['infant_passenger']) }}</td>
                            <td class="text-center">{{ number_format($item['totalamt']) }}</td>
                            <td class="text-center">{{ number_format($item['extraamt']) }}</td>
                            <td class="text-center">
                                @if($item['promotion_id'] != '')
                                    <p class="mb-0">
                                        {{ number_format($item['promotion']['discount']) }} @if($item['promotion']['discount'] == 'THB') THB @else % @endif
                                    </p>
                                    <small class="smaller ms-1">[{{ $item['promotion']['code'] }}]</small>
                                @else
                                    <span>-</span>
                                @endif
                            </td>
                            <td class="text-center">{{ number_format($item['payments'][0]['totalamt']) }}</td>
                            <td class="text-center">{{ $item['trip_type'] }}</td>
                            <td class="text-center">{{ $item['book_channel'] }}</td>
                            <td class="text-center">@if($item['ispremiumflex'] == 'Y') <i class="fa-regular fa-circle-check"></i> @else - @endif</td>
                            <td class="text-center">
                                @if($item['payments'][0]['status'] == 'CO') {{ $item['payments'][0]['payment_method'] }}
                                @else -
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    const button = document.getElementById('download-button');

    function generatePDF() {
        let date = getDataNow()
        let file_name = `report_${date}_pdf.pdf`
        // Setting pdf file
        let opt = {
            margin:       [0.1, 0.3],
            filename:     file_name,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
        }
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('pdf-report');
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
