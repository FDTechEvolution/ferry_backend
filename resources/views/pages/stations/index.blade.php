@extends('layouts.default')

@section('page-title')
    <div class="row ms-md-2 d-md-flex flex-md-wrap flex-lg-nowrap">
        <div class="col-12 col-md-7 my-auto">
            <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Station</span> manager</h1>
        </div>
        <div class="col-12 col-md-12 col-lg-12">
            <x-a-href-green :text="_('Add')" :href="route('create-station')" :target="_('_self')" class="" />


            <x-a-href-orange :text="_('Manage Section')" :href="route('section.index')" :target="_('_self')" class="" />
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <table class="table table-hover">

                <tbody>
                    @foreach ($sections as $i=> $section)
                    <tr>
                        <td colspan="8" class="@if($i>0) pt-5 @endif">
                            <strong class="text-main-color-2">{{$section->name}}</strong>
                        </td>
                    </tr>
                    <tr>
                        <th>Sort</th>
                        <th>Station Name</th>
                        <th>Nick Name</th>
                        <th>Pier</th>
                        <th class="text-center">Status</th>
                        <th>Image</th>
                        <th>Google Map</th>
                        <th></th>
                    </tr>
                        @foreach ($section->stations as $index => $station)
                            <tr>
                                <td>{{ $station->sort }}</td>
                                <td>{{ $station->name }}</td>
                                <td>{{ $station->nickname }}</td>
                                <td>{{ $station->piername }}</td>

                                <td>
                                    {{-- {!! $status[$station['isactive']] !!} --}}
                                    <label class="d-flex justify-content-center align-items-center">
                                        <input class="d-none-cloaked station-isactive" type="checkbox" name="isactive" value="{{ $station->id }}" @checked(old('isactive', $station->isactive == 'Y'))>
                                        <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                                        {{-- <span class="px-2 user-select-none">{{ $station->isactive == 'Y' ? 'On' : 'Off' }}</span> --}}
                                    </label>
                                </td>
                                <td>
                                    @if (isset($station->image->path))
                                        <div class="avatar avatar-sm"
                                            style="background-image:url({{ asset('/' . $station->image->path) }})">
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($station['google_map'] != null && $station['google_map'] != '')
                                        <a href="https://www.google.co.th/maps/dir//{{ $station['google_map'] }}"
                                            target="_blank"><i class="fa-solid fa-location-dot"></i></a>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <input type="hidden" id="station-id-{{ $index }}"
                                        value="{{ $station['id'] }}">
                                    <input type="hidden" id="station-section-{{ $index }}"
                                        value="{{ $station['section']['id'] }}">
                                    <input type="hidden" id="station-status-{{ $index }}"
                                        value="{{ $station['isactive'] }}">
                                    <x-action-edit class="me-2" :url="route('edit-station', ['id' => $station['id']])" id="btn-station-edit" />
                                    <x-action-delete :url="route('station-delete', ['id' => $station['id']])" :message="_('Are you sure? Delete ' . $station['name'] . '?')" />
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <style>
        @media (max-width: 412px) {
            body.layout-admin #middle {
                margin-top: 140px !important;
            }
        }
    </style>
@stop

@section('modal')
    <div class="modal fade" id="modal-station-info" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="station-info-modal-title"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="station-info-modal-content">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')

    <script src="{{ asset('assets/js/app/station.js') }}"></script>

    <script>
        $(document).ready(function() {
            /*
            $('#text').on('keyup',function(){
                let str = $(this).val();
                str = str.replace(/[^\x00-\x7F]/g, "");
                console.log(str);
            });
            */
        });
    </script>
@stop
