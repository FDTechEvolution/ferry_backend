<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        @include('includes.head')
        @vite('resources/css/app.css')
    </head>
<body class="layout-admin aside-sticky header-sticky" data-s2t-class="btn-primary btn-sm bg-gradient-default rounded-circle border-0">
    
    @yield('content')

    @include('includes.script')
</body>