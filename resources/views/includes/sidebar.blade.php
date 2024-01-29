<!-- sidebar -->
<aside id="aside-main" class="aside-start aside-hide-xs shadow-sm d-flex flex-column px-2 h-auto background-trans border-radius-30">


<!-- sidebar : logo -->
<div class="py-2 px-3 mb-0 mt-4">
    <h2 class="fw-bold text-main-color">MAIN MENU</h2>
</div>
<!-- /sidebar : logo -->


<!-- sidebar : navigation -->
<div class="aside-wrapper scrollable-vertical scrollable-styled-light align-self-baseline h-100 w-100">

  <!--

    All parent open navs are closed on click!
    To ignore this feature, add .js-ignore to .nav-deep

    Links height (paddings):
      .nav-deep-xs
      .nav-deep-sm
      .nav-deep-md

    .nav-deep-hover     hover background slightly different
    .nav-deep-bordered  bordered links

  -->
  <nav class="nav-deep nav-deep-sm nav-deep-light">
    <ul class="nav flex-column">

      <li class="nav-item {{ (request()->is('booking*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('booking-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Booking</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('account*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('users-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Administation</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('stations*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('stations-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Station Manage</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('route-control*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('route-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Route Manage</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('promotion*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('promotion-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Promotion</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('time-table*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('time-table-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Timetable</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('route-map*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('route-map-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Route Map</span>
        </a>
      </li>

      <li class="nav-item {{ (request()->is('news*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('news-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>News</span>
        </a>
      </li>
      <li class="nav-item {{ (request()->is('meals*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('meals-index') }}">
              <i class="fi fi-arrow-right"></i>
              <span>Meal on board</span>
          </a>
      </li>
      <li class="nav-item {{ (request()->is('activity*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('activity-index') }}">
              <i class="fi fi-arrow-right"></i>
              <span>Activity</span>
          </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">
        <i class="fi fi-arrow-right"></i>
          <span>Media</span>
          <span class="group-icon float-end">
            <i class="fi fi-arrow-end"></i>
            <i class="fi fi-arrow-down"></i>
          </span>
        </a>

        <ul class="nav flex-column ms-4">
          <li class="nav-item">
            <a class="nav-link" href="#">
              <i class="fi fi-arrow-right"></i>
              Vdo
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('billboard-index') }}">
              <i class="fi fi-arrow-right"></i>
              Billboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('blog-index') }}">
              <i class="fi fi-arrow-right"></i>
              Blog
            </a>
          </li>
        </ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('review-index') }}">
          <i class="fi fi-arrow-right"></i>
          <span>Review Mange</span>
        </a>
      </li>

      <li class="nav-item">
          <a class="nav-link" href="#">
              <i class="fi fi-arrow-right"></i>
              <span>Report</span>
          </a>
      </li>
      <li class="nav-item {{ (request()->is('fare-manage*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('fare-index') }}">
              <i class="fi fi-arrow-right"></i>
              <span>Fare Manage</span>
          </a>
      </li>
      <li class="nav-item {{ (request()->is('information*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{ route('information-index') }}">
              <i class="fi fi-arrow-right"></i>
              <span>Infomation</span>
          </a>
      </li>
      <li class="nav-item {{ (request()->is('partner*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('partner-index') }}">
            <i class="fi fi-arrow-right"></i>
            <span>Partner</span>
        </a>
    </li>
    <li class="nav-item {{ (request()->is('premium-flex*')) ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pmf-index') }}">
            <i class="fi fi-arrow-right"></i>
            <span>Premium Flex</span>
        </a>
    </li>
      <li class="nav-item" style="display: none;">
          <a class="nav-link" href="#">
              <i class="fi fi-arrow-right"></i>
              <span>Backup</span>
          </a>
      </li>
      <li class="nav-item {{ (request()->is('api*')) ? 'active' : '' }}">
          <a class="nav-link" href="{{route('api.index')}}">
              <i class="fi fi-arrow-right"></i>
              <span>API</span>
          </a>
      </li>


    </ul>
  </nav>

</div>
<!-- /sidebar : navigation -->


<!-- sidebar : footer -->
<div class="d-flex align-self-baseline w-100 py-3 px-3 border-top border-light small">

  <p class="d-inline-grid gap-auto-3 mb-0">
    <x-ajax-button-confirm
      class="link-normal"
      :url="route('logout')"
      :message="_('Logout?')"
      :text="_('Logout')"
    />
  </p>

</div>
<!-- /sidebar : footer -->


</aside>
<!-- /sidebar -->
