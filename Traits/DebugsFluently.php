<?php

namespace CyberDuck\Traits;

trait DebugsFluently {

    /**
     * Break to examine function argument
     *
     * @param $argument
     *
     * @return $this
     */

    public function debugBreak()
    {
        if (function_exists('xdebug_break')) {
            $args = func_get_args();
            xdebug_break();
        }

        return $this;
    }

    /**
     * Break to examine function argument iff $if
     *
     * @param $argument
     * @param $if
     *
     * @return $this
     */

    public function debugBreakIf($cond)
    {
        if (function_exists('xdebug_break')) {
            if (value($cond)) {
                $args = array_slice(func_get_args(),1);
                xdebug_break();
            }
        }

        return $this;
    }

}