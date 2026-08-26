<?php

declare(strict_types=1);

namespace Nova\Settings\Enums;

enum SettingsKey: string
{
    case Default = 'default';
    case Custom = 'custom';
}
