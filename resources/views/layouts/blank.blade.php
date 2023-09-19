<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
    <head>
        @include('includes.head')
    </head>
    <body>
        @include('includes.flash-message')
        @yield('content')
        
        @include('includes.script')
    </body>
</html>