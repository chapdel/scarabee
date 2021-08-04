<?php

namespace Chapdel\scarabee;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Chapdel\scarabee\scarabee
 */
class scarabeeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'scarabee';
    }
}
