<div class="prow">
    <table class="w-100 ptable">
        <tbody>
            <tr>
                <td colspan="2">
                    <h3 style="color: #0580c4;margin-top:0px;margin-bottom: 0px;">YOUR BOOKING DETAILS</h3>
                </td>
                <td colspan="2" class="text-end">
                    <h3 style="color:{{ $colors[$booking['trip_type']] ?? $colors['addon'] }};margin-top:0px;margin-bottom: 0px;">
                        Addon ticket
                    </h3>
                </td>
            </tr>
            <tr class="bg-gray font-w-700">
                <td style="width: 25%;">ISSUED DATE</td>
                <td style="width: 25%;">INVOICE NO.</td>
                <td style="width: 20%;">TICKET NO.</td>
                <td>{{ Str::upper('Number of Passenger:') }}
                    {{ ($booking['adult_passenger'] + $booking['child_passenger'] + $booking['infant_passenger']) }}
                </td>
            </tr>
            <tr>
                <td><small>{{ date('l d M Y H:i', strtotime($booking['created_at'])) }}</small></td>
                <td>{{ $booking['bookingno'] }}</td>
                <td>{{ $ticketNo }}</td>
                <td>

                </td>
            </tr>
            <tr class="bg-gray">
                <td colspan="3" class="font-w-700">
                    {{ strtoupper('Contact Information') }}
                    @if ($index == 0 && sizeof($customers) > 1)
                    <span class="text-main">[Lead passenger]</span>
                    @endif
                </td>
                <td colspan="1" class="font-w-700">
                    {{ strtoupper('Payment Information') }}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    @if ($firstCustomer)
                    Name: <span>{{ Str::upper($firstCustomer['title']) }}.{{ Str::upper($firstCustomer['fullname']) }}</span><br>
                    Passport No.: {{ $firstCustomer['passportno'] }}<br>
                    Nationality: {{ $firstCustomer['country'] }}<br>
                    Email: {{ $firstCustomer['email'] }}<br>
                    Tel: {{ $firstCustomer['mobile_code'].$firstCustomer['mobile'] }}
                    @if (!empty($firstCustomer['mobile_th']))
                    / Thai tel: {{ $firstCustomer['mobile_th'] }}
                    @endif
                    @endif
                </td>
                <td colspan="1">
                    Total Amount: {{ number_format($payment['totalamt'] ?? $booking['totalamt'] ?? 0) }}THB<br>
                    Payment Status:
                    <span class="{{ $statusLabel[$booking['status']]['class'] ?? '' }}">
                        {{ $statusLabel[$booking['status']]['title'] ?? $booking['status'] }}
                    </span><br>
                    Method: {{ $booking['book_channel'] }}-{{ $payment['payment_method'] ?? '-' }}<br>
                    Transection No.: {{ $payment['c_tranref'] ?? '-' }}<br>
                    Approved by:
                    @if (isset($user->firstname))
                    {{ $user->firstname }}
                    @else
                    RSVN
                    @endif
                    @if (!empty($booking['ref_ticketno']))
                    <br>Ref Ticket No.: {{ $booking['ref_ticketno'] }}
                    @endif
                </td>
            </tr>
        </tbody>
    </table>
</div>
