<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        @include('includes.head')
        @vite('resources/css/app.css')
    </head>
<body class="layout-admin aside-sticky header-sticky" data-s2t-class="btn-primary btn-sm bg-gradient-default rounded-circle border-0">
    <div id="wrapper" class="d-flex align-items-stretch flex-column">
        @include('includes.header')

        <!-- content -->
        <div id="wrapper_content" class="d-flex flex-fill">
            @include('includes.sidebar')

            <!-- main -->
            <main id="middle" class="flex-fill mx-auto">

                <!-- PAGE TITLE -->
                <header>
                    <h1 class="h4">Good morning, John!</h1>
                    <nav aria-label="breadcrumb">
                    <ol class="breadcrumb small">
                        <li class="breadcrumb-item text-muted active" aria-current="page">You've got 2 new sales today</li>
                    </ol>
                    </nav>
                </header>

                @yield('content')

            </main>
        </div>

        @include('includes.footer')
        @include('includes.script')

    </div>
</body>