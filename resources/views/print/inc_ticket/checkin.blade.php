@if ($bookingRoute->master_from_info == 'Y' || $bookingRoute->master_to_info == 'Y'
||$bookingRoute->isinformation_to_active == 'Y' || $bookingRoute->isinformation_from_active == 'Y')


<div class="prow mt-3">

    <table class="w-100 ptable" style="margin-bottom: 5px;">
        <tr class="bg-gray font-w-700">
            <td>
                <h3>TRAVEL INFORMATION</h3>
            </td>
        </tr>
        <tr>

            <td style="white-space:wrap;font-size: 9px;">

                @if ($bookingRoute->master_from_info == 'Y')
                <br>#{{ strip_tags($bookingRoute['master_from']) }}
                @endif
                @if ($bookingRoute->isinformation_from_active == 'Y')
                <br> #{{ strip_tags($bookingRoute['information_from']) }}
                @endif
            </td>
        </tr>

        <tr class="border-gray-top">
            <td style="white-space:wrap;font-size: 9px;">

                @if ($bookingRoute->master_to_info == 'Y')
                <br>#{{ strip_tags($bookingRoute['master_to']) }}
                @endif
                @if ($bookingRoute->isinformation_to_active == 'Y')
                <br> #{{ strip_tags($bookingRoute['information_to']) }}
                @endif
            </td>
        </tr>

    </table>

</div>
@endif