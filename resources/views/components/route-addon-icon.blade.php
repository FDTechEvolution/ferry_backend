@props(['routeAddons' => [], 'subtype' => ''])

@foreach ($routeAddons as $addon)
    @if($addon['subtype'] == $subtype)
        @if($addon['type'] == 'shuttle_bus' && $addon['isactive'] == 'Y')
            <img class="me-1 cursor-pointer" src="{{ asset('icon/route/ico-bus.png') }}" width="20"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $addon['name'] }}">
        @endif
        @if($addon['type'] == 'longtail_boat' && $addon['isactive'] == 'Y')
            <img class="me-1 cursor-pointer" src="{{ asset('icon/route/ico-long-tail-boat.png') }}" width="20"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $addon['name'] }}">
        @endif
        @if($addon['type'] == 'private_taxi' && $addon['isactive'] == 'Y')
            <img class="me-1 cursor-pointer" src="{{ asset('icon/route/ico-private-taxi.png') }}" width="20"
                data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $addon['name'] }}">
        @endif
    @endif
@endforeach
