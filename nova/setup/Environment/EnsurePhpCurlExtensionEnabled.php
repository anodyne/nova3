<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpCurlExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('curl')) {
            $content['curl'] = "Your server's version of PHP doesn't have the cURL extension enabled. Please contact your web host to ensure PHP's cURL extension is enabled for your site.";
        }

        return $next($content);
    }
}
