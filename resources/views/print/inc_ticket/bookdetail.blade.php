<div class="prow">
    <h3>YOUR BOOKING DETAILS</h3>
    <table class="w-100 ptable">

        <tbody>
            <tr class="bg-gray font-w-700">
                <td class="w-15">ISSUED DATE</td>
                <td class="w-15">INVOICE NO.</td>
                <td class="w-15">TICKET NO.</td>
                <td class="w-15">
                    <strong
                        style="color:{{ $colors[$booking['trip_type']] }};">{{ ucwords(str_replace('-',' ',$booking['trip_type'])) }}
                        ticket</strong>
                    </td>
            </tr>
            <tr>
                <td><small>{{ date('l d M Y', strtotime($booking['created_at'])) }}</small></td>
                <td>{{ $booking['bookingno'] }}</td>
                <td class="font-bold-14">
                    {{ $ticket['ticketno'] }}
                </td>
                <td>
                    Channel of Distribution: {{ $booking['book_channel'] }}
                </td>
            </tr>


        </tbody>

    </table>


    <table class="w-100 ptable">

        <tbody>

            <tr class="bg-gray font-w-700">
                <td colspan="2" class="w-75">
                    {{strtoupper('Contact Information')}}
                    @if ($index==0 && sizeof($customers) >1)
                        <span class="text-main">[Lead passenger]</span>
                    @endif
                </td>
                <td colspan="2" class="w-25">
                    {{strtoupper('Payment Information')}}
                </td>

            </tr>
            <tr>
                <td colspan="2">
                    Name: <span
                        class="font-bold-14 ">{{ $firstCustomer['title'] }}.{{ ucfirst($firstCustomer['fullname']) }}</span><br>
                    Passport No.: {{ $firstCustomer['passportno'] }}<br>
                    Tel: {{ $firstCustomer['mobile'] }}<br>
                    Thai: {{ $firstCustomer['mobile_th'] }}<br>
                    Email: {{ $firstCustomer['email'] }}<br>

                </td>
                <td colspan="2">
                    Payment Status: @if($booking['ispayment']=='Y') <span class="text-success">Paid</span> @else <span class="text-danger">Unpay</span>  @endif <br>
                    Method: {{ isset($payment['payment_method'])?$payment['payment_method']:'-' }}<br>
                    Transaction No. {{$referenceNo}}<br>
                    Approved by: @if(isset($user->firstname)) {{$user->firstname}} @else System  @endif<br>
                    Approved Date:  @if (isset($payment['created_at']))
                    {{ date('d M Y', strtotime($payment['created_at'])) }}
                    @endif


                </td>

            </tr>
        </tbody>

    </table>
</div>
