@props(['text' => '', 'bg' => '', 'route' => ''])

<a href="{{ $route }}" class="text-success-hover">
    <div class="section w-100 transition-hover-zoom " style="background-color: {{ $bg }}6b">
        <div class="d-flex w-100 align-items-center text-center">
            <span class="w-100 display-7 fw-bold">
                {{ $text }}
            </span>
        </div>
    </div>
</a>