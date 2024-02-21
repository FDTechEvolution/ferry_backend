<div class="prow">
    <h3>YOUR BOOKING DETAILS</h3>
    <table class="w-100 ptable">

        <tbody>
            <tr class="bg-gray font-w-700">
                <td class="w-15">ISSUED DATE</td>
                <td class="w-15">INVOICE NO.</td>
                <td class="w-15">TICKET NO.</td>
                <td class="w-15">DETAILS <strong
                        style="color:{{ $colors[$booking['trip_type']] }};">{{ ucfirst($booking['trip_type']) }}
                        ticket</strong></td>
            </tr>
            <tr>
                <td><small>{{ date('d/m/Y H:i', strtotime($booking['created_at'])) }}</small></td>
                <td>{{ $booking['bookingno'] }}</td>
                <td class="font-bold-14">
                    {{ $ticket['ticketno'] }}
                </td>
                <td>
                    Channel of Distribution: {{ $booking['book_channel'] }}
                </td>
            </tr>
            <tr class="bg-blue font-w-700">
                <td colspan="2">
                    Contact Information
                    @if ($index==0 && sizeof($customers) >1)
                        <span class="text-main">[Lead passenger]</span>
                    @endif
                </td>
                <td colspan="2">
                    Payment Information
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    Name: <span
                        class="font-bold-14 text-main">{{ $firstCustomer['title'] }}.{{ ucfirst($firstCustomer['fullname']) }}</span><br>
                    Passport No.: {{ $firstCustomer['passportno'] }}<br>
                    Tel: {{ $firstCustomer['mobile'] }}<br>
                    Email: {{ $firstCustomer['email'] }}<br>
                    Adult: {{$booking['adult_passenger']}} person(s)
                    @if($booking['child_passenger']>0)<br>Child: {{$booking['child_passenger']}} person(s) @endif
                </td>
                <td colspan="2">
                    Payment Status: @if($booking['ispayment']=='Y') <span class="text-success">Paid</span> @else <span class="text-danger">Unpay</span>  @endif <br>
                    Total Payment: <span
                        class="font-bold-14 text-main">{{ number_format($booking['totalamt']) }}THB</span><br>
                    @if (!is_null($payment))
                        Payment Method: {{ $payment['payment_method'] }}<br>
                        Approved code: {{$approveCode}}<br>
                    @endif

                </td>

            </tr>
        </tbody>

    </table>
</div>
