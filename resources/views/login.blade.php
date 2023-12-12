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
                    <form novalidate action="{{ route('authenticate') }}" method="POST" class="collapse bs-validate show"
                        id="accordionAccountSignIn" data-bs-parent="#accordionAccount">
                        @csrf
                        <div class="p-5 pb-3 border-radius-30 d-inline-block bg-white text-dark w-100 max-w-600 mb-4">
                            <div class="text-center mb-5">
                                <h1 class="fw-bold" style="color: #ff6100;">Login</h1>
                            </div>

                            <div class="form-floating mb-3">
                                <input required placeholder="Username" id="username" name="username" type="text"
                                    class="form-control rounded-pill">
                                <label for="username"><em>Username</em></label>
                            </div>

                            <div class="input-group-over">
                                <div class="form-floating mb-4">
                                    <input required placeholder="Password" id="account_password" name="password"
                                        type="password" class="form-control rounded-pill">
                                    <label for="account_password"><em>Password</em></label>
                                </div>
                            </div>

                            <div class="ms-1 mb-2 text-start">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-shield-lock" viewBox="0 0 16 16">
                                    <path
                                        d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z">
                                    </path>
                                    <path
                                        d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z">
                                    </path>
                                </svg>
                                <a href="#accordionAccountPasswd" data-bs-toggle="collapse" aria-expanded="true"
                                    aria-controls="accordionAccountPasswd" class="text-dark">Forget Password?</a>
                            </div>

                        </div>


                        <div class="row px-5 ms-2 d-inline-block w-100 max-w-600">

                            <div class="col-12 mt-4">
                                <button type="submit" class="btn w-100 transition-hover-top rounded-pill"
                                    style="background-color: #ff6100; color: #fff;">
                                    Login
                                </button>
                            </div>

                        </div>
                    </form>

                    <form novalidate class="collapse bs-validate" method="POST" action="{{ route('password-email') }}"
                        id="accordionAccountPasswd" data-bs-parent="#accordionAccount">
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
                                <a href="#accordionAccountSignIn" data-bs-toggle="collapse" aria-expanded="true"
                                    aria-controls="accordionAccountSignIn" class="text-dark">Back to login</a>
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
