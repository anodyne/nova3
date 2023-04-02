<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpSessionExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('session')) {
            $content['session'] = "Your server's version of PHP doesn't have the Session extension enabled. Please contact your web host to ensure PHP's Session extension is enabled for your site.";
        }

        return $next($content);
    }
}
