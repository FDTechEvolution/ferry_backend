<!--  header -->
<header id="header" class="d-flex align-items-center shadow-xs">

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
      <img src="assets/images/logo/logo_sm.svg" width="38" height="38" alt="...">
    </a>

  </div>

  <!-- navbar : navigation -->
  <div class="collapse navbar-collapse" id="navbarMainNav">

    <!-- navbar : mobile menu -->
    <div class="navbar-xs d-none">

      <!-- close button -->
      <button class="navbar-toggler pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
        <svg width="20" viewBox="0 0 20 20">
          <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
        </svg>
      </button>

      <!-- logo -->
      <a class="navbar-brand" href="index.html">
        <img src="assets/images/logo/logo_dark.svg" width="110" height="38" alt="...">
      </a>

    </div>
    <!-- /navbar : mobile menu -->


    <!-- Dropdowns -->
    <ul class="navbar-nav align-items-center">

      <!-- Features -->
      <li class="nav-item dropdown">

        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainNavPages">
          Features
        </a>

        <ul class="dropdown-menu dropdown-menu-clean dropdown-fadeindown" aria-labelledby="mainNavPages">
          <li class="dropdown-item dropdown">
            <a class="dropdown-link" href="#" data-bs-toggle="dropdown">
              Pages
            </a>
            <ul class="dropdown-menu dropdown-menu-hover border-0 m-0">
              <li class="dropdown-item"><a class="dropdown-link" href="page-ecommerce-product-list.html">Product list</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-ecommerce-product-reviews.html">Product reviews</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-ecommerce-order-list.html">Order list</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-ecommerce-order-detail.html">Order detail</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-ecommerce-invoice.html">Invoice</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-generic-forum.html">Forum</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-user-customer-list.html">Customer list</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-user-admins.html">Admin / Staff</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-util-maintenance.html">Maintenance</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-util-404.html">404 Error</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="page-util-500.html">500 Error</a></li>
            </ul>
          </li>
          <li class="dropdown-item dropdown">
            <a class="dropdown-link" href="#" data-bs-toggle="dropdown">
              Apps
            </a>
            <ul class="dropdown-menu dropdown-menu-hover border-0 m-0">
              <li class="dropdown-item"><a class="dropdown-link" href="app-projects-list.html">Project list</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="app-file-manager.html">File manager</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="app-chat.html">Chat</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="app-kanban.html">Kanban</a></li>
            </ul>
          </li>
          <li class="dropdown-item dropdown">
            <a class="dropdown-link" href="#" data-bs-toggle="dropdown">
              Authentication
            </a>
            <ul class="dropdown-menu dropdown-menu-hover border-0 m-0">
              <li class="dropdown-item"><a class="dropdown-link" href="auth-signin-cover.html">Sign in</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="auth-signup-cover.html">Sign up</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="auth-passreset-cover.html">Reset password</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="auth-2step-cover.html">2-step verification</a></li>
            </ul>
          </li>
          <li class="dropdown-item dropdown">
            <a class="dropdown-link" href="#" data-bs-toggle="dropdown">
              Layouts
            </a>
            <ul class="dropdown-menu dropdown-menu-hover border-0 m-0">
              <li class="dropdown-item"><a class="dropdown-link" href="layout-dark-header.html">Dark Header</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="layout-dark-sidebar.html">Dark Sidebar</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="layout-dark-both.html">Dark Both</a></li>
              <li class="dropdown-item mt-2"><a class="dropdown-link" href="layout-sticky-header.html">Sticky Header</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="layout-sticky-sidebar.html">Sticky Sidebar</a></li>
              <li class="dropdown-item"><a class="dropdown-link" href="layout-sticky-both.html">Sticky Both</a></li>
            </ul>
          </li>
        </ul>

      </li>

      <li class="nav-item dropdown dropdown-mega">

        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="mainMegaNav">
          Documentation
        </a>

        <ul class="dropdown-menu dropdown-menu-clean dropdown-fadeindown" aria-labelledby="mainMegaNav">
          <li class="dropdown-item bg-transparent">
            
            <div class="row col-border-md text-wrap">

              <div class="col-12 col-md-3">

                <h3 class="h6">Getting started</h3>
                <ul>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/index.html">Introduction</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/gulp.html">Gulp</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/migration.html">Migration</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/changelog.html">Changelog</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/credits.html">Credits</a></li>
                </ul>

              </div>

              <div class="col-12 col-md-3">

                <h3 class="h6">Elements</h3>
                <ul>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/components-alerts.html">Components</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/forms-overview.html">Forms</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/icons-bootstrap.html">Icons</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/util-misc.html">Utilities</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/plugins-sow-overview.html">SOW Plugins</a></li>
                  <li class="dropdown-item"><a class="dropdown-link transition-hover-end" href="../html_frontend/documentation/plugins-vendor-chartjs.html">Vendor Plugins</a></li>
                </ul>

              </div>

              <div class="col-12 col-md-6 text-center p-xl-5">

                <h2 class="mb-4">High quality!</h2>
                <img width="586" height="219" class="img-fluid mb-0" src="../assets/images/smarty_lighthouse.png" alt="...">

              </div>

            </div>

          </li>
        </ul>

      </li>

    </ul>
    <!-- /Dropdowns -->

  </div>
  <!-- /navbar : navigation -->

  <!-- options -->
  <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">

    <!-- notifications -->
    <li class="list-inline-item mx-1 dropdown">

      <a href="#" id="dropdownNotificationOptions" class="btn btn-sm btn-light rounded-circle text-primary-hover dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-haspopup="true" aria-label="Notifications">

        <!-- svg icon -->
        <span style="margin-top: -3px;">
          <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <path fill="currentColor" d="M17,12 L18.5,12 C19.3284271,12 20,12.6715729 20,13.5 C20,14.3284271 19.3284271,15 18.5,15 L5.5,15 C4.67157288,15 4,14.3284271 4,13.5 C4,12.6715729 4.67157288,12 5.5,12 L7,12 L7.5582739,6.97553494 C7.80974924,4.71225688 9.72279394,3 12,3 C14.2772061,3 16.1902508,4.71225688 16.4417261,6.97553494 L17,12 Z"></path>
              
              <!-- animate-blink -->
              <!-- <rect class="animate-blink" fill="#6dbb30" opacity="0.8" x="10" y="16" width="4" height="4" rx="2"></rect> -->

              <!-- no animate -->
              <rect fill="#000000" opacity="0.3" x="10" y="16" width="4" height="4" rx="2"></rect>
            </g>
          </svg>
        </span>

      </a>

      <div aria-labelledby="dropdownNotificationOptions" class="dropdown-menu dropdown-menu-clean dropdown-menu-navbar-autopos dropdown-fadeindown end-0 p-0 mt-2 w-300">
        <div class="dropdown-header p-4">1 new notification</div>
        <div class="dropdown-divider"></div>
        <div class="max-vh-50 scrollable-vertical">
          
          <!-- <div class="py-5 text-gray-400 text-center">NO ITEMS!</div> -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- badge -->
            <span class="badge bg-success float-end fw-normal mt-1">new</span>

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-cart-1"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">2 new orders</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-shield-ok"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">AI self repair success!</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-check"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">2 people joined the team</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-close"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">Missed a chat</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-check"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">3 new orders today</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-close"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">System chrashed</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-close"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">John sent you an attachment</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-close"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">Melissa removed from Ikarus project</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-star"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">2 new notifications</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-star-full"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">System fully recovered</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">

            <!-- icon -->
            <div class="float-start avatar avatar-sm rounded-circle bg-gray-200 fs-5">
              <i class="fi fi-round-info-full"></i>
            </div>

            <p class="small fw-bold m-0 text-truncate">System health status</p>
            <small class="d-block smaller fw-normal text-muted">Oct 22, 2019 / 02:21:46pm</small>

          </a>
          <!-- /item -->


        </div>
        <div class="dropdown-divider mb-0"></div>
        <a href="#" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3">
          View all
        </a>
      </div>

    </li>

    <!-- chat -->
    <li class="list-inline-item mx-1 dropdown">

      <a role="button" href="#offcanvasChat" data-bs-toggle="offcanvas" aria-controls="offcanvasChat" class="btn btn-sm btn-light rounded-circle text-primary-hover dropdown-toggle" aria-label="Chat">

        <!-- svg icon -->
        <span style="margin-top: -3px;">
          <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="0" y="0" width="24" height="24"></rect>
              <path fill="currentColor" d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z"></path>
              
              <!-- animate-blink -->
              <path class="animate-blink" fill="#6dbb30" opacity="0.8" d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"></path>

              <!-- no animate -->
              <!-- <path fill="#000000" opacity="0.3" d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z"></path> -->
            </g>
          </svg>
        </span>

      </a>

    </li>

    <!-- messages -->
    <li class="list-inline-item mx-1 dropdown">

      <a role="button" href="#" id="dropdownMessageOptions" class="btn btn-sm btn-light rounded-circle text-primary-hover dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-haspopup="true" aria-label="Messages">
        
        <!-- svg icon -->
        <span style="margin-top: -3px;">

          <svg width="24px" height="24px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
              <rect x="0" y="0" width="24" height="24"></rect>
              <path fill="currentColor" d="M8,6 L20.5,6 C21.3284271,6 22,6.67157288 22,7.5 C22,8.32842712 21.3284271,9 20.5,9 L8,9 L8,19.5 C8,20.3284271 7.32842712,21 6.5,21 C5.67157288,21 5,20.3284271 5,19.5 L5,9 L3.5,9 C2.67157288,9 2,8.32842712 2,7.5 C2,6.67157288 2.67157288,6 3.5,6 L5,6 L5,4.5 C5,3.67157288 5.67157288,3 6.5,3 C7.32842712,3 8,3.67157288 8,4.5 L8,6 Z"></path>

              <!-- animate-blink -->
              <!-- <path class="animate-blink" fill="#6dbb30" opacity="0.8" d="M10,11 L20.5,11 C21.3284271,11 22,11.6715729 22,12.5 L22,15 C22,17.209139 20.209139,19 18,19 L11.5,19 C10.6715729,19 10,18.3284271 10,17.5 L10,11 Z M20,12 C19.4477153,12 19,12.4477153 19,13 L19,16 C19,16.5522847 19.4477153,17 20,17 C20.5522847,17 21,16.5522847 21,16 L21,13 C21,12.4477153 20.5522847,12 20,12 Z"></path> -->

              <!-- no animate -->
              <path fill="currentColor" opacity="0.3" d="M10,11 L20.5,11 C21.3284271,11 22,11.6715729 22,12.5 L22,15 C22,17.209139 20.209139,19 18,19 L11.5,19 C10.6715729,19 10,18.3284271 10,17.5 L10,11 Z M20,12 C19.4477153,12 19,12.4477153 19,13 L19,16 C19,16.5522847 19.4477153,17 20,17 C20.5522847,17 21,16.5522847 21,16 L21,13 C21,12.4477153 20.5522847,12 20,12 Z"></path>
            </g>
          </svg>
        </span>

      </a>

      <div aria-labelledby="dropdownMessageOptions" class="dropdown-menu dropdown-menu-clean dropdown-menu-navbar-autopos dropdown-fadeindown end-0 p-0 mt-2 w-300">
        <div class="dropdown-header p-4">
          <a href="#" class="js-ajax-modal btn btn-sm btn-primary border-0 px-2 py-1 m-0 smaller float-end"
            data-href="_ajax/admin_modal_message_write.html" 
            data-ajax-modal-size="modal-md" 
            data-ajax-modal-centered="false" 
            data-ajax-modal-backdrop="static">
            + MESSAGE
          </a>
         1 new message
        </div>
        <div class="dropdown-divider"></div>
        <div class="max-vh-50 scrollable-vertical">
          
          <!-- <div class="py-5 text-gray-400 text-center">NO ITEMS!</div> -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">
            <span class="float-end badge bg-success fw-normal">new</span>
            <span class="float-end badge bg-danger fw-normal">urgent</span>
            <div class="float-start avatar rounded-circle bg-gray-200">FD</div>
            <span class="d-block small text-truncate fw-bold">John Doe</span>
            <p class="small m-0 text-truncate">Spartans has no weekends, so neither you!</p>
            <small class="d-block smaller text-muted">Jan 22, 2019 / 02:21:46pm</small>
          </a>
          <!-- /item -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">
            <div class="float-start avatar rounded-circle bg-gray-200" style="background-image:url(../assets/images/avatar/jessica_barden.jpg)"></div>
            <span class="d-block small text-truncate fw-bold">Jessica Barden</span>
            <p class="small m-0 text-truncate">Go with Smarty, you can't go wrong, trust me</p>
            <small class="d-block smaller text-muted">Jan 22, 2019 / 02:21:46pm</small>
          </a>
          <!-- /item -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">
            <div class="float-start avatar rounded-circle bg-gray-200" style="background-image:url(../assets/images/avatar/peter_cole.jpg)"></div>
            <span class="d-block small text-truncate fw-bold">Peter Cole</span>
            <p class="small m-0 text-truncate">RE: No Subject</p>
            <small class="d-block smaller text-muted">Jan 22, 2019 / 02:21:46pm</small>
          </a>
          <!-- /item -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">
            <div class="float-start avatar rounded-circle bg-gray-200" style="background-image:url(../assets/images/avatar/jadson_dantas.jpg)"></div>
            <span class="d-block small text-truncate fw-bold">Jadson Dantas</span>
            <p class="small m-0 text-truncate">Indeed, this is unbeliveable</p>
            <small class="d-block smaller text-muted">Jan 22, 2019 / 02:21:46pm</small>
          </a>
          <!-- /item -->

          <!-- item -->
          <a href="#" class="clearfix dropdown-item fw-medium p-3 border-bottom border-light overflow-hidden">
            <div class="float-start avatar rounded-circle bg-gray-200" style="background-image:url(../assets/images/avatar/tasmin_egerton.jpg)"></div>
            <span class="d-block small text-truncate fw-bold">Tasmin Egerton</span>
            <p class="small m-0 text-truncate">RE: No Subject</p>
            <small class="d-block smaller text-muted">Jan 22, 2019 / 02:21:46pm</small>
          </a>
          <!-- /item -->

        </div>
        <div class="dropdown-divider mb-0"></div>
        <a href="#" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3">
          View all
        </a>
      </div>

    </li>

    <!-- account -->
    <li class="list-inline-item mx-1 dropdown">

      <!-- has avatar -->
      <a href="#" id="dropdownAccountOptions" class="btn btn-sm btn-icon btn-light dropdown-toggle rounded-circle shadow bg-cover" style="background-image:url(../assets/images/joseph-gonzalez-iFgRcqHznqg-unsplash.jpg)" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-haspopup="true" aria-label="Account options"></a>

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

        <a href="#" class="prefix-icon-ignore dropdown-footer dropdown-custom-ignore fw-medium py-3 px-4">
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