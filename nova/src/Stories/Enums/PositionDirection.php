<?php

declare(strict_types=1);

namespace Nova\Stories\Enums;

enum PositionDirection: string
{
    case After = 'after';

    case Before = 'before';

    case Start = 'start';

    case End = 'end';
}
