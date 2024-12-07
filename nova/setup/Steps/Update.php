<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

class Update
{
    public function steps(): array
    {
        return [
            new VerifyServerRequirements,
            new WhatsNew,
            new UpdateNova,
        ];
    }
}
