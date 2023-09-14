<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta charset="UTF-8">
    <title>Smarty v5</title>
    <meta name="description" content="...">

    <meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1">
    <!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- up to 10% speed up for external res -->
    <link rel="dns-prefetch" href="https://fonts.googleapis.com/">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com/">
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/">
    <!-- preloading icon font is helping to speed up a little bit -->
    <link rel="preload" href="assets/fonts/flaticon/Flaticon.woff2" as="font" type="font/woff2" crossorigin>

    <link rel="stylesheet" href="assets/css/core.min.css">
    <link rel="stylesheet" href="assets/css/vendor_bundle.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="apple-touch-icon" href="demo.files/logo/icon_512x512.png">

  </head>

  <body data-s2t-class="btn-primary bg-gradient" data-bs-spy="scroll" data-bs-target="#demos-scrollspy" data-bs-offset="0">


    <div id="wrapper">


      <!-- Header -->
      <header id="header" class="shadow-none">

        <!-- Navbar -->
        <div class="container position-relative">


          <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit">

            <!-- navbar : brand (logo) -->
            <a class="navbar-brand" href="index.html">
              <img src="assets/images/logo/logo_dark.svg" width="110" height="38" alt="...">
            </a>

            <div class="align-items-start">

              <!-- mobile menu button : show -->
              <button class="navbar-toggler border-0 m-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg width="25" viewBox="0 0 20 20">
                  <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                  <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                  <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                  <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                </svg>
              </button>

            </div>




            <!-- Menu -->
            <!--

              Dropdown Classes (should be added to primary .dropdown-menu only, dropdown childs are also affected)
                .dropdown-menu-dark     - dark dropdown (desktop only, will be white on mobile)
                .dropdown-menu-hover    - open on hover
                .dropdown-menu-clean    - no background color on hover
                .dropdown-menu-invert     - open dropdown in oposite direction (left|right, according to RTL|LTR)
                .dropdown-menu-uppercase  - uppercase text (font-size is scalled down to 13px)
                .dropdown-click-ignore    - keep dropdown open on inside click (useful on forms inside dropdown)

                Repositioning long dropdown childs (Example: Pages->Account)
                  .dropdown-menu-up-n100    - open up with top: -100px
                  .dropdown-menu-up-n100    - open up with top: -150px
                  .dropdown-menu-up-n180    - open up with top: -180px
                  .dropdown-menu-up-n220    - open up with top: -220px
                  .dropdown-menu-up-n250    - open up with top: -250px
                  .dropdown-menu-up       - open up without negative class


                Dropdown prefix icon (optional, if enabled in variables.scss)
                  .prefix-link-icon .prefix-icon-dot    - link prefix
                  .prefix-link-icon .prefix-icon-line   - link prefix
                  .prefix-link-icon .prefix-icon-ico    - link prefix
                  .prefix-link-icon .prefix-icon-arrow  - link prefix

                .nav-link.nav-link-caret-hide   - no dropdown icon indicator on main link
                .nav-item.dropdown-mega     - required ONLY on fullwidth mega menu

                Mobile animation - add to .navbar-collapse:
                .navbar-animate-fadein
                .navbar-animate-fadeinup
                .navbar-animate-bouncein

            -->
            <div class="collapse navbar-collapse justify-content-end navbar-animate-fadein" id="navbarMainNav">


              <!-- navbar : mobile menu -->
              <div class="navbar-xs d-none"><!-- .sticky-top -->

                <!-- mobile menu button : close -->
                <button class="navbar-toggler pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                  <svg width="20" viewBox="0 0 20 20">
                    <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
                  </svg>
                </button>

                <!-- 
                  Mobile Menu Logo 
                  Logo : height: 70px max
                -->
                <a class="navbar-brand" href="index.html">
                  <img src="assets/images/logo/logo_dark.svg" width="110" height="38" alt="...">
                </a>

              </div>
              <!-- /navbar : mobile menu -->



              <!-- navbar : navigation -->
              <ul class="navbar-nav">
                <!-- Menu -->
                <!--

                  Dropdown Classes (should be added to primary .dropdown-menu only, dropdown childs are also affected)
                    .dropdown-menu-dark     - dark dropdown (desktop only, will be white on mobile)
                    .dropdown-menu-hover    - open on hover
                    .dropdown-menu-clean    - no background color on hover
                    .dropdown-menu-invert     - open dropdown in oposite direction (left|right, according to RTL|LTR)
                    .dropdown-menu-uppercase  - uppercase text (font-size is scalled down to 13px)
                    .dropdown-click-ignore    - keep dropdown open on inside click (useful on forms inside dropdown)

                    Repositioning long dropdown childs (Example: Pages->Account)
                      .dropdown-menu-up-n100    - open up with top: -100px
                      .dropdown-menu-up-n100    - open up with top: -150px
                      .dropdown-menu-up-n180    - open up with top: -180px
                      .dropdown-menu-up-n220    - open up with top: -220px
                      .dropdown-menu-up-n250    - open up with top: -250px
                      .dropdown-menu-up       - open up without negative class


                    Dropdown prefix icon (optional, if enabled in variables.scss)
                      .prefix-link-icon .prefix-icon-dot    - link prefix
                      .prefix-link-icon .prefix-icon-line   - link prefix
                      .prefix-link-icon .prefix-icon-ico    - link prefix
                      .prefix-link-icon .prefix-icon-arrow  - link prefix

                    .nav-link.nav-link-caret-hide   - no dropdown icon indicator on main link
                    .nav-item.dropdown-mega     - required ONLY on fullwidth mega menu

                -->
                <!-- mobile only image + simple search (d-block d-sm-none) -->
                <li class="nav-item d-block d-sm-none">

                  <!-- image -->
                  <div class="mb-4">
                    <img width="600" height="600" class="img-fluid" src="demo.files/svg/artworks/people_crossbrowser.svg" alt="...">
                  </div>

                  <!-- search -->
                  <form method="get" action="#!search" class="input-group-over mb-4 bg-light p-2 form-control-pill">
                    <input type="text" name="keyword" value="" placeholder="Quick search..." class="form-control border-dashed">
                    <button class="btn btn-sm fi fi-search mx-3"></button>
                  </form>

                </li>


                <!-- home -->
                <li class="nav-item dropdown active">

                  <a href="#" id="mainNavHome" class="nav-link dropdown-toggle" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    Home
                  </a>

                  <div aria-labelledby="mainNavHome" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover dropdown-mega-md dropdown-fadeinup">

                    <!-- 
                      optional line column separator 
                      .col-border-lg 
                    -->
                    <div class="row">

                      <div class="col-12 col-lg-6">
                        <ul class="list-unstyled">
                          <li class="dropdown-item">
                            <h3 class="fs-6 text-muted py-3 px-lg-4">
                              Niche pages
                            </h3>
                          </li>
                          <li class="dropdown-item"><a href="niche.restaurant.html" class="dropdown-link">Restaurant</a></li>
                          <li class="dropdown-item"><a href="niche.caffe.html" class="dropdown-link">Caffe</a></li>
                          <li class="dropdown-item"><a href="niche.tattoo.html" class="dropdown-link">Tattoo</a></li>
                          <li class="dropdown-item"><a href="niche.lawyer.html" class="dropdown-link">Lawyer</a></li>
                          <li class="dropdown-item"><a href="niche.hosting.html" class="dropdown-link">Hosting</a></li>
                          <li class="dropdown-item"><a href="niche.classifieds.html" class="dropdown-link">Classifieds</a></li>
                          <li class="dropdown-item"><a href="niche.realestate.html" class="dropdown-link">Real Estate</a></li>
                          <li class="dropdown-item"><a href="#" class="dropdown-link disabled">More soon</a></li>
                        </ul>
                      </div>

                      <div class="col-12 col-lg-6">
                        <ul class="list-unstyled">
                          <li class="dropdown-item">
                            <h3 class="fs-6 text-muted py-3 px-lg-4">
                              Landing pages
                            </h3>
                          </li>
                          <li class="dropdown-item"><a href="landing-0.html" class="dropdown-link">Default</a></li>
                          <li class="dropdown-item"><a href="landing-1.html" class="dropdown-link">Landing 1</a></li>
                          <li class="dropdown-item"><a href="landing-2.html" class="dropdown-link">Landing 2</a></li>
                          <li class="dropdown-item"><a href="landing-3.html" class="dropdown-link">Landing 3</a></li>
                          <li class="dropdown-item"><a href="landing-4.html" class="dropdown-link">Landing 4</a></li>
                          <li class="dropdown-item"><a href="landing-5.html" class="dropdown-link">Landing 5</a></li>
                          <li class="dropdown-item"><a href="landing-6.html" class="dropdown-link">Landing 6</a></li>
                          <li class="dropdown-item"><a href="landing-7.html" class="dropdown-link">Landing 7</a></li>
                          <li class="dropdown-item"><a href="landing-8.html" class="dropdown-link">Landing 8</a></li>
                        </ul>
                      </div>

                    </div>

                    <ul class="list-unstyled">
                      <li class="dropdown-divider"></li>
                      <li class="dropdown-item pt-2">
                        <a href="index-2.html" class="dropdown-link text-muted d-flex align-items-center">
                          <span class="pe-2">All Demos</span>
                          <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                            <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                          </svg>
                        </a>
                      </li>
                    </ul>

                  </div>

                </li>


                <!-- pages -->
                <li class="nav-item dropdown">

                  <a href="#" id="mainNavPages" class="nav-link dropdown-toggle" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    Pages
                  </a>

                  <div aria-labelledby="mainNavPages" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover dropdown-fadeinup">
                      <ul class="list-unstyled m-0 p-0">
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">About</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="about-us-1.html" class="dropdown-link">About Us 1</a></li>
                                  <li class="dropdown-item"><a href="about-us-2.html" class="dropdown-link">About Us 2</a></li>
                                  <li class="dropdown-item"><a href="about-us-3.html" class="dropdown-link">About Us 3</a></li>
                                  <li class="dropdown-item"><a href="about-us-4.html" class="dropdown-link">About Us 4</a></li>
                                  <li class="dropdown-item"><a href="about-us-5.html" class="dropdown-link">About Us 5</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="about-me-1.html" class="dropdown-link">About Me 1</a></li>
                                  <li class="dropdown-item"><a href="about-me-2.html" class="dropdown-link">About Me 2</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Services</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="services-1.html" class="dropdown-link">Services 1</a></li>
                                  <li class="dropdown-item"><a href="services-2.html" class="dropdown-link">Services 2</a></li>
                                  <li class="dropdown-item"><a href="services-3.html" class="dropdown-link">Services 3</a></li>
                                  <li class="dropdown-item"><a href="services-4.html" class="dropdown-link">Services 4</a></li>
                                  <li class="dropdown-item"><a href="services-5.html" class="dropdown-link">Services 5</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Contact</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="contact-1.html" class="dropdown-link">Contact 1</a></li>
                                  <li class="dropdown-item"><a href="contact-2.html" class="dropdown-link">Contact 2</a></li>
                                  <li class="dropdown-item"><a href="contact-3.html" class="dropdown-link">Contact 3</a></li>
                                  <li class="dropdown-item"><a href="contact-4.html" class="dropdown-link">Contact 4</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Pricing</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="pricing-1.html" class="dropdown-link">Pricing 1</a></li>
                                  <li class="dropdown-item"><a href="pricing-2.html" class="dropdown-link">Pricing 2</a></li>
                                  <li class="dropdown-item"><a href="pricing-3.html" class="dropdown-link">Pricing 3</a></li>
                                  <li class="dropdown-item"><a href="pricing-4.html" class="dropdown-link">Pricing 4</a></li>
                                  <li class="dropdown-item"><a href="pricing-5.html" class="dropdown-link">Pricing 5</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">FAQ</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="faq-1.html" class="dropdown-link">FAQ 1</a></li>
                                  <li class="dropdown-item"><a href="faq-2.html" class="dropdown-link">FAQ 2</a></li>
                                  <li class="dropdown-item"><a href="faq-3.html" class="dropdown-link">FAQ 3</a></li>
                                  <li class="dropdown-item"><a href="faq-4.html" class="dropdown-link">FAQ 4</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Team</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="team-1.html" class="dropdown-link">Team 1</a></li>
                                  <li class="dropdown-item"><a href="team-2.html" class="dropdown-link">Team 2</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Account</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="account-index.html" class="dropdown-link">Account pages (12)</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="account-full-signin-1.html" class="dropdown-link">Sign In/Up : Full 1</a></li>
                                  <li class="dropdown-item"><a href="account-full-signin-2.html" class="dropdown-link">Sign In/Up : Full 2</a></li>
                                  <li class="dropdown-item"><a href="account-onepage-signin.html" class="dropdown-link">Sign In/Up : Onepage</a></li>
                                  <li class="dropdown-item"><a href="account-simple-signin.html" class="dropdown-link">Sign In/Up : Simple</a></li>
                                  <li class="dropdown-item"><a href="account-modal-signin.html" class="dropdown-link">Sign In/Up : Modal</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Clients / Career</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="clients.html" class="dropdown-link">Clients</a></li>
                                  <li class="dropdown-item"><a href="career.html" class="dropdown-link">Career</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Portfolio</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="portfolio-columns-2.html" class="dropdown-link">2 Columns</a></li>
                                  <li class="dropdown-item"><a href="portfolio-columns-3.html" class="dropdown-link">3 Columns</a></li>
                                  <li class="dropdown-item"><a href="portfolio-columns-4.html" class="dropdown-link">4 Columns</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="portfolio-single-1.html" class="dropdown-link">Single Item 1</a></li>
                                  <li class="dropdown-item"><a href="portfolio-single-2.html" class="dropdown-link">Single Item 2</a></li>
                                  <li class="dropdown-item"><a href="portfolio-single-3.html" class="dropdown-link">Single Item 3</a></li>
                                  <li class="dropdown-item"><a href="portfolio-single-4.html" class="dropdown-link">Single Item 4</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Utility</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-up dropdown-menu-block-md shadow-lg border-0 m-0">
                                  <li class="dropdown-item"><a href="404-1.html" class="dropdown-link">Error 1</a></li>
                                  <li class="dropdown-item"><a href="404-2.html" class="dropdown-link">Error 2</a></li>
                                  <li class="dropdown-item"><a href="404-3.html" class="dropdown-link">Error 3</a></li>
                                  <li class="dropdown-item"><a href="invoice.html" class="dropdown-link">Invoice</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="maintenance-1.html" class="dropdown-link">Maintenance 1</a></li>
                                  <li class="dropdown-item"><a href="maintenance-2.html" class="dropdown-link">Maintenance 2</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="comingsoon-1.html" class="dropdown-link">Coming Soon 1</a></li>
                                  <li class="dropdown-item"><a href="comingsoon-2.html" class="dropdown-link">Coming Soon 2</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="page-cookie.html" class="dropdown-link">GDPR Page &amp; Cookie Window</a></li>
                              </ul>
                          </li>
                      </ul>
                  </div>

                </li>


                <!-- features -->
                <li class="nav-item dropdown">

                  <a href="#" id="mainNavFeatures" class="nav-link dropdown-toggle" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    Features
                  </a>

                  <div aria-labelledby="mainNavFeatures" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover dropdown-fadeinup">
                      <ul class="list-unstyled m-0 p-0">
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Header</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item dropdown"><a href="#" class="dropdown-link fw-bold" data-bs-toggle="dropdown">Variants</a>
                                      <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                          <li class="dropdown-item"><a href="header-variant-1.html" class="dropdown-link">Header : Variant : 1</a></li>
                                          <li class="dropdown-item"><a href="header-variant-2.html" class="dropdown-link">Header : Variant : 2</a></li>
                                          <li class="dropdown-item"><a href="header-variant-3.html" class="dropdown-link">Header : Variant : 3</a></li>
                                          <li class="dropdown-item"><a href="header-variant-4.html" class="dropdown-link">Header : Variant : 4</a></li>
                                          <li class="dropdown-item"><a href="header-variant-5.html" class="dropdown-link">Header : Variant : 5</a></li>
                                          <li class="dropdown-item"><a href="header-variant-6.html" class="dropdown-link">Header : Variant : 6</a></li>
                                      </ul>
                                  </li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="header-option-light.html" class="dropdown-link">Header : Light <small class="text-muted">(default)</small></a></li>
                                  <li class="dropdown-item"><a href="header-option-dark.html" class="dropdown-link">Header : Dark</a></li>
                                  <li class="dropdown-item"><a href="header-option-color.html" class="dropdown-link">Header : Color</a></li>
                                  <li class="dropdown-item"><a href="header-option-transparent.html" class="dropdown-link">Header : Transparent</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="header-option-centered.html" class="dropdown-link">Header : Centered</a></li>
                                  <li class="dropdown-item"><a href="header-option-bottom.html" class="dropdown-link">Header : Bottom</a></li>
                                  <li class="dropdown-item"><a href="header-option-floating.html" class="dropdown-link">Header : Floating</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="header-option-fixed.html" class="dropdown-link">Header : Fixed</a></li>
                                  <li class="dropdown-item"><a href="header-option-reveal.html" class="dropdown-link">Header : Reveal on Scroll</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="header-option-ajax-search-json.html" class="dropdown-link">Ajax Search : Json</a></li>
                                  <li class="dropdown-item"><a href="header-option-ajax-search-html.html" class="dropdown-link">Ajax Search : Html</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Footer</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item dropdown"><a href="#" class="dropdown-link fw-bold" data-bs-toggle="dropdown">Variants</a>
                                      <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                          <li class="dropdown-item"><a href="footer-variant-1.html#footer" class="dropdown-link">Footer : Variant : 1</a></li>
                                          <li class="dropdown-item"><a href="footer-variant-2.html#footer" class="dropdown-link">Footer : Variant : 2</a></li>
                                          <li class="dropdown-item"><a href="footer-variant-3.html#footer" class="dropdown-link">Footer : Variant : 3</a></li>
                                          <li class="dropdown-item"><a href="footer-variant-4.html#footer" class="dropdown-link">Footer : Variant : 4</a></li>
                                          <li class="dropdown-item"><a href="footer-variant-5.html#footer" class="dropdown-link">Footer : Variant : 5</a></li>
                                          <li class="dropdown-item"><a href="footer-variant-6.html#footer" class="dropdown-link">Footer : Variant : 6</a></li>
                                      </ul>
                                  </li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="footer-option-light.html" class="dropdown-link">Footer : Light</a></li>
                                  <li class="dropdown-item"><a href="footer-option-dark.html" class="dropdown-link">Footer : Dark <small class="text-muted">(default)</small></a></li>
                                  <li class="dropdown-item"><a href="footer-option-image.html" class="dropdown-link">Footer : Image</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Sliders</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="slider-swiper.html" class="dropdown-link">Swiper Slider</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Page Title</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="page-title-classic.html" class="dropdown-link">Page Title : Classic</a></li>
                                  <li class="dropdown-item"><a href="page-title-alternate.html" class="dropdown-link">Page Title : Alternate</a></li>
                                  <li class="dropdown-item"><a href="page-title-color.html" class="dropdown-link">Page Title : Color + Nav</a></li>
                                  <li class="dropdown-item"><a href="page-title-clean.html" class="dropdown-link">Page Title : Clean</a></li>
                                  <li class="dropdown-item"><a href="page-title-parallax-1.html" class="dropdown-link">Page Title : Parallax 1</a></li>
                                  <li class="dropdown-item"><a href="page-title-parallax-2.html" class="dropdown-link">Page Title : Parallax 2</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item dropdown"><a href="#" class="dropdown-link" data-bs-toggle="dropdown">Sidebar</a>
                              <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                                  <li class="dropdown-item"><a href="sidebar-float-cart.html" class="dropdown-link">Sidebar : Cart</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="sidebar-float-dark.html" class="dropdown-link">Sidebar : Float : Dark</a></li>
                                  <li class="dropdown-item"><a href="sidebar-float-light.html" class="dropdown-link">Sidebar : Float : Light</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><a href="sidebar-static-dark.html" class="dropdown-link">Sidebar : Static : Dark</a></li>
                                  <li class="dropdown-item"><a href="sidebar-static-light.html" class="dropdown-link">Sidebar : Static : Light</a></li>
                                  <li class="dropdown-divider"></li>
                                  <li class="dropdown-item"><span class="d-block text-muted py-2 px-4 small fw-bold">Same as admin</span></li>
                                  <li class="dropdown-item"><a href="sidebar-float-admin-color.html" class="dropdown-link">Sidebar : Float</a></li>
                                  <li class="dropdown-item"><a href="sidebar-static-admin-color.html" class="dropdown-link">Sidebar : Static</a></li>
                              </ul>
                          </li>
                          <li class="dropdown-item">
                            <a href="header-dropdown.html" class="dropdown-link fw-medium">
                              Menu Dropdowns
                            </a>
                          </li>
                          <li class="dropdown-divider"></li>
                          <li class="dropdown-item"><a href="layout-boxed-1.html" class="dropdown-link">Boxed Layout</a></li>
                          <li class="dropdown-item"><a href="layout-boxed-0.html" class="dropdown-link">Boxed + Header Over</a></li>
                          <li class="dropdown-item"><a href="layout-boxed-2.html" class="dropdown-link">Boxed + Background</a></li>
                      </ul>
                  </div>

                </li>


                <!-- blog -->
                <li class="nav-item dropdown">

                  <a href="#" id="mainNavBlog" class="nav-link dropdown-toggle" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    Blog
                  </a>

                  <div aria-labelledby="mainNavBlog" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover dropdown-fadeinup">
                    <ul class="list-unstyled m-0 p-0">
                      <li class="dropdown-item"><a class="dropdown-link" href="blog-page-sidebar.html">With Sidebar</a></li>
                      <li class="dropdown-item"><a class="dropdown-link" href="blog-page-sidebar-no.html">Without Sidebar</a></li>
                      <li class="dropdown-item"><a class="dropdown-link" href="blog-page-article-sidebar.html">Article With Sidebar</a></li>
                      <li class="dropdown-item"><a class="dropdown-link" href="blog-page-article-sidebar-no.html">Article Without Sidebar</a></li>
                    </ul>
                  </div>

                </li>


                <!-- demos -->
                <li class="nav-item dropdown active">

                  <a href="#" id="mainNavDemo" class="nav-link dropdown-toggle" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    Demos
                  </a>

                  <div aria-labelledby="mainNavDemo" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover end-0 dropdown-fadeinup">
                    <ul class="list-unstyled m-0 p-0">
                      <li class="dropdown-item dropdown">
                        <a href="#" class="dropdown-link" data-bs-toggle="dropdown">Admin <span class="small text-muted">(2 layouts)</span></a>
                        <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                          <li class="dropdown-item"><a href="../html_admin/index.html" target="_blank" rel="noopener" class="dropdown-link">Layout 1</a></li>
                          <li class="dropdown-item"><a href="../html_admin/layout-2.html" target="_blank" rel="noopener" class="dropdown-link">Layout 2</a></li>
                        </ul>
                      </li>
                      <li class="dropdown-item"><a href="shop-index-1.html" target="_blank" rel="noopener" class="dropdown-link">Ecommerce <span class="small text-muted">(44 pages)</span></a></li>
                      <li class="dropdown-item"><a href="niche.realestate.html" target="_blank" rel="noopener" class="dropdown-link">Real estate <span class="small text-muted">(5 pages)</span></a></li>
                      <li class="dropdown-item"><a href="niche.classifieds.html" target="_blank" rel="noopener" class="dropdown-link">Classifieds <span class="small text-muted">(3 pages)</span></a></li>
                      <li class="dropdown-item"><a href="fullajax-index.html" target="_blank" rel="noopener" class="dropdown-link">Full Ajax <span class="small text-muted">(14 pages)</span></a></li>
                      <li class="dropdown-item"><a href="forum-index.html" rel="noopener" class="dropdown-link">Forum <span class="small text-muted">(3 pages)</span></a></li>
                      <li class="dropdown-item dropdown">
                        <a href="#" class="dropdown-link" data-bs-toggle="dropdown">Help center <span class="small text-muted">(2 layouts)</span></a>
                        <ul class="dropdown-menu dropdown-menu-hover dropdown-menu-block-md shadow-lg rounded-xl border-0 m-0">
                          <li class="dropdown-item"><a href="help-center-1-index.html" class="dropdown-link">Layout 1 <span class="small text-muted">(2 pages)</span></a></li>
                          <li class="dropdown-item"><a href="help-center-2-index.html" class="dropdown-link">Layout 2 <span class="small text-muted">(3 pages)</span></a></li>
                        </ul>
                      </li>
                    </ul>
                  </div>

                </li>


                <!-- documentation -->
                <li class="nav-item dropdown">

                  <a href="#" id="mainNavDocumentation" class="nav-link dropdown-toggle nav-link-caret-hide" 
                    data-bs-toggle="dropdown" 
                    aria-haspopup="true" 
                    aria-expanded="false">
                    <span>Documentation</span>
                  </a>

                  <div aria-labelledby="mainNavDocumentation" class="dropdown-menu dropdown-menu-clean dropdown-menu-hover end-0 w-300 dropdown-fadeinup">                    
                    
                    <a href="documentation/index.html" class="dropdown-item py-4 d-flex">

                      <span class="flex-none">
                        <svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-file-earmark-medical" viewBox="0 0 16 16">  
                          <path d="M7.5 5.5a.5.5 0 0 0-1 0v.634l-.549-.317a.5.5 0 1 0-.5.866L6 7l-.549.317a.5.5 0 1 0 .5.866l.549-.317V8.5a.5.5 0 1 0 1 0v-.634l.549.317a.5.5 0 1 0 .5-.866L8 7l.549-.317a.5.5 0 1 0-.5-.866l-.549.317V5.5zm-2 4.5a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5zm0 2a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1h-5z"></path>  
                          <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>
                        </svg>
                      </span>

                      <span class="ps-3">
                        <span class="d-block mb-1">Documentation</span>
                        <small class="d-block text-muted text-wrap">
                          Your development guide to work with Smarty
                        </small>
                      </span>
                    </a>

                    <a href="documentation/changelog.html" class="dropdown-item py-4 d-flex border-top">

                      <span class="flex-none">
                        <svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-files-alt" viewBox="0 0 16 16">  
                          <path d="M11 0H3a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2 2 2 0 0 0 2-2V4a2 2 0 0 0-2-2 2 2 0 0 0-2-2zm2 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1V3zM2 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V2z"></path>
                        </svg>
                      </span>

                      <span class="ps-3">Changelog</span>
                    </a>

                    <a href="__elements.html" target="_blank" rel="noopener" class="dropdown-item py-4 d-flex border-top">

                      <span class="flex-none">
                        <svg width="26" height="26" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-layout-wtf" viewBox="0 0 16 16">  
                          <path d="M5 1v8H1V1h4zM1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm13 2v5H9V2h5zM9 1a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9zM5 13v2H3v-2h2zm-2-1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H3zm12-1v2H9v-2h6zm-6-1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H9z"></path>
                        </svg>
                      </span>

                      <span class="ps-3">
                        <span class="d-block mb-1">Uncategorized Elements</span>
                        <small class="d-block text-muted text-wrap">
                          Various uncategorized elements ready to use
                        </small>
                      </span>
                    </a>

                  </div>

                </li>




                <!-- social icons : mobile only -->
                <li class="nav-item d-block d-sm-none text-center mb-4">

                  <h3 class="h6 text-muted">Follow Us</h3>

                    <!-- facebook -->
                  <a href="#" class="btn btn-sm btn-facebook transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                    <i class="fi fi-social-facebook"></i> 
                  </a>

                  <!-- twitter -->
                  <a href="#" class="btn btn-sm btn-twitter transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                    <i class="fi fi-social-twitter"></i> 
                  </a>

                  <!-- linkedin -->
                  <a href="#" class="btn btn-sm btn-linkedin transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                    <i class="fi fi-social-linkedin"></i> 
                  </a>

                  <!-- youtube -->
                  <a href="#" class="btn btn-sm btn-youtube transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                    <i class="fi fi-social-youtube"></i> 
                  </a>

                </li>



                <!-- Get Smarty : mobile only (d-block d-sm-none)-->
                <li class="nav-item d-block d-sm-none">
                  <a target="_blank" rel="noopener" href="#buy_now" class="btn w-100 btn-primary shadow-none text-white m-0">
                    Get Smarty
                  </a>
                </li>

              </ul>
              <!-- /navbar : navigation -->


            </div>

          </nav>

        </div>
        <!-- /Navbar -->

      </header>
      <!-- /Header -->


      <!-- hero -->
      <div class="section py-5 position-relative">
        <div class="container py-5">

          <div class="row g-4 justify-content-md-between align-items-md-center mb-5">

            <div class="col-lg-6 col-xl-6" data-aos="fade-up" data-aos-delay="100">
              
              <h2 class="mb-5 display-2 fw-bold">
                <span class="d-block">Smarty Multipurpose</span>
                <span class="d-block text-info fs-1">Ready to use in seconds!</span>
              </h2>
              <p class="fs-4 fw-light">The only template in the market that don't require Javascript & CSS coding!</p>

              <a href="https://wrapbootstrap.com/theme/smarty-website-admin-rtl-WB02DSN1B" target="_blank" rel="noopener nofollow" class="btn btn-info bg-gradient row-pill fw-medium d-inline-flex align-items-center px-4 mb-3">
                <span class="me-1">Get Smarty</span>
                <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                  <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                </svg>
              </a>
              
            </div>

            <div class="col-12 my-5 d-lg-none"><!-- mobile spacer --></div>

            <div class="col-lg-6 col-xl-6" data-aos="fade-up" data-aos-delay="100">

              <!-- hero images -->
              <div class="position-relative text-center" data-aos="fade-in" data-aos-delay="450">
                
                <!-- svg lines -->
                <svg class="rtl-scalex-n1 position-absolute start-0 top-0 z-index-1 text-info mx-4" fill="currentColor" data-aos="fade-up" data-aos-delay="200">         
                  <path d="M35.2,1.6c37.3,18.9,72.2,41.8,107.4,64.1c-0.2,0.4-0.4,0.8-0.6,1.2c-1.9-0.8-3.9-1.5-5.6-2.5c-30.3-17-60.6-34.1-91-51.1c-4.1-2.3-8.1-4.6-12.2-6.9c-2.3-1.2-2.8-2.7-1-4.7C33.2,1.6,34.2,1.6,35.2,1.6z"></path>
                  <path d="M137.4,81.7C93.8,56.6,50.2,31.6,6.6,6.5C6.1,6.2,6.1,5.1,5.2,2.5c4.4,1.6,7.6,2.4,10.5,3.9c10,5.3,20,10.6,29.7,16.5c29.9,18.5,59.6,37.2,89.4,55.9c1.1,0.7,2.1,1.5,3.1,2.2C137.7,81.2,137.6,81.5,137.4,81.7z"></path>
                  <path d="M122.8,88.8C87.6,68.9,52.4,49,17.2,29c-0.6-0.4-0.8-1.6-1.9-4c3.7,1.1,6.3,1.3,8.3,2.5c20.1,11.4,40.3,22.7,60.1,34.5 c12.1,7.2,23.8,15.3,35.6,23.1c1.4,0.9,2.6,1.9,3.9,2.9C123.1,88.3,122.9,88.6,122.8,88.8z"></path>
                  <path d="M111.3,103.9c-1.8-1-3.7-1.9-5.5-2.9c-27-15.4-54.1-30.8-81-46.3c-2.1-1.2-5.3-5.2-5.1-5.4c2.8-3.3,5.4-0.2,7.6,1.2c27.6,17,55.2,34.1,82.7,51.3c0.6,0.4,1.2,0.9,1.7,1.4C111.6,103.3,111.5,103.6,111.3,103.9z"></path>
                </svg>

                <!-- images -->
                <span class="d-inline-block ratio ratio-1x1 rounded-circle bg-cover mx-1 z-index-0" style="max-width:500px; background-image:url(demo.files/images/unsplash/team/windows-WJPHTJEtgzw-unsplash.jpg);"></span>
                <div class="position-absolute bottom-0 w-100 z-index-1">
                  <span class="d-inline-block ratio ratio-1x1 rounded-circle bg-cover mx-1 mb-n5" data-jarallax-element="-30" style="max-width:200px; background-image:url(demo.files/images/unsplash/team/thumb_330/michael-dam-mEZ3PoFGs_k-unsplash.jpg);"></span>
                  <span class="d-inline-block ratio ratio-1x1 rounded-circle bg-cover mx-1 mt-n5" data-jarallax-element="-60" style="max-width:130px; background-image:url(demo.files/images/unsplash/team/thumb_330/foto-sushi-6anudmpILw4-unsplash.jpg);"></span>
                </div>

              </div>

            </div>

          </div>

        </div>
      </div>


      <!-- stats -->
      <div class="py-5 position-relative text-center border-top border-bottom border-light border-3" data-aos="fade-up" data-aos-delay="200" data-aos-offset="0">
        <div class="container">

          <!-- icons + counters -->
          <div class="row g-4 col-border text-center text-gray-700">
            
            <div class="col-6 col-md-3">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-292 -375) translate(292 375)" fill="none"><circle fill="#E0F7FA" cx="103.5" cy="103.5" r="103.5"/><g transform="translate(49 42)"><rect fill="#B2EBF2" width="110" height="123" rx="10"/><rect fill="#26C6DA" x="9" y="10" width="31" height="31" rx="15.5"/><rect fill="#26C6DA" x="49" y="19" width="36" height="4" rx="2"/><rect fill="#26C6DA" x="49" y="28" width="44" height="4" rx="2"/><rect fill="#26C6DA" x="11" y="51" width="89" height="60" rx="9"/></g></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="25" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">+</span>
              </div>
              
              <h2 class="h6 m-0">PLUGINS FROM SCRATCH</h2>

            </div>


            <div class="col-6 col-md-3">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-78 -2353) translate(78 2353)" fill="none"><circle fill="#EDE7F6" cx="103.5" cy="103.5" r="103.5"/><path d="M67.647 133.232c9.714 3.322 21.665 4.983 35.853 4.983 14.188 0 26.139-1.661 35.853-4.983 1.045-.357 2.182.2 2.54 1.245.071.208.108.427.108.647v8.828c0 .84-.525 1.591-1.314 1.879-9.963 3.637-22.49 5.455-37.582 5.455-15.072 0-27.345-1.814-36.819-5.441-.774-.296-1.285-1.039-1.285-1.868v-8.853c0-1.105.895-2 2-2 .22 0 .439.036.647.108z" fill="#7E57C2"/><path d="M156.417 75.333c-7.017 0-12.139 6.699-10.181 13.377 3.233 11.013-33.639 21.425-39.084-8.448-1.386-7.605.111-9.601 3.852-13.335 1.9-1.896 3.08-4.503 3.08-7.394 0-5.814-4.596-10.533-10.438-10.533-5.842 0-10.729 4.719-10.729 10.533 0 2.891 1.18 5.504 3.08 7.389 3.736 3.739 5.233 5.735 3.852 13.335-5.445 29.888-42.312 19.455-39.084 8.448 1.958-6.673-3.164-13.372-10.181-13.372-5.842 0-10.583 4.719-10.583 10.533 0 6.425 5.726 11.318 12.028 10.428 5.616-.786 10.325 9.213 14.125 29.998.197 1.075.962 1.958 1.999 2.305 8.842 2.96 20.673 4.44 35.494 4.44 14.808 0 26.547-1.477 35.217-4.432 1.029-.351 1.788-1.231 1.983-2.3 3.8-20.794 8.509-30.795 14.127-30.006 6.302.885 12.028-4.008 12.028-10.433 0-5.814-4.741-10.533-10.583-10.533z" fill="#B39DDB"/></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">FREE UPDATES</h2>

            </div>


            <div class="col-6 col-md-3">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-942 -375) translate(942 375)" fill="none"><circle fill="#FFEBEE" cx="103.5" cy="103.5" r="103.5"/><g><path d="M83.054 78.792c-8.149-.046-18.618 4.175-26.428 11.981-2.979 2.975-5.601 6.453-7.627 10.349 7.049-5.33 14.795-6.806 23.59-1.87 2.594-6.848 6.05-13.814 10.464-20.46zm23.852 80.208c3.905-2.017 7.379-4.643 10.363-7.627 7.828-7.819 12.017-18.338 11.935-26.501-7.219 4.721-14.323 8.122-20.469 10.523 4.936 8.8 3.502 16.564-1.829 23.604zm51.847-109.798c-1.962-.138-3.887-.202-5.78-.202-42.799 0-66.298 34.036-73.796 59.625l20.295 20.295c26.492-8.502 59.528-31.061 59.528-73.301v-.27c-.009-2.003-.087-4.052-.248-6.146z" fill="#EF9A9A" fill-rule="nonzero"/><path d="M88 130.98c-4.32 11.254-16.812 18.339-30 19.02.635-12.671 7.698-25.635 19.24-30l2.331 2.382c-7.012 6.962-9.421 12.639-9.8 15.821 3.218-.389 9.17-2.779 15.921-9.581l2.308 2.359zM131 85c-4.972 0-9-4.027-9-9s4.028-9 9-9 9 4.027 9 9-4.028 9-9 9z" fill="#EF5350"/></g></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">UPCOMING FEATURES</h2>

            </div>


            <div class="col-6 col-md-3">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-320 -305) translate(320 305)" fill="none"><circle fill="#FCE4EC" cx="103.5" cy="103.5" r="103.5"/><g><path d="M133 62.25c0-4.554-3.712-8.25-8.286-8.25h-41.429c-4.574 0-8.286 3.696-8.286 8.25v82.5c0 4.554 3.712 8.25 8.286 8.25h41.429c4.574 0 8.286-3.696 8.286-8.25v-82.5z" fill="#F8BBD0" fill-rule="nonzero"/><path d="M97.786 62.25h12.429c1.143 0 2.071.924 2.071 2.063 0 1.139-.928 2.063-2.071 2.063h-12.429c-1.143 0-2.071-.924-2.071-2.063 0-1.139.928-2.063 2.071-2.063zM104 144.75c-2.291 0-4.143-1.848-4.143-4.125s1.852-4.125 4.143-4.125c2.287 0 4.139 1.848 4.139 4.125s-1.852 4.125-4.139 4.125zM124.714 132.375h-41.429v-57.849h41.429z" fill="#EC407A"/></g></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="1500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">MOBILE FIRST</h2>

            </div>

          </div>

        </div>
      </div>
      <!-- /stats -->


      <!-- block : demos -->
      <div id="demos" class="section">
        <div class="container">

          <div class="d-inline-block mx-auto mb-7">
            <small class="fw-medium">Ready to use in your production</small>
            <h2 class="display-5 mb-0 fw-bold"><span class="text-info">Demos</span> Production Ready</h2>
            <p class="lead">Start your project in seconds, <b>don't waste your time with coding</b>!</p>
          </div>

          <!-- classic -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-1 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <a href="../html_frontend/landing-0.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens-2/index.jpg">
                  <svg viewBox="0 0 460 305"><!-- image width; used by lazyload --></svg>
                </div>
              </a>

            </div>

            <div class="order-2 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">190+ premium pages</span>
              <h2 class="fw-bold mb-4">Smarty 5 Classic : Multipurpose</h2>
              <p class="lead mb-4">Limitless reusable user interface elements, a variety of landing pages such as multipurpose, ecommerce, real estate, full ajax and more...</p>

              <div class="d-flex">
                <a href="landing-0.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/landing-0.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- ecommerce -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-2 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <div class="swiper-container swiper-preloader swiper-btn-group swiper-btn-group-end text-white"
                data-swiper='{
                  "slidesPerView": 1,
                  "spaceBetween": 0,
                  "autoplay": true,
                  "loop": true,
                  "pagination": { "type": "progressbar" }
                }'>

                <div class="swiper-wrapper">

                  <a href="shop-index-1.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-1.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="shop-index-2.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-2.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="shop-index-3.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-3.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="shop-index-4.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-4.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="shop-index-5.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-5.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="shop-index-6.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/shop-6.jpg')">
                    <svg viewBox="0 0 460 597"><!-- image width; used by lazyload --></svg>
                  </a>

                </div>

                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-dark"></div>
                <div class="swiper-button-prev swiper-button-dark"></div>

                <!-- Add Pagination -->
                <div class="swiper-pagination" style="height: 2px"></div>

              </div>

            </div>

            <div class="order-1 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">44 ecommerce pages</span>
              <h2 class="fw-bold mb-4">eCommerce Template</h2>
              <p class="lead mb-3">Multiple eCommerce layouts and pages ready to use in your template. You get everything you need:</p>
              <ul class="mb-4">
                <li>5+ home layouts</li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="shop-page-product-1.html">5+ product pages (+ <a href="shop-page-product-options.html">options</a>)</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="shop-page-category-1.html">7+ category pages</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="account-index.html">8 account pages</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="shop-page-cart-1.html">4 cart & checkout pages</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="shop-page-contact.html">contact page</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="invoice.html">invoice page</a></li>
                <li class="mb-1"><a target="_blank" rel="noopener" href="shop-page-faq.html">help page</a></li>
                <li class="small">...more various pages</li>
              </ul>

              <div class="d-flex">
                <a href="landing-0.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/landing-0.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- admin -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-1 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <div class="swiper-container swiper-preloader swiper-btn-group swiper-btn-group-end text-white"
                data-swiper='{
                  "slidesPerView": 1,
                  "spaceBetween": 0,
                  "autoplay": true,
                  "loop": true,
                  "pagination": { "type": "progressbar" }
                }'>

                <div class="swiper-wrapper">

                  <a href="../html_admin/index.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/admin-1.jpg')">
                    <svg viewBox="0 0 460 348"><!-- image width; used by lazyload --></svg>
                  </a>

                  <a href="../html_admin/layout-2.html" target="_blank" rel="noopener" class="swiper-slide bg-cover" style="background:url('demo.files/images/smarty_intro/screens-2/admin-2.jpg')">
                    <svg viewBox="0 0 460 348"><!-- image width; used by lazyload --></svg>
                  </a>

                </div>

                <!-- Add Arrows -->
                <div class="swiper-button-next swiper-button-dark"></div>
                <div class="swiper-button-prev swiper-button-dark"></div>

                <!-- Add Pagination -->
                <div class="swiper-pagination" style="height: 2px"></div>

              </div>

            </div>

            <div class="order-2 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">2 different admin layouts</span>
              <h2 class="fw-bold mb-4">Admin Templates</h2>
              <p class="lead mb-3">Why should you learn a to use a different new template when Smarty also gives you an admin template, able to use 100% of all usable elements from any Smarty template?</p>
              <p><b><em>That's right: you can use any element from admin/frontend wherever you need in your project because Smarty does NOT use dedicated CSS files like other templates!</em></b></p>

              <div class="d-flex">
                <a href="../html_admin/index.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_admin/index.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- real estate -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-2 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <a href="../html_frontend/niche.realestate.html" target="_blank" rel="noopener" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens-2/realestate.jpg">
                  <svg viewBox="0 0 460 373"><!-- image width; used by lazyload --></svg>
                </div>
              </a>

            </div>

            <div class="order-1 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">5 premium pages</span>
              <h2 class="fw-bold mb-4">Real Estate</h2>
              <p class="lead mb-4">Start your real estate project using Smarty predefined lyaouts (home, category, property profile, etc). Also, you can use any Smarty element you see in any other template because all Smarty elements are 100% reusable.</p>

              <div class="d-flex">
                <a href="niche.realestate.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/niche.realestate.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- classifieds -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-1 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <a href="../html_frontend/niche.classifieds.html" target="_blank" rel="noopener" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens-2/classifieds.jpg">
                  <svg viewBox="0 0 460 335"><!-- image width; used by lazyload --></svg>
                </div>
              </a>

            </div>

            <div class="order-2 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">3 premium pages</span>
              <h2 class="fw-bold mb-4">Classifieds</h2>
              <p class="lead mb-4">Include minimum required layouts to start you classifieds project - for yourself or for your customer.</p>

              <div class="d-flex">
                <a href="niche.classifieds.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/niche.classifieds.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- full ajax -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-2 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <a href="../html_frontend/fullajax-index.html" target="_blank" rel="noopener" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens-2/fullajax.jpg">
                  <svg viewBox="0 0 460 402"><!-- image width; used by lazyload --></svg>
                </div>
              </a>

            </div>

            <div class="order-1 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium"><span class="text-danger">Unique to Smarty</span> (14 pages)</span>
              <h2 class="fw-bold mb-4">Full Ajax</h2>
              <p class="lead">Literally, no other template in any marketplace has this! It was possible because of <a href="documentation/plugins-sow-overview.html" target="_blank" rel="noopener">custom-developed plugins</a> to enable full ajax navigation, also 100% SEO friendly. Google require nowdays speed so your customer needs it!</p>
              <p class="small mb-4"><b><em>All plugins are fully working in ajax mode because of an internal function that reinits them all, when needed. You don't have to worry at all about ajax-javascript coding!</em></b></p>

              <div class="d-flex">
                <a href="fullajax-index.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/fullajax-index.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


          <!-- forum -->
          <div class="row g-4 align-items-center mb-8 pb-5">

            <div class="order-1 col-md-6 col-xl-5 ms-xl-auto mb-md-0" data-aos="fade-up">

              <a href="../html_frontend/forum-index.html" target="_blank" rel="noopener" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens-2/forum.jpg">
                  <svg viewBox="0 0 460 335"><!-- image width; used by lazyload --></svg>
                </div>
              </a>

            </div>

            <div class="order-2 col-md-6 mx-md-auto" data-aos="fade-up" data-aos-delay="100">

              <span class="fw-medium">3 premium pages</span>
              <h2 class="fw-bold mb-4">Internal Forum</h2>
              <p class="lead mb-4">When your project require an internal forum, you are covered - all layouts you need are included to integrate them in no time.</p>

              <div class="d-flex">
                <a href="forum-index.html" class="btn btn-sm btn-info me-2 rounded-lg d-flex align-items-center" target="_blank" rel="noopener">
                  <span>Preview</span>
                  <svg width="18" height="18" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-right-short" viewBox="0 0 16 16">  
                    <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                  </svg>
                </a>
                <a href="../_rtl/html_frontend/forum-index.html" class="btn btn-sm btn-light rounded-lg d-none" target="_blank" rel="noopener">Preview RTL</a>
              </div>

            </div>

          </div>


        </div>
      </div>
      <!-- /block : demos -->


      <!-- block : niche pages -->
      <!--
      <div id="niche" class="section border-top bg-light">
        <div class="container">

          <div class="d-inline-block mx-auto mb-7">
            <h2 class="display-5 mb-0 fw-bold"><span class="text-info">Demos</span> Niche Pages</h2>
            <p class="lead">Pages to help you get started in seconds</b>!</p>
          </div>

          <div class="row g-4 g-lg-5">


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Restaurant
              </h3>

              <a href="../html_frontend/niche.restaurant.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/niche.restaurant-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Lawyer
              </h3>

              <a href="../html_frontend/niche.lawyer.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/niche.lawyer-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Tattoo
              </h3>

              <a href="../html_frontend/niche.tattoo.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/niche.tattoo-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Hosting
              </h3>

              <a href="../html_frontend/niche.hosting.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/niche.hosting-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Caffe
              </h3>

              <a href="../html_frontend/niche.caffe.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/niche.caffe-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Soon
              </h3>

              <div class="bg-white shadow-indigo-md rounded p-2">
                <div class="position-relative rounded overflow-hidden overlay-dark overlay-opacity-6 bg-cover">
                  <svg viewBox="0 0 250 340"></svg>

                  <div class="absolute-full z-index-3 text-white text-center d-flex align-items-center justify-content-center h4">
                    MORE DEMOS<br>
                    SOON
                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>
      </div>
      -->
      <!-- /block : niche pages -->



      <!-- block : landing pages -->
      <!--
      <div id="landing" class="section">
        <div class="container">

          <div class="d-inline-block mx-auto mb-7">
            <h2 class="display-5 mb-0 fw-bold"><span class="text-info">Demos</span> Landing Pages</h2>
            <p class="lead">Pages to help you get started in seconds</b>!</p>
          </div>

          <div class="row g-4 g-lg-5">

            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Default
              </h3>

              <a href="../html_frontend/landing-0.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/index-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>



            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 1
              </h3>

              <a href="../html_frontend/landing-1.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_1-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 2
              </h3>

              <a href="../html_frontend/landing-2.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_2-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 3
              </h3>

              <a href="../html_frontend/landing-3.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_3-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>




            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 4
              </h3>

              <a href="../html_frontend/landing-4.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_4-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 5
              </h3>

              <a href="../html_frontend/landing-5.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_5-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 6
              </h3>

              <a href="../html_frontend/landing-6.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_6-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 7
              </h3>

              <a href="../html_frontend/landing-7.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_7-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Landing 8
              </h3>

              <a href="../html_frontend/landing-8.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/landing_8-min.jpg">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>

          </div>

        </div>
      </div>
      -->
      <!-- /block : landing pages -->



      <!-- block : blog + help center -->
      <!--
      <div id="blog" class="section bg-light">
        <div class="container">

          <div class="d-inline-block mx-auto">
            <small class="fw-bold">Prebuild demos</small>
            <h2 class="display-5 mb-7 text-center fw-bold">
              Blog &amp; Help Center
            </h2>
          </div>

          <div class="row g-4 g-lg-5">

            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Blog : With Sidebar
              </h3>

              <a href="../html_frontend/blog-page-sidebar.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/blog_1-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Blog : No Sidebar
              </h3>

              <a href="../html_frontend/blog-page-sidebar-no.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/blog_2-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>

            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Help Center 1 
                <span class="smaller text-primary fw-bold">(2 pages)</span>
              </h3>

              <a href="../html_frontend/help-center-1-index.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/help_center_1-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Help Center 2 
                <span class="smaller text-primary fw-bold">(3 pages)</span>
              </h3>

              <a href="../html_frontend/help-center-2-index.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/help_center_2-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>

          </div>

        </div>
      </div>
      -->
      <!-- /block : blog + help center -->



      <!-- block : portfolio -->
      <!--
      <div id="portfolio" class="section">
        <div class="container">

          <div class="d-inline-block mx-auto">
            <small class="fw-bold">Prebuild demos</small>
            <h2 class="display-5 mb-7 text-center fw-bold">
              Portfolio
            </h2>
          </div>

          <div class="row g-4 g-lg-5">

            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                2 Columns
              </h3>

              <a href="../html_frontend/portfolio-columns-2.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_2col-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                3 Columns
              </h3>

              <a href="../html_frontend/portfolio-columns-3.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_3col-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>

            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Single Item 1
              </h3>

              <a href="../html_frontend/portfolio-single-1.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_single_1-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Single Item 2
              </h3>

              <a href="../html_frontend/portfolio-single-2.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_single_2-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Single Item 3
              </h3>

              <a href="../html_frontend/portfolio-single-3.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_single_3-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


            <div class="col-12 col-lg-3 mb-5" data-aos="fade-in">

              <h3 class="h5 mb-3 d-flex align-items-center justify-content-lg-between">
                Single Item 4
              </h3>

              <a href="../html_frontend/portfolio-single-4.html" target="_blank" class="d-block bg-white shadow-md rounded p-2" aria-label="template">
                <div class="position-relative rounded overflow-hidden overlay-dark-hover overlay-opacity-3 show-hover-container p-4 bg-cover lazy" data-background-image="demo.files/images/smarty_intro/screens/portfolio_single_4-min.png">
                  <svg viewBox="0 0 250 340"></svg>
                </div>
              </a>

            </div>


          </div>

        </div>
      </div>
      -->
      <!-- /block : portfolio -->



      <!-- CALL TO ACTION -->
      <!--
      <div class="section py-5 shadow-xs">
        <div class="container">
          <div class="row text-center-xs">

            <div class="col-12 col-md-8">
              <h3 class="m-0 fw-bold">New Smarty 5</h3>
              <p class="m-0 fw-bold lead"><span class="text-danger-gradient">7800+ total sales</span> & free updates</p>
            </div>
            
            <div class="col-12 mt-4 d-block d-md-none"></div>

            <div class="col-12 col-md-4 text-align-end">
              <a href="https://wrapbootstrap.com/theme/smarty-website-admin-rtl-WB02DSN1B" target="_blank" rel="noopener" class="btn btn-lg btn-primary bg-gradient-primary d-block-xs">
                Get Smarty 5
              </a>
            </div>

          </div>
        </div>
      </div>
      -->
      <!-- /CALL TO ACTION -->


      <!-- cta -->
      <div class="py-6 position-relative text-center border-top border-info border-2">

        <div class="container">

          <div class="d-inline-block mb-4" data-aos="fade-up" data-aos-delay="0">
            <span class="d-block fs-5 fw-bold">Bootstrap 5 inside</span>
            <h1 class="display-4 fw-bold mb-0">
              <span class="text-danger-gradient">7800+ purchases</span>
            </h1>
          </div>

          <div class="mb-5 pb-5" data-aos="fade-up" data-aos-delay="100">
            <a href="https://wrapbootstrap.com/theme/smarty-website-admin-rtl-WB02DSN1B" target="_blank" rel="noopener" class="btn btn-lg btn-primary bg-gradient-primary px-5 d-block-xs">
              Get Smarty
            </a>
          </div>

          <!-- icons + counters -->
          <div class="row col-border text-center text-gray-700" data-aos="fade-up" data-aos-delay="200">
            
            <div class="col-6 col-md-3 mb-5">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-292 -375) translate(292 375)" fill="none"><circle fill="#E0F7FA" cx="103.5" cy="103.5" r="103.5"/><g transform="translate(49 42)"><rect fill="#B2EBF2" width="110" height="123" rx="10"/><rect fill="#26C6DA" x="9" y="10" width="31" height="31" rx="15.5"/><rect fill="#26C6DA" x="49" y="19" width="36" height="4" rx="2"/><rect fill="#26C6DA" x="49" y="28" width="44" height="4" rx="2"/><rect fill="#26C6DA" x="11" y="51" width="89" height="60" rx="9"/></g></g></svg>


              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="25" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">+</span>
              </div>
              
              <h2 class="h6 m-0">PLUGINS FROM SCRATCH</h2>

            </div>


            <div class="col-6 col-md-3 mb-5">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-78 -2353) translate(78 2353)" fill="none"><circle fill="#EDE7F6" cx="103.5" cy="103.5" r="103.5"/><path d="M67.647 133.232c9.714 3.322 21.665 4.983 35.853 4.983 14.188 0 26.139-1.661 35.853-4.983 1.045-.357 2.182.2 2.54 1.245.071.208.108.427.108.647v8.828c0 .84-.525 1.591-1.314 1.879-9.963 3.637-22.49 5.455-37.582 5.455-15.072 0-27.345-1.814-36.819-5.441-.774-.296-1.285-1.039-1.285-1.868v-8.853c0-1.105.895-2 2-2 .22 0 .439.036.647.108z" fill="#7E57C2"/><path d="M156.417 75.333c-7.017 0-12.139 6.699-10.181 13.377 3.233 11.013-33.639 21.425-39.084-8.448-1.386-7.605.111-9.601 3.852-13.335 1.9-1.896 3.08-4.503 3.08-7.394 0-5.814-4.596-10.533-10.438-10.533-5.842 0-10.729 4.719-10.729 10.533 0 2.891 1.18 5.504 3.08 7.389 3.736 3.739 5.233 5.735 3.852 13.335-5.445 29.888-42.312 19.455-39.084 8.448 1.958-6.673-3.164-13.372-10.181-13.372-5.842 0-10.583 4.719-10.583 10.533 0 6.425 5.726 11.318 12.028 10.428 5.616-.786 10.325 9.213 14.125 29.998.197 1.075.962 1.958 1.999 2.305 8.842 2.96 20.673 4.44 35.494 4.44 14.808 0 26.547-1.477 35.217-4.432 1.029-.351 1.788-1.231 1.983-2.3 3.8-20.794 8.509-30.795 14.127-30.006 6.302.885 12.028-4.008 12.028-10.433 0-5.814-4.741-10.533-10.583-10.533z" fill="#B39DDB"/></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">FREE UPDATES</h2>

            </div>


            <div class="col-6 col-md-3 mb-5">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-942 -375) translate(942 375)" fill="none"><circle fill="#FFEBEE" cx="103.5" cy="103.5" r="103.5"/><g><path d="M83.054 78.792c-8.149-.046-18.618 4.175-26.428 11.981-2.979 2.975-5.601 6.453-7.627 10.349 7.049-5.33 14.795-6.806 23.59-1.87 2.594-6.848 6.05-13.814 10.464-20.46zm23.852 80.208c3.905-2.017 7.379-4.643 10.363-7.627 7.828-7.819 12.017-18.338 11.935-26.501-7.219 4.721-14.323 8.122-20.469 10.523 4.936 8.8 3.502 16.564-1.829 23.604zm51.847-109.798c-1.962-.138-3.887-.202-5.78-.202-42.799 0-66.298 34.036-73.796 59.625l20.295 20.295c26.492-8.502 59.528-31.061 59.528-73.301v-.27c-.009-2.003-.087-4.052-.248-6.146z" fill="#EF9A9A" fill-rule="nonzero"/><path d="M88 130.98c-4.32 11.254-16.812 18.339-30 19.02.635-12.671 7.698-25.635 19.24-30l2.331 2.382c-7.012 6.962-9.421 12.639-9.8 15.821 3.218-.389 9.17-2.779 15.921-9.581l2.308 2.359zM131 85c-4.972 0-9-4.027-9-9s4.028-9 9-9 9 4.027 9 9-4.028 9-9 9z" fill="#EF5350"/></g></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="2500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">UPCOMING FEATURES</h2>

            </div>


            <div class="col-6 col-md-3 mb-5">

              <!-- svg icon -->
              <svg width="60" viewBox="0 0 207 207"><g transform="translate(-320 -305) translate(320 305)" fill="none"><circle fill="#FCE4EC" cx="103.5" cy="103.5" r="103.5"/><g><path d="M133 62.25c0-4.554-3.712-8.25-8.286-8.25h-41.429c-4.574 0-8.286 3.696-8.286 8.25v82.5c0 4.554 3.712 8.25 8.286 8.25h41.429c4.574 0 8.286-3.696 8.286-8.25v-82.5z" fill="#F8BBD0" fill-rule="nonzero"/><path d="M97.786 62.25h12.429c1.143 0 2.071.924 2.071 2.063 0 1.139-.928 2.063-2.071 2.063h-12.429c-1.143 0-2.071-.924-2.071-2.063 0-1.139.928-2.063 2.071-2.063zM104 144.75c-2.291 0-4.143-1.848-4.143-4.125s1.852-4.125 4.143-4.125c2.287 0 4.139 1.848 4.139 4.125s-1.852 4.125-4.139 4.125zM124.714 132.375h-41.429v-57.849h41.429z" fill="#EC407A"/></g></g></svg>

              <div class="h1 mt-3">
                <span data-toggle="count" 
                  data-count-from="0" 
                  data-count-to="100" 
                  data-count-duration="1500" 
                  data-count-decimals="0">0</span><span class="fw-light">%</span>
              </div>
              
              <h2 class="h6 m-0">MOBILE FIRST</h2>

            </div>

          </div>

        </div>

      </div>
      <!-- /cta -->



      <!-- quick faq -->
      <div class="section bg-gradient-linear-primary text-white">
        <div class="container">

          <h2 class="h1 fw-bold text-center mb-7">Frequently Asked Questions</h2>

          <div class="row">

            <div class="col-12 col-md-5 offset-md-1">

              <div class="d-flex mb-5">

                <!-- icon -->
                <div class="fi mdi-filter_1 fs-3"></div>

                <div class="mx-4">

                  <h3 class="fs-5">Do I get free updates?</h3>
                  <p>
                    Yes, all updates are free. Each new version is available for download from your account.
                  </p>

                </div>

              </div>


              <div class="d-flex mb-5">

                <!-- icon -->
                <div class="fi mdi-filter_2 fs-3"></div>

                <div class="mx-4">

                  <h3 class="fs-5">Is compatible with my framework?</h3>
                  <p>
                    Yes, because this is a HTML/CSS/JS template, should be compatible with any framework.
                  </p>

                </div>

              </div>

            </div>

            <div class="col-12 col-md-5">

              <div class="d-flex mb-5">

                <!-- icon -->
                <div class="fi mdi-filter_3 fs-3"></div>

                <div class="mx-4">

                  <h3 class="fs-5">Who can use it?</h3>
                  <p>
                    You can use it for your own project or for a project for your client. Also, money back is guaranteed!
                  </p>

                </div>

              </div>

              <div class="d-flex mb-5">

                <!-- icon -->
                <div class="fi mdi-filter_4 fs-3"></div>

                <div class="mx-4">

                  <h3 class="fs-5">Do I get free updates?</h3>
                  <p>
                    Yes, all updates are free. Each new version is available for download from your account.
                  </p>

                </div>

              </div>

            </div>

          </div>

        </div>
      </div>
      <!-- /quick faq -->




      <!-- info box : yellow -->
      <!--
      <div class="bg-warning py-4">
        <div class="container">

          <div class="row g-4">

            <div class="col-12 col-sm-6 col-lg-3 d-flex text-center-xs py-2 py-sm-3 py-lg-4" data-aos="fade-in" data-aos-delay="0" data-aos-offset="0">

              <img width="60" height="60" class="lazy" data-src="demo.files/svg/various/trendy.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="...">
              <div class="ps-3">
                <h3 class="fs-5 mb-1">Trendy & Modern</h3>
                <p class="m-0">Love it! Use it! Reuse it!</p>
              </div>

            </div>

            <div class="col-12 col-sm-6 col-lg-3 d-flex text-center-xs py-2 py-sm-3 py-lg-4" data-aos="fade-in" data-aos-delay="150" data-aos-offset="0">

              <img width="60" height="60" class="lazy" data-src="demo.files/svg/various/hot_deal.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="...">
              <div class="ps-3">
                <h3 class="fs-5 mb-1">Free Updates</h3>
                <p class="m-0">Lifetime <b>free</b> updates!</p>
              </div>

            </div>

            <div class="col-12 col-sm-6 col-lg-3 d-flex text-center-xs py-2 py-sm-3 py-lg-4" data-aos="fade-in" data-aos-delay="250" data-aos-offset="0">

              <img width="60" height="60" class="lazy" data-src="demo.files/svg/various/new.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="...">
              <div class="ps-3">
                <h3 class="fs-5 mb-1">Frontend & Admin</h3>
                <p class="m-0">Sharing the same core!</p>
              </div>

            </div>

            <div class="col-12 col-sm-6 col-lg-3 d-flex text-center-xs py-2 py-sm-3 py-lg-4" data-aos="fade-in" data-aos-delay="350" data-aos-offset="0">

              <a href="#" class="text-dark text-decoration-none d-flex">

                <img width="60" height="60" class="lazy" data-src="demo.files/svg/various/ok_like.svg" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="...">
                <div class="ps-3">
                  <h3 class="fs-5 mb-1">You're Covered</h3>
                  <p class="m-0">Frontend + Admin</p>
                </div>

              </a>

            </div>

          </div>

        </div>
      </div>
      -->
      <!-- /info box : yellow -->


    </div><!-- /#wrapper -->







    <!-- offcanvas : demos -->
    <div class="offcanvas offcanvas-start" style="width:500px" tabindex="-1" id="offcanvasDemos" aria-labelledby="offcanvasDemosLabel">
      
      <!-- offcanvas : header -->
      <div class="offcanvas-header border-bottom">
        <div class="offcanvas-title lh-1" id="offcanvasDemosLabel">
          <span class="d-block fs-4 mb-1 text-danger-gradient fw-bold">Smarty 5</span>
          <span class="d-block small fw-medium">Frontend + Admin</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>

      <!-- offcanvas : body -->
      <div class="offcanvas-body p-4 p-xl-5">

        <div class="d-flex align-items-center justify-content-between mb-2">
          <h3 class="h5 text-dark fw-bold">Licenses</h3>
          <a class="small fw-medium" href="https://support.wrapbootstrap.com/help/usage-licenses" target="_blank" rel="noopener nofollow">License FAQ</a>
        </div>

        <!-- licenses -->
        <div class="border border-dashed rounded p-3 mb-3">
          <h6 class="d-flex justify-content-between mb-0">
            <span>Single license</span>
            <span class="fs-5"><span class="smaller text-muted">$</span>39</span>
          </h6>
          <p class="mb-0 text-muted small">For single end product used by you or one client</p>

          <div class="border border-dashed border-bottom-0 my-3"><!-- divider --></div>

          <h6 class="d-flex justify-content-between mb-0">
            <span>Multiple license</span>
            <span class="fs-5"><span class="smaller text-muted">$</span>150</span>
          </h6>
          <p class="mb-0 text-muted small">Multiple instalations used by you or one client</p>

          <div class="border border-dashed border-bottom-0 my-3"><!-- divider --></div>

          <h6 class="d-flex justify-content-between mb-0">
            <span>Extended license</span>
            <span class="fs-5"><span class="smaller text-muted">$</span>1800</span>
          </h6>
          <p class="mb-0 text-muted small">For single SaaS app, paying users</p>
        </div>

        <div class="d-grid mb-5">
          <a href="https://wrapbootstrap.com/theme/smarty-website-admin-rtl-WB02DSN1B" target="_blank" rel="noopener nofollow" class="btn btn-primary bg-gradient w-100">
            Buy Now
          </a>
        </div>

        <!-- smarty performance -->
        <img width="403" height="167" class="img-fluid" src="demo.files/images/smarty_lighthouse_403.png" alt="smarty performance">

      </div>

    </div>
    <!-- /offcanvas : demos -->






    <!-- modal offer -->
    <!--
    <div class="hide js-onload js-ajax-modal" 
        data-href="_ajax/modal_offer.html" 
        data-ajax-modal-delay="1000" 
        data-ajax-modal-size="modal-lg" 
        data-ajax-modal-centered="true" 
        data-ajax-modal-backdrop=""></div>
    -->


    <script src="assets/js/core.min.js"></script>

  </body>
</html>