@extends('layouts.blank')

@section('content')
<div class="row g-0 bg-white min-vh-100 align-items-center">
    <div class="col-lg-6 text-center text-lg-start overflow-hidden z-index-2">
        <div class="px-3 py-6">

            <div class="row">
                <div class="col-sm-8 col-md-6 col-lg-9 col-xl-12 mx-auto max-w-450">

                    <h1 class="fw-bold mb-5">รีเซ็ตรหัสผ่าน</h1>

                    <form novalidate onSubmit="return formSubmit()" id="password-reset-form" class="bs-validate" method="POST" action="{{ route('update-password') }}">
                    @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        
                        <div class="form-floating mb-3">
                            <input required type="email" name="email" class="form-control" id="account_email" placeholder="Email address">
                            <label for="account_email">อีเมล์</label>
                        </div>

                        <div class="form-floating mb-3">
                            <input required type="password" name="password" class="form-control" id="password" placeholder="รหัสผ่านใหม่" minlength="6">
                            <label for="password">รหัสผ่านใหม่</label>

                            <i class="fi fi-eye btn bg-transparent shadow-none link-muted position-absolute top-0 end-0 m-1" id="show-password"></i>
                        </div>

                        <div class="form-floating mb-3">
                            <input required type="password" name="password_confirmation" class="form-control" id="confirm-password" placeholder="ยืนยันรหัสผ่าน" minlength="6">
                            <label for="confirm-password">ยืนยันรหัสผ่าน</label>

                            <i class="fi fi-eye btn bg-transparent shadow-none link-muted position-absolute top-0 end-0 m-1" id="show-confirm-password"></i>
                        </div>

                        <!-- submot button -->
                        <div class="d-grid mb-3">
                            <button type="submit" id="button-submit-form" class="btn btn-primary">
                            <span>รีเซ็ตรหัสผ่าน</span>
                            <svg class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                            </svg>
                            </button>
                        </div>

                    </form>

                    <!-- create account -->
                    <div class="text-center m-4">
                        <a href="{{ route('login') }}" class="link-muted">
                            เข้าสู่ระบบ
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <div class="d-none d-lg-block min-vh-100 col-lg-6 bg-cover py-8 overlay-dark overlay-opacity-25" style="background-image:url(demo.files/images/unsplash/covers/ilya-pavlov-OqtafYT5kTw-unsplash.jpg)">
        <svg class="d-none d-lg-block position-absolute h-100 top-0 text-white ms-n5" style="width:6rem" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
            <polygon points="50,0 100,0 50,100 0,100"></polygon>
        </svg>
    </div>
</div>

<script src="{{ asset('assets/js/app/reset_password.js') }}"></script>
@stop