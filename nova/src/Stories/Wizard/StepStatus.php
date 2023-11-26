<?php

declare(strict_types=1);

namespace Nova\Stories\Wizard;

enum StepStatus: string
{
    case Previous = 'previous';

    case Current = 'current';

    case Next = 'next';
}
