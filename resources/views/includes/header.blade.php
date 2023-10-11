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
    <div class="collapse navbar-collapse" id="navbarMainNav">

        @yield('page-title')

    </div>
    <!-- /navbar : navigation -->

        @yield('page-option')

    <!-- options -->
    <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

      <!-- account -->
      <li class="list-inline-item mx-1 dropdown text-end">

        <!-- has avatar -->
        <a href="return javascript(void)" id="dropdownAccountOptions" class="dropdown-toggle text-dark" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-haspopup="true" aria-label="Account options"><i class="fi fi-arrow-down-full me-1 text-secondary"></i> {{ Auth::user()->username }}
          <img src="../assets/images/avatar/{{ Auth::user()->image != '' ? Auth::user()->image : 'blank-profile-picture.png' }}" class="rounded-circle shadow ms-2" style="width: 42px; margin-top: -5px;" />
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
            <span class="d-block fw-medium text-truncate">John Doe</span>
            <span class="d-block smaller fw-medium text-truncate">john.doe@gmail.com</span>
            <span class="d-block smaller"><b>Last Login:</b> 2019-09-03 01:48</span>
          </div>

          <div class="dropdown-divider mb-3"></div>

          <a href="#" class="dropdown-item text-truncate">
            <span class="fw-medium">My profile</span>
            <small class="d-block text-muted smaller">account settings and more</small>
          </a>

          <a href="#" class="dropdown-item text-truncate">
            <small class="badge bg-success-soft float-end">1 new</small>
            <span class="fw-medium">My Messages</span>
            <small class="d-block text-muted smaller">inbox, projects, tasts</small>
          </a>

          <a href="#" class="dropdown-item text-truncate">
            <small class="badge bg-danger-soft float-end">1 unpaid</small>
            <span class="fw-medium">My billing</span>
            <small class="d-block text-muted smaller">your monthly billing</small>
          </a>

          <a href="#" class="dropdown-item text-truncate">
            <span class="fw-medium">Account Settings</span>
            <small class="d-block text-muted smaller">profile, password and more...</small>
          </a>

          <a href="#" class="dropdown-item text-truncate">
            <span class="fw-medium">Upgrade</span>
            <small class="d-block text-muted smaller">upgrade your account</small>
          </a>

          <div class="dropdown-divider mb-0 mt-3"></div>

          <a href="{{ route('logout') }}" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3 px-4">
            <i class="fi fi-power float-start"></i>
            Log Out
          </a>
        </div>

      </li>

      <!-- navigation toggler (mobile) -->
      <li class="list-inline-item d-inline-block d-lg-none">
        <button class="btn p-2" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fi fi-bars m-0"></i>
        </button>
      </li>

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