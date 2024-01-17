@props(['isactive' => ''])
@if ($isactive == 'Y')
<span class="text-success"><i class="fa-solid fa-earth-americas"></i> On</span>
@else
<span class="text-muted"><i class="fa-solid fa-earth-americas"></i> Off</span>
@endif
