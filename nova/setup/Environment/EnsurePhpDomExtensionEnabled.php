<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpDomExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('dom')) {
            $content['dom'] = "Your server's version of PHP doesn't have the DOM extension enabled. Please contact your web host to ensure PHP's DOM extension is enabled for your site.";
        }

        return $next($content);
    }
}
