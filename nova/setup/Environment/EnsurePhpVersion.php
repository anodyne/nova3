<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpVersion
{
    protected string $requiredVersion = '8.3';

    public function handle(array $content, Closure $next)
    {
        $content['items']['php']['header'] = 'PHP '.$this->requiredVersion.'+';

        if (version_compare(PHP_VERSION, $this->requiredVersion, '<')) {
            $content['errors'] += 1;

            $content['items']['php']['fail'] = sprintf(
                'Your server is running PHP %s, but Nova requires PHP %s or higher. Please update to a newer version of PHP or contact your web host for assistance with fixing this issue.',
                PHP_VERSION,
                $this->requiredVersion
            );
        }

        return $next($content);
    }
}
