<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpFileinfoExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('fileinfo')) {
            $content['fileinfo'] = "Your server's version of PHP doesn't have the Fileinfo extension enabled. Please contact your web host to ensure PHP's Fileinfo extension is enabled for your site.";
        }

        return $next($content);
    }
}
