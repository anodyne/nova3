<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpOpenSslExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('openssl')) {
            $content['openssl'] = "Your server's version of PHP doesn't have the OpenSSL extension enabled. Please contact your web host to ensure PHP's OpenSSL extension is enabled for your site.";
        }

        return $next($content);
    }
}
