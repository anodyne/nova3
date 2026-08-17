<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/nova/bootstrap/app.php',
        __DIR__.'/nova/config',
        __DIR__.'/nova/database',
        __DIR__.'/nova/foundation',
        __DIR__.'/nova/setup',
        __DIR__.'/nova/src',
        __DIR__.'/public',
    ])
    ->withSkip([
        __DIR__.'/nova/database/migrations',
        __DIR__.'/nova/database/migrations_data',
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        earlyReturn: true,
    )
    ->withPhpSets();
