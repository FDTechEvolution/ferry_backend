@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">{{ $title }}</span></h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12 mb-3">
            <div class="alert alert-danger" role="alert">
                DO NOT Close this page!!
            </div>
        </div>
        <div class="col-12">
            <table class="table" id="tb-job-task">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Route</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routeSchedules as $index => $routeSchedule)
                        <tr data-id="{{ $routeSchedule->id }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $routeSchedule->route->station_from->name }}
                                <i class="fa-solid fa-angles-right text-info"></i>
                                {{ $routeSchedule->route->station_to->name }}
                            </td>
                            <td>
                                {{ date('d M Y', strtotime($routeSchedule->start_datetime)) }} -
                                {{ date('d M Y', strtotime($routeSchedule->end_datetime)) }}
                            </td>
                            <td>
                                <span id="{{ $routeSchedule->id }}-status">Waiting...</span>
                                <div class="spinner-border text-warning" role="status" style="display: none;"
                                    id="{{ $routeSchedule->id }}-running">
                                    <span class="visually-hidden">Processing ...</span>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@stop


@section('script')
    <script>
        $(document).ready(function() {

            const isHasEffectBookingMaster = {{$isHasEffectBookingMaster}};

            // Function to perform AJAX GET request
            function performRequest(url) {
                return $.ajax({
                    url: url,
                    method: 'GET'
                });
            }


            // Loop through each URL and wait for each request to complete before moving to the next one
            function processUrlsSequentially() {
                var sequence = $.Deferred().resolve();
                const baseUrl = '{{env('APP_URL')}}';
                //console.log(baseUrl);
                $('#tb-job-task > tbody > tr').each(function(index, tr) {
                    let $this = $(this);
                    let id = $this.data('id');
                    let statusText = '#' + id + '-status';
                    let statusSpin = '#' + id + '-running';



                    let url = baseUrl+'/routeSchedule/job-run/'+id;


                    sequence = sequence.then(function() {
                        $(statusSpin).show();
                        $(statusText).hide();

                        return performRequest(url).then(function(data) {
                            console.log('Data received from:', url, data);

                            $(statusText).show();
                            $(statusSpin).hide();
                            $(statusText).addClass('text-success');
                            $(statusText).text('success');
                        });
                    });
                });

                // All requests completed
                sequence.done(function() {
                    console.log('All requests completed');
                    if(isHasEffectBookingMaster){
                        window.location.href = baseUrl+'/booking-affected';
                    }else{
                        window.location.href = baseUrl+'/routeSchedules';
                    }
                });
            }

            // Start the process
            processUrlsSequentially();


        });
    </script>

@stop
