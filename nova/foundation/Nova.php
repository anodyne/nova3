<?php

declare(strict_types=1);

namespace Nova\Foundation;

use Illuminate\Support\Facades\Facade;

/**
 * @see NovaManager
 */
class Nova extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'nova';
    }
}
