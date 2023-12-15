@props(['text' => '', 'href' => '', 'target' => ''])

<a href="{{ $href }}" 
    target="{{ $target }}" 
    {{ $attributes->merge(['class' => 'btn button-green-bg border-radius-10']) }}
>{{ $text }}</a>