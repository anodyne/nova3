<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

class Update extends SetupSteps
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
