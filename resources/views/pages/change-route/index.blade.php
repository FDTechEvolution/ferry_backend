@extends('layouts.default')

@section('head_meta')
<style>
    .route-col-pricing {
        min-width: 17rem;
    }

    .route-price-nested .route-cost-stack {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 0.5rem;
        margin-top: 0.35rem;
        padding-top: 0.35rem;
        border-top: 1px solid rgba(0, 0, 0, 0.06);
    }

    .route-price-nested .route-cost-stack__label {
        flex: 0 1 auto;
        min-width: 0;
        font-size: 0.625rem;
        line-height: 1.2;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: var(--bs-secondary-color);
    }

    .route-price-nested .route-cost-stack__value {
        flex: 0 0 auto;
        text-align: right;
        font-size: 0.75rem;
        line-height: 1.25;
        font-variant-numeric: tabular-nums;
        font-weight: 500;
        color: var(--bs-secondary);
    }

    .sub-route-save-message {
        min-width: 5.5rem;
        font-size: 0.75rem;
    }

</style>
@endsection

@section('page-title')
<h1 class="ms-2 mb-0 text-main-color-2" id="change-booking-page-title">168789chang.com Route</h1>
@stop

@section('content')
@if (! $stationsOk)
<div class="row">
    <div class="col-12">
        <div class="alert alert-warning mb-3">
            @if (! empty($stationsError))
            สถานี (dropdown): {{ $stationsError }}
            @else
            ไม่สามารถโหลดรายการสถานีได้
            @endif
        </div>
    </div>
</div>
@endif

