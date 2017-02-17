<?php

if (!function_exists('debugBreak')) {

    /**
     * Break to examine function argument
     *
     * @param $argument
     *
     * @return mixed
     */
    function debugBreak($argument)
    {
        if (function_exists('xdebug_break')) {
            xdebug_break();
        }

        return $argument;
    }


}

if (!function_exists('debugBreakIf')) {

    /**
     * Break to examine function argument iff $if
     *
     * @param $argument
     * @param $if
     *
     * @return mixed
     */

    function debugBreakIf($argument, $if)
    {
        if (value($if)) {
            if (function_exists('xdebug_break')) {
                xdebug_break();
            }
        }

        return $argument;
    }
}


if (! function_exists('value')) {
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}
