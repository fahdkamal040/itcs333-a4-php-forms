<?php
declare(strict_types=1);

function validate_required(string $v): bool
{
    return trim($v) !== '';
}

function validate_email(string $v): bool
{
    return filter_var($v, FILTER_VALIDATE_EMAIL) !== false;
}

function validate_length(string $v, int $min, int $max): bool
{
    return mb_strlen($v) >= $min && mb_strlen($v) <= $max;
}
