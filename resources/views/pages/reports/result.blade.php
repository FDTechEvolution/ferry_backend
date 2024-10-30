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
                    <h3>Booking Report</h3>
                    <small class="p-0 m-0">{{ $description }}</small>
                </div>
            </div>
            <hr>
            <table class="table table-hover">
                <thead>
                    <tr class="">
                        <th class="text-center">#</th>
                        <th width="70">InvoiceNo.</th>
                        <th width="70">PaymentNo.</th>
                        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Premium Flex">
                            P.Flex
                        </th>
                        <th width="90">Route</th>
                        <th>Lead Name</th>
                        <th>Contact</th>
                        <th class="text-center" width="90">Passenger</th>
                        <th class="p-0">
                            Shuttle Bus
                        </th>
                        <th>Sales Channel</th>
                        <th>Partner</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $index => $item)
                    <tr class="" style="font-size: 10px;">
                        <td class="text-center">{{ $index+1 }}</td>
                        <td>{{ $item->bookingno }}</td>
                        <td>{{ $item->paymentno }}</td>
                        <td class="text-center">
                            @if($item->ispremiumflex == 'Y')
                            <span class="text-success">YES</span>
                            @endif
                        </td>
                        <td>
                            <p class="mb-0">{{ $item->station_from_name }}-{{ $item->station_to_name }}
                            </p>
                            <small class="d-flex">{{ $item->traveldate }}</small>
                        </td>
                        <td>
                            @if (empty($item->title))
                            {{ $item->fullname }}
                            @else
                            {{ sprintf('%s.%s',$item->title,$item->fullname) }}
                            @endif

                        </td>
                        <td>
                            <span class="d-flex">{{ $item->mobileno }}</span>
                            <span class="d-flex">{{ $item->email }}</span>
                        </td>
                        <td class="text-center">
                            <span class="me-1">A:{{ $item->adult_passenger }}</span>
                            <span class="me-1">C:{{ $item->child_passenger }}</span>
                            <span class="">I:{{ $item->infant_passenger }}</span>
                        </td>
                        <td class="p-0">
                            @if (!empty($item->addon_name))
                            <small>
                                <strong>{{ $item->addon_name }}</strong>: {{ $item->description }}
                            </small>
                            @endif

                        </td>
                        <td>{{ $item->book_channel }}</td>
                        <td>{{ $item->partner_name }}</td>
                        <td><span class="text-success">Paid</span></td>
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