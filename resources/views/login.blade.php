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

            <!-- optional class: .form-control-pill -->
            <form novalidate action="{{ route('authenticate') }}" method="POST" class="bs-validate">
            @csrf
                <div class="p-5 pb-3 border-radius-30 d-inline-block bg-white text-dark w-100 max-w-600 mb-4">
                    <div class="text-center mb-5">
                        <h1 class="fw-bold" style="color: #ff6100;">Login</h1>
                    </div>

                    <div class="form-floating mb-3">
                        <input required placeholder="Username" id="username" name="username" type="text" class="form-control rounded-pill">
                        <label for="username"><em>Username</em></label>
                    </div>

                    <div class="input-group-over">
                        <div class="form-floating mb-4">
                            <input required placeholder="Password" id="account_password" name="password" type="password" class="form-control rounded-pill">
                            <label for="account_password"><em>Password</em></label>
                        </div>
                    </div>

                    <div class="form-check mb-2 ms-4 text-start">
                        <input class="form-check-input form-check-input-default" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            Remember Password
                        </label>
                    </div>

                    <div class="form-check mb-2 ms-4 text-start">
                        <input class="form-check-input form-check-input-default" type="checkbox" value="" id="checkDefault">
                        <label class="form-check-label" for="checkDefault">
                            Forget Password
                        </label>
                    </div>

                </div>


                <div class="row px-5 ms-2 d-inline-block w-100 max-w-600">

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn w-100 transition-hover-top rounded-pill" style="background-color: #ff6100; color: #fff;">
                            Login
                        </button>
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <a href="#" class="btn px-0 link-normal text-dark">
                            Already Have Account? Sign in
                        </a>
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
@stop