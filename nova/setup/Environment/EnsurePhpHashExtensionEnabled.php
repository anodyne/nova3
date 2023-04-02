<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpHashExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('hash')) {
            $content['hash'] = "Your server's version of PHP doesn't have the Hash extension enabled. Please contact your web host to ensure PHP's Hash extension is enabled for your site.";
        }

        return $next($content);
    }
}
