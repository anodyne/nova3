<?php

declare(strict_types=1);

namespace Nova\Forms\Enums;

enum FormMode: string
{
    case Create = 'create';

    case Edit = 'edit';

    case View = 'view';
}
