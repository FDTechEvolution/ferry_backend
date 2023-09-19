@props(['header' => '', 'main_content' => '', 'sub_content' => ''])

<div class="section p-4">
    <h6 class="mb-0 text-muted">{{ $header }}</h6>
    <div class="d-flex align-items-center">
        <span class="w-100">
            <span class="fs-5 fw-bold mb-0">{{ $main_content }}</span>
            <small class="text-muted">{{ $sub_content != '' ? '/ '.$sub_content : '' }}</small>
        </span>
    </div>
</div>