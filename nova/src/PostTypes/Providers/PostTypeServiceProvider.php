<?php

declare(strict_types=1);

namespace Nova\PostTypes\Providers;

use Nova\DomainServiceProvider;
use Nova\PostTypes\Spotlight\AddPostType;
use Nova\PostTypes\Spotlight\EditPostType;
use Nova\PostTypes\Spotlight\ViewPostType;
use Nova\PostTypes\Spotlight\ViewPostTypes;

class PostTypeServiceProvider extends DomainServiceProvider
{
    public function spotlightCommands(): array
    {
        return [
            AddPostType::class,
            EditPostType::class,
            ViewPostType::class,
            ViewPostTypes::class,
        ];
    }
}
