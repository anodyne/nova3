<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpPdoExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('PDO')) {
            $content['pdo'] = "Your server's version of PHP doesn't have the PDO extension enabled. Please contact your web host to ensure PHP's PDO extension is enabled for your site.";
        }

        return $next($content);
    }
}
