<?php

if (! function_exists('_')) {
    /**
     * Gettext-style translation shortcut used across Blade components.
     */
    function _(?string $message = null, array $replace = [], ?string $locale = null): string|array|null
    {
        return __($message, $replace, $locale);
    }
}
