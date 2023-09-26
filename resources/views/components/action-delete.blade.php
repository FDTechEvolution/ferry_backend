@props(['url' => '', 'message' => ''])

<a href="#"
    data-href="{{ $url }}"
    data-ajax-confirm-mode="regular"
    data-ajax-confirm-type="danger"

    data-ajax-confirm-size="modal-md"
    data-ajax-confirm-centered="false"

    data-ajax-confirm-title="Please Confirm"
    data-ajax-confirm-body="{{ $message }}"

    data-ajax-confirm-btn-yes-class="btn-danger"
    data-ajax-confirm-btn-yes-text="Yes, delete"
    data-ajax-confirm-btn-yes-icon="fi fi-check"

    data-ajax-confirm-btn-no-class="btn-light"
    data-ajax-confirm-btn-no-text="Cancel"
    data-ajax-confirm-btn-no-icon="fi fi-close"
    {{ $attributes->merge(['class' => 'js-ajax-confirm text-danger']) }} 
    />
    <i class="fi fi-thrash"></i>
</a>