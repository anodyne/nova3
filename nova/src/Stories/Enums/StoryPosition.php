<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

enum StoryPosition: string
{
    case before = 'before';

    case after = 'after';
}
