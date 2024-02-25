@extends('layouts.ajaxmodal')

@section('content')
    <div class="modal-header">
        <h4 class="modal-title m-0">
            Edit Passenger
        </h4>

        <button type="button" class="close pointer" data-bs-dismiss="modal" aria-label="Close">
            <span class="fi fi-close " aria-hidden="true"></span>
        </button>
    </div>

    <form novalidate class="bs-validate" id="frm" method="POST"
        action="{{ route('customer.update', ['customer' => $customer]) }}">
        @csrf
        @method('PATCH')
        <input type="hidden" name="id" value="{{$customer->id}}">
        <input type="hidden" name="booking_id" value="{{$bookingId}}">
        <div class="modal-body p-4">

            <div class="row">
                <div class="col-12 col-lg-2 form-floating mb-3">
                    <select required class="form-select form-select-sm" name="title" id="passenger-title"
                        aria-label="Floating label select example">

                        <option value="mr" @selected($customer->title=='mr')>Mr.</option>
                        <option value="mrs" @selected($customer->title=='mrs')>Mrs.</option>
                        <option value="ms" @selected($customer->title=='ms')>Ms.</option>
                        <option value="other" @selected($customer->title=='other')>Other</option>
                    </select>
                    <label for="passenger-title">Title<span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-lg-6 form-floating mb-3">
                    <input required type="text" class="form-control form-control-sm" name="fullname"
                        id="passenger-full-name" placeholder="Full name" value="{{$customer->fullname}}">
                    <label for="passenger-first-name" class="ms-2">Full name<span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-lg-4 form-floating mb-3">
                    <input required type="text" name="birth_day" value="{{$customer->birth_day}}"
                        class="form-control form-control-sm datepicker" data-show-weeks="true"
                        data-today-highlight="true" data-today-btn="false" data-clear-btn="false" data-autoclose="true"
                        data-format="YYYY-MM-DD" data-date-end="{{$customer->birth_day}}" autocomplete="off"
                        placeholder="Date of Birth">
                    <label class="ms-2">Date of Birth<span class="text-danger">*</span></label>
                </div>

                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control form-control-sm"
                                    id="passenger-email" placeholder="E-mail" autocomplete="true" value="{{$customer->email}}">
                                <label for="passenger-email" class="ms-2">E-mail</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 form-floating mb-3">
                    <select class="form-select form-select-sm" name="country" id="passenger-country"
                        aria-label="Floating label select example" autocomplete="true">
                        <option value="" selected disabled>Select Country</option>
                        @foreach ($country_list as $key => $country)
                            <option value="{{ $country }}" @selected($customer->country == $country)>{{ $country }}</option>
                        @endforeach
                    </select>
                    <label for="passenger-country">Country</label>
                </div>

                <div class="col-12 col-lg-6 mb-3">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Telephone number ( <i
                                    class="fi fi-phone"></i> )</label>
                            <div class="row">
                                <div class="col-4">
                                    <select class="form-select" name="mobile_code" id="passenger-mobile-code">
                                        <option value="" selected disabled></option>
                                        @foreach ($code_country as $code)
                                            <option value="{{ $code }}" @selected($customer->mobile_code==$code)>
                                                +{{ $code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-8">
                                    <input type="number" class="form-control" id="passenger-mobile"
                                        name="mobile" value="{{$customer->mobile}}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label class="form-label">Thai telephone number</label>
                    <div class="row">

                        <div class="col-12">
                            <input type="number" name="mobile_th" id="mobile_th" class="form-control" value="{{$customer->mobile_th}}">
                        </div>
                    </div>
                </div>

                <div class="col-12 col-lg-4 form-floating mb-3">
                    <input type="text" name="passportno" class="form-control form-control-sm"
                        id="passportno" placeholder="Passport Number" value="{{$customer->passportno}}">
                    <label for="passportno" class="ms-2">Passport Number</label>
                </div>
                <div class="col-12 form-floating mb-3">
                    <textarea class="form-control" placeholder="Address" id="fulladdress" name="fulladdress" style="height: 100px"
                        autocomplete="true">{{$customer->fulladdress}}</textarea>
                    <label for="fulladdress" class="ms-2">Address</label>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">SAVE </button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

        </div>
    </form>


@stop
