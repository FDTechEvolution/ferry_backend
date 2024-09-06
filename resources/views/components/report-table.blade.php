@props(['reports' => []])

<thead>
    <tr class="small">
        <th class="text-center">#</th>
        <th width="90">InvoiceNo.</th>
        <th class="text-center" data-bs-toggle="tooltip" data-bs-placement="top" title="Premium Flex">P.Flex</th>
        <th>Route</th>
        <th>Lead Name</th>
        <th>Contact</th>
        <th class="text-center">Passenger</th>
        <th class="p-0">
            <p class="mb-0">Shuttle Bus</p>(From)
        </th>
        <th class="p-0">Meal on Board</th>
        <th class="p-0">Activity</th>
        <th class="text-center p-0">Status</th>
        <th class="text-center p-0">Other</th>
    </tr>
</thead>
<tbody>
    @foreach ($reports as $index => $item)
        <tr class="">
            <td class="text-center">{{ $index+1 }}</td>
            <td>{{ $item['bookingno'] }}</td>
            <td class="text-center">
                @if($item['ispremiumflex'] == 'Y')
                    <span class="text-success">YES</span>
                @endif
            </td>
            <td>
                <p class="mb-0">{{ $item['station_from']['nickname'] }} - {{ $item['station_to']['nickname'] }}</p>
                <small>{{ $item['travel_date'] }}</small>
            </td>
            <td>
                @php
                    $mobile = ''; $email = '';
                @endphp
                @foreach ($item['booking_customers'] as $cus)
                    @php
                        if($cus['mobile'] != '') $mobile = $cus['mobile'];
                        if($cus['email'] != '') $email = $cus['email'];
                    @endphp
                    @if($cus['pivot']['isdefault'] == 'Y')
                        <p class="small mb-0">
                            {{ strtolower($cus['title']) }}.
                            {{ $cus['fullname'] }}
                        </p>
                    @endif
                @endforeach
            </td>
            <td>
                <p class="smaller mb-0">{{ $mobile }}</p>
                <p class="smaller mb-0">{{ $email }}</p>
            </td>
            <td class="text-center">
                <span class="me-1">A:{{ $item['adult_passenger'] }}</span>
                <span class="me-1">C:{{ $item['child_passenger'] }}</span>
                <span class="">I:{{ $item['infant_passenger'] }}</span>
            </td>
            <td class="p-0">
                @if($item['shuttle_bus_from'] != '')
                    Shuttle Bus from: {{ $item['shuttle_bus_from'] }}<br>
                @endif
                @if($item['shuttle_bus_to'] != '')
                    Shuttle Bus to: {{ $item['shuttle_bus_to'] }}<br>
                @endif
                @if($item['longtail_boat_from'] != '')
                    Longtail Boat from: {{ $item['longtail_boat_from'] }}<br>
                @endif
                @if($item['longtail_boat_to'] != '')
                    Longtail Boat to: {{ $item['longtail_boat_to'] }}
                @endif
            </td>
            <td class="p-0">
                @if(sizeof($item['meal']) > 0)
                    @foreach ($item['meal'] as $meal)
                        - {{ $meal }}
                    @endforeach
                @else
                    <p class="mb-0">-</p>
                @endif
            </td>
            <td class="p-0">
                @if(sizeof($item['activity']) > 0)
                    @foreach ($item['activity'] as $activity)
                        - {{ $activity }}
                    @endforeach
                @else
                    <p class="mb-0">-</p>
                @endif
            </td>
            <td class="text-center p-0">
                @if($item['ispayment'] == 'Y')
                    <span class="text-success">Paid</span>
                @endif
            </td>
            <td class="p-0">
                @if($item['longtail_boat_to'] != '')
                    {{ $item['note']}}
                @else
                    <p class="text-center">-</p>
                @endif
            </td>
        </tr>
    @endforeach
</tbody>
