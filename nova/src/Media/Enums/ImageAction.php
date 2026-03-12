<?php

declare(strict_types=1);

namespace Nova\Media\Enums;

enum ImageAction: string
{
    case Unchanged = 'unchanged';
    case Add = 'add';
    case Replace = 'replace';
    case Remove = 'remove';
}