<div class="row mb-3">
    <div class="col-12">
        <form method="get" action="{{ route('changeRoute.index') }}" class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-md-4 col-lg-3">
                        <label for="cr_depart_station" class="form-label mb-1">ต้นทาง</label>
                        <select name="depart_station_id" id="cr_depart_station" class="form-select" onchange="document.getElementById('cr_dest_station').value=''; this.form.submit();">
                            <option value="">ทั้งหมด</option>
                            @foreach ($departStations as $station)
                            <option value="{{ $station['id'] }}" @selected((string) ($departStationId ?? '' )===(string) $station['id'])>
                                {{ $station['name'] }}{{ $station['nickname'] ? ' ['.$station['nickname'].']' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <label for="cr_dest_station" class="form-label mb-1">ปลายทาง</label>
                        <select name="dest_station_id" id="cr_dest_station" class="form-select" onchange="this.form.submit();" @disabled(! $departStationId)>
                            <option value="">ทั้งหมด</option>
                            @foreach ($destStations as $station)
                            <option value="{{ $station['id'] }}" @selected((string) ($destStationId ?? '' )===(string) $station['id'])>
                                {{ $station['name'] }}{{ $station['nickname'] ? ' ['.$station['nickname'].']' : '' }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-auto">
                        <a href="{{ route('changeRoute.index') }}" class="btn btn-outline-secondary">ล้างตัวกรอง</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<hr>
<div class="row">
    @if (! $agentRoutesOk)
    <div class="col-12">
        <div class="alert alert-danger mb-3">
            @if (! empty($agentRoutesError))
            ไม่สามารถเชื่อมต่อ API ได้: {{ $agentRoutesError }}
            @else
            ไม่สามารถโหลดข้อมูล route ได้ (HTTP {{ $agentRoutesStatus }})
            @endif
        </div>
    </div>
    @endif



    <div class="col-12">
        <div class="table-responsive">
            <table class="table-datatable table table-bordered table-hover" data-lng-empty="No data available in table" data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries" data-lng-filtered="(filtered from _MAX_ total entries)" data-lng-loading="Loading..." data-lng-processing="Processing..." data-lng-search="Search..." data-lng-norecords="No matching records found" data-lng-sort-ascending=": activate to sort column ascending" data-lng-sort-descending=": activate to sort column descending" data-enable-col-sorting="false" data-items-per-page="15" data-enable-column-visibility="false" data-enable-export="false" data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>" data-lng-pdf="PDF" data-lng-xls="XLS" data-lng-all="All" data-export-pdf-disable-mobile="true" data-responsive="false" data-export='["pdf", "xls"]' data-main-search="false" data-column-search="false" data-custom-config='{

                    }'>

                <thead>
                    <tr>

                        <th>Route</th>
                        <th class="route-col-pricing">Time &amp; ราคา</th>

                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($routes as $route)
                    <tr>

                        <td>
                            <span>
                                {{ sprintf('%s [%s]', $route['departure_station']['name'], $route['departure_station']['nickname']) }}
                            </span>
                            <i class="fa-solid fa-angles-right text-main-color-2" aria-hidden="true"></i>
                            <span>
                                {{ sprintf('%s [%s]', $route['destination_station']['name'], $route['destination_station']['nickname']) }}
                            </span>
                        </td>
                        <td>
                            <table class="table table-sm align-middle mb-0 route-price-nested">

                                <tbody>
                                    @foreach ($route['sub_routes'] as $time)
                                    @php
                                    $rowFormId = 'sub-route-form-'.$loop->parent->index.'-'.$loop->index;
                                    @endphp
                                    <tr>
                                        <td class="align-middle text-nowrap pe-2">
                                            <form id="{{ $rowFormId }}" method="post" action="{{ route('changeRoute.store') }}">
                                                @csrf
                                                <input type="hidden" name="agent_sub_route_id" value="{{ $time['agent_sub_route_id'] ?? '' }}">
                                                <input type="hidden" name="depart_station_id" value="{{ $departStationId }}">
                                                <input type="hidden" name="dest_station_id" value="{{ $destStationId }}">
                                            </form>
                                            <span class="badge bg-secondary">{{ $time['depart_time'] }}/{{ $time['arrival_time'] }}</span>
                                        </td>
                                        <td class="align-top pe-2">
                                            <div class="route-cost-stack">
                                                <div class="route-cost-stack__label">Regular</div>
                                                <div class="route-cost-stack__value">฿{{ number_format((float) ($time['cost_price'] ?? 0), 0, '.', ',') }}</div>
                                            </div>
                                            <input type="number" class="form-control form-control-sm" min="0" step="1" inputmode="decimal" name="price" form="{{ $rowFormId }}" value="{{ old('price', $time['price'] ?? $time['adult_price'] ?? '') }}" placeholder="ราคา" aria-label="ราคาผู้ใหญ่">

                                        </td>
                                        <td class="align-top pe-2">
                                            <div class="route-cost-stack">
                                                <div class="route-cost-stack__label">Child</div>
                                                <div class="route-cost-stack__value">฿{{ number_format((float) ($time['cost_child_price'] ?? 0), 0, '.', ',') }}</div>
                                            </div>
                                            <input type="number" class="form-control form-control-sm" min="0" step="1" inputmode="decimal" name="child_price" form="{{ $rowFormId }}" value="{{ old('child_price', $time['child_price'] ?? '') }}" placeholder="ราคา" aria-label="ราคาเด็ก">

                                        </td>
                                        <td class="align-top">
                                            <div class="route-cost-stack">
                                                <div class="route-cost-stack__label">Infant</div>
                                                <div class="route-cost-stack__value">฿{{ number_format((float) ($time['cost_infant_price'] ?? 0), 0, '.', ',') }}</div>
                                            </div>
                                            <input type="number" class="form-control form-control-sm" min="0" step="1" inputmode="decimal" name="infant_price" form="{{ $rowFormId }}" value="{{ old('infant_price', $time['infant_price'] ?? '') }}" placeholder="ราคา" aria-label="ราคาทารก">

                                        </td>
                                        <td class="align-middle text-end">
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                            <span class="sub-route-save-message text-muted" data-save-message role="status" aria-live="polite"></span>
                                            <button type="submit" form="{{ $rowFormId }}" class="btn btn-sm btn-primary text-nowrap" data-save-btn>
                                                <i class="fa-solid fa-floppy-disk me-1" aria-hidden="true"></i>บันทึก
                                            </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@stop

@section('script')
<script>
    $(function() {
        $('form[id^="sub-route-form-"]').on('submit', async function(e) {
            e.preventDefault();

            const $form = $(this);
            const $row = $form.closest('tr');
            const $button = $row.find('[data-save-btn]');
            const $message = $row.find('[data-save-message]');
            const originalHtml = $button.html();
            const submitUrl = $form.attr('action');

            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1" aria-hidden="true"></span>กำลังบันทึก');
            $message.removeClass('text-success text-danger').addClass('text-muted').text('กำลังส่ง...');

            try {
                const response = await fetch(submitUrl, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    body: new FormData($form[0])
                });

                const body = await response.json().catch(() => ({}));
                if (!response.ok) {
                    const msg = body.message || 'บันทึกไม่สำเร็จ';
                    throw new Error(msg);
                }

                $message.removeClass('text-muted text-danger').addClass('text-success').text(body.message || 'บันทึกแล้ว');
            } catch (error) {
                $message.removeClass('text-muted text-success').addClass('text-danger').text(error.message || 'บันทึกไม่สำเร็จ');
            } finally {
                $button.prop('disabled', false).html(originalHtml);
            }
        });
    });
</script>
@endsection
