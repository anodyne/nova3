<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpCtypeExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('ctype')) {
            $content['ctype'] = "Your server's version of PHP doesn't have the Ctype extension enabled. Please contact your web host to ensure PHP's Ctype extension is enabled for your site.";
        }

        return $next($content);
    }
}
