<div class="prow">
    <table class="w-100 ptable" style="padding-bottom: 10px;">
        <tr class="bg-gray font-w-700">
            <td style="width: 22%;">DATE</td>

            <td>ADDON</td>
            <td class="text-center" style="width: 12%;">QTY</td>
            <td class="text-center" style="width: 14%;">TIME</td>
            <td class="text-end" style="width: 14%;">AMOUNT</td>
        </tr>

        @forelse ($addonRows as $addon)
        <tr class="border-gray-top">
            <td>
                {{ date('l d M Y', strtotime($booking['departdate'] ?? $booking['created_at'])) }}
            </td>

            <td style="white-space:wrap;">
                {{ $addon['type_label'] }}<br>
                <span class="font-bold-14">{{ $addon['name'] }}</span>

            </td>
            <td class="text-center">
                <span class="font-bold-14">{{ $addon['qty'] }}</span>
            </td>
            <td class="text-center">
                @if (!empty($addon['departure_time']))
                <span class="font-bold-14">{{ date('H:i', strtotime($addon['departure_time'])) }}</span>
                @else
                -
                @endif
            </td>
            <td class="text-end">
                <span class="font-bold-14">{{ number_format($addon['amount'] * $addon['qty']) }}</span>
            </td>
        </tr>
        @empty
        <tr class="border-gray-top">
            <td colspan="6">No addon items</td>
        </tr>
        @endforelse
    </table>
</div>
