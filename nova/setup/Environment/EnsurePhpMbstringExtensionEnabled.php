<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpMbstringExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('mbstring')) {
            $content['mbstring'] = "Your server's version of PHP doesn't have the Mbstring extension enabled. Please contact your web host to ensure PHP's Mbstring extension is enabled for your site.";
        }

        return $next($content);
    }
}
