<div class="prow mt-3">
    <h3>YOUR TRAVEL ITINERARY</h3>



    <table class="w-100 ptable border-gray" style="padding-bottom: 10px;">

        <tr class="bg-gray font-w-700">
            <td class="w-25" rowspan="2" style="">
                DATE OF TRAVELING
            </td>
            <td class="w-50 text-center" colspan="2" style="padding: 0;">
                DESTINATION
            </td>
            <td class="w-25 text-center" colspan="2" style="padding: 0;">
                TIME
            </td>
        </tr>
        <tr class="bg-gray font-w-700">

            <td class="" style="padding: 0;">
                From:
            </td>
            <td class="" style="padding: 0;">
                TO:
            </td>
            <td class="text-center" style="padding: 0;">
                DEP.
            </td>
            <td class="text-center" style="padding: 0;">
                ARR.
            </td>
        </tr>
        @foreach ($bookingRoutes as $indexRoute => $route)
            <tr class="border-gray-top">
                <td class="">
                    {{ date('l d M Y', strtotime($route['pivot']['traveldate'])) }}
                </td>
                <td class="">
                    <span class="font-bold-14">{{ $route['station_from']['name'] }}</span>
                    @if ($route['station_from']['piername'] != '')
                        <br>({{ $route['station_from']['piername'] }})
                    @endif
                </td>
                <td class="">
                    <span class="font-bold-14">{{ $route['station_to']['name'] }}</span>
                    @if ($route['station_to']['piername'] != '')
                        <br>({{ $route['station_to']['piername'] }})
                    @endif
                </td>

                <td class="text-center">
                    <span class="font-bold-14">{{ date('H:i', strtotime($route['depart_time'])) }}</span>
                </td>
                <td class="text-center">
                    <span class="font-bold-14">{{ date('H:i', strtotime($route['arrive_time'])) }}</span>
                </td>
            </tr>

            @if (sizeof($bookingRoutesX[$indexRoute]->bookingRouteAddons) > 0 || sizeof($bookingRoutesX[$indexRoute]->bookingExtraAddons) > 0)

                    <tr>
                        <td class="">Extra service</td>
                        <td colspan="4">
                            @foreach ($bookingRoutesX[$indexRoute]->bookingRouteAddons as $extra)
                            <p style="padding: 0;margin: 0;">- {{$extra->name}}: {{$extra->pivot->description}}</p>
                            @endforeach

                            @foreach ($bookingRoutesX[$indexRoute]->bookingExtraAddons as $extra)
                            <p style="padding: 0;margin: 0;">- </p>
                            @endforeach
                        </td>
                    </tr>

            @endif
        @endforeach
    </table>


</div>
