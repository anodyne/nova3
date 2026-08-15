<?php

declare(strict_types=1);

namespace Nova\Foundation\Console\Commands;

use Jlorente\DataMigrations\Console\Commands\InstallCommand;

/**
 * Restores the `migrate-data:install` name for the data migration repository.
 *
 * Laravel 13 changed `Illuminate\Database\Console\Migrations\InstallCommand`
 * from declaring `$name` to declaring `$signature`, and a fluent signature
 * always wins over `$name`. The upstream package renames the command by
 * overriding `$name` only, so on Laravel 13 it silently inherits the
 * `migrate:install` signature and hijacks the core command — leaving the real
 * `migrations` table uncreated because the data repository already exists.
 *
 * @see https://github.com/jlorente/laravel-data-migrations
 */
class InstallDataMigrations extends InstallCommand
{
    /**
     * @var string
     */
    protected $signature = 'migrate-data:install {--database= : The database connection to use}';

    /**
     * @var string
     */
    protected $description = 'Create the data migration repository';
}
