@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0 text-main-color-2" id="promotion-page-title">Create New Booking</h1>
@stop

<link rel="stylesheet" href="{{ asset('js/lou-multi-select/css/multi-select.css') }}">

@section('content')
    <div class="section bg-main-color mb-3">
        <div class="row">
            <div class="col-12">

                <h2 class="text-white">{{ $route['station_from']['name'] }} to {{ $route['station_to']['name'] }}</h2>
            </div>
        </div>
        <hr>
        <div class="row text-white">
            <div class="col-12 col-md-3">
                <i class="fi fi-time"></i> Detart Time: {{ date('H:i', strtotime($route['depart_time'])) }}
            </div>
            <div class="col-12 col-md-3">
                <i class="fi fi-time"></i> Arrive Time: {{ date('H:i', strtotime($route['arrive_time'])) }}
            </div>

            <div class="col-12 col-md-3">
                Regular Price: {{ number_format($route['regular_price']) }}THB
            </div>
            <div class="col-12 col-md-3">
                Child Price: {{ number_format($route['child_price']) }}THB
            </div>
        </div>
    </div>


        <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{ route('booking-store') }}">
            @csrf
            <fieldset id="booking-ceate">
                <input type="hidden" value="{{ $route['id'] }}" name="route_id" id="route_id" />
                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
                <div class="row">
                    <div class="col-12">
                        <div class="row mb-3">
                            <label class="col-5 col-md-2 col-form-label-sm">Depart Date <span
                                    class="text-danger">*</span></label>
                            <div class="col-7 col-md-4">
                                <input required type="text" name="departdate" id="departdate"
                                    value="{{ $departdate }}" class="form-control form-control-sm datepicker"
                                    data-show-weeks="true" data-today-highlight="true" data-today-btn="true"
                                    data-clear-btn="false" data-autoclose="true" data-date-start="today"
                                    data-format="DD/MM/YYYY">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-5 col-md-2 col-form-label-sm">Reference</label>
                            <div class="col-7 col-md-4 mb-3">
                                <input type="text" class="form-control form-control-sm" name="reference"
                                    id="reference" />
                            </div>

                            <label class="col-3 col-md-1 col-form-label-sm text-end">A <span
                                    class="text-danger">*</span></label>
                            <div class="col-3 col-md-1 ">
                                <input type="number" class="form-control form-control-sm" name="adult_passenger"
                                    id="adult_passenger" required value="1" />
                            </div>

                            <label class="col-3 col-md-1  col-form-label-sm text-end">C <span
                                    class="text-danger">*</span></label>
                            <div class="col-3 col-md-1 ">
                                <input type="number" class="form-control form-control-sm" name="child_passenger"
                                    id="child_passenger" required value="0" />
                            </div>

                            <label class="col-3 col-md-1  col-form-label-sm text-end">I <span
                                    class="text-danger">*</span></label>
                            <div class="col-3 col-md-1 ">
                                <input type="number" class="form-control form-control-sm" name="infant_passenger"
                                    id="infant_passenger" required value="0" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-12 col-md-2 col-form-label-sm">Customer Name <span
                                    class="text-danger">*</span></label>
                            <div class="col-12 col-md-4">
                                <input type="text" class="form-control form-control-sm" name="fullname" id="fullname"
                                    required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-12 col-md-2 col-form-label-sm">Extra</label>
                            <div class="col-12 col-md-6">
                                <table class="table" id="tb-extra">
                                    <tbody>

                                    </tbody>
                                </table>
                                <button class="btn btn-sm rounded-circle btn-outline-ferry" type="button" title="add extra"
                                    data-bs-toggle="modal" data-bs-target="#modalCentered"><i
                                        class="fi fi-plus"></i></button>
                                <div class="list-group">


                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-4 col-md-2 col-form-label-sm">Price <span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-md-2 mb-3">
                                <input type="number" class="form-control form-control-sm" name="price" id="price"
                                    required value="{{ $route['regular_price'] }}" />
                            </div>

                            <label class="col-4 col-md-2 col-form-label-sm">Extra Price</label>
                            <div class="col-8 col-md-2 mb-3">
                                <input type="text" class="form-control form-control-sm" name="extra_price"
                                    id="extra_price" value="0" value="0" />
                            </div>

                            <label class="col-4 col-md-2 col-form-label-sm">Total Price</label>
                            <div class="col-8 col-md-2 mb-3">
                                <input type="text" class="form-control form-control-sm" name="total_price"
                                    id="total_price" value="0" required readonly />
                            </div>
                        </div>
                        <hr>

                        <div class="row mb-3">
                            <label class="col-4 col-md-2 col-form-label-sm text-success">Pay <span
                                    class="text-danger">*</span></label>
                            <div class="col-8 col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-check-input-danger" type="radio"
                                        name="ispayment" value="N" id="" required>
                                    <label class="form-check-label" for="checkDanger">Unpay</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input form-check-input-success" type="radio"
                                        name="ispayment" value="Y" id="" required>
                                    <label class="form-check-label" for="checkSuccess">Paid</label>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3" id="box-payment-option" style="display: none;">
                            <label class="col-4 col-md-2 col-form-label-sm text-end">Payment Method</label>
                            <div class="col-8 col-md-3">
                                <select name="payment_method" id="payment_method" class="form-control">
                                    <option value="CASH">Cash</option>
                                    <option value="BANKING">Banking</option>
                                </select>
                            </div>
                            <label class="col-4 col-md-2 col-form-label-sm text-end">Slip</label>
                            <div class="col-8 col-md-4">
                                <input class="form-control form-control-sm" id="image_file" name="image_file" type="file" accept=".png, .jpg, .jpeg">
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <label class="col-12 col-md-2 col-form-label-sm">Note</label>
                            <div class="col-12 col-md-6">
                                <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row mb-3">
                            <div class="col-12 text-center">
                                <x-button-submit-loading class="btn-lg w--20 me-4 button-orange-bg" :form_id="_('booking-form')"
                                    :fieldset_id="_('booking-create')" :text="_('Save Booking')" />
                            </div>

                        </div>

                    </div>
                </div>
            </fieldset>
        </form>
    

