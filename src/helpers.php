<?php

use Chapdel\scarabee\scarabee;

if (!function_exists('scarabee')) {
    /**
     * @param mixed ...$args
     *
     * @return
     */
    function scarabee(...$vars)
    {
        return app(scarabee::class)->dump($vars);
    }
}
