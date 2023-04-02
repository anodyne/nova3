<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;
use PDO;

class EnsureDatabasePlatform
{
    public function handle(array $content, Closure $next)
    {
        if (! in_array('mysql', PDO::getAvailableDrivers())) {
            $content['db'] = "Your server doesn't appear to have a MySQL driver for PDO available. As a result, Nova will not be able to connect to the database.";
        }

        return $next($content);
    }
}
