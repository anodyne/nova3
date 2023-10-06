<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;
use PDO;

class EnsureDatabasePlatform
{
    public function handle(array $content, Closure $next)
    {
        $content['items']['db']['header'] = 'MySQL 8.0+';

        if (! in_array('mysql', PDO::getAvailableDrivers())) {
            $content['errors'] += 1;

            $content['items']['db']['fail'] = "Your server doesn't appear to have a MySQL driver for PDO available. Nova will not be able to connect to your database.";
        }

        return $next($content);
    }
}
