@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Affected</span> bookings</h1>

@stop

@php
    $colors = [
        'one-way' => '#0580c4',
        'round-trip' => '#00bf63',
        'multi-trip' => '#ff6100',
    ];
@endphp

@section('content')
    <div class="row">
        <div class="col-12">
            <a href="{{ route('routeSchedules.index') }}?merchant_id={{ $merchant_id }}" class="btn btn-secondary"><i
                    class="fi fi-arrow-left"></i> Back</a>

            @if (isset($apiMerchant) && !is_null($apiMerchant))
                <img src="{{ $apiMerchant->logo }}" width="200px" class="px-2" />
            @endif
        </div>
    </div>
    <hr>
    <div class="row">

        <div class="col-12">
            <h5><i class="fa-regular fa-envelope"></i> Cancel and Send Email</a></h5>
            <form class="bs-validate" novalidate="" id="frm" method="post"
                action="{{ route('routeSchedules.sendVoidBooking') }}">
                @csrf
                <input type="hidden" id="merchant_id" name="merchant_id" value="{{$merchant_id}}">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="" id="message" name="message" style="height: 150px"></textarea>
                            <label for="message">Email Message</label>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6">
                        <a href="#" data-href="#"
                        class="js-ajax-confirm btn btn-sm btn-facebook transition-hover-top"
                            data-ajax-confirm-mode="ajax" data-ajax-confirm-type="warning"
                            data-ajax-confirm-title="Please Confirm"
                            data-ajax-confirm-body="Are you sure you want to cancel selected booking?"
                            data-ajax-confirm-btn-yes-class="btn-sm btn-warning" data-ajax-confirm-btn-yes-text="Confirm"
                            data-ajax-confirm-btn-yes-icon="fi fi-check" data-ajax-confirm-btn-no-class="btn-sm btn-light"
                            data-ajax-confirm-btn-no-text="Cancel" data-ajax-confirm-btn-no-icon="fi fi-close"
                            data-ajax-confirm-callback-function="send_email">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>Send Email</span>
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-framed">
                        <thead>
                            <th class="text-gray-500" style="width:80px">
                                <div class="form-check"><!-- check all -->
                                    <input data-checkall-container="#item_list" class="checkall form-check-input"
                                        type="checkbox" id="check_all">All
                                </div>
                            </th>
                            <th class="">Issue Date</th>
                            <th>Invoice No</th>
                            <th class="text-center">Passengers</th>
                            <th>Type</th>
                            <th>Route</th>
                            <th>Depart Date</th>
                            <th class="text-end">Price</th>
                            <th class="text-center">Status</th>
                            <th>Admin</th>
                            <th>Sales Ch</th>
                            <th class="text-center">Action</th>
                        </thead>

                        <tbody id="item_list">
                            @foreach ($bookings as $index => $item)
                                <tr
                                    style="color: {{ $colors[$item['trip_type']] }};--bs-table-color:{{ $colors[$item['trip_type']] }};">
                                    <td>
                                        <div class="form-check mb-2">
                                            <input class="form-check-input form-check-input-primary" data-action="check_all"
                                                type="checkbox" value="{{ $item['booking_route_id'] }}" id="book_{{ $item['booking_route_id'] }}"
                                                name="booking_route_id[]">

                                        </div>
                                    </td>
                                    <td><small>{{ date('d/m/Y H:i', strtotime($item['created_at'])) }}</small></td>
                                    <td>{{ $item['bookingno'] }}</td>
                                    <td class="text-center">
                                        {{ $item['adult_passenger'] + $item['child_passenger'] + $item['infant_passenger'] }}</strong>
                                    </td>
                                    <td>{{ $item['trip_type'] }}</td>
                                    <td>
                                        {{ $item['route'] }}<br>
                                        <small><span
                                                class="badge rounded-pill bg-secondary">{{ date('H:i', strtotime($item['depart_time'])) }}-{{ date('H:i', strtotime($item['arrive_time'])) }}</span></small>
                                    </td>
                                    <td>{{ date('d/m/Y', strtotime($item['traveldate'])) }}</td>
                                    <td class="text-end">{{ number_format($item['totalamt']) }}</td>
                                    <td class="text-center">
                                        @if ($item['ispayment'] == 'Y')
                                            <span class="text-success">Paid</span>
                                        @else
                                            <span class="text-danger">Unpay</span>
                                        @endif

                                    </td>
                                    <td>
                                        {{ $item['firstname'] }}
                                    </td>
                                    <td><small>{{ $item['book_channel'] }}</small></td>
                                    <td class="text-end">
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="transition-hover-top fs-5 me-2" rel="noopener" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="View and Edit ooking">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('booking-view', ['id' => $item['id']]) }}"
                                            class="transition-hover-top fs-5 text-danger" rel="noopener" target="_blank"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel this Order">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
@stop



@section('script')
    <script>
        var send_email = function(el, data) {
            $('#frm').submit();
        }

        function settingActionLink(active) {
            if (active) {
                $('#action-print').removeClass('disabled');
                $('#action-send-email').removeClass('disabled');
            } else {
                $('#action-print').addClass('disabled');
                $('#action-send-email').addClass('disabled');
            }
        }
        $(document).ready(function() {
            $('#check_all').on('change', function() {
                //let all_booking_checks = $('input[data-action="check_all"]');
                let checked = false;

                if (this.checked) {
                    checked = true;
                    settingActionLink(true);
                } else {
                    settingActionLink(false);
                }


            });

            $('input[data-action="check_all"]').on('change', function() {
                let all_booking_checks = $('input[data-action="check_all"]');

                settingActionLink(false);
                $.each(all_booking_checks, function(index, item) {
                    if (item.checked) {
                        settingActionLink(true);
                        return true;
                    }
                });
            });

        });
    </script>
@stop
