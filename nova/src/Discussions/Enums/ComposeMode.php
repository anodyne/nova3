<?php

declare(strict_types=1);

namespace Nova\Discussions\Enums;

enum ComposeMode: string
{
    case New = 'new';

    case Reply = 'reply';

    case ChangeGroupName = 'change-group-name';
}
