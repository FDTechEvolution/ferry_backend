<div class="prow">
    <table class="w-100 ptable" style="margin-bottom: 5px;">
        <tr class="bg-gray font-w-700">
            <td>
                <h3 style="margin-top:0px;margin-bottom: 0px;">ADDON INFORMATION</h3>
            </td>
        </tr>

        @forelse ($addonRows as $addon)
        <tr class="{{ !$loop->first ? 'border-gray-top' : '' }}">
            <td style="white-space:wrap;font-size: 9px;">
                <p style="margin-bottom: 4px;">
                    <strong>{{ $addon['type_label'] }}:</strong> {{ $addon['name'] }}
                    @if ($addon['qty'] > 1)
                    (x{{ $addon['qty'] }})
                    @endif
                </p>
                @if (!empty($addon['description']))
                <div>{!! $addon['description'] !!}</div>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td style="white-space:wrap;font-size: 9px;">No addon details</td>
        </tr>
        @endforelse
    </table>
</div>
