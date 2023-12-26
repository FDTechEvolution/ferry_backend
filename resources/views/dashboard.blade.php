@extends('layouts.default')

@section('content')
    <!-- PAGE TITLE -->
    <div class="py-2 px-5">
        <header>
            <div class="row">
                <div class="col-12 col-md-6 col-xl-7">
                    <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}" class="w-100 mb-sm-4">

                </div>
                <div class="col-12 col-md-6 col-xl-5 my-auto">
                    <h1 class="display-1 fw-bold ms-5 text-main-color text-center">
                        Welcome
                    </h1>
                </div>
            </div>
        </header>

        <div class="row mt-3">
            <div class="col-lg-5 order-lg-2">
                <div class="section w-100" style="background-color: #ADD8E66b;">
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2">
                            @if (Auth::user()->image != '')
                                <img src="{{ asset('assets/images/avatar/' . Auth::user()->image) }}" class="w-100"
                                    alt="">
                            @else
                                <img src="{{ asset('assets/images/avatar/blank-profile-picture.png') }}" class="w-100 rounded-circle"
                                    alt="">
                            @endif
                        </div>
                        <div class="col-12  text-center">
                            <span class="w-100 mb-4 display-4 fw-bold text-main-color">
                                {{ $role }}
                            </span>
                        </div>
                    </div>

                </div>
            </div>
            <div class="col-lg-7 order-lg-1">
                <div class="row mt-4">
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-dashboard-section-manage :text="_('Account')" :bg="_('#ADD8E6')" :route="route('users-index')" />
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-dashboard-section-manage :text="_('Station')" :bg="_('#ADD8E6')" :route="route('stations-index') " />
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-dashboard-section-manage :text="_('Booking')" :bg="_('#ADD8E6')" :route="route('booking-index')" />
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-dashboard-section-manage :text="_('Route')" :bg="_('#ADD8E6')" :route="route('route-index')" />
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <x-dashboard-section-manage :text="_('Report')" :bg="_('#ADD8E6')" :route="_('#')" />
                    </div>
                    <div class="col-12 col-md-6 col-xl-4">
                        <a href="#" class = 'js-ajax-confirm' data-href="{{ route('logout') }}"
                            data-ajax-confirm-mode="regular" data-ajax-confirm-type="primary"
                            data-ajax-confirm-size="modal-md" data-ajax-confirm-centered="false"
                            data-ajax-confirm-title="Please Confirm" data-ajax-confirm-body="Logout?"
                            data-ajax-confirm-btn-yes-class="btn-primary" data-ajax-confirm-btn-yes-text="Yes"
                            data-ajax-confirm-btn-yes-icon="fi fi-check" data-ajax-confirm-btn-no-class="btn-light"
                            data-ajax-confirm-btn-no-text="Cancel" data-ajax-confirm-btn-no-icon="fi fi-close">
                            <div class="section w-100" style="background-color: #ff61006b">
                                <div class="d-flex w-100 align-items-center text-center">
                                    <span class="w-100 display-7 text-light fw-bold">
                                        Logout
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* header#header {
            display: none !important;
        } */
        body.layout-admin #middle {
            padding-top: 0;
        }

        .section:before {
            content: '';
            display: block;
            padding-bottom: 100%;
        }

        .section {
            border-radius: 25px !important;
            display: -webkit-inline-box;
        }

        .avatar-custom {
            height: 16rem !important;
            width: 16rem !important;
        }

        @media only screen and (min-width: 992px) {
            body.layout-admin.layout-padded #header {
                display: none !important;
            }
        }

        @media (max-width: 412px) {
            body.layout-admin #middle {
                margin-top: 10px !important;
            }
        }
    </style>
@stop
