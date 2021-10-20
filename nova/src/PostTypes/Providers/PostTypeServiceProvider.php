<?php

declare(strict_types=1);

namespace Nova\PostTypes\Providers;

use Nova\DomainServiceProvider;
use Nova\PostTypes\Models\PostType;
use Nova\PostTypes\Policies\PostTypePolicy;

class PostTypeServiceProvider extends DomainServiceProvider
{
    public function policies(): array
    {
        return [
            PostType::class => PostTypePolicy::class,
        ];
    }
}
