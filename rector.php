<?php

declare(strict_types=1);

use Rector\Caching\ValueObject\Storage\FileCacheStorage;
use Rector\Config\RectorConfig;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\TypeDeclaration\Rector\ClassMethod\StrictArrayParamDimFetchRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/nova/bootstrap/app.php',
        __DIR__.'/nova/bootstrap/providers.php',
        __DIR__.'/nova/config',
        __DIR__.'/nova/database',
        __DIR__.'/nova/foundation',
        __DIR__.'/nova/routes',
        __DIR__.'/nova/setup',
        __DIR__.'/nova/src',
    ])
    ->withSkip([
        __DIR__.'/nova/database/migrations',
        __DIR__.'/nova/database/migrations_data',
        RenameParamToMatchTypeRector::class,
        StrictArrayParamDimFetchRector::class,
        ClosureToArrowFunctionRector::class,
    ])
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        earlyReturn: true,
    )
    ->withPhpSets()
    ->withAttributesSets()
    ->withImportNames()
    ->withCache(
        cacheDirectory: __DIR__.'/.rector.cache',
        cacheClass: FileCacheStorage::class,
    );
