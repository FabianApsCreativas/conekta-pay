<?php

if (!function_exists('to_cents')) {
    function to_cents($integer = null)
    {
        if ($integer) {
            return $integer * 100;
        }
        return null;
    }
}
if (!function_exists('from_cents')) {
    function from_cents($integer = null)
    {
        if ($integer) {
            return $integer / 100;
        }
        return null;
    }
}
