@extends('layouts.blank')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <button id="download-button">Download as PDF</button>
    </div>
</div>
@stop
