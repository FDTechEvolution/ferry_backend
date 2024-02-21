@if (sizeof($customers) > 1)
    <div class="prow mt-3">
        <h3>Passenger List</h3>
        <table class="ptable w-100">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Fullname</th>
                    <th>Birth Day</th>
                </tr>
            </thead>
            @foreach ($customers as $i => $customer)
                <tr>
                    <td>{{ $i + 1 }}.</td>
                    <td>{{ $customer['type'] }}</td>
                    <td>{{ $customer['title'] }}.{{ ucfirst($customer['fullname']) }}</td>
                    <td>{{ $customer['birth_day'] }}</td>

                </tr>
            @endforeach
        </table>
    </div>
@endif
