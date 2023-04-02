<?php

declare(strict_types=1);

namespace Nova\Setup\Environment;

use Closure;

class EnsurePhpTokenizerExtensionEnabled
{
    public function handle(array $content, Closure $next)
    {
        if (! extension_loaded('tokenizer')) {
            $content['tokenizer'] = "Your server's version of PHP doesn't have the Tokenizer extension enabled. Please contact your web host to ensure PHP's Tokenizer extension is enabled for your site.";
        }

        return $next($content);
    }
}
