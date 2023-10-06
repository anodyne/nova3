<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpVersion
{
    public function handle(array $content, Closure $next)
    {
        $content['items']['php']['header'] = 'PHP 8.2+';

        if (version_compare(PHP_VERSION, '8.2', '<')) {
            $content['errors'] += 1;

            $content['items']['php']['fail'] = sprintf(
                'Your server is running PHP %s, but Nova requires PHP %s or higher. Please update to a newer version of PHP or contact your web host for assistance with fixing this issue.',
                PHP_VERSION,
                '8.2'
            );
        }

        return $next($content);
    }
}
