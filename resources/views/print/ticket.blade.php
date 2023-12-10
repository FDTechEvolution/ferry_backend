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

        h1,
        h2,
        h3 {
            font-family: 'Noto Sans Thai', sans-serif;
            font-weight: 700;
        }

        .font-w-700 {
            font-weight: 700;
        }

        .font-bold-14 {
            font-size: 14px;
            font-weight: 700;
        }

        .text-main {
            color: #ff6100;
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

        .bg-gray {
            background: #d9d9d9;
        }

        .bg-blue {
            background: #2889e8;
        }

        .border-gray {
            border: 1px solid #d9d9d9;
        }

        .border-blue {
            border: 1px solid #2889e8;
        }

        .ptable {}

        .ptable td {
            padding: 5px;
        }

        .header {
            background-image: url("https://andamanexpress.com/tiger-line-ferry_logo-header-3.png");
            background-color: #ffffff;
            width: 100%;
            height: auto;
            position: relative;
            background-attachment: fixed;
            background-position: center center;
            background-repeat: no-repeat;
            background-size: cover;

            
        }
    </style>
</head>

<body>
    @php

        $tickets = $booking['tickets'];
        $user = $booking['user'];
        $extras = $booking['bookingExtraAddons'];
        $bookingRoutes = $booking['bookingRoutes'];
        $payment = sizeof($booking['payments']) > 0 ? $booking['payments'][0] : null;
    @endphp

    @foreach ($tickets as $ticket)
        <div class="">
            <div class="prow">
                <table class="w-100 ptable">
                    <tr>
                        <td class="w-100" style="padding: 0px;">
                            <div class="header">
                                <table class="w-100 ptable">
                                    <tr>
                                        <td style="width: 88%;padding-top:30px;" class="text-end">
                                            <h2 class="text-white">ONLINE TICKET ITENERY</h2>
                                        </td>
                                        <td class="text-end" style="height: 100px;">
                                            <div style="float: right;display:block;margin-top:32px;">
                                                <?= DNS2D::getBarcodeHTML('4445645656', 'QRCODE', 2.5, 2.5,'white') ?>
                                            </div>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>



            </div>
            <hr>
            <div class="prow">
                <h3>YOUR BOOKING DETAILS</h3>
                <table class="w-100 ptable">

                    <tbody>
                        <tr class="bg-blue font-w-700">
                            <td class="w-15">DATE</td>
                            <td class="w-15">BOOKING NO</td>
                            <td class="w-15">TICKET NO</td>
                            <td class="w-15">DETAILS</td>
                        </tr>
                        <tr>
                            <td></td>
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
                            </td>
                            <td colspan="">
                                Payment Information
                            </td>
                            <td colspan="">
                                Extra Service
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                Name: <span
                                    class="font-bold-14 text-main">{{ $ticket['customer']['fullname'] }}</span><br>
                                Passport No.: {{ $ticket['customer']['passportno'] }}<br>
                                Mobile No.: {{ $ticket['customer']['mobile'] }}<br>
                                Email: {{ $ticket['customer']['email'] }}
                            </td>
                            <td colspan="">
                                Total Payment: <span
                                    class="font-bold-14 text-main">{{ number_format($booking['totalamt']) }}THB</span><br>
                                @if (!is_null($payment))
                                    Payment Method: {{ $payment['payment_method'] }}<br>
                                    Approved code: <br>
                                @endif
                                Approved by: {{ isset($user['firstname']) ? $user['firstname'] : '-' }}
                            </td>
                            <td>
                                @foreach ($extras as $extra)
                                    - {{ $extra['name'] }}<br>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <div class="prow mt-3">
                <h3>YOUR TRAVEL ITINERARY</h3>
                <table class="w-100 ptable">
                    @foreach ($bookingRoutes as $route)
                        <tr class="bg-blue font-w-700">
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
                        <tr class="border-blue font-bold-14 text-main">
                            <td class="w-25">
                                {{ date('l d/m/Y', strtotime($route['pivot']['traveldate'])) }}
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
                <table class="w-100 ptable border-blue">
                    @foreach ($bookingRoutes as $route)
                        <tr class="bg-blue font-w-700">
                            <td>
                                {{ date('l d/m/Y', strtotime($route['pivot']['traveldate'])) }} From:
                                {{ $route['station_from']['name'] }} @if ($route['station_from']['piername'] != '')
                                    [{{ $route['station_from']['piername'] }}]
                                @endif
                                To: {{ $route['station_to']['name'] }} @if ($route['station_to']['piername'] != '')
                                    [{{ $route['station_to']['piername'] }}]
                                @endif
                            </td>
                        </tr>
                        @foreach ($route['station_lines'] as $info)
                            @if ($info['pivot']['type'] == 'from')
                                <tr>
                                    <td style="white-space:wrap">
                                        <span class="font-bold-14">{{ $route['station_from']['name'] }} @if ($route['station_from']['piername'] != '')
                                                [{{ $route['station_from']['piername'] }}]
                                            @endif
                                        </span>
                                        <div style="width: inherit">
                                            {{ strip_tags($info['text']) }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach

                        @foreach ($route['station_lines'] as $info)
                            @if ($info['pivot']['type'] == 'to')
                                <tr>
                                    <td style="white-space:wrap">
                                        <span class="font-bold-14">{{ $route['station_to']['name'] }} @if ($route['station_to']['piername'] != '')
                                                [{{ $route['station_to']['piername'] }}]
                                            @endif </span>
                                        <div style="width: inherit">
                                            {{ strip_tags($info['text']) }}
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                </table>


            </div>
            <div class="prow mt-3">
                <small><strong>Terms and Conditions</strong></small>
                <table class="w-100 ptable ">
                    <tr>
                        <td style="white-space:wrap;font-size: 9px;">
                            <?= $term['body'] ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach
</body>

</html>
