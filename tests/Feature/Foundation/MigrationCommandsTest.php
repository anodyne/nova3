<?php

declare(strict_types=1);

use Illuminate\Database\Console\Migrations\InstallCommand;
use Illuminate\Database\Migrations\DatabaseMigrationRepository;
use Illuminate\Support\Facades\Artisan;
use Jlorente\DataMigrations\Repositories\DatabaseDataMigrationRepository;
use Nova\Foundation\Console\Commands\InstallDataMigrations;

uses()->group('foundation');

/*
 * Laravel 13 moved `migrate:install` from `$name` to `$signature`, and a fluent
 * signature always wins over `$name`. The data migrations package renames the
 * command by overriding `$name` alone, so without Nova's replacement it
 * inherits the `migrate:install` signature, shadows the core command, and
 * reports success while never creating the migrations table.
 */
describe('migration commands', function () {
    it('leaves migrate:install owned by the framework', function () {
        expect(Artisan::all()['migrate:install'])
            ->toBeInstanceOf(InstallCommand::class)
            ->not->toBeInstanceOf(InstallDataMigrations::class);
    });

    it('keeps the data migration installer under its own name', function () {
        expect(Artisan::all())->toHaveKey('migrate-data:install')
            ->and(Artisan::all()['migrate-data:install'])->toBeInstanceOf(InstallDataMigrations::class);
    });

    it('points migrate:install at the schema migration repository', function () {
        expect(repositoryOf(Artisan::all()['migrate:install']))
            ->toBeInstanceOf(DatabaseMigrationRepository::class);
    });

    it('points migrate-data:install at the data migration repository', function () {
        expect(repositoryOf(Artisan::all()['migrate-data:install']))
            ->toBeInstanceOf(DatabaseDataMigrationRepository::class);
    });

    it('creates the schema migrations table rather than the data one', function () {
        $repository = repositoryOf(Artisan::all()['migrate:install']);

        expect(tableOf($repository))->toBe('migrations');
    });
});

function repositoryOf(object $command): object
{
    $property = (new ReflectionObject($command))->getProperty('repository');
    $property->setAccessible(true);

    return $property->getValue($command);
}

function tableOf(object $repository): string
{
    $property = (new ReflectionObject($repository))->getProperty('table');
    $property->setAccessible(true);

    return $property->getValue($repository);
}
