@extends('layouts.default')

@section('page-title')
<h1 class="ms-2 mb-0" id="promotion-page-title"><span class="text-main-color-2">API</span> Management</h1>
@stop

@section('content')

<div class="row">
    <div class="col-8">
        <h4><i class="fa-solid fa-store"></i> Agent API Services</h4>
    </div>
    <div class="col-4 text-end">
        <a href="#" data-href="{{ route('api.create') }}" data-ajax-modal-size="modal-md"
            data-ajax-modal-centered="true" data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
            class="btn btn-ferry js-ajax-modal"><i class="fa-solid fa-plug-circle-plus"></i> Create</a>
    </div>
    <div class="col-12 mt-2">
        <table class="table table-hover table-align-middle table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>API Code</th>
                    <th>API KEY</th>
                    <th class="text-center">Regular</th>
                    <th class="text-center">Child</th>
                    <th class="text-center">Infant</th>

                    <th>Description</th>
                    <th class="text-end">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($apiMerchants as $index => $apiMerchant)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if (!is_null($apiMerchant->image))
                        <div class="avatar avatar-md rounded-circle"
                            style="background-image:url({{asset($apiMerchant->image->path)}})"></div>
                        @endif
                    </td>
                    <td>{{ $apiMerchant->name }}</td>
                    <td>{{ $apiMerchant->code }}</td>
                    <td>{{ $apiMerchant->key }}</td>
                    <td class="text-center">
                        @if ($apiMerchant->isopenregular =='Y')
                        <span class="text-success">
                            <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z">
                                </path>
                            </svg>
                        </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($apiMerchant->isopenchild =='Y')
                        <span class="text-success">
                            <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z">
                                </path>
                            </svg>
                        </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($apiMerchant->isopeninfant =='Y')
                        <span class="text-success">
                            <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                class="bi bi-patch-check-fill" viewBox="0 0 16 16">
                                <path
                                    d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01-.622-.636zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708z">
                                </path>
                            </svg>
                        </span>
                        @endif
                    </td>

                    <td>{{ $apiMerchant->description }}</td>
                    <td class="text-end">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="#" data-href="{{ route('api.editMerchant',['id'=>$apiMerchant->id]) }}"
                                data-ajax-modal-size="modal-md" data-ajax-modal-centered="true"
                                data-ajax-modal-callback-function="" data-ajax-modal-backdrop="static"
                                class="btn btn-sm btn-primary js-ajax-modal"><i
                                    class="me-0 fa-solid fa-pen-to-square"></i></a>

                            <a href="{{ route('api.edit', ['id' => $apiMerchant->id]) }}"
                                class="btn btn-sm btn-secondary"><i class="me-0 fa-solid fa-gear"></i></a>

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