@extends('layouts.blank')

@section('head')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
</script>
@stop

@section('content')
<div class="row p-4 w-100">
    <div class="col-12 mb-3 no-print text-end">
        <button class="btn btn-sm btn-primary me-3" id="download-button"><i class="fi fi-arrow-download"></i> Download</button>
        <button class="btn btn-sm btn-primary" id="print-button" onclick="setupToPrint()"><i class="fi fi-print"></i> Print</button>
    </div>
    <div class="col-12" id="pdf-report">
        <div class="row">
            <div class="col-12 print-status mb-2 text-end is-print">
                <span class="is-print-status"></span>
            </div>
            <div class="col-12 col-lg-3">
                <img src="{{ asset('image/tigerlineferry_icon.png') }}" class="w-100">
            </div>
            <div class="col-12 col-lg-9">
                <div class="d-flex flex-wrap align-content-end" style="height: 100%;">
                    <p class="small mb-2">
                        <span class="fw-bold">Station From : </span>
                        @if($from == 'ALL')
                            <span class="">{{ $from }}</span>
                        @else
                            <span class="">@if($from->nickname != '') [{{ $from->nickname }}] @endif {{ $from->name }} @if($from->piername != '') ({{ $from->piername }}) @endif</span>
                        @endif
                        <span class="fw-bold ms-3">Station To : </span>
                        @if($to == 'ALL')
                            <span class="">{{ $to }}</span>
                        @else
                            <span class="">@if($to->nickname != '') [{{ $to->nickname }}] @endif {{ $to->name }} @if($to->piername != '') ({{ $to->piername }}) @endif</span>
                        @endif
                        <span class="fw-bold ms-3">Depart Date :</span> <span class="">{{ $depart_date }}</span>
                    </p>
                    <p class="small">
                        <span class="fw-bold">Depart Time : </span>
                        @if($depart_arrive == 'ALL')
                            <span class="">{{ $depart_arrive }}</span>
                        @else
                            @php
                                $d_ex = explode('-', $depart_arrive)
                            @endphp
                            <span class="">{{ $d_ex[0] }}</span>
                        @endif

                        <span class="fw-bold ms-3">Arrive Time : </span>
                        @if($depart_arrive == 'ALL')
                            <span class="">{{ $depart_arrive }}</span>
                        @else
                            @php
                                $d_ex = explode('-', $depart_arrive)
                            @endphp
                            <span class="">{{ $d_ex[1] }}</span>
                        @endif

                        <span class="fw-bold ms-3">Partner : </span>
                        @if($partner == 'ALL')
                            <span class="">{{ $is_partner }}</span>
                        @else
                            <span class="">{{ $is_partner->name }}</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
        <div id="report-list" class="table-responsive">
            <table class="table table-sm">
                <x-report-table
                    :reports="$reports"
                />
            </table>
        </div>
    </div>
</div>
@stop

@section('script')
<style media="print">
    .no-print {
        display: none;
    }
    #pdf-report {
        width: 70% !important;
        margin: 0 auto;
    }
    .is-print {
        display: block !important;
    }
 </style>

 <style>
    .is-print {
        display: none;
    }
 </style>

<script>
    const button = document.getElementById('download-button');

    function generatePDF() {
        let date = getDataNow()
        let file_name = `report_${date}_pdf.pdf`
        // Setting pdf file
        let opt = {
            margin:       [0.1, 0.3],
            filename:     file_name,
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2 },
            jsPDF:        { unit: 'in', format: 'letter', orientation: 'landscape' }
        }
        // Choose the element that your content will be rendered to.
        const element = document.getElementById('pdf-report');
        // Choose the element and save the PDF for your user.
        html2pdf().set(opt).from(element).save();
        // window.close()
    }

    function getDataNow() {
        const date = new Date();

        let day = date.getDate();
        let month = date.getMonth() + 1;
        let year = date.getFullYear();

        return `${day}-${month}-${year}`;
    }

    button.addEventListener('click', generatePDF);

    function setupToPrint() {
        const _print = document.querySelector('.is-print-status')
        let date_now = getDataNow()
        let _date = date_now.split('-')

        const now = new Date();
        const hours = now.getHours();
        const minutes = now.getMinutes();

        _print.innerHTML = `Print Time : ${hours}:${minutes} <span class="ms-2">${_date[0]}/${_date[1]}/${_date[2]}</span>`
        window.print()
    }
</script>
@stop
