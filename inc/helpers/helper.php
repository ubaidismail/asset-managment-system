<?php

// Example: Formatting a date

function sanitize_date(string $date, string $format = 'd/m/Y'): string
{
    $sanitized = trim(strip_tags($date));
    $d = DateTime::createFromFormat($format, $sanitized);

    return ($d && $d->format($format) === $sanitized) ? $sanitized : '';
}