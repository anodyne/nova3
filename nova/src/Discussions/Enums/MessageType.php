<?php

declare(strict_types=1);

namespace Nova\Discussions\Enums;

enum MessageType: string
{
    case Text = 'text';

    case System = 'system';

    case SystemDanger = 'system-danger';
}
