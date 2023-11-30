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

        .border-gray {
            border: 1px solid #d9d9d9;
        }

        .ptable {}

        .ptable td {
            padding: 5px;
        }
    </style>
</head>

<body>
    @php
        
        $tickets = $booking['tickets'];
        $user = $booking['user'];
        $extras = $booking['bookingExtraAddons'];
        $bookingRoutes = $booking['bookingRoutes'];
        $payment = sizeof($booking['payments'])>0?$booking['payments'][0]:NULL;
    @endphp

    @foreach ($tickets as $ticket)
        <div class="">
            <div class="prow">
                <table class="w-100 ptable">
                    <tr>
                        <td class="w-25">
                            <img src="https://andamanexpress.com/assets/images/logo_tiger_line_ferry.png" alt=""
                                class="img-fluid w-100">
                        </td>
                        <td class="text-end" style="height: 70px;">
                            <div style="float: right;display:block;">
                            <?= DNS2D::getBarcodeHTML('4445645656', 'QRCODE',4,4)?>
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
                        <tr class="bg-gray font-w-700">
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
                                Channel of Distribution: {{$booking['book_channel']}}
                            </td>
                        </tr>
                        <tr class="bg-gray font-w-700">
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
                                Name: <span class="font-bold-14">{{ $ticket['customer']['fullname'] }}</span><br>
                                Passport No.: {{ $ticket['customer']['passportno'] }}<br>
                                Mobile No.: {{ $ticket['customer']['mobile'] }}<br>
                                Email: {{ $ticket['customer']['email'] }}
                            </td>
                            <td colspan="">
                                Total Payment: <strong
                                    class="text-success">{{ number_format($booking['totalamt']) }}THB</strong><br>
                                @if(!is_null($payment))
                                Payment Method: {{$payment['payment_method']}}<br>
                                Approved code: <br>
                                @endif
                                Approved by: {{ isset($user['firstname'])?$user['firstname']:'-' }}
                            </td>
                            <td>
                                @foreach ($extras as $extra)
                                    - {{$extra['name']}}<br>
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
                        <tr class="bg-gray font-w-700">
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
                        <tr class="border-gray font-bold-14 text-danger">
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
                <table class="w-100 ptable border-gray">
                    @foreach ($bookingRoutes as $route)
                        <tr class="bg-gray font-w-700">
                            <td>
                                {{ date('l d/m/Y', strtotime($route['pivot']['traveldate'])) }} From:
                                {{ $route['station_from']['name'] }} @if($route['station_from']['piername']!='')[{{$route['station_from']['piername']}}] @endif
                                To: {{ $route['station_to']['name'] }} @if($route['station_to']['piername']!='')[{{$route['station_to']['piername']}}] @endif
                            </td>
                        </tr>
                        @foreach ($route['station_lines'] as $info)
                       
                            @if ($info['pivot']['type'] == 'from')
                                <tr>
                                    <td style="white-space:wrap">
                                        <span class="font-bold-14">{{ $route['station_from']['name'] }} @if($route['station_from']['piername']!='')[{{$route['station_from']['piername']}}] @endif</span>
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
                                        <span class="font-bold-14">{{ $route['station_to']['name'] }} @if($route['station_to']['piername']!='')[{{$route['station_to']['piername']}}]@endif </span>
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
                            <?=$term['body']?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    @endforeach
</body>

</html>
