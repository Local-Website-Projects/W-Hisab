<?php
function formatBDT($amount)
{
    $amount = number_format($amount, 2, '.', '');
    $parts = explode('.', $amount);
    $int = $parts[0];
    $decimal = isset($parts[1]) ? '.' . $parts[1] : '';

    $len = strlen($int);
    if ($len <= 3) {
        return '৳' . $int . $decimal;
    }

    $last3 = substr($int, -3);
    $rest = substr($int, 0, -3);
    $rest = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $rest);

    return '৳' . $rest . ',' . $last3 . $decimal;
}
