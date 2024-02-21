<div class="prow mt-3">
    <h3>CHECK-IN</h3>
    @foreach ($bookingRoutes as $route)
        <table class="w-100 ptable border-gray" style="margin-bottom: 5px;">

            <tr class="bg-gray font-w-700">
                <td colspan="2">
                    {{ date('l d/m/Y', strtotime($route['pivot']['traveldate'])) }} From:
                    {{ $route['station_from']['name'] }} @if ($route['station_from']['piername'] != '')
                        [{{ $route['station_from']['piername'] }}]
                    @endif
                    To: {{ $route['station_to']['name'] }} @if ($route['station_to']['piername'] != '')
                        [{{ $route['station_to']['piername'] }}]
                    @endif

                </td>
            </tr>
            <tr>
                <td class="w-25">
                    {{ $route['station_from']['name'] }}
                </td>
                <td class="w-75" style="white-space:wrap;font-size: 9px;">
                    <a href="https://www.andamanexpress.com/station/detail/{{ $route['station_from']['nickname'] }}"
                        class="text-main" target="_blank">Click to see your check-in points</a>
                    @if ($route->master_from_info == 'Y')
                        <br>#{{ strip_tags($route['master_from']) }}
                    @endif
                    @if ($route->isinformation_from_active == 'Y')
                        <br> #{{ strip_tags($route['information_from']) }}
                    @endif
                </td>
            </tr>

            <tr class="border-gray-top">
                <td class="w-25">
                    {{ $route['station_to']['name'] }}
                </td>
                <td class="w-75" style="white-space:wrap;font-size: 9px;">
                    <a href="https://www.andamanexpress.com/station/detail/{{ $route['station_to']['nickname'] }}"
                        class="text-main" target="_blank">Click to see your check-in points</a>
                    @if ($route->master_to_info == 'Y')
                        <br>#{{ strip_tags($route['master_to']) }}
                    @endif
                    @if ($route->isinformation_to_active == 'Y')
                        <br> #{{ strip_tags($route['information_to']) }}
                    @endif
                </td>
            </tr>

        </table>
    @endforeach
</div>
