@props(['stationfrom' => null, 'stationto' => null, 'icons' => null,'txt'=>'empty'])

<dl class="row mb-0">
    @if (!is_null($stationfrom))
        <dt class="col-sm-4">
            [{{ $stationfrom['nickname'] }}]
            {{ $stationfrom['name'] }}
            @if ($stationfrom['piername'] != '')
                <br>
                <small class="text-secondary fs-d-80">({{ $stationfrom['piername'] }})</small>
            @endif
        </dt>
        <dt class="col-sm-2 align-middle">
            <i class="fa-solid fa-angles-right px-2 fa-2x"></i>
        </dt>
    @endif
    @if (!is_null($stationto))
        <dt class="col-sm-4">
            [{{ $stationto['nickname'] }}]
            {{ $stationto['name'] }}
            @if ($stationto['piername'] != '')
                <br>
                <small class="text-secondary fs-d-80">({{ $stationto['piername'] }})</small>
            @endif
        </dt>
    @endif

    @if (!is_null($icons))
    <dt class="col-sm-10">
        <div class="row mx-auto border-top">
            @foreach ($icons as $icon)
                <div class="col-sm-4 px-0" style="width: 30px;">
                    <img src="{{ $icon['path'] }}" class="w-100">
                </div>
            @endforeach
        </div>
    </dt>
    @endif


</dl>


