@extends('layouts.default')

@section('content')
<!-- PAGE TITLE -->
<header>
    <div class="row">
        <div class="col-12 d-flex">
            <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}">
            <h1 class="display-1 fw-bold ms-5 text-main-color">
                Welcome
            </h1>
        </div>
    </div>
</header>

<div class="row mt-7">
    <div class="col-7">
        <div class="row mt-4">
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Account')"
                    :bg="_('#ADD8E6')"
                    :route="route('users-index')"
                />
            </div>
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Manage')"
                    :bg="_('#ADD8E6')"
                    :route="_('#')"
                />
            </div>
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Booking')"
                    :bg="_('#ADD8E6')"
                    :route="_('#')"
                />
            </div>
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Route Stations')"
                    :bg="_('#ADD8E6')"
                    :route="_('#')"
                />
            </div>
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Report')"
                    :bg="_('#ADD8E6')"
                    :route="_('#')"
                />
            </div>
            <div class="col-4">
                <x-dashboard-section-manage 
                    :text="_('Logout')"
                    :bg="_('#ff6100')"
                    :route="route('logout')"
                />
            </div>
        </div>
    </div>
    <div class="col-5">
        <div class="section w-100" style="background-color: #ADD8E66b;">
            <div class="d-flex flex-wrap w-100 align-items-center text-center">
                <span class="w-100 mt-4 display-4 fw-bold text-main-color">
                    Member Admin
                </span>
                <span class="w-100">
                    <div class="avatar avatar-custom rounded-circle" style="background-image:url('https://cdn.pixabay.com/photo/2016/12/19/21/36/woman-1919143_1280.jpg')"></div>
                </span>
                <span class="w-100 mb-4 display-4 fw-bold text-main-color">
                    admin
                </span>
            </div>
        </div>
    </div>
</div>

<style>
    header#header {
        display: none !important;
    }
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
        height: 16rem!important;
        width: 16rem!important;
    }
</style>
@stop