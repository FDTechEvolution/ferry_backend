<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('includes.head')
    <script src="https://kit.fontawesome.com/4e1914be33.js" crossorigin="anonymous"></script>
    @yield('head_meta')
</head>

<body class="layout-admin layout-padded aside-sticky"
    data-s2t-class="btn-primary btn-sm bg-gradient-default rounded-circle border-0">

    <div class="page-loader" id="page-loader">
        <div class="spinner"></div>
    </div>

    <div id="wrapper" class="d-flex align-items-stretch flex-column">
        @include('includes.header')

        <!-- content -->
        <div id="wrapper_content" class="d-flex flex-fill">
            @include('includes.sidebar')

            <!-- main -->
            <main id="middle" class="flex-fill mt-6 mt-md-0 mx-auto py-2 border-radius-20"
                style="margin-left: 10px !important;">
                @include('includes.flash-message')
                <div class="section mb-3">
                    @yield('content')
                </div>
            </main>
        </div>

        @include('includes.script')

    </div>

    @if ($errors->any())
        <div class="modal fade" id="model-errors" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Error from Controller</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(window).on('load', function() {
                $('#model-errors').modal('show');
            });
        </script>
    @endif

    @yield('modal')
    @yield('script')

    <script>
        $(document).ready(function() {
            $('#page-loader').hide();

            $("a").click(function(){
                //console.log($(this).attr("href"));
                let clickUrl = $(this).attr("href");
                if(!clickUrl.startsWith('javascript')){
                    //$('#page-loader').show();
                }
            });

            $(window).on('beforeunload', function(){
                //$('#page-loader').show();
            });
        });
    </script>
</body>

</html>
