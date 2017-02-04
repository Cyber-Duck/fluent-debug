<?php

if (!function_exists('debugBreak')) {

    function debugBreak(&$arg)
    {
        if (function_exists('xdebug_break')) {
            xdebug_break();
        }
        return $arg;
    }


}

if (!function_exists('debugBreakIf')) {
    function debugBreakIf(&$arg, $if)
    {
        if (value($if)) {
            if (function_exists('xdebug_break')) {
                xdebug_break();
            }
        }
        return $arg;
    }
}


if (! function_exists('value')) {
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
