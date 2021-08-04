<?php

use Chapdel\Scarabee\Scarabee;

if (!function_exists('scarabee')) {
    /**
     * @param mixed ...$args
     *
     * @return
     */
    function scarabee(...$vars)
    {
        return app(Scarabee::class)->dump($vars);
    }
}
