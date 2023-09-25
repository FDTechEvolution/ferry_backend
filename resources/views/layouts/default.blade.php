<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        @include('includes.head')
    </head>
    <body class="layout-admin layout-padded aside-sticky" data-s2t-class="btn-primary btn-sm bg-gradient-default rounded-circle border-0">

        <div id="wrapper" class="d-flex align-items-stretch flex-column">
            @include('includes.header')

            <!-- content -->
            <div id="wrapper_content" class="d-flex flex-fill">
                @include('includes.sidebar')

                <!-- main -->
                <main id="middle" class="flex-fill mx-auto py-2 background-trans border-radius-30" style="margin-left: 10px !important;">
                    @include('includes.flash-message')
                    @yield('content')
                </main>
            </div>

            @include('includes.script')

        </div>

        @yield('modal')
        @yield('script')
    </body>
</html>