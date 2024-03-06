@props(['price' => 0, 'discount' => 0, 'ontop' => 0])

@if ($discount > 0 && $ontop == 0)
    <del class="text-muted">{{ number_format($price) }}</del>
    <strong>{{ number_format($price - ($price * $discount) / 100) }}</strong>
@elseif ($discount > 0 && $ontop > 0)
    <del class="text-muted">{{ number_format($price) }}</del>
    @php
        $price = $price - ($price * $discount) / 100;
    @endphp
    <del class="text-muted">{{ number_format($price) }}</del>
    <strong>{{ number_format($price - ($price * $ontop) / 100) }}</strong>
@elseif ($discount == 0 && $ontop > 0)
    <del class="text-muted">{{ number_format($price) }}</del>
    <strong>{{ number_format($price - ($price * $ontop) / 100) }}</strong>
@else
    {{ number_format($price) }}
@endif
