<!--  header -->
<header id="header" class="d-flex align-items-center shadow-xs mb-3 background-trans rounded">

  <!-- Navbar -->
  <div class="container-fluid position-relative">

  <nav class="navbar navbar-expand-lg navbar-light justify-content-between">

    <!-- logo, navigation toggler -->
    <div class="align-items-start">
      
      <!-- sidebar toggler -->
      <a href="#aside-main" class="btn-sidebar-toggle h-100 d-inline-block d-lg-none justify-content-center align-items-center p-2">
        <span>
          <svg width="25" height="25" viewBox="0 0 20 20">
            <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
            <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
            <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
            <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
          </svg>
        </span>
      </a>

      <!-- logo : mobile only -->
      <a class="navbar-brand d-inline-block d-lg-none mx-2" href="index.html">
        <!-- <img src="assets/images/logo/logo_sm.svg" width="38" height="38" alt="..."> -->
      </a>

    </div>

    <!-- navbar : navigation -->
    <div class="collapse navbar-collapse d-md-flex d-sm-none" id="navbarMainNav">

        @yield('page-title')

    </div>
    <!-- /navbar : navigation -->

        @yield('page-option')

    <!-- options -->
    <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

      <!-- account -->
      <li class="list-inline-item mx-1 dropdown text-end">

        <!-- has avatar -->
        <a href="return javascript(void)" id="dropdownAccountOptions" class="dropdown-toggle text-dark" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-haspopup="true" aria-label="Account options"><i class="fi fi-arrow-down-full me-1 text-secondary"></i> {{ Auth::user()->firstname }}
          @if(Auth::user()->image != '')
            <img src="{{ asset('assets/images/avatar/'.Auth::user()->image) }}" class="rounded-circle shadow ms-2" style="width: 46px; height: 48px; margin-top: -5px;" />
          @else
            <img src="{{ asset('assets/images/avatar/blank-profile-picture.png') }}" class="rounded-circle shadow ms-2" style="width: 42px; margin-top: -5px;" />
          @endif
        </a>

        <!-- no avatar -->
        <!--
        <a href="#" id="dropdownAccountOptions" class="btn btn-sm btn-icon btn-light dropdown-toggle rounded-circle" data-bs-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
          <span class="small fw-bold">JD</span>
        </a>
        -->

        <div aria-labelledby="dropdownAccountOptions" class="dropdown-menu dropdown-menu-clean dropdown-menu-navbar-autopos dropdown-menu-invert dropdown-fadeindown p-0 mt-2 w-300">
          
          <!-- user detail -->
          <div class="dropdown-header bg-primary bg-gradient rounded rounded-bottom-0 text-white small p-4">
            <span class="d-block fw-medium text-truncate">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
            <span class="d-block smaller fw-medium text-truncate">j{{ Auth::user()->email }}</span>
            <span class="d-block smaller"><b>Last Login:</b> 00:00</span>
          </div>

          <div class="dropdown-divider mb-3"></div>

          

          <a href="{{ route('logout') }}" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3 px-4">
            <i class="fi fi-power float-start"></i>
            Log Out
          </a>
        </div>

      </li>

      <!-- navigation toggler (mobile) -->
      <!-- <li class="list-inline-item d-inline-block d-lg-none">
        <button class="btn p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fi fi-bars m-0"></i>
        </button>
      </li> -->

    </ul>
    <!-- /options -->

  </nav>

  </div>
  <!-- /Navbar -->

</header>
<!-- /Header -->

<style>
  @media only screen and (min-width: 992px) {
    body.layout-admin.layout-padded #header {
        margin-left: 275px!important;
    }
  }
</style>