@props(['text' => '', 'form_id' => '', 'fieldset_id' => ''])

@php
    $buttonId = uniqid();
    $iconBeforeClickId = uniqid();
    $iconAfterClickId = uniqid();
@endphp

<button type="submit" data-button-id="{{ $buttonId }}" {{ $attributes->merge(['class' => 'btn button-green-bg border-radius-10']) }}>
    <span>{{ $text }}</span>
    <i data-icon-after-click-id="{{ $iconAfterClickId }}" class="fi fi-loading-dots fi-spin d-none"></i>
</button>

<script type="text/javascript" defer="true">
    document.addEventListener("DOMContentLoaded", function() {
        const button = document.querySelector("[data-button-id='{{ $buttonId }}']")
        const icon_arter = document.querySelector("[data-icon-after-click-id='{{ $iconAfterClickId }}']")
        const form_id = document.querySelector("#{{ $form_id }}")
        const fieldset_id = document.querySelector("#{{ $fieldset_id }}")

        if (button instanceof HTMLElement) {
            button.addEventListener("click", function() {
                if(form_id.checkValidity()){
                    form_id.submit()
                    icon_arter.classList.remove('d-none')
                    fieldset_id.disabled = true
                }
            });
        }
    })
</script>