@if(Session::has('success'))
<div class="hide toast-on-load" 
    data-toast-type="success" 
    data-toast-title="" 
    data-toast-body="{{ Session::get('success') }}" 
    data-toast-pos="top-center" 
    data-toast-delay="4000" 
    data-toast-fill="true">
</div>
@endif

@if(Session::has('fail'))
<div class="hide toast-on-load" 
    data-toast-type="danger" 
    data-toast-title="" 
    data-toast-body="{{ Session::get('fail') }}" 
    data-toast-pos="top-center" 
    data-toast-delay="4000" 
    data-toast-fill="true">
</div>
@endif

@if(Session::has('warning'))
<div class="hide toast-on-load" 
    data-toast-type="warning" 
    data-toast-title="" 
    data-toast-body="{{ Session::get('warning') }}" 
    data-toast-pos="top-center" 
    data-toast-delay="4000" 
    data-toast-fill="true">
</div>
@endif