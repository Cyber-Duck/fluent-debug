<?php

namespace CyberDuck\Traits;

trait DebugsFluently {

    public function debugBreak()
    {
        if (function_exists('xdebug_break')) {
            $args = func_get_args();
            xdebug_break();
        }
        return $this;
    }

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