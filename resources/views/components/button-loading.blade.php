@props(['text' => '', 'form_id' => '', 'fieldset_id' => '', 'cancel_id' => ''])

@php
    $buttonId = uniqid();
    $iconBeforeClickId = uniqid();
    $iconAfterClickId = uniqid();
@endphp

<button type="button" class="btn btn-sm btn-primary" data-button-id="{{ $buttonId }}">
    <span>{{ $text }}</span>
    <svg data-icon-before-click-id="{{ $iconBeforeClickId }}" class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
    </svg>
    <i data-icon-after-click-id="{{ $iconAfterClickId }}" class="fi fi-loading-dots fi-spin d-none"></i>
</button>

<script type="text/javascript" defer="true">
    document.addEventListener("DOMContentLoaded", function() {
        const button = document.querySelector("[data-button-id='{{ $buttonId }}']")
        const icon_before = document.querySelector("[data-icon-before-click-id='{{ $iconBeforeClickId }}']")
        const icon_arter = document.querySelector("[data-icon-after-click-id='{{ $iconAfterClickId }}']")
        const form_id = document.querySelector("#{{ $form_id }}")
        const fieldset_id = document.querySelector("#{{ $fieldset_id }}")
        const cancel_id = document.querySelector("#{{ $cancel_id }}")

        if (button instanceof HTMLElement) {
            button.addEventListener("click", function() {
                icon_before.classList.add('d-none')
                icon_arter.classList.remove('d-none')
                form_id.submit()

                fieldset_id.disabled = button.disabled = cancel_id.disabled = true
            });

            // or do whatever needed to initialize the button...
        }
    })
</script>