<?php

namespace Nova\Settings\Models\Casts;

use Nova\Foundation\DTOCast;
use Nova\Settings\DataTransferObjects\EmailSettings;

class EmailSettingsCast extends DTOCast
{
    public function dtoClass(): string
    {
        return EmailSettings::class;
    }
}
