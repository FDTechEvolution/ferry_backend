@props(['routeAddons' => [], 'name' => '', 'type' => '', 'subtype' => ''])

@if(!empty($routeAddons))
    @foreach ($routeAddons as $addon)
        @if($addon['type'] == $type && $addon['subtype'] == $subtype)
            @if($addon['isactive'] == 'Y')
                <i class="fa-solid fa-circle text-success"
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ $name }}">
                </i>
            @else
                <i class="fa-solid fa-circle text-secondary"
                    data-bs-toggle="tooltip" data-bs-placement="top"
                    title="{{ $name }}">
                </i>
            @endif
        @endif
    @endforeach
@else
    <i class="fa-solid fa-circle text-secondary"
        data-bs-toggle="tooltip" data-bs-placement="top"
        title="{{ $name }}">
    </i>
@endif
