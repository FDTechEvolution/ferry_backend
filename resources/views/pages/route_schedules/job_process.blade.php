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

        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                        <div>
                            <div class="text-muted small">Current task</div>
                            <div class="fw-semibold" id="job-current-label">Preparing...</div>
                        </div>
                        <div class="text-end">
                            <div class="text-muted small">Progress</div>
                            <div class="fs-4 fw-bold text-primary" id="job-progress-text">0%</div>
                        </div>
                    </div>
                    <div class="progress mb-2" style="height: 1.5rem;">
                        <div id="job-progress-bar"
                            class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                            role="progressbar"
                            style="width: 0%;"
                            aria-valuenow="0"
                            aria-valuemin="0"
                            aria-valuemax="100">0%</div>
                    </div>
                    <small class="text-muted" id="job-progress-count">0 / {{ $routeSchedules->count() }} completed</small>
                </div>
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
                        <tr data-id="{{ $routeSchedule->id }}"
                            data-route-label="{{ $routeSchedule->station_from_name }} → {{ $routeSchedule->station_to_name }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                {{ $routeSchedule->station_from_name }}
                                <i class="fa-solid fa-angles-right text-info"></i>
                                {{ $routeSchedule->station_to_name }}
                            </td>
                            <td>
                                {{ date('d M Y', strtotime($routeSchedule->start_datetime)) }} -
                                {{ date('d M Y', strtotime($routeSchedule->end_datetime)) }}
                            </td>
                            <td>
                                <span id="{{ $routeSchedule->id }}-status">Waiting...</span>
                                <div class="spinner-border spinner-border-sm text-warning" role="status" style="display: none;"
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
            const isHasEffectBookingMaster = {{ $isHasEffectBookingMaster ? 'true' : 'false' }};
            const jobRunUrlTemplate = @json(route('routeSchedules.jobRun', ['id' => '__ID__']));
            const redirectUrl = isHasEffectBookingMaster
                ? @json(route('routeSchedules.bookingAffected'))
                : @json(route('routeSchedules.index'));

            const $rows = $('#tb-job-task > tbody > tr');
            const total = $rows.length;
            let completed = 0;
            let failed = false;

            function updateProgress(currentLabel) {
                const percent = total === 0 ? 100 : Math.round((completed / total) * 100);

                $('#job-progress-text').text(percent + '%');
                $('#job-progress-bar')
                    .css('width', percent + '%')
                    .attr('aria-valuenow', percent)
                    .text(percent + '%');
                $('#job-progress-count').text(completed + ' / ' + total + ' completed');
                $('#job-current-label').text(currentLabel);
            }

            function setRowState(id, state) {
                const $row = $('tr[data-id="' + id + '"]');
                const $status = $('#' + id + '-status');
                const $spin = $('#' + id + '-running');

                $row.removeClass('table-warning table-success table-danger');

                if (state === 'running') {
                    $row.addClass('table-warning');
                    $spin.show();
                    $status.hide();
                    return;
                }

                $spin.hide();
                $status.show();

                if (state === 'success') {
                    $row.addClass('table-success');
                    $status.addClass('text-success').text('Success');
                } else if (state === 'error') {
                    $row.addClass('table-danger');
                    $status.addClass('text-danger').text('Failed');
                } else if (state === 'waiting') {
                    $status.removeClass('text-success text-danger').text('Waiting...');
                }
            }

            function performRequest(url) {
                return $.ajax({
                    url: url,
                    method: 'GET',
                });
            }

            function processSequentially() {
                if (total === 0) {
                    updateProgress('No pending schedule');
                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 500);
                    return;
                }

                let sequence = $.Deferred().resolve();

                $rows.each(function(index) {
                    const $row = $(this);
                    const id = $row.data('id');
                    const routeLabel = $row.data('route-label');
                    const url = jobRunUrlTemplate.replace('__ID__', id);

                    sequence = sequence.then(function() {
                        if (failed) {
                            return $.Deferred().reject();
                        }

                        updateProgress('Processing #' + (index + 1) + ': ' + routeLabel);
                        setRowState(id, 'running');

                        return performRequest(url).then(function() {
                            completed++;
                            setRowState(id, 'success');
                            updateProgress(completed === total ? 'All tasks completed' : 'Waiting for next task...');
                        }).fail(function() {
                            failed = true;
                            setRowState(id, 'error');
                            updateProgress('Failed at #' + (index + 1) + ': ' + routeLabel);
                            $('#job-progress-bar')
                                .removeClass('progress-bar-animated bg-primary')
                                .addClass('bg-danger');
                            return $.Deferred().reject();
                        });
                    });
                });

                sequence.done(function() {
                    updateProgress('All tasks completed');
                    $('#job-progress-bar').removeClass('progress-bar-animated');

                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 800);
                });
            }

            updateProgress('Starting...');
            processSequentially();
        });
    </script>

@stop
