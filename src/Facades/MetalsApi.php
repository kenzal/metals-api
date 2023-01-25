<?php

namespace Kenzal\MetalsApi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Kenzal\MetalsApi\MetalsApi
 */
class MetalsApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Kenzal\MetalsApi\MetalsApi::class;
    }
}
