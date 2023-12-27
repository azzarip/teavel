<?php

namespace Azzarip\Teavel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Azzarip\Teavel\Teavel
 */
class Teavel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Azzarip\Teavel\Teavel::class;
    }
}
