@props(['label' => 'Station', 'name' => '','selected'=>'','data'=>[],'required'=>false ])


<select class="form-select" name="{{ $name }}" id="{{ $name }}" @required($required)>
    <option value="" selected>- ALL -</option>
    @foreach ($data as $index => $section)
    <optgroup label="{{ $section['name'] }}">
        @foreach ($section['stations'] as $station)
        <option value="{{ $station['id'] }}" @selected($selected==$station['id'])>
            @if ($station['nickname'] != '')
            [{{ $station['nickname'] }}]
            @endif
            {{ $station['name'] }}
            @if ($station['piername'] != '')
            ({{ $station['piername'] }})
            @endif
        </option>
        @endforeach
    </optgroup>
    @endforeach
</select>
<label for="{{ $name }}">{{ $label }}</label>