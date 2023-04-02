<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpPcreExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('pcre')) {
            $content['pcre'] = "Your server's version of PHP doesn't have the PCRE extension enabled. Please contact your web host to ensure PHP's PCRE extension is enabled for your site.";
        }

        return $next($content);
    }
}
