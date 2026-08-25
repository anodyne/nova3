<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

class Migrate extends SetupSteps
{
    /** @return list<Step> */
    public function steps(): array
    {
        return [
            new VerifyServerRequirements,
            new ConfigureDatabase,
            new InstallNova,
            new MigrateNovaData,
        ];
    }
}
