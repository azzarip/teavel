<?php

if (! function_exists('ns_case')) {
    /**
     * Convert a namespace-like string to a "namespace case" string
     * by replacing hyphens and underscores with capital Letters.
     */
    function ns_case(string $input): string
    {
        return str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $input)));
    }
}
