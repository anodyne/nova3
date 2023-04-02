<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpFilterExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('filter')) {
            $content['filter'] = "Your server's version of PHP doesn't have the Filter extension enabled. Please contact your web host to ensure PHP's Filter extension is enabled for your site.";
        }

        return $next($content);
    }
}
