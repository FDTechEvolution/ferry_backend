@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API</span> Management</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12">
            <table class="table table-hover table-lg">
                <thead>
                    <tr>

                        <th></th>
                        <th>Name</th>
                        <th class="text-center">Commission (%)</th>
                        <th class="text-center">Vat. (%)</th>
                        {{-- <th class="text-center">Status</th> --}}
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>

                        <td>
                            <img src="{{ $merchant->logo }}" width="100px" />
                        </td>
                        <td>{{ $merchant['name'] }}</td>
                        <td class="text-center">{{ $merchant['commission'] }}</td>
                        <td class="text-center">{{ $merchant['vat'] }}</td>
                        <td class="d-flex justify-content-end align-items-center">
                            <x-api-merchant-comm-vat :comm="$merchant['commission']" :vat="$merchant['vat']" :id="$merchant['id']" />
                            <a href="{{ route('api-route-index', ['merchant_id' => $merchant['id']]) }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" title="" class="ms-2">
                                <i class="fa-solid fa-gear"></i> Routes Setting
                            </a>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-8">
            <h4><i class="fa-solid fa-store"></i> Agent API Services</h4>
        </div>
        <div class="col-4 text-end">
            <a href="#" data-href="{{ route('api.create') }}" data-ajax-modal-size="modal-md"
                data-ajax-modal-centered="true" data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                class="btn btn-ferry js-ajax-modal"><i class="fa-solid fa-plug-circle-plus"></i> Create</a>
        </div>
        <div class="col-12">
            <table class="table table-hover table-align-middle table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Code</th>
                        <th>API KEY</th>
                        <th>On Top Discount</th>
                        <th>Des/Note</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apiMerchants as $index => $apiMerchant)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $apiMerchant->name }}</td>
                            <td>{{ $apiMerchant->code }}</td>
                            <td>{{ $apiMerchant->key }}</td>
                            <td>{{ $apiMerchant->discount }}%</td>
                            <td>{{ $apiMerchant->description }}</td>
                            <td class="text-end">
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <a href="{{ route('api.edit', ['id' => $apiMerchant->id]) }}"
                                        class="btn btn-sm btn-primary"><i class="me-0 fa-solid fa-gear"></i></a>

                                    <a href="{{ route('api.destroy', ['id' => $apiMerchant->id]) }}"
                                        class="btn btn-sm btn-danger"><i class="me-0 fa-solid fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
