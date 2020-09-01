<?php

namespace Nova\Settings\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\Settings\DataTransferObjects\DiscordSettings;

class DiscordSettingsCast extends DTOCast
{
    public function dtoClass(): string
    {
        return DiscordSettings::class;
    }
}
