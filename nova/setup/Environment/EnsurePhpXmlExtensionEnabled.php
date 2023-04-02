<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpXmlExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('xml')) {
            $content['xml'] = "Your server's version of PHP doesn't have the XML extension enabled. Please contact your web host to ensure PHP's XML extension is enabled for your site.";
        }

        return $next($content);
    }
}
