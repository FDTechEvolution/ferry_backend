@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API</span> Management</h1>
@stop

@section('content')
<div class="row">
    <div class="col-12 col-lg-6">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th class="text-center">#</th>
                    <th>Name</th>
                    <th class="text-center">Status</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($merchant as $index => $item)
                    <tr>
                        <td class="text-center">{{ $index +1 }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td class="text-center">
                            <label class="d-flex justify-content-center align-items-center">
                                <input class="d-none-cloaked section-isactive" type="checkbox" name="isactive" value="" checked />
                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                            </label>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('api-route-index', ['merchant_id' => $item['id']]) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="View API List">
                            <i class="fa-solid fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
