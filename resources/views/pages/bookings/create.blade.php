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
            <div class="col-3">
                <i class="fi fi-time"></i> Detart Time: {{ date('H:i', strtotime($route['depart_time'])) }}
            </div>
            <div class="col-3">
                <i class="fi fi-time"></i> Arrive Time: {{ date('H:i', strtotime($route['arrive_time'])) }}
            </div>

            <div class="col-3">
                Regular Price: {{ number_format($route['regular_price']) }}THB
            </div>
            <div class="col-3">
                Child Price: {{ number_format($route['child_price']) }}THB
            </div>
        </div>
    </div>


    <div class="section mb-3">
        <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{ route('booking-store') }}">
            @csrf
            <fieldset id="booking-ceate">
                <input type="hidden" value="{{$route['id']}}" name="route_id" id="route_id" />
                <input type="hidden" value="{{ Auth::user()->id }}" name="user_id" id="user_id">
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1">
                        <div class="row mb-3">
                            <label class="col-3 col-md-2 col-form-label-sm">Depart Date <span class="text-danger">*</span></label>
                            <div class="col-9 col-md-4">
                                <input required type="text" name="departdate" id="departdate" value="{{ $departdate }}"
                                    class="form-control form-control-sm datepicker" data-show-weeks="true"
                                    data-today-highlight="true" data-today-btn="true" data-clear-btn="false"
                                    data-autoclose="true" data-date-start="today" data-format="DD/MM/YYYY">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-3 col-md-2 col-form-label-sm">Reference</label>
                            <div class="col-9 col-md-4">
                                <input type="text" class="form-control form-control-sm" name="reference"
                                    id="reference" />
                            </div>

                            <label class="col-1 col-form-label-sm text-end">A <span class="text-danger">*</span></label>
                            <div class="col-1">
                                <input type="number" class="form-control form-control-sm" name="adult_passenger"
                                    id="adult_passenger" required value="1"/>
                            </div>

                            <label class="col-1 col-form-label-sm text-end">C <span class="text-danger">*</span></label>
                            <div class="col-1">
                                <input type="number" class="form-control form-control-sm" name="child_passenger"
                                    id="child_passenger" required value="0" />
                            </div>

                            <label class="col-1 col-form-label-sm text-end">I <span class="text-danger">*</span></label>
                            <div class="col-1">
                                <input type="number" class="form-control form-control-sm" name="infant_passenger"
                                    id="infant_passenger" required value="0" />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-2 col-form-label-sm">Customer Name <span class="text-danger">*</span></label>
                            <div class="col-4">
                                <input type="text" class="form-control form-control-sm" name="fullname" id="fullname"
                                    required />
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-12 col-md-2 col-form-label-sm">Extra</label>
                            <div class="col-12 col-md-6">
                                <button class="btn btn-sm rounded-circle btn-outline-ferry" type="button" title="add extra" data-bs-toggle="modal" data-bs-target="#modalCentered"><i class="fi fi-plus"></i></button>
                                <div class="list-group">
                              
                                    
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-2 col-form-label-sm">Price <span class="text-danger">*</span></label>
                            <div class="col-2">
                                <input type="number" class="form-control form-control-sm" name="price" id="price"
                                    required value="{{$route['regular_price']}}"/>
                            </div>

                            <label class="col-2 col-form-label-sm text-end">Extra Price</label>
                            <div class="col-2">
                                <input type="text" class="form-control form-control-sm" name="extra_price" id="extra_price"
                                    value="0" value="0" />
                            </div>

                            <label class="col-2 col-form-label-sm text-end">Total Price</label>
                            <div class="col-2">
                                <input type="text" class="form-control form-control-sm" name="total_price" id="total_price"
                                    value="0" required readonly />
                            </div>
                        </div>
                        <hr>

                        <div class="row mb-3">
                            <label class="col-2 col-form-label-sm text-success">Pay</label>
                            <div class="col-3">
                                <div class="form-check mb-2">
                                    <input class="form-check-input form-check-input-danger" type="radio" name="ispayment"
                                        value="N" id="" required>
                                    <label class="form-check-label" for="checkDanger">Unpay</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input form-check-input-success" type="radio"
                                        name="ispayment" value="Y" id="" required>
                                    <label class="form-check-label" for="checkSuccess">Paid</label>
                                </div>
                            </div>

                            <label class="col-1 col-form-label-sm">Slip</label>
                            <div class="col-4">
                                <input class="form-control form-control-sm" id="formFileSm" type="file">
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
    </div>

@stop


@section('modal')
<!-- Modal -->
<div class="modal fade" id="modalCentered" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalCenteredLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalCenteredLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<table class="table">
                    <tbody>
                        @foreach($meals as $index => $meal)
                            <tr>
                                <td>
                                    <div class="avatar avatar-sm {{ !isset($meal['image_icon']) ? 'opacity-25' : 'opacity-100' }}" 
                                        style="background-image:url({{ isset($meal['image_icon']) ? asset('assets/images/meal/icon/'.$meal['image_icon']) : asset('assets/images/no_image_icon.svg') }})">
                                    </div>
                                </td>
                                <td class="text-start" data-id="name">{{ $meal['name'] }}</td>
                                <td class="text-end">{{ number_format($meal['amount']) }}THB</td>
                                <td class="text-end">
                                    <button class="btn btn-outline-success btn-sm">Select</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="button" class="btn btn-ferry">Save</button>
			</div>
		</div>
	</div>
</div>
@stop

@section('script')
<script>
    function calculateTotalPrice(){
        let price = isNaN($('#price').val())?0:$('#price').val();
        let extra_price = isNaN($('#extra_price').val())?0:$('#extra_price').val();
        let total_price = parseFloat(price)+parseFloat(extra_price);

        $('#total_price').val(total_price); 
    }

    $(document).ready(function(){
        calculateTotalPrice();

        $('#price').on('keyup',function(){
            calculateTotalPrice();
        });

        $('#extra_price').on('keyup',function(){
            calculateTotalPrice();
        });
    });
</script>
@stop