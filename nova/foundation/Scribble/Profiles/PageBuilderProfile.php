<?php

declare(strict_types=1);

namespace Nova\Foundation\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Nova\Foundation\Blocks\BlockManager;

class PageBuilderProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [];
    }

    public static function suggestionTools(): array
    {
        return app(BlockManager::class)->groupedPageBlocks();
    }

    public static function toolbarTools(): array
    {
        return [];
    }
}
