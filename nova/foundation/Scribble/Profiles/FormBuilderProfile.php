<?php

declare(strict_types=1);

namespace Nova\Foundation\Scribble\Profiles;

use Awcodes\Scribble\ScribbleProfile;
use Nova\Foundation\Blocks\BlockManager;

class FormBuilderProfile extends ScribbleProfile
{
    public static function bubbleTools(): array
    {
        return [];
    }

    public static function suggestionTools(): array
    {
        return app(BlockManager::class)->groupedFormBlocks();
    }

    public static function toolbarTools(): array
    {
        return [
            'heading-two',
            'heading-three',
            'horizontal-rule',
            'bullet-list',
            'ordered-list',
            'divider',
            'paragraph',
            'bold',
            'italic',
            'divider',
            'link',
            'media',
        ];
    }
}
