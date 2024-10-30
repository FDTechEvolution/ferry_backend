@extends('layouts.blank')

@section('content')
<style>
    tr {
        page-break-inside: avoid;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-12 p-3 text-center">
            <button class="btn btn-lg btn-primary" id="bt-export" type="button"><i class="fa-solid fa-file-pdf"></i>
                Export to PDF</button>
        </div>
        <hr>
        <div class="col-12 p-3" id="content">
            <div class="row">
                <div class="col-3">
                    <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}" alt="" class="w-100">
                </div>
                <div class="col-9 text-end">
                    <h3>Payment Report</h3>
                    <small class="p-0 m-0">{{ $description }}</small>
                </div>
            </div>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr class="">
                        <th class="text-center">#</th>
                        <th width="90">Payment Date</th>
                        <th>InvoiceNo.</th>
                        <th>PaymentNo.</th>
                        <th>TicketNo.</th>
                        <th>Station From</th>
                        <th>Station To</th>
                        <th width="90">Depart</th>
                        <th class="text-end" data-bs-toggle="tooltip" data-bs-placement="top" title="Premium Flex">
                            P.Flex
                        </th>
                        <th class="p-0">
                            Shuttle Bus
                        </th>
                        <th>Customer</th>

                        <th class="text-end">Price</th>
                        <th class="text-end">Discount</th>
                        <th class="text-end">Processing fee</th>
                        <th class="text-end">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $index => $item)
                    <tr class="" style="font-size: 10px;">
                        <td class="text-center align-middle">{{ $index+1 }}</td>
                        <td class="align-middle">{{ $item->docdate }}</td>
                        <td class="align-middle">{{ $item->bookingno }}</td>
                        <td class="align-middle">{{ $item->paymentno }}</td>
                        <td class="align-middle">{{ $item->ticketno }}</td>
                        <td class="align-middle">{{ $item->station_from_name }}</td>
                        <td class="align-middle">{{ $item->station_to_name }}</td>
                        <td class="align-middle">{{ $item->traveldate }}</td>
                        <td class="align-middle text-end">{{ number_format($item->pflex,2) }}</td>
                        <td class="p-0">
                            @if (!empty($item->addon_name))
                            <small>
                                <strong>{{ $item->addon_name }}</strong>: {{ $item->description }}
                            </small>
                            @endif

                        </td>
                        <td class="align-middle align-middle">
                            @if (empty($item->title))
                            {{ $item->fullname }}
                            @else
                            {{ sprintf('%s.%s',$item->title,$item->fullname) }}
                            @endif

                        </td>
                        <td class="text-end align-middle">{{ number_format($item->amount,2) }}</td>
                        <td class="text-end align-middle">{{ number_format($item->discount,2) }}</td>
                        <td class="text-end align-middle">{{ number_format($item->fee,2) }}</td>
                        <td class="text-end align-middle">{{ number_format($item->totalamt,2) }}</td>



                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@stop

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    function generatePDF() {
        console.log('export...');
        const element = document.getElementById('content');

        const options = {
            margin:       0.3,
            filename:     '{{ $title }}.pdf',
            image:        { type: 'jpeg', quality: 1 },
            html2canvas:  { scale: 3 },
            jsPDF:        { unit: 'in', format: 'A4', orientation: 'landscape' }
        };

        // แปลง HTML เป็น PDF
        html2pdf().set(options).from(element).save();
    }

    $(document).ready(function(){
        $('#bt-export').on('click',function(){
            console.log('click...');
            generatePDF();
        });
    });

</script>
@stop