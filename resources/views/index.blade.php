@extends('layouts.blank')

@section('content')

<div class="row g-0 bg-white min-vh-100 align-items-center">
  <div class="col-lg-6 text-center text-lg-start overflow-hidden z-index-2">
    <div class="px-3 py-6">

      <div class="row">
        <div class="col-sm-8 col-md-6 col-lg-9 col-xl-12 mx-auto max-w-450">

          <h1 class="fw-bold mb-5">เข้าสู่ระบบ</h1>
          
          <form novalidate class="bs-validate" method="POST" action="{{ route('authenticate') }}">
            @csrf
              <!-- email address -->
              <div class="form-floating mb-3">
                <input required type="email" name="email" class="form-control" id="account_email" placeholder="Email address">
                <label for="account_email">Email address</label>
              </div>

              <!-- password -->
              <div class="form-floating mb-3">
                <input required type="password" name="password" class="form-control" id="account_passwd" placeholder="Password" autocomplete="new-password">
                <label for="account_passwd">Password</label>

                <!-- forgot -->
                <a href="account-full-signin-password-1.html" class="btn bg-transparent shadow-none link-muted position-absolute top-0 end-0 m-1">
                  Forgot
                </a>
              </div>

              <!-- submot button -->
              <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">
                  <span>เข้าสู่ระบบ</span>
                  <svg class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </button>
              </div>

            </form>

        </div>
      </div>

    </div>
  </div>
  <div class="d-none d-lg-block min-vh-100 col-lg-6 bg-cover py-8 overlay-dark overlay-opacity-25" style="background-image:url(demo.files/images/unsplash/covers/andrew-neel-cckf4TsHAuw-unsplash.jpg)">
    <svg class="d-none d-lg-block position-absolute h-100 top-0 text-white ms-n5" style="width:6rem" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
      <polygon points="50,0 100,0 50,100 0,100"></polygon>
    </svg>
  </div>
</div>

@stop