<div class="prow">

    <table class="w-100 ptable">

        <tbody>
            <tr>
                <td colspan="2">
                    <h3 style="color: #0580c4;">YOUR BOOKING DETAILS</h3>
                </td>
                <td colspan="2" class="text-end">
                    <h3 style="color:{{ $colors[$booking['trip_type']] }};">{{ ucwords(str_replace('-','
                        ',$booking['trip_type'])) }}
                        ticket
                        @if ($booking['trip_type'] == 'multi-trip')
                        <span>{{$i+1}}/{{sizeof($bookingRoutes)}}</span>
                        @endif
                    </h3>
                </td>
            </tr>
            <tr class="bg-gray font-w-700">
                <td class="w-15">ISSUED DATE</td>
                <td class="w-15">INVOICE NO.</td>
                <td class="w-15">TICKET NO.</td>
                <td class="w-15">{{ Str::upper('Number of Passenger:') }} </td>
            </tr>
            <tr>
                <td><small>{{ date('l d M Y', strtotime($booking['created_at'])) }}</small></td>
                <td>{{ $booking['bookingno'] }}</td>
                <td class="">
                    @if (isset($bookingRouteX->tickets[0]))
                    {{ $bookingRouteX->tickets[0]['ticketno'] }}
                    @endif
                </td>
                <td>
                    Adult: {{$booking['adult_passenger']}} &nbsp;&nbsp;
                    Child: {{$booking['child_passenger']}} &nbsp;&nbsp;
                    Infant: {{$booking['infant_passenger']}}
                </td>
            </tr>


        </tbody>

    </table>


    <table class="w-100 ptable">

        <tbody>

            <tr class="bg-gray">
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
                    Name: <span class="">{{ $firstCustomer['title'] }}.{{ ucfirst($firstCustomer['fullname'])
                        }}</span><br>
                    Passport No.: {{ $firstCustomer['passportno'] }}<br>
                    Nationality: {{ $firstCustomer['country'] }}<br>
                    Email: {{ $firstCustomer['email'] }}<br>
                    Tel: {{ $firstCustomer['mobile'] }} / Thai tel: {{ $firstCustomer['mobile_th'] }}



                </td>
                <td colspan="2">
                    Total Amount: {{$payment['totalamt']}}<br>
                    Payment Status: @if($booking['status']=='CO') <span class="text-success">APPROVED</span> @else <span
                        class="text-danger">Unpay</span> @endif <br>
                    Method:{{ $booking['book_channel'] }}/ {{
                    isset($payment['payment_method'])?$payment['payment_method']:'-' }}<br>
                    Transaction No. {{$referenceNo}}<br>
                    Approved by: @if(isset($user->firstname)) {{$user->firstname}} @else RSVN @endif<br>



                </td>

            </tr>
        </tbody>

    </table>
</div>