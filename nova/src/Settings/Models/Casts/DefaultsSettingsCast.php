<?php

namespace Nova\Settings\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\Settings\DataTransferObjects\DefaultsSettings;

class DefaultsSettingsCast extends DTOCast
{
    public function dtoClass(): string
    {
        return DefaultsSettings::class;
    }
}
