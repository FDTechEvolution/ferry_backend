@extends('layouts.blank')

@section('content')
<div class="d-lg-flex text-white min-vh-100" style="background: #eeeee8;">
    <div class="col-12 col-lg-7 d-lg-flex">
        <div class="w-100">

            <div class="py-7 px-5 me-lg-7 mt-lg-6">
                <h1 class="d-inline-block text-align-end text-end-md text-end-xs display-4 w-100">
                    <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}" class="ps-lg-8 w-100">
                    <h1 class="display-1 d-block fw-medium mt-4 mt-lg-7 text-center text-lg-end fw-bold" style="color: #0a3961;">
                        Welcome
                    </h1>
                </h1>
            </div>

        </div>
    </div>


    <div class="col-12 col-lg-5 d-lg-flex">
        <div class="w-100 align-self-center text-center-md text-center-xs p-2">
            
            <form novalidate onSubmit="return formSubmit()" id="password-reset-form" class="bs-validate" method="POST" action="{{ route('update-password') }}">
            @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="p-5 pb-3 border-radius-30 d-inline-block bg-white text-dark w-100 max-w-600 mb-4">
                    <div class="text-center mb-5">
                        <h1 class="fw-bold" style="color: #ff6100;">Reset Password</h1>
                    </div>

                    <!-- email address -->
                    <div class="form-floating mb-4">
                        <input required type="email" name="email" class="form-control rounded-pill" id="account_email" placeholder="Email">
                        <label for="account_email">Email</label>
                    </div>

                    <div class="form-floating mb-4">
                        <input required type="password" name="password" class="form-control rounded-pill" id="password" placeholder="New password" minlength="6">
                        <label for="password">New password</label>

                        <i class="fi fi-eye btn bg-transparent shadow-none link-muted position-absolute top-0 end-0 m-1" id="show-password"></i>
                    </div>

                    <div class="form-floating mb-4">
                        <input required type="password" name="password_confirmation" class="form-control rounded-pill" id="confirm-password" placeholder="Confirm password" minlength="6">
                        <label for="confirm-password">Confirm password</label>

                        <i class="fi fi-eye btn bg-transparent shadow-none link-muted position-absolute top-0 end-0 m-1" id="show-confirm-password"></i>
                    </div>

                    <div class="ms-1 mb-2 text-start">
                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">  
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z"></path>
                        </svg>
                        <a href="{{ route('login') }}" class="text-dark">Back to login</a>
                    </div>

                </div>

                <div class="row px-5 ms-2 d-inline-block w-100 max-w-600">

                    <div class="col-12 mt-4 text-center">
                        <button type="submit" class="btn w-100 transition-hover-top rounded-pill" style="background-color: #ff6100; color: #fff;">
                            Reset password
                        </button>
                        <small class="text-danger" id="reset-password-error-notice"></small>
                    </div>

                </div>

            </form>

        </div>
    </div>

</div>

<style>
    .border-radius-30 {
        border-radius: 30px;
    }
</style>

<script src="{{ asset('assets/js/app/reset_password.js') }}"></script>
@stop