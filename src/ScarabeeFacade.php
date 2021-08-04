<?php

namespace Chapdel\Scarabee;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chapdel\scarabee\scarabee
 */
class ScarabeeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scarabee';
    }
}
