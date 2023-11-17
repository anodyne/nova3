<?php

declare(strict_types=1);

namespace Nova\Posts\Wizard;

enum StepStatus: string
{
    case Previous = 'previous';

    case Current = 'current';

    case Next = 'next';
}
