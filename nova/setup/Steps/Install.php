<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

class Install
{
    public function steps(): array
    {
        return [
            new VerifyServer,
            new DatabaseConnect,
        ];
    }
}
