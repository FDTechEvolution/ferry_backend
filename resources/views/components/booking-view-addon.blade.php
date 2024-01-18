@props(['booking_route' => [], 'subtype' => ''])

@foreach ($booking_route as $addon)
    @if($addon['subtype'] == $subtype)
        @if ($addon['type'] == 'shuttle_bus')
            <img class="ms-1 cursor-pointer" src="{{ asset('icon/route/ico-bus.png') }}" width="20"
                title="{{ $addon['name'] }}"
                data-bs-toggle="popover" data-bs-placement="bottom"
                data-bs-content="{{ $addon['pivot']['description'] }}"
            >
        @endif
        @if ($addon['type'] == 'longtail_boat')
            <img class="ms-1 cursor-pointer" src="{{ asset('icon/route/ico-long-tail-boat.png') }}" width="20"
                title="{{ $addon['name'] }}"
                data-bs-toggle="popover" data-bs-placement="bottom"
                data-bs-content="{{ $addon['pivot']['description'] }}"
            >
        @endif
        @if ($addon['type'] == 'private_taxi')
            <img class="ms-1 cursor-pointer" src="{{ asset('icon/route/ico-private-taxi.png') }}" width="20"
                title="{{ $addon['name'] }}"
                data-bs-toggle="popover" data-bs-placement="bottom"
                data-bs-content="{{ $addon['pivot']['description'] }}"
            >
        @endif
    @endif
@endforeach
