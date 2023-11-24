<!DOCTYPE html>
<html>

<head>
    <title>Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <style>
        @font-face {
            font-family: 'Noto Sans Thai';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url({{ storage_path('pdf/Noto_Sans_Thai/NotoSansThai-VariableFont_wdth,wght.ttf') }}) format("truetype");
        }

        body {
            font-size: 12px;
            font-family: 'Noto Sans Thai', sans-serif;
            font-weight: 400;
        }
        h1,h2,h3{
            font-family: 'Noto Sans Thai', sans-serif;
            font-weight: 700;
        }

        .font-w-700 {
            font-weight: 700;
        }

        .prow {
            width: 100%;
            position: relative;
            white-space: nowrap;

        }

        .w-50 {
            width: 50%;
        }

        .w-25 {
            width: 25%;
        }

        .page-break {
            page-break-after: always;
        }

        .bg-main {
            background: #BDEDFF;
        }

        .ptable {}

        .ptable td {
            padding: 7px;
        }
    </style>
</head>

<body>
    @php
        $customers = $booking['bookingCustomers'];
        $tickets = $booking['tickets'];
        $user = $booking['user'];
        $extras = $booking['bookingExtraAddons'];
        $bookingRoutes = $booking['bookingRoutes'];
    @endphp

    @foreach ($customers as $customer)
        <div class="">
            <div class="prow">
                <table class="w-100 ptable">
                    <tr>
                        <td class="w-25">
                            <img src="https://andamanexpress.com/assets/images/logo_tiger_line_ferry.png" alt=""
                                class="img-fluid w-100">
                        </td>
                        <td class="text-end">
                            <h1>Andamanexpress Ticket</h1>
                        </td>
                    </tr>
                </table>

            </div>
            <hr>
            <div class="prow">
                <h3>YOUR BOOKING DETAILS</h3>
                <table class="w-100 ptable">

                    <tbody>
                        <tr class="bg-main font-w-700">
                            <td class="w-15">DATE</td>
                            <td class="w-15">BOOKING NO</td>
                            <td class="w-15">TICKET NO</td>
                            <td class="w-15">DETAILS</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>{{ $booking['bookingno'] }}</td>
                            <td>
                                @if (isset($booking['tickets'][0]))
                                    {{ $booking['tickets'][0]['ticketno'] }}
                                @endif
                            </td>
                            <td></td>
                        </tr>
                        <tr class="bg-main font-w-700">
                            <td colspan="2">
                                Contact Information
                            </td>
                            <td colspan="2">
                                Payment Information
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Name: {{ $customer['fullname'] }}<br>
                                Passport No.: {{ $customer['passportno'] }}<br>
                                Mobile No.: {{ $customer['mobile'] }}<br>
                                Email: {{ $customer['email'] }}
                            </td>
                            <td colspan="2">
                                Total Payment: <strong
                                    class="text-success">{{ number_format($booking['totalamt']) }}THB</strong><br>
                                Payment Method: <br>
                                Approved code: <br>
                                Approved by: {{ $user['firstname'] }}
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <div class="prow mt-3">
                <h3>YOUR TRAVEL ITINERARY</h3>
                <table class="w-100 ptable">
                    @foreach ($bookingRoutes as $route)
                        <tr class="bg-main font-w-700">
                            <td class="w-25">
                                Date of Traveling
                            </td>
                            <td class="w-25">
                                From
                            </td>
                            <td class="w-25">
                                To
                            </td>
                            <td class="w-25">
                                Time
                            </td>
                        </tr>
                        <tr>
                            <td class="w-25">
                                {{ date('D d/m/Y', strtotime($route['traveldate'])) }}
                            </td>
                            <td class="w-25">
                                {{ $route['station_from']['name'] }}
                            </td>
                            <td class="w-25">
                                {{ $route['station_to']['name'] }}
                            </td>
                            <td class="w-25">
                                {{ date('H:i', strtotime($route['depart_time'])) }}/{{ date('H:i', strtotime($route['arrive_time'])) }}
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            <div class="prow mt-3">
                <h3>YOUR TRAVEL INFORMATION</h3>
                <table class="w-100 ptable">
                    @foreach ($bookingRoutes as $route)
                        <tr class="bg-main font-w-700">
                            <td>
                                {{ date('D d/m/Y', strtotime($route['traveldate'])) }} From: {{ $route['station_from']['name'] }} To: {{ $route['station_to']['name'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>
                                -
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    @endforeach
</body>

</html>
