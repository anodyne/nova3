<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpVersion
{
    public function handle(array $content, Closure $next)
    {
        if (version_compare(PHP_VERSION, '8.2', '<')) {
            $content['php'] = sprintf(
                'Your server is running PHP %s, but Nova 3 requires PHP %s.',
                PHP_VERSION,
                '8.2'
            );
        }

        return $next($content);
    }
}
