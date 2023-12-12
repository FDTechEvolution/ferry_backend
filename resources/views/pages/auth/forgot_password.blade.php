@extends('layouts.blank')

@section('content')
    <div class=" justify-content-center vh-100" style="background: #eeeee8;">
        <div class="container vh-100">
            <div class="row vh-100">
                <div class="col-12 col-md-5 col-xs-6 offset-md-1 my-auto">
                    <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}" class="w-100">
                    <h1 class="d-inline-block text-align-end text-end-md text-end-xs display-4 w-100">
                        
                        <h1 class="display-1 d-block fw-medium text-center text-lg-end fw-bold"
                            style="color: #0a3961;">
                            Welcome
                        </h1>
                    </h1>
                </div>
                <div class="col-12 col-md-5 my-auto">
                
                    <form novalidate class="bs-validate" method="POST" action="{{ route('password-email') }}"
                        >
                        @csrf
                        <div class="p-5 pb-3 border-radius-30 d-inline-block bg-white text-dark w-100 max-w-600 mb-4">
                            <div class="text-center mb-5">
                                <h1 class="fw-bold" style="color: #ff6100;">Forget Password?</h1>
                            </div>

                            <!-- email address -->
                            <div class="form-floating mb-4">
                                <input required type="email" name="email" class="form-control rounded-pill"
                                    id="account_email" placeholder="Email address">
                                <label for="account_email">Email</label>
                            </div>

                            <div class="ms-1 mb-2 text-start">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5z">
                                    </path>
                                </svg>
                                <a href="{{route('login')}}" class="text-dark">Back to login</a>
                            </div>

                        </div>

                        <div class="row px-5 ms-2 d-inline-block w-100 max-w-600">

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn w-100 transition-hover-top rounded-pill"
                                    style="background-color: #ff6100; color: #fff;">
                                    Reset password
                                </button>
                            </div>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .border-radius-30 {
            border-radius: 30px;
        }
    </style>
@stop
