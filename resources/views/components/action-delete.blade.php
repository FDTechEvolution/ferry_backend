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
    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">  
        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>  
        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
    </svg>
</a>