@stop


@section('modal')
    <!-- Modal -->
    <div class="modal fade" id="modalCentered" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="modalCenteredLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCenteredLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            @php
                                $type = '';
                            @endphp
                            @foreach ($extras as $index => $item)
                                @if ($type != $item['type'])
                                    <tr>
                                        <td colspan="3">
                                            <h4>{{ $item['type'] }}</h4>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td style="width: 30%">
                                        @if (isset($item['image']))
                                            <img src="{{ $item['image']['path'] }}/{{ $item['image']['name'] }}"
                                                alt="" class="img-fluid">
                                        @endif
                                    </td>
                                    <td class="text-start">
                                        <p><strong>{{ $item['name'] }}</strong></p>
                                        {{ number_format($item['amount']) }}THB
                                    </td>

                                    <td class="text-end">
                                        <button class="btn btn-outline-secondary btn-sm" data-id="{{ $item['id'] }}"
                                            data-type="addon" data-action="extra" data-price="{{ $item['amount'] }}"
                                            data-title="{{ $item['name'] }}" data-value="N">Select</button>
                                    </td>
                                </tr>

                                @php
                                    $type = $item['type'];
                                @endphp
                            @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-ferry" data-bs-dismiss="modal">Save</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script>
        function calculateTotalPrice() {
            let price = isNaN($('#price').val()) ? 0 : $('#price').val();
            let extra_price = isNaN($('#extra_price').val()) ? 0 : $('#extra_price').val();
            let total_price = parseFloat(price) + parseFloat(extra_price);

            $('#total_price').val(total_price);
        }

        function calculateExtraPrice() {
            let extra_price = 0;
            let arr = $('input[name="addon_price[]"]').map(function() {
                //return this.value; // $(this).val()
                extra_price += parseFloat(this.value);
            }).get();

            $('#extra_price').val(extra_price);
            //calculateTotalPrice();
        }

        $(document).ready(function() {
            calculateTotalPrice();

            $('input[name="ispayment"]').change(function(){
                let selected_value = $("input[name='ispayment']:checked").val();
                if(selected_value =='Y'){
                    $('#box-payment-option').show();
                }else{
                    $('#box-payment-option').hide();
                }
            });

            $('#price').on('keyup', function() {
                calculateTotalPrice();
            });

            $('#extra_price').on('keyup', function() {
                calculateTotalPrice();
            });

            $('button[data-action="extra"]').on('click', function(e) {
                let id = $(this).data('id');
                let type = $(this).data('type');
                let title = $(this).data('title');
                let price = parseFloat($(this).data('price'));
                let value = $(this).attr('data-value');
                //console.log(value);
                if (value === 'N') {
                    $(this).attr('data-value', 'Y');
                    $(this).removeClass('btn-outline-secondary');
                    $(this).addClass('btn-success');
                    $(this).text('Selected');

                    //set select
                    let _title =
                        '<svg width="1.5em" height="1.5em" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"></path></svg> ' +
                        title;
                    let _inputprice = '<input type="hidden" name="addon_id[]" value="' + id +
                        '"/><input type="hidden" name="addon_price[]" value="' + price + '"/>';
                    let row = '<tr id="tr-extra-' + id + '"><td>' + _title + '</td><td>' + price + 'THB' +
                        _inputprice + '</td></tr>';
                    $("#tb-extra tbody").append(row);
                } else {
                    $(this).attr('data-value', 'N');
                    $(this).removeClass('btn-success');
                    $(this).addClass('btn-outline-secondary');
                    $(this).text('Select');

                    $('#tr-extra-' + id).remove();
                }

                calculateExtraPrice();
                calculateTotalPrice();


            });
        });
    </script>
@stop
