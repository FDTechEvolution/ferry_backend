@props(['url' => '', 'message' => '', 'text' => '', 'icon' => ''])

<a href="#"
    data-href="{{ $url }}"
    data-ajax-confirm-mode="regular"
    data-ajax-confirm-type="primary"

    data-ajax-confirm-size="modal-md"
    data-ajax-confirm-centered="false"

    data-ajax-confirm-title="Please Confirm"
    data-ajax-confirm-body="{{ $message }}"

    data-ajax-confirm-btn-yes-class="btn-primary"
    data-ajax-confirm-btn-yes-text="Yes"
    data-ajax-confirm-btn-yes-icon="fi fi-check"

    data-ajax-confirm-btn-no-class="btn-light"
    data-ajax-confirm-btn-no-text="Cancel"
    data-ajax-confirm-btn-no-icon="fi fi-close"
    {{ $attributes->merge(['class' => 'js-ajax-confirm']) }} 
    />
    <i class="{{ $icon }}"></i> {{ $text }}
</a>