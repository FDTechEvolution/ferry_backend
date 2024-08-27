@if (sizeof($customers) > 1)
    <div class="prow mt-3">
        <table class="ptable w-100 border">
            <tr>
                <td colspan="4">
                    <h3>PASSENGER NAME LIST</h3>
                </td>
            </tr>
            @foreach ($customers as $i => $customer)
                <tr>
                    <td>{{ $i + 1 }}.</td>

                    <td>{{ $customer['title'] }}.{{ ucfirst($customer['fullname']) }}</td>
                    <td>{{ $customer['birth_day'] }}</td>
                    <td>
                        @if ($customer['type'] == 'ADULT')
                            <div class="ico-adult"></div>
                        @elseif ($customer['type'] == 'CHILD')
                            <div class="ico-child"></div>
                        @else
                            <div class="ico-infant"></div>
                        @endif

                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
