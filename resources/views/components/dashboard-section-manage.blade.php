@props(['text' => '', 'bg' => '', 'route' => ''])

<a href="{{ $route }}">
    <div class="section w-100" style="background-color: {{ $bg }}6b">
        <div class="d-flex w-100 align-items-center text-center">
            <span class="w-100 display-6 text-light fw-bold">
                {{ $text }}
            </span>
        </div>
    </div>
</a>