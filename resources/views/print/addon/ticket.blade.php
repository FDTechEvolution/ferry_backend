<!DOCTYPE html>
<html>
@php
$colors = [
'one-way' => '#0580c4',
'round-trip' => '#00bf63',
'multi-trip' => '#ff6100',
'addon' => '#ff6100',
];
$addonTypeLabels = [
'ACTV' => 'Activity',
'MEAL' => 'Meal',
'SHBT' => 'Shuttle Bus & Boat',
'BIKE' => 'Rent a Bike',
];
@endphp

<head>
    <title>Addon Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    @include('print.addon.inc_ticket.style')
</head>

<body>
    @foreach ($bookings as $index => $booking)
    @php
    $user = is_null($booking['user']) ? [] : $booking['user'];
    $customers = $booking['bookingCustomers'];
    $firstCustomer = $customers[0] ?? null;
    foreach ($customers as $customer) {
    if ($customer->pivot->isdefault == 'Y') {
    $firstCustomer = $customer;
    break;
    }
    }

    $payment = sizeof($booking['payments']) > 0 ? $booking['payments'][0] : null;
    $tickets = $booking['tickets'] ?? collect();
    $ticketNo = isset($tickets[0]) ? $tickets[0]['ticketno'] : ($booking['bookingno'] ?? '');

    $addonRows = [];
    foreach (($booking['bookingAddons'] ?? []) as $row) {
    $addon = $row->addon ?? null;
    if (! $addon) {
    continue;
    }
    $id = $addon->id;
    if (! isset($addonRows[$id])) {
    $addonRows[$id] = [
    'id' => $id,
    'name' => $addon->name,
    'code' => $addon->code,
    'type' => $addon->type,
    'type_label' => $addonTypeLabels[$addon->type] ?? $addon->type,
    'amount' => (float) $addon->amount,
    'description' => $addon->description,
    'departure_time' => $addon->departure_time,
    'qty' => 0,
    ];
    }
    $addonRows[$id]['qty']++;
    }
    $addonRows = array_values($addonRows);
    @endphp

    <div class="{{ $booking['book_channel'] == 'ADMIN' ? 'bg-staff' : '' }}">
        @include('print.addon.inc_ticket.head')
        @include('print.addon.inc_ticket.bookdetail')
        @include('print.addon.inc_ticket.travel')
        @include('print.addon.inc_ticket.checkin')
        @include('print.addon.inc_ticket.footer')
    </div>

    @if (sizeof($bookings) != $index + 1)
    <div style="page-break-before:always;"></div>
    @endif
    @endforeach
</body>

</html>